<?php
// Buzón del formulario de contacto de juanalbglz.eu.
// Recibe el formulario, lo reenvía por correo y vuelve a la web. No guarda los mensajes
// ni las IP: solo un resumen cifrado de la IP durante una hora para frenar el spam.
// Funciona con PHP 7.0 o superior y no necesita extensiones.

$config = __DIR__ . '/contacto.config.php';
if (!is_file($config)) {
  http_response_code(500);
  exit('Falta contacto.config.php junto a contacto.php');
}
$c = require $config;

function volver($c, $lang, $estado) {
  $ruta = $lang === 'en' ? '/en/thanks/' : '/gracias/';
  header('Location: ' . $c['web'] . $ruta . ($estado === 'ok' ? '' : '?error=' . $estado), true, 303);
  exit;
}

function largo($s) {
  return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen($s);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

$lang = (isset($_POST['lang']) && $_POST['lang'] === 'en') ? 'en' : 'es';

// Solo se aceptan envíos desde la propia web.
$origen = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
if (strpos($origen, $c['web']) !== 0) volver($c, $lang, 'origen');

// Trampa para bots: un campo oculto que una persona deja vacío.
if (!empty($_POST['web'])) volver($c, $lang, 'ok');

$nombre = trim(isset($_POST['nombre']) ? (string) $_POST['nombre'] : '');
$correo = trim(isset($_POST['correo']) ? (string) $_POST['correo'] : '');
$mensaje = trim(isset($_POST['mensaje']) ? (string) $_POST['mensaje'] : '');
if ($nombre === '' || $mensaje === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) volver($c, $lang, 'datos');
if (largo($nombre) > 100 || largo($correo) > 200 || largo($mensaje) > 5000) volver($c, $lang, 'datos');
$nombre = preg_replace('/[\r\n]+/', ' ', $nombre);

// Como mucho N envíos por hora desde la misma IP. Se guarda junto al script,
// en una carpeta que el .htaccess protege; si no se puede escribir, se omite el límite.
$dir = __DIR__ . '/.limite';
if (!is_dir($dir)) @mkdir($dir, 0700);
if (is_dir($dir) && is_writable($dir)) {
  if (!is_file("$dir/.htaccess")) @file_put_contents("$dir/.htaccess", "Require all denied\nDeny from all\n");
  foreach ((array) glob("$dir/*") as $f) if (@filemtime($f) < time() - 3600) @unlink($f);
  $huella = "$dir/" . hash_hmac('sha256', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '', $c['secreto']);
  $envios = is_file($huella) ? (int) @file_get_contents($huella) : 0;
  if ($envios >= $c['max_por_hora']) volver($c, $lang, 'limite');
  @file_put_contents($huella, (string) ($envios + 1));
}

$asunto = '=?UTF-8?B?' . base64_encode("[juanalbglz.eu] Mensaje de $nombre") . '?=';
$cuerpo = "Nombre: $nombre\nCorreo: $correo\nIdioma: $lang\n\n$mensaje\n";
$cabeceras = implode("\r\n", array(
  'From: ' . $c['remitente'],
  'Reply-To: ' . $correo,
  'MIME-Version: 1.0',
  'Content-Type: text/plain; charset=utf-8',
));

volver($c, $lang, @mail($c['destino'], $asunto, $cuerpo, $cabeceras) ? 'ok' : 'envio');

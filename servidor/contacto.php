<?php
// Buzón del formulario de contacto de juanalbglz.eu.
// Recibe el formulario, lo reenvía por correo y vuelve a la web. No guarda los mensajes
// ni las IP: solo un resumen cifrado de la IP durante una hora para frenar el spam.

$c = require __DIR__ . '/contacto.config.php';

function volver(string $lang, string $estado): never {
  global $c;
  $ruta = $lang === 'en' ? '/en/thanks/' : '/gracias/';
  header('Location: ' . $c['web'] . $ruta . ($estado === 'ok' ? '' : '?error=' . $estado), true, 303);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

$lang = ($_POST['lang'] ?? '') === 'en' ? 'en' : 'es';

// Solo se aceptan envíos desde la propia web.
$origen = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
if (!str_starts_with($origen, $c['web'])) volver($lang, 'origen');

// Trampa para bots: un campo oculto que una persona deja vacío.
if (($_POST['web'] ?? '') !== '') volver($lang, 'ok');

$nombre = trim((string) ($_POST['nombre'] ?? ''));
$correo = trim((string) ($_POST['correo'] ?? ''));
$mensaje = trim((string) ($_POST['mensaje'] ?? ''));
if ($nombre === '' || $mensaje === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) volver($lang, 'datos');
if (mb_strlen($nombre) > 100 || mb_strlen($correo) > 200 || mb_strlen($mensaje) > 5000) volver($lang, 'datos');
$nombre = preg_replace('/[\r\n]+/', ' ', $nombre);

// Como mucho N envíos por hora desde la misma IP.
$dir = sys_get_temp_dir() . '/buzon-juanalbglz';
@mkdir($dir, 0700, true);
foreach (glob("$dir/*") as $f) if (filemtime($f) < time() - 3600) @unlink($f);
$huella = "$dir/" . hash_hmac('sha256', $_SERVER['REMOTE_ADDR'] ?? '', $c['secreto']);
$envios = is_file($huella) ? (int) file_get_contents($huella) : 0;
if ($envios >= $c['max_por_hora']) volver($lang, 'limite');
file_put_contents($huella, (string) ($envios + 1));

$asunto = '=?UTF-8?B?' . base64_encode("[juanalbglz.eu] Mensaje de $nombre") . '?=';
$cuerpo = "Nombre: $nombre\nCorreo: $correo\nIdioma: $lang\n\n$mensaje\n";
$cabeceras = implode("\r\n", [
  'From: ' . $c['remitente'],
  'Reply-To: ' . $correo,
  'Content-Type: text/plain; charset=utf-8',
]);

volver($lang, mail($c['destino'], $asunto, $cuerpo, $cabeceras) ? 'ok' : 'envio');

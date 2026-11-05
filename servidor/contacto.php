<?php
// Buzón de los formularios de juanalbglz.eu y sus subdominios (contacto y «Propón otra utopía»).
// Recibe el formulario, lo reenvía por correo y vuelve a la web de la que vino. No guarda los mensajes
// ni las IP: solo un resumen cifrado de la IP durante una hora para frenar el spam.
// Funciona con PHP 7.0 o superior y no necesita extensiones.

$config = __DIR__ . '/contacto.config.php';
if (!is_file($config)) {
  http_response_code(500);
  exit('Falta contacto.config.php junto a contacto.php');
}
$c = require $config;

function volver($web, $lang, $estado) {
  $ruta = $lang === 'en' ? '/en/thanks/' : '/gracias/';
  header('Location: ' . $web . $ruta . ($estado === 'ok' ? '' : '?error=' . $estado), true, 303);
  exit;
}

// Esquema y dominio de una dirección («https://utopias.juanalbglz.eu»), o '' si no es válida.
function origen_de($url) {
  $p = parse_url($url);
  if (!$p || empty($p['scheme']) || empty($p['host'])) return '';
  return strtolower($p['scheme'] . '://' . $p['host'] . (isset($p['port']) ? ':' . $p['port'] : ''));
}

function campo($nombre) {
  return trim(isset($_POST[$nombre]) ? (string) $_POST[$nombre] : '');
}

function largo($s) {
  return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen($s);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

$lang = (isset($_POST['lang']) && $_POST['lang'] === 'en') ? 'en' : 'es';

// Solo se aceptan envíos desde las webs de la configuración ('web' puede ser una o una lista;
// la primera es a la que se vuelve si el origen no es válido).
$webs = array_map('origen_de', (array) $c['web']);
$origen = origen_de(isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''));
if ($origen === '' || !in_array($origen, $webs, true)) volver($webs[0], $lang, 'origen');
$web = $origen;

// Trampa para bots: un campo oculto que una persona deja vacío.
if (!empty($_POST['web'])) volver($web, $lang, 'ok');

$nombre = campo('nombre');
$correo = campo('correo');
$mensaje = campo('mensaje');
if ($nombre === '' || $mensaje === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) volver($web, $lang, 'datos');
if (largo($nombre) > 100 || largo($correo) > 200 || largo($mensaje) > 5000) volver($web, $lang, 'datos');
$nombre = preg_replace('/[\r\n]+/', ' ', $nombre);

// «Propón otra utopía» (utopias.juanalbglz.eu) manda además estos campos.
$utopia = campo('tipo') === 'utopia';
if ($utopia) {
  $titulo = preg_replace('/[\r\n]+/', ' ', campo('titulo'));
  $fechas = campo('fechas');
  $lugar = campo('lugar');
  $categoria = campo('categoria');
  $enlace = campo('enlace');
  if ($titulo === '' || $fechas === '' || $lugar === '') volver($web, $lang, 'datos');
  if (largo($titulo) > 200 || largo($fechas) > 100 || largo($lugar) > 200 || largo($categoria) > 100 || largo($enlace) > 500) volver($web, $lang, 'datos');
  if ($enlace !== '' && !preg_match('#^https?://#i', $enlace)) volver($web, $lang, 'datos');
}

// Como mucho N envíos por hora desde la misma IP. Se guarda junto al script,
// en una carpeta que el .htaccess protege; si no se puede escribir, se omite el límite.
$dir = __DIR__ . '/.limite';
if (!is_dir($dir)) @mkdir($dir, 0700);
if (is_dir($dir) && is_writable($dir)) {
  if (!is_file("$dir/.htaccess")) @file_put_contents("$dir/.htaccess", "Require all denied\nDeny from all\n");
  foreach ((array) glob("$dir/*") as $f) if (@filemtime($f) < time() - 3600) @unlink($f);
  $huella = "$dir/" . hash_hmac('sha256', isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '', $c['secreto']);
  $envios = is_file($huella) ? (int) @file_get_contents($huella) : 0;
  if ($envios >= $c['max_por_hora']) volver($web, $lang, 'limite');
  @file_put_contents($huella, (string) ($envios + 1));
}

$sitio = parse_url($web, PHP_URL_HOST);
if ($utopia) {
  $asunto = '=?UTF-8?B?' . base64_encode("[$sitio] Propuesta: $titulo") . '?=';
  $cuerpo = "Propuesta para el mapa de utopías y revoluciones\n\n"
    . "Qué: $titulo\nCuándo: $fechas\nDónde: $lugar\nTipo: $categoria\n"
    . ($enlace !== '' ? "Enlace: $enlace\n" : '')
    . "\n$mensaje\n\n—\nDe: $nombre <$correo>\n";
} else {
  $asunto = '=?UTF-8?B?' . base64_encode("[$sitio] Mensaje de $nombre") . '?=';
  $cuerpo = "Nombre: $nombre\nCorreo: $correo\nIdioma: $lang\nWeb: $web\n\n$mensaje\n";
}
$cabeceras = implode("\r\n", array(
  'From: ' . $c['remitente'],
  'Reply-To: ' . $correo,
  'MIME-Version: 1.0',
  'Content-Type: text/plain; charset=utf-8',
));

// Con datos SMTP en la configuración, se envía autenticado desde un buzón real.
// Sin ellos, se usa mail() del servidor (a menudo acaba en spam).
$enviado = !empty($c['smtp']['servidor'])
  ? enviar_smtp($c['smtp'], $c['remitente'], $c['destino'], $correo, $asunto, $cuerpo)
  : @mail($c['destino'], $asunto, $cuerpo, $cabeceras);
volver($web, $lang, $enviado ? 'ok' : 'envio');

// Cliente SMTP mínimo: SSL (puerto 465) o STARTTLS (587) y AUTH LOGIN.
function enviar_smtp($s, $de, $para, $responder, $asunto, $cuerpo) {
  $puerto = isset($s['puerto']) ? (int) $s['puerto'] : 465;
  $host = ($puerto === 465 ? 'ssl://' : 'tcp://') . $s['servidor'] . ':' . $puerto;
  // Algunos hostings usan un certificado a nombre del servidor y no del dominio:
  // en ese caso, pon 'verificar_certificado' => false en la configuración.
  $verificar = !isset($s['verificar_certificado']) || $s['verificar_certificado'];
  $ctx = stream_context_create(array('ssl' => array('verify_peer' => $verificar, 'verify_peer_name' => $verificar)));
  $f = @stream_socket_client($host, $errno, $errstr, 15, STREAM_CLIENT_CONNECT, $ctx);
  if (!$f) return smtp_fallo("conexión: $errstr");
  stream_set_timeout($f, 15);
  $leer = function () use ($f) {
    $r = '';
    while (($l = fgets($f, 515)) !== false) { $r .= $l; if (isset($l[3]) && $l[3] === ' ') break; }
    return $r;
  };
  $orden = function ($cmd, $esperado) use ($f, $leer) {
    if ($cmd !== null) fwrite($f, $cmd . "\r\n");
    $r = $leer();
    return strpos($r, (string) $esperado) === 0 ? true : $r;
  };
  $yo = 'buzon.juanalbglz.eu';
  if (($r = $orden(null, 220)) !== true) return smtp_fallo($r);
  if (($r = $orden("EHLO $yo", 250)) !== true) return smtp_fallo($r);
  if ($puerto !== 465) {
    if (($r = $orden('STARTTLS', 220)) !== true) return smtp_fallo($r);
    if (!stream_socket_enable_crypto($f, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) return smtp_fallo('TLS');
    if (($r = $orden("EHLO $yo", 250)) !== true) return smtp_fallo($r);
  }
  if (($r = $orden('AUTH LOGIN', 334)) !== true) return smtp_fallo($r);
  if (($r = $orden(base64_encode($s['usuario']), 334)) !== true) return smtp_fallo($r);
  if (($r = $orden(base64_encode($s['clave']), 235)) !== true) return smtp_fallo('autenticación rechazada');
  if (($r = $orden("MAIL FROM:<$de>", 250)) !== true) return smtp_fallo($r);
  if (($r = $orden("RCPT TO:<$para>", 250)) !== true) return smtp_fallo($r);
  if (($r = $orden('DATA', 354)) !== true) return smtp_fallo($r);
  $datos = implode("\r\n", array(
    'Date: ' . date('r'),
    "From: juanalbglz.eu <$de>",
    "To: <$para>",
    "Reply-To: <$responder>",
    "Subject: $asunto",
    'Message-ID: <' . bin2hex(random_bytes(12)) . "@$yo>",
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=utf-8',
    'Content-Transfer-Encoding: base64',
    '',
    chunk_split(base64_encode($cuerpo)),
  ));
  if (($r = $orden($datos . "\r\n.", 250)) !== true) return smtp_fallo($r);
  $orden('QUIT', 221);
  fclose($f);
  return true;
}

// Deja el motivo en el registro de errores de PHP del hosting, nunca en la página.
function smtp_fallo($motivo) {
  error_log('contacto.php SMTP: ' . trim($motivo));
  return false;
}

<?php
// Copia este archivo como contacto.config.php (con .php al final) en el hosting y rellénalo.
// contacto.config.php no se sube nunca al repositorio.
return [
  'web' => 'https://juanalbglz.eu',
  'destino' => 'tu-correo@ejemplo.org',          // a dónde llegan los mensajes (no se publica)
  'remitente' => 'buzon@tudominio.org',          // debe ser la misma cuenta que 'usuario' de SMTP
  'secreto' => 'cambia-esto-por-una-frase-larga',
  'max_por_hora' => 5,
  // Envío autenticado desde un buzón real. Si 'servidor' queda vacío, se usa mail() del hosting.
  'smtp' => [
    'servidor' => 'mail.tudominio.org',            // el servidor SMTP del buzón
    'puerto' => 465,                               // 465 (SSL) o 587 (STARTTLS)
    'usuario' => 'buzon@tudominio.org',
    'clave' => 'contraseña-del-buzón',
    // 'verificar_certificado' => false,           // solo si da error de certificado
  ],
];

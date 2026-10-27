<?php
// Copia este archivo como contacto.config.php en el hosting y rellénalo.
// contacto.config.php no se sube nunca al repositorio.
return [
  'web' => 'https://juanalbglz.eu',
  'destino' => 'tu-correo@ejemplo.org',          // a dónde llegan los mensajes (no se publica)
  'remitente' => 'buzon@juanalbglz.eu',          // dirección del propio hosting
  'secreto' => 'cambia-esto-por-una-frase-larga',
  'max_por_hora' => 5,
];

# Buzón del formulario de contacto

GitHub Pages solo sirve archivos estáticos, así que el formulario envía los mensajes a este script PHP, que se aloja aparte (por ejemplo en el hosting de canarias.africa). El correo de destino solo está en el servidor y nunca aparece en la web.

## Instalación

1. En el hosting, crea un subdominio, por ejemplo `buzon.juanalbglz.eu`, con certificado SSL.
2. Sube `contacto.php` a su carpeta pública.
3. Copia `contacto.config.ejemplo.php` como `contacto.config.php` en la misma carpeta y rellénalo.
4. En el DNS del dominio, apunta `buzon` al hosting (el registro que te indique).
5. En `src/site.ts`, pon `contactEndpoint: 'https://buzon.juanalbglz.eu/contacto.php'`. Mientras esté vacío, la web no muestra el formulario.

Requisitos: PHP 8 o superior con `mail()` activo.

## Qué hace

- Solo acepta envíos que vengan de `https://juanalbglz.eu`.
- Tiene un campo trampa invisible para bots y un límite de envíos por hora y por IP.
- No guarda los mensajes ni las IP: reenvía cada mensaje por correo y vuelve a la página de gracias.

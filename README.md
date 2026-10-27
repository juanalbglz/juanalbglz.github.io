# juanalbglz.eu

Web personal de Juan González, con blog en español e inglés. Sitio estático hecho con [Astro](https://astro.build), publicado en GitHub Pages. Sin cookies, sin analítica, sin recursos de terceros.

## Escribir una entrada

1. Crea un archivo `.md` en `src/content/blog/es/` (español) o `src/content/blog/en/` (inglés). El nombre del archivo es la URL: `mi-entrada.md` → `juanalbglz.eu/blog/mi-entrada/`.
2. Empieza el archivo con esta cabecera:

   ```md
   ---
   title: Título de la entrada
   description: Una frase que resume la entrada.
   date: 2026-10-27
   tags: [territorio, turismo]
   draft: false            # true = no se publica
   translation: my-post    # opcional: nombre del archivo de la versión en el otro idioma
   ---

   Aquí el texto, en Markdown.
   ```

3. Haz commit en `main` (se puede hacer desde la web de GitHub con *Add file → Create new file*). La web se publica sola en un par de minutos.

## Cambiar textos y enlaces

- Enlaces (Mastodon, email de contacto, CSA2): `src/site.ts`.
- Textos de la portada: `src/components/Home.astro`.
- Colores y tipografía: `src/styles/global.css`.

## Trabajar en local

```sh
npm install
npm run dev     # http://localhost:4321
npm run build   # genera dist/
```

## Publicación

El workflow `.github/workflows/deploy.yml` construye y publica en cada push a `main`. Configuración única:

1. En GitHub: *Settings → Pages → Source: GitHub Actions*, y en *Custom domain* escribe `juanalbglz.eu` (activa *Enforce HTTPS* cuando aparezca).
2. En el DNS del dominio: registros `A` de `juanalbglz.eu` a `185.199.108.153`, `185.199.109.153`, `185.199.110.153` y `185.199.111.153`, y un `CNAME` de `www` a `juanalbglz.github.io`.

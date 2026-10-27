import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://juanalbglz.eu',
  integrations: [sitemap()],
  // La web antigua (Solo) enlazaba a /juanalbglz/; la mantenemos viva.
  redirects: {
    '/juanalbglz': '/en/',
  },
});

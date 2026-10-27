// Datos del sitio. Cambia aquí los enlaces y se actualizan en todas las páginas.
export const SITE = {
  name: 'Juan González',
  handle: 'juanalbglz',
  mastodon: 'https://mastodon.art/@juanalbglz',
  mastodonHandle: '@juanalbglz@mastodon.art',
  // Pon aquí la dirección de contacto (se muestra como enlace mailto).
  email: '',
  // Pon aquí el enlace al proyecto CSA2 cuando lo tengas.
  csa2: '',
  license: 'https://creativecommons.org/licenses/by-nc-sa/4.0/',
};

export type Lang = 'es' | 'en';

export const UI = {
  es: {
    htmlLang: 'es',
    home: '/',
    blog: '/blog/',
    rss: '/rss.xml',
    other: { lang: 'en' as Lang, label: 'English', href: '/en/' },
    nav: { home: 'Inicio', blog: 'Blog', contact: 'Contacto' },
    tagline: 'Explorando márgenes invisibles',
    description:
      'Juan González trabaja en sostenibilidad, patrimonio cultural, ecosistemas digitales y pensamiento decolonial, con una mirada crítica al trabajo invisible y la mercantilización del territorio en las periferias europeas.',
    blogTitle: 'Blog',
    blogIntro: 'Notas, ensayos y apuntes de trabajo.',
    latest: 'Últimas entradas',
    allPosts: 'Ver todas las entradas',
    noPosts: 'Todavía no hay entradas.',
    readIn: 'Leer en inglés',
    back: '← Volver al blog',
    privacy: 'Esta web no usa cookies, analítica ni rastreadores.',
    dateLocale: 'es-ES',
  },
  en: {
    htmlLang: 'en',
    home: '/en/',
    blog: '/en/blog/',
    rss: '/en/rss.xml',
    other: { lang: 'es' as Lang, label: 'Español', href: '/' },
    nav: { home: 'Home', blog: 'Blog', contact: 'Contact' },
    tagline: 'Exploring invisible margins',
    description:
      'Juan González works on sustainability, cultural heritage, digital ecosystems and decolonial thought, with a critical eye on invisible labour and the commodification of territory in Europe’s peripheries.',
    blogTitle: 'Blog',
    blogIntro: 'Notes, essays and working drafts.',
    latest: 'Latest posts',
    allPosts: 'See all posts',
    noPosts: 'No posts yet.',
    readIn: 'Read in Spanish',
    back: '← Back to the blog',
    privacy: 'This site uses no cookies, analytics or trackers.',
    dateLocale: 'en-GB',
  },
} as const;

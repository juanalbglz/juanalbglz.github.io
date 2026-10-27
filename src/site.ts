// Datos del sitio. Cambia aquí los enlaces y se actualizan en todas las páginas.
export const SITE = {
  name: 'Juan González',
  handle: 'juanalbglz',
  mastodon: 'https://mastodon.art/@juanalbglz',
  mastodonHandle: '@juanalbglz@mastodon.art',
  // URL del buzón PHP del formulario (ver servidor/README.md). Vacío = sin formulario.
  contactEndpoint: '',
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
    tagline: 'Arte relacional, educación y territorio',
    description:
      'Juan Alberto González, graduado en Bellas Artes en Tenerife. Arte relacional, mediación cultural y educación ambiental con mirada crítica sobre el territorio.',
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
    tagline: 'Relational art, education and territory',
    description:
      'Juan Alberto González, Fine Arts graduate based in Tenerife. Relational art, cultural mediation and environmental education with a critical eye on territory.',
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

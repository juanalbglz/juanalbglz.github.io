import rss from '@astrojs/rss';
import type { APIContext } from 'astro';
import { SITE, UI, type Lang } from './site';
import { getPosts, slugOf } from './posts';

export async function feed(lang: Lang, context: APIContext) {
  const t = UI[lang];
  const posts = await getPosts(lang);
  return rss({
    title: `${SITE.name} · ${t.blogTitle}`,
    description: t.description,
    site: context.site!,
    items: posts.map((p) => ({
      title: p.data.title,
      description: p.data.description,
      pubDate: p.data.date,
      link: `${t.blog}${slugOf(p.id)}/`,
    })),
    customData: `<language>${lang}</language>`,
  });
}

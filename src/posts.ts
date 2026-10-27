import { getCollection } from 'astro:content';
import type { Lang } from './site';

export async function getPosts(lang: Lang) {
  const posts = await getCollection(
    'blog',
    (p) => p.id.startsWith(`${lang}/`) && (import.meta.env.DEV || !p.data.draft),
  );
  return posts.sort((a, b) => b.data.date.valueOf() - a.data.date.valueOf());
}

export const slugOf = (id: string) => id.split('/').slice(1).join('/');

export const formatDate = (d: Date, locale: string) =>
  d.toLocaleDateString(locale, { year: 'numeric', month: 'long', day: 'numeric' });

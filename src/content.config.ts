import { defineCollection, z } from 'astro:content';
import { glob } from 'astro/loaders';

const blog = defineCollection({
  // Las entradas viven en src/content/blog/es/ y src/content/blog/en/
  loader: glob({ base: './src/content/blog', pattern: '**/*.md' }),
  schema: z.object({
    title: z.string(),
    description: z.string(),
    date: z.coerce.date(),
    updated: z.coerce.date().optional(),
    tags: z.array(z.string()).default([]),
    draft: z.boolean().default(false),
    // Nombre del archivo (sin .md) de la versión en el otro idioma, si existe.
    translation: z.string().optional(),
  }),
});

export const collections = { blog };

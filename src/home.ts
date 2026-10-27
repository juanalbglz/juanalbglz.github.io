// Contenido de la portada en los dos idiomas. Los trabajos salen en este orden.
import type { Lang } from './site';

type Item = { year: string; title: string; where?: string; text: string };

export const HOME: Record<Lang, {
  eyebrow: string;
  title: string;
  lede: string;
  about: { title: string; body: string[] };
  works: { title: string; items: Item[] };
  education: { title: string; items: Item[] };
}> = {
  es: {
    eyebrow: 'Arte relacional · educación · territorio',
    title: 'El arte no es patrimonio de quienes se llaman artistas',
    lede: 'Soy Juan Alberto González, graduado en Bellas Artes por la Universidad de La Laguna. Vivo en Fasnia (Tenerife) y trabajo entre la práctica artística, la mediación cultural y la educación ambiental.',
    about: {
      title: 'Sobre mí',
      body: [
        'Mi interés principal está en el arte relacional: la práctica artística como espacio de encuentro, disfrute, expresión y participación, donde el proceso y las relaciones que se generan importan tanto como el resultado material. Todas las personas pueden expresarse, experimentar y relacionarse a través del arte.',
        'He trabajado con pintura, dibujo, ilustración, grabado, cerámica, moldes y microfusión. Hoy diseño materiales didácticos y hago visitas educativas e interpretativas con mirada crítica sobre territorio, patrimonio y medio ambiente, en español, inglés, alemán y francés.',
        'Mi TFG, *Momentos de vida*, reflexiona sobre la desacralización del arte y sobre la experiencia estética como algo inherente al ser humano, también fuera de las disciplinas consideradas artísticas.',
      ],
    },
    works: {
      title: 'Trabajos',
      items: [
        { year: '2026', title: 'Home Sweet Home — Alfonso Simó', where: 'Centro de Arte Juan Ismael, Fuerteventura', text: 'Producción digital y coordinación de materiales expositivos, e infraestructura digital de ArchipiélagoVivo.org vinculada a la muestra.' },
        { year: '2016', title: 'Cerámica para Mundo Guanche', where: 'Proyecto museográfico', text: 'Reproducciones e interpretaciones de cerámica guanche modeladas a mano a partir de referentes del patrimonio canario.' },
        { year: '2014', title: 'ZAT — Zona Artística Temporal', where: 'Centro Social La Tabona', text: 'Exposición colectiva montada desde cero en un espacio recuperado. Mi instalación recombinaba dibujos de anatomía desechados, y el público podía seguir interviniéndolos durante la muestra.' },
        { year: '2013', title: 'Dinámicas Norte–Sur', where: 'IES El Médano, con Guacimara Guerra', text: 'Juego de rol para hacer visibles las relaciones extractivas y las desigualdades Norte–Sur, cerrado con una asamblea de reflexión colectiva.' },
        { year: '2009–2012', title: 'Edukaution', where: 'Universidad de La Laguna', text: 'Identidad colectiva de artivismo nacida de las asambleas estudiantiles de 2012: talleres, cinefórums, intervenciones gráficas y acciones informativas.' },
        { year: '2009–2021', title: 'De un grano de cebada / Del huerto a la mesa', where: 'Práctica propia', text: 'Puesta en marcha comunitaria de una finca, con cebada canaria del CCBAT y un huerto compartido donde quienes cuidaban el cultivo cocinaban y comían juntos. El arte se disolvía en lo cotidiano.' },
        { year: '2011', title: 'Grabado: de la estampa al objeto', where: 'Seleccionado para Merkarte, Cabildo de Tenerife', text: 'Linograbados sobre papel de arroz con tintas al agua, y una serie de pins y broches que sacaba la estampa del soporte expositivo.' },
        { year: '2005–2007', title: 'Taller de Roberto Cedrón', where: 'Douarnenez, Francia', text: 'Dos años como asistente: linograbado, estampación, pastel graso, tinta china y preparación de obra para galerías de París.' },
      ],
    },
    education: {
      title: 'Educación y mediación',
      items: [
        { year: '2024–', title: 'Guía de naturaleza', where: 'Reserva Ambiental San Blas', text: 'Visitas educativas para centros escolares, familias y público general, con materiales propios y adaptadas a públicos diversos, incluidas visitas de ATELSAM y ONCE.' },
        { year: '2023–', title: 'PROYECT4', where: 'Cofundador', text: 'Proyectos educativos, ambientales y comunitarios: Pescambiente, La Alpispa (Arafo) y talleres de sostenibilidad energética en Fasnia y Arafo.' },
        { year: '2022–2023', title: 'Asociación La Destiladera', where: 'Cofundador', text: 'Talleres de sostenibilidad en centros escolares y actividades con jóvenes en riesgo de exclusión, con la música como vehículo.' },
        { year: '2022', title: 'Aula Cultural de Pensamiento Artístico Contemporáneo', where: 'Universidad de La Laguna', text: 'Codirección académica y docencia del taller de sostenibilidad en el sector textil y de la moda.' },
      ],
    },
  },
  en: {
    eyebrow: 'Relational art · education · territory',
    title: 'Art does not belong only to those who call themselves artists',
    lede: 'I am Juan Alberto González, a Fine Arts graduate from the University of La Laguna. I live in Fasnia (Tenerife) and work across art practice, cultural mediation and environmental education.',
    about: {
      title: 'About',
      body: [
        'My main interest is relational art: art practice as a space for meeting, enjoyment, expression and participation, where the process and the relationships it creates matter as much as the material result. Everyone can express themselves, experiment and relate to others through art.',
        'I have worked in painting, drawing, illustration, printmaking, ceramics, mould-making and lost-wax casting. Today I design learning materials and lead educational and interpretive visits with a critical eye on territory, heritage and the environment, in Spanish, English, German and French.',
        'My final degree project, *Momentos de vida* (Moments of life), reflects on desacralising art and on aesthetic experience as something inherent to being human, also outside the disciplines considered artistic.',
      ],
    },
    works: {
      title: 'Work',
      items: [
        { year: '2026', title: 'Home Sweet Home — Alfonso Simó', where: 'Centro de Arte Juan Ismael, Fuerteventura', text: 'Digital production and coordination of exhibition materials, plus the digital infrastructure of ArchipiélagoVivo.org linked to the show.' },
        { year: '2016', title: 'Ceramics for Mundo Guanche', where: 'Museum project', text: 'Hand-modelled reproductions and interpretations of Guanche pottery based on Canarian heritage references.' },
        { year: '2014', title: 'ZAT — Temporary Art Zone', where: 'La Tabona social centre', text: 'A group show built from scratch in a reclaimed space. My installation recombined discarded anatomy drawings, and visitors could keep drawing on them throughout the show.' },
        { year: '2013', title: 'North–South dynamics', where: 'IES El Médano, with Guacimara Guerra', text: 'A role-playing game that made extractive relations and North–South inequalities visible, closed with a collective reflection assembly.' },
        { year: '2009–2012', title: 'Edukaution', where: 'University of La Laguna', text: 'A collective artivist identity born from the 2012 student assemblies: workshops, film forums, graphic interventions and information actions.' },
        { year: '2009–2021', title: 'From a grain of barley / From garden to table', where: 'Own practice', text: 'Bringing a farm back to life as a community, with Canarian barley from CCBAT and a shared garden where the people tending the crops cooked and ate together. Art dissolved into everyday life.' },
        { year: '2011', title: 'Printmaking: from print to object', where: 'Selected for Merkarte, Cabildo de Tenerife', text: 'Linocuts on rice paper with water-based inks, and a series of pins and brooches that took the print off the gallery wall.' },
        { year: '2005–2007', title: 'Roberto Cedrón’s studio', where: 'Douarnenez, France', text: 'Two years as a studio assistant: linocut, printing, oil pastel, Indian ink and preparing work for Paris galleries.' },
      ],
    },
    education: {
      title: 'Education and mediation',
      items: [
        { year: '2024–', title: 'Nature guide', where: 'San Blas Environmental Reserve', text: 'Educational visits for schools, families and the general public, with my own materials and adapted to diverse audiences, including groups from ATELSAM and ONCE.' },
        { year: '2023–', title: 'PROYECT4', where: 'Co-founder', text: 'Educational, environmental and community projects: Pescambiente, La Alpispa (Arafo) and energy sustainability workshops in Fasnia and Arafo.' },
        { year: '2022–2023', title: 'La Destiladera association', where: 'Co-founder', text: 'Sustainability workshops in schools and activities with young people at risk of exclusion, using music as a way in.' },
        { year: '2022', title: 'Contemporary Artistic Thought cultural chair', where: 'University of La Laguna', text: 'Co-directed and taught the workshop on sustainability in textiles and fashion.' },
      ],
    },
  },
};

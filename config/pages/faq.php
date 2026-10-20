<?php
// Seitenkonfiguration für /faq/
$faqItems = require dirname(__DIR__, 2) . '/content/faq.php';
return array (
  'title' => 'FAQ zur Gebäudereinigung | KEM',
  'description' => 'Häufige Fragen zu Gebäudereinigung, Ablauf, Reinigungszeiten, Turnus, Angebot und Einsatzgebiet von KEM in Köln, Brühl und Bonn.',
  'path' => '/faq/',
  'og_image' => '/assets/img/pages/faq/faq-hero.webp',
  'breadcrumbs' => 
  array (
    0 => 
    array (
      'name' => 'Startseite',
      'path' => '/',
    ),
    1 => 
    array (
      'name' => 'FAQ',
      'path' => '/faq/',
    ),
  ),
  'faq_items' => $faqItems,
  'schema_extra' => [
    [
      '@type' => 'FAQPage',
      '@id' => '/faq/#faq',
      'url' => '/faq/',
      'mainEntity' => array_map(static function (array $item): array {
        return [
          '@type' => 'Question',
          'name' => $item['question'],
          'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $item['answer'],
          ],
        ];
      }, $faqItems),
    ],
  ],
  'intro' =>
  array (
    'container_class' => 'faq-container',
    'eyebrow' => 'FAQ',
    'title' => 'Häufige Fragen',
    'lead' => 'Antworten zu Kosten, Anfrage und Zusammenarbeit mit KEM.',
    'variant' => 'compact',
  ),
  'hero' => 
  array (
    'src' => '/assets/img/pages/faq/faq-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
    'tag' => 'FAQ',
    'class' => 'hero-focus-high',
  ),
  'cta' => 
  array (
    'class' => 'cta-band',
    'content' => 'ctas/faq.php',
  ),
);

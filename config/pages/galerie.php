<?php
// Seitenkonfiguration für /galerie/
return array (
  'title' => 'Galerie | KEM Gebäudereinigung',
  'description' => 'Video-Einblicke in verschiedene Leistungen von KEM Gebäudereinigung – von Glas- und Fensterreinigung bis Solar-, Polster-, Fassaden-, Teppich- und Grundreinigung.',
  'path' => '/galerie/',
  'og_image' => '/assets/img/pages/galerie/galerie-collage-details.webp',
  'breadcrumbs' => 
  array (
    0 => 
    array (
      'name' => 'Startseite',
      'path' => '/',
    ),
    1 => 
    array (
      'name' => 'Galerie',
      'path' => '/galerie/',
    ),
  ),
  'schema_extra' => 
  array (
  ),
  'intro' =>
  array (
    'container_class' => 'gallery-container',
    'eyebrow' => 'Einblicke in unsere Arbeit',
    'title' => 'Galerie',
    'lead' => 'Videoeinblicke aus verschiedenen Reinigungsleistungen von KEM. Die Aufnahmen zeigen beispielhafte Arbeitssituationen; das konkrete Vorgehen stimmen wir immer auf Objekt, Oberfläche, Verschmutzung und Zugänglichkeit ab.',
    'variant' => 'media',
  ),
  'hero' => 
  array (
    'src' => '/assets/img/pages/galerie/galerie-collage-details.webp',
    'width' => 1536,
    'height' => 1024,
    'alt' => 'Illustrative Collage zur Büro-, Fenster-, Polster- und Solarreinigung',
    'class' => 'gallery-collage',
  ),
  'cta' => 
  array (
    'class' => 'cta-band',
    'content' => 'ctas/galerie.php',
  ),
);

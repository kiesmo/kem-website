<?php
// Seitenkonfiguration für /leistungen/grundreinigung/
return array (
  'title' => 'Grundreinigung Köln, Brühl & Bonn | KEM Gebäudereinigung',
  'description' => 'Professionelle Grundreinigung in Köln, Brühl und Bonn für Übergaben, Renovierungen, Umzüge und intensive Reinigungsarbeiten nach individuellem Bedarf.',
  'path' => '/leistungen/grundreinigung/',
  'og_image' => '/assets/img/services/grundreinigung/grundreinigung-hero.webp',
  'breadcrumbs' => 
  array (
    0 => 
    array (
      'name' => 'Startseite',
      'path' => '/',
    ),
    1 => 
    array (
      'name' => 'Leistungen',
      'path' => '/leistungen/',
    ),
    2 => 
    array (
      'name' => 'Grund- und Spezialreinigung',
      'path' => '/leistungen/grundreinigung/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/leistungen/grundreinigung/#service',
      'name' => 'Grund- und Spezialreinigung',
      'serviceType' => 'Grund- und Spezialreinigung',
      'url' => '/leistungen/grundreinigung/',
      'description' => 'Intensive Reinigung nach Bauarbeiten, bei Übergaben oder bei besonders hartnäckigen und anspruchsvollen Verschmutzungen.',
      'provider' => 
      array (
        '@id' => '/#business',
      ),
      'areaServed' => 
      array (
        0 => 'Köln',
        1 => 'Brühl',
        2 => 'Bonn',
      ),
    ),
  ),
  'hero' => 
  array (
    'class' => 'hero-focus-right',
    'heading' => 'Grundreinigung in Köln, Brühl, Bonn & Umgebung',
    'src' => '/assets/img/services/grundreinigung/grundreinigung-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/leistungen-grundreinigung.php',
  ),
);

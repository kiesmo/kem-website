<?php
// Seitenkonfiguration für /leistungen/entruempelung/
return array (
  'title' => 'Entrümpelung Köln, Brühl & Bonn | KEM Gebäudereinigung',
  'description' => 'Entrümpelung und Haushaltsauflösung in Köln, Brühl und Bonn für Wohnungen, Keller, Garagen, Büros und Gewerbeflächen – individuell geplant.',
  'path' => '/leistungen/entruempelung/',
  'og_image' => '/assets/img/services/entruempelung/entruempelung-hero.webp',
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
      'name' => 'Entrümpelung',
      'path' => '/leistungen/entruempelung/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/leistungen/entruempelung/#service',
      'name' => 'Entrümpelung',
      'serviceType' => 'Entrümpelung',
      'url' => '/leistungen/entruempelung/',
      'description' => 'Geplante Räumung von Wohnungen, Kellern, Büros und Gewerbeflächen einschließlich besenreiner Übergabe nach Absprache.',
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
    'heading' => 'Entrümpelung und Haushaltsauflösung in Köln, Brühl, Bonn & Umgebung',
    'src' => '/assets/img/services/entruempelung/entruempelung-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/leistungen-entruempelung.php',
  ),
);

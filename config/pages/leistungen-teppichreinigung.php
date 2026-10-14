<?php
// Seitenkonfiguration für /leistungen/teppichreinigung/
return array (
  'title' => 'Teppichreinigung Köln, Brühl & Bonn | KEM Gebäudereinigung',
  'description' => 'Teppichreinigung in Köln, Brühl und Bonn für private und gewerbliche Räume. Materialgerechte Behandlung von Teppichböden, Flecken und Laufspuren.',
  'path' => '/leistungen/teppichreinigung/',
  'og_image' => '/assets/img/services/teppichreinigung/teppichreinigung-hero.webp',
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
      'name' => 'Teppichreinigung',
      'path' => '/leistungen/teppichreinigung/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/leistungen/teppichreinigung/#service',
      'name' => 'Teppichreinigung',
      'serviceType' => 'Teppichreinigung',
      'url' => '/leistungen/teppichreinigung/',
      'description' => 'Materialgerechte Reinigung von Teppichböden und textilen Flächen zur Entfernung von Schmutz, Flecken und Laufspuren.',
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
    'class' => 'hero-focus-left',
    'heading' => 'Teppichreinigung in Köln, Brühl, Bonn & Umgebung',
    'src' => '/assets/img/services/teppichreinigung/teppichreinigung-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/leistungen-teppichreinigung.php',
  ),
);

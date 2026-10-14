<?php
// Seitenkonfiguration für /leistungen/polsterreinigung/
return array (
  'title' => 'Polsterreinigung Köln, Brühl & Bonn | KEM Gebäudereinigung',
  'description' => 'Polsterreinigung in Köln, Brühl und Bonn für Sofas, Sessel, Stühle und weitere geeignete Polstermöbel – materialgerecht und individuell geplant.',
  'path' => '/leistungen/polsterreinigung/',
  'og_image' => '/assets/img/services/polsterreinigung/polsterreinigung-hero.webp',
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
      'name' => 'Polsterreinigung',
      'path' => '/leistungen/polsterreinigung/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/leistungen/polsterreinigung/#service',
      'name' => 'Polsterreinigung',
      'serviceType' => 'Polsterreinigung',
      'url' => '/leistungen/polsterreinigung/',
      'description' => 'Schonende Tiefenreinigung für Sofas, Sessel, Stühle und weitere Polstermöbel – passend zu Material und Nutzung.',
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
    'src' => '/assets/img/services/polsterreinigung/polsterreinigung-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
    'tag' => 'Polsterreinigung',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/leistungen-polsterreinigung.php',
  ),
);

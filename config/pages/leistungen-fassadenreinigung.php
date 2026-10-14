<?php
// Seitenkonfiguration für /leistungen/fassadenreinigung/
return array (
  'title' => 'Fassadenreinigung Köln, Brühl & Bonn | KEM Gebäudereinigung',
  'description' => 'Fassaden- und Graffitireinigung in Köln, Brühl und Bonn. Verfahren und Reinigungsumfang werden auf Untergrund, Verschmutzung und Zugang abgestimmt.',
  'path' => '/leistungen/fassadenreinigung/',
  'og_image' => '/assets/img/services/fassadenreinigung/fassadenreinigung-hero.webp',
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
      'name' => 'Fassaden- und Graffitireinigung',
      'path' => '/leistungen/fassadenreinigung/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/leistungen/fassadenreinigung/#service',
      'name' => 'Fassaden- und Graffitireinigung',
      'serviceType' => 'Fassaden- und Graffitireinigung',
      'url' => '/leistungen/fassadenreinigung/',
      'description' => 'Fachgerechte Reinigung von Fassaden und Außenflächen sowie Entfernung störender Graffiti nach Prüfung des Untergrunds.',
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
    'heading' => 'Fassaden- und Graffitireinigung in Köln, Brühl, Bonn & Umgebung',
    'src' => '/assets/img/services/fassadenreinigung/fassadenreinigung-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/leistungen-fassadenreinigung.php',
  ),
);

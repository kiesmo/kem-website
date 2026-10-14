<?php
// Seitenkonfiguration für /bueroreinigung-bruehl/
return array (
  'title' => 'Büroreinigung Brühl | KEM Gebäudereinigung',
  'description' => 'Büroreinigung in Brühl direkt vom KEM-Firmensitz: für Büros, Praxen und Gewerbeflächen. Flexible Reinigungsintervalle und individuelles Angebot.',
  'path' => '/bueroreinigung-bruehl/',
  'og_image' => '/assets/img/locations/bueroreinigung-bruehl/bueroreinigung-bruehl-hero.webp',
  'breadcrumbs' => 
  array (
    0 => 
    array (
      'name' => 'Startseite',
      'path' => '/',
    ),
    1 => 
    array (
      'name' => 'Büro- und Gewerberaumreinigung',
      'path' => '/leistungen/buero-und-gewerberaumreinigung/',
    ),
    2 => 
    array (
      'name' => 'Büroreinigung Brühl',
      'path' => '/bueroreinigung-bruehl/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/bueroreinigung-bruehl/#service',
      'name' => 'Büroreinigung Brühl',
      'serviceType' => 'Büroreinigung',
      'url' => '/bueroreinigung-bruehl/',
      'description' => 'Büroreinigung in Brühl direkt vom KEM-Firmensitz: für Büros, Praxen und Gewerbeflächen. Flexible Reinigungsintervalle und individuelles Angebot.',
      'provider' => 
      array (
        '@id' => '/#business',
      ),
      'areaServed' => 
      array (
        '@type' => 'City',
        'name' => 'Brühl',
      ),
    ),
  ),
  'hero' => 
  array (
    'src' => '/assets/img/locations/bueroreinigung-bruehl/bueroreinigung-bruehl-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
    'tag' => 'Büroreinigung Brühl',
    'class' => 'hero-focus-left',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/bueroreinigung-bruehl.php',
  ),
);

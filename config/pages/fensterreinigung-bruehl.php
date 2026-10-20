<?php
// Seitenkonfiguration für /fensterreinigung-bruehl/
return array (
  'title' => 'Fensterreinigung Brühl | KEM Gebäudereinigung',
  'description' => 'Fenster- und Glasreinigung in Brühl durch KEM mit Firmensitz vor Ort. Für private und gewerbliche Objekte, Rahmen und Falze nach Vereinbarung.',
  'path' => '/fensterreinigung-bruehl/',
  'og_image' => '/assets/img/locations/fensterreinigung-bruehl/fensterreinigung-bruehl-hero.webp',
  'breadcrumbs' => 
  array (
    0 => 
    array (
      'name' => 'Startseite',
      'path' => '/',
    ),
    1 => 
    array (
      'name' => 'Glas- und Fensterreinigung',
      'path' => '/leistungen/glas-und-fensterreinigung/',
    ),
    2 => 
    array (
      'name' => 'Fensterreinigung Brühl',
      'path' => '/fensterreinigung-bruehl/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/fensterreinigung-bruehl/#service',
      'name' => 'Fensterreinigung Brühl',
      'serviceType' => 'Fensterreinigung',
      'url' => '/fensterreinigung-bruehl/',
      'description' => 'Fenster- und Glasreinigung in Brühl durch KEM mit Firmensitz vor Ort. Für private und gewerbliche Objekte, Rahmen und Falze nach Vereinbarung.',
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
  'offer_context' =>
  array (
    'city' => 'bruehl',
    'service' => 'window',
  ),
  'intro' =>
  array (
    'variant' => 'media',
    'eyebrow' => 'Fenster- & Glasreinigung in Brühl',
    'title' => 'Fensterreinigung in Brühl',
    'lead' => 'Mit Firmensitz in Brühl bietet KEM Fenster- und Glasreinigung für private und gewerbliche Objekte in der Stadt an. Umfang und Ausführung richten sich nach den vorhandenen Glasflächen, der Zugänglichkeit und den zusätzlich gewünschten Bereichen.',
  ),
  'hero' => 
  array (
    'class' => 'hero-focus-left',
    'src' => '/assets/img/locations/fensterreinigung-bruehl/fensterreinigung-bruehl-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/fensterreinigung-bruehl.php',
  ),
  'related_links' =>
  array (
    'heading' => 'Fensterreinigung in weiteren Einsatzgebieten',
    'links' =>
    array (
      array ('label' => 'Fensterreinigung Köln', 'href' => '/fensterreinigung-koeln/'),
      array ('label' => 'Fensterreinigung Bonn', 'href' => '/fensterreinigung-bonn/'),
    ),
  ),
);

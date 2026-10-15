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
  'intro' =>
  array (
    'variant' => 'media',
    'eyebrow' => 'Büro- & Gewerbereinigung in Brühl',
    'title' => 'Büroreinigung in Brühl',
    'lead' => 'KEM Gebäudereinigung hat seinen Firmensitz in Brühl. Für Büros, Praxen, Kanzleien, Ladenlokale und andere gewerblich genutzte Flächen stimmen wir Reinigungsumfang, Turnus und Ausführungszeiten individuell auf das jeweilige Objekt ab.',
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
  'related_links' =>
  array (
    'heading' => 'Büroreinigung in weiteren Einsatzgebieten',
    'links' =>
    array (
      array ('label' => 'Büroreinigung Köln', 'href' => '/bueroreinigung-koeln/'),
      array ('label' => 'Büroreinigung Bonn', 'href' => '/bueroreinigung-bonn/'),
    ),
  ),
);

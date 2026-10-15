<?php
// Seitenkonfiguration für /bueroreinigung-koeln/
return array (
  'title' => 'Büroreinigung Köln | KEM Gebäudereinigung',
  'description' => 'Professionelle Büroreinigung in Köln für Büros, Praxen, Kanzleien, Verwaltungen und Gewerbeflächen. Flexible Intervalle und individueller Leistungsumfang.',
  'path' => '/bueroreinigung-koeln/',
  'og_image' => '/assets/img/locations/bueroreinigung-koeln/bueroreinigung-koeln-hero.webp',
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
      'name' => 'Büroreinigung Köln',
      'path' => '/bueroreinigung-koeln/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/bueroreinigung-koeln/#service',
      'name' => 'Büroreinigung Köln',
      'serviceType' => 'Büroreinigung',
      'url' => '/bueroreinigung-koeln/',
      'description' => 'Professionelle Büroreinigung in Köln für Büros, Praxen, Kanzleien, Verwaltungen und Gewerbeflächen. Flexible Intervalle und individueller Leistungsumfang.',
      'provider' => 
      array (
        '@id' => '/#business',
      ),
      'areaServed' => 
      array (
        '@type' => 'City',
        'name' => 'Köln',
      ),
    ),
  ),
  'intro' =>
  array (
    'variant' => 'media',
    'eyebrow' => 'Büro- & Gewerbereinigung in Köln',
    'title' => 'Büroreinigung in Köln',
    'lead' => 'Vom Firmensitz in Brühl aus betreut KEM auch Büros, Praxen, Kanzleien, Verwaltungen und andere Gewerbeflächen in Köln. Die Büroreinigung wird passend zu Nutzung, Flächengröße und gewünschtem Turnus geplant; Leistungsumfang und Ausführungszeiten stimmen wir vorab klar ab.',
  ),
  'hero' => 
  array (
    'src' => '/assets/img/locations/bueroreinigung-koeln/bueroreinigung-koeln-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
    'tag' => 'Büroreinigung Köln',
    'class' => 'hero-focus-left',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/bueroreinigung-koeln.php',
  ),
  'related_links' =>
  array (
    'heading' => 'Büroreinigung in weiteren Einsatzgebieten',
    'links' =>
    array (
      array ('label' => 'Büroreinigung Brühl', 'href' => '/bueroreinigung-bruehl/'),
      array ('label' => 'Büroreinigung Bonn', 'href' => '/bueroreinigung-bonn/'),
    ),
  ),
);

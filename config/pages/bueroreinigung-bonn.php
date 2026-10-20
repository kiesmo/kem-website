<?php
// Seitenkonfiguration für /bueroreinigung-bonn/
return array (
  'title' => 'Büroreinigung Bonn | KEM Gebäudereinigung',
  'description' => 'Professionelle Büroreinigung in Bonn für Büros, Praxen, Verwaltungen und Gewerbeflächen. Flexible Intervalle, abgestimmte Zeiten und individuelles Angebot.',
  'path' => '/bueroreinigung-bonn/',
  'og_image' => '/assets/img/locations/bueroreinigung-bonn/bueroreinigung-bonn-hero.webp',
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
      'name' => 'Büroreinigung Bonn',
      'path' => '/bueroreinigung-bonn/',
    ),
  ),
  'schema_extra' => 
  array (
    0 => 
    array (
      '@type' => 'Service',
      '@id' => '/bueroreinigung-bonn/#service',
      'name' => 'Büroreinigung Bonn',
      'serviceType' => 'Büroreinigung',
      'url' => '/bueroreinigung-bonn/',
      'description' => 'Professionelle Büroreinigung in Bonn für Büros, Praxen, Verwaltungen und Gewerbeflächen. Flexible Intervalle, abgestimmte Zeiten und individuelles Angebot.',
      'provider' => 
      array (
        '@id' => '/#business',
      ),
      'areaServed' => 
      array (
        '@type' => 'City',
        'name' => 'Bonn',
      ),
    ),
  ),
  'offer_context' =>
  array (
    'city' => 'bonn',
    'service' => 'office',
  ),
  'intro' =>
  array (
    'variant' => 'media',
    'eyebrow' => 'Büro- & Gewerbereinigung in Bonn',
    'title' => 'Büroreinigung in Bonn',
    'lead' => 'KEM hat seinen Firmensitz in Brühl und übernimmt auch Büroreinigung für Büro-, Praxis-, Verwaltungs- und Gewerbeflächen in Bonn. Der Reinigungsplan richtet sich nach Nutzung, Flächen, gewünschter Häufigkeit und den betrieblichen Abläufen vor Ort.',
  ),
  'hero' => 
  array (
    'src' => '/assets/img/locations/bueroreinigung-bonn/bueroreinigung-bonn-hero.webp',
    'width' => 1920,
    'height' => 870,
    'alt' => '',
    'class' => 'hero-focus-left',
  ),
  'cta' => 
  array (
    'class' => 'cta-band service-cta-band',
    'content' => 'ctas/bueroreinigung-bonn.php',
  ),
  'related_links' =>
  array (
    'heading' => 'Büroreinigung in weiteren Einsatzgebieten',
    'links' =>
    array (
      array ('label' => 'Büroreinigung Köln', 'href' => '/bueroreinigung-koeln/'),
      array ('label' => 'Büroreinigung Brühl', 'href' => '/bueroreinigung-bruehl/'),
    ),
  ),
);

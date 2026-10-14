<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/galerie/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['gallery'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';

$galleryVideos = [
  [
    'src' => '/assets/video/services/glas-und-fensterreinigung/glas-und-fensterreinigung-praxis.mp4',
    'poster' => '/assets/img/services/glas-und-fensterreinigung/glas-und-fensterreinigung-praxis-poster.webp',
    'aria' => 'Video einer Glas- und Fensterreinigung',
    'title' => 'Glas- und Fensterreinigung in der Praxis',
    'description' => 'Kurzer Einblick in eine professionelle Fensterreinigung.',
    'service_url' => '/leistungen/glas-und-fensterreinigung/',
    'service_label' => 'Glas- und Fensterreinigung',
  ],
  [
    'src' => '/assets/video/pages/galerie/galerie-fensterreinigung-01.mp4',
    'poster' => '/assets/img/pages/galerie/galerie-fensterreinigung-01-poster.webp',
    'aria' => 'Video der Reinigung einer Dachverglasung',
    'title' => 'Dachverglasung in der Praxis',
    'description' => 'Reinigung einer Dachverglasung mit einem Teleskopsystem.',
    'service_url' => '/leistungen/glas-und-fensterreinigung/',
    'service_label' => 'Glas- und Fensterreinigung',
  ],
  [
    'src' => '/assets/video/pages/galerie/galerie-fensterreinigung-02.mp4',
    'poster' => '/assets/img/pages/galerie/galerie-fensterreinigung-02-poster.webp',
    'aria' => 'Video einer Fensterreinigung mit Abzieher',
    'title' => 'Glasreinigung mit Abzieher',
    'description' => 'Einblick in die Reinigung einer Glasfläche mit professionellem Abzieher.',
    'service_url' => '/leistungen/glas-und-fensterreinigung/',
    'service_label' => 'Glas- und Fensterreinigung',
  ],
  [
    'src' => '/assets/video/services/solaranlagenreinigung/solaranlagenreinigung-praxis.mp4',
    'poster' => '/assets/img/services/solaranlagenreinigung/solaranlagenreinigung-praxis-poster.webp',
    'aria' => 'Video einer Solaranlagenreinigung',
    'title' => 'Solaranlagenreinigung in der Praxis',
    'description' => 'Kurzer Einblick in die Reinigung einer Photovoltaikanlage.',
    'service_url' => '/leistungen/solaranlagenreinigung/',
    'service_label' => 'Solar- und Photovoltaikanlagenreinigung',
  ],
  [
    'src' => '/assets/video/services/polsterreinigung/polsterreinigung-praxis.mp4',
    'poster' => '/assets/img/services/polsterreinigung/polsterreinigung-praxis-poster.webp',
    'aria' => 'Video einer Polsterreinigung',
    'title' => 'Polsterreinigung in der Praxis',
    'description' => 'Kurzer Einblick in die professionelle Reinigung eines Polsters.',
    'service_url' => '/leistungen/polsterreinigung/',
    'service_label' => 'Polsterreinigung',
  ],
  [
    'src' => '/assets/video/services/fassadenreinigung/fassadenreinigung-praxis.mp4',
    'poster' => '/assets/img/services/fassadenreinigung/fassadenreinigung-praxis-poster.webp',
    'aria' => 'Video einer Graffitireinigung an einer Fassade',
    'title' => 'Graffitireinigung in der Praxis',
    'description' => 'Kurzer Einblick in die Entfernung von Graffiti an einer Außenfläche.',
    'service_url' => '/leistungen/fassadenreinigung/',
    'service_label' => 'Fassaden- und Graffitireinigung',
  ],
  [
    'src' => '/assets/video/services/teppichreinigung/teppichreinigung-praxis.mp4',
    'poster' => '/assets/img/services/teppichreinigung/teppichreinigung-praxis-poster.webp',
    'aria' => 'Video einer Teppichreinigung',
    'title' => 'Teppichreinigung in der Praxis',
    'description' => 'Kurzer Einblick in eine professionelle Teppichreinigung.',
    'service_url' => '/leistungen/teppichreinigung/',
    'service_label' => 'Teppichreinigung',
  ],
  [
    'src' => '/assets/video/services/grundreinigung/grundreinigung-praxis.mp4',
    'poster' => '/assets/img/services/grundreinigung/grundreinigung-praxis-poster.webp',
    'aria' => 'Video einer Bauendreinigung',
    'title' => 'Bauendreinigung in der Praxis',
    'description' => 'Kurzer Einblick in eine gründliche Reinigung nach Bau- oder Renovierungsarbeiten.',
    'service_url' => '/leistungen/grundreinigung/',
    'service_label' => 'Grund- und Spezialreinigung',
  ],
];
?>
<main id="main"><?php kem_render_page_hero($pageKey); ?><?php kem_render_breadcrumbs($pageKey); ?>
<section class="section">
<div class="container gallery-container">
<span class="eyebrow">Einblicke in unsere Arbeit</span>
<h1>Galerie</h1>
<p class="lead narrow">Videoeinblicke aus verschiedenen Reinigungsleistungen von KEM. Die Aufnahmen zeigen beispielhafte Arbeitssituationen; das konkrete Vorgehen stimmen wir immer auf Objekt, Oberfläche, Verschmutzung und Zugänglichkeit ab.</p>
<div class="video-gallery-grid" aria-label="Video-Galerie mit Einblicken in verschiedene Reinigungsleistungen">
<?php foreach ($galleryVideos as $video): ?>
<figure class="service-video-card gallery-video-card">
<div class="service-video-frame"><video controls playsinline preload="none" poster="<?= htmlspecialchars($video['poster'], ENT_QUOTES, 'UTF-8') ?>" aria-label="<?= htmlspecialchars($video['aria'], ENT_QUOTES, 'UTF-8') ?>"><source src="<?= htmlspecialchars($video['src'], ENT_QUOTES, 'UTF-8') ?>" type="video/mp4">Ihr Browser unterstützt die Videowiedergabe nicht.</video></div>
<figcaption><strong><?= htmlspecialchars($video['title'], ENT_QUOTES, 'UTF-8') ?></strong><span><?= htmlspecialchars($video['description'], ENT_QUOTES, 'UTF-8') ?></span><a class="gallery-card-link" href="<?= htmlspecialchars($video['service_url'], ENT_QUOTES, 'UTF-8') ?>">Zur Leistung: <?= htmlspecialchars($video['service_label'], ENT_QUOTES, 'UTF-8') ?></a></figcaption>
</figure>
<?php endforeach; ?>
</div>
</div>
</section>
<?php kem_render_page_cta($pageKey); ?></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

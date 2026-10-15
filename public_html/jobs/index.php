<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/jobs/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['jobs'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><?php kem_render_breadcrumbs($pageKey); ?>
<?php kem_render_page_intro($pageKey); ?><section class="section"><div class="container content-grid"><article><div class="job-box"><h2>Ihre Aufgaben</h2><ul><li>Gebäudereinigung im privaten und gewerblichen Bereich</li><li>Touren zum Kunden werden in der Regel zu zweit ausgeführt</li></ul><h2>Was Sie mitbringen</h2><ul><li>Berufserfahrung im Bereich Reinigung</li><li>Gültiger Pkw-Führerschein</li></ul><h2>Was wir bieten</h2><ul><li>Übertarifliche Bezahlung</li><li>Unbefristeter Arbeitsvertrag</li><li>Gutes Betriebsklima</li></ul></div></article><aside class="content-card"><img alt="Vorbereitung eines professionellen Reinigungseinsatzes" height="800" loading="lazy" src="/assets/img/pages/jobs/jobs-content.webp" width="1200"><h2>Firmensitz</h2><p>KEM Gebäudereinigung<br/><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?></p></aside></div></section><?php kem_render_page_cta($pageKey); ?></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

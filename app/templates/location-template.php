<?php
require_once dirname(__DIR__) . '/bootstrap.php';
if (empty($pageKey) || empty($locationContent)) {
    throw new RuntimeException('Standortseite ohne pageKey/locationContent.');
}
$contentFile = KEM_CONTENT_DIR . '/locations/' . basename($locationContent) . '.php';
if (!is_file($contentFile)) {
    throw new RuntimeException('Inhalt der Standortseite fehlt: ' . $locationContent);
}
?><!DOCTYPE html>
<html lang="de"><?php require KEM_TEMPLATES_DIR . '/head.php'; ?><body class="has-hero"><?php
$headerMode = 'overlay';
$navActive = [];
$servicesCurrent = !str_starts_with($pageKey, '/gebaeudereinigung-');
$footerVariant = 'full';
require KEM_TEMPLATES_DIR . '/header.php';
?>
<main id="main">
<?php kem_render_page_hero($pageKey); ?>
<?php kem_render_breadcrumbs($pageKey); ?>
<?php require $contentFile; ?>
<?php kem_render_page_cta($pageKey); ?>
</main><?php require KEM_TEMPLATES_DIR . '/footer.php'; ?></body></html>

<?php
require_once dirname(__DIR__) . '/bootstrap.php';
$service = kem_service_data($serviceKey);
$serviceCatalog = kem_service_catalog();
$pageKey = $service['route'];
?>
<!DOCTYPE html>
<html lang="de"><?php require KEM_TEMPLATES_DIR . '/head.php'; ?><body><?php
$navActive = [$service['nav_key']];
$servicesCurrent = true;
require KEM_TEMPLATES_DIR . '/header.php';
?>
<main id="main">
<?php kem_render_breadcrumbs($pageKey); ?>
<?php kem_render_page_intro($pageKey, $service['article']); ?>
<section class="section"><div class="container content-grid"><article class="service-detail prose"><?php kem_render_content($service['article']['body_content']); ?></article><aside class="content-card service-summary-card"><?php kem_render_image($service['summary_image']); ?><?php kem_render_content($service['summary_content']); ?></aside></div></section>
<?php kem_render_page_cta($pageKey); ?>
<section class="section service-more-section"><div class="container"><h2>Weitere Leistungen von KEM Gebäudereinigung</h2><nav aria-label="Weitere Leistungen" class="service-nav"><?php foreach ($serviceCatalog as $route => $item): if ($route === $pageKey) continue; ?><a href="<?= kem_h($route) ?>"><?= kem_h($item['label']) ?></a><?php endforeach; ?></nav></div></section>
</main>
<?php require KEM_TEMPLATES_DIR . '/footer.php'; ?></body></html>

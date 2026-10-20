<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/faq/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['faq'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main class="task-page task-page--faq" id="main"><?php kem_render_breadcrumbs($pageKey); ?>
<?php kem_render_page_intro($pageKey); ?><section class="section task-content"><div class="container faq-container"><div class="faq-list"><?php foreach (kem_page_data($pageKey)['faq_items'] as $faqItem): ?>
<details class="faq-item"><summary><span><?= kem_h($faqItem['question']) ?></span></summary><p><?= kem_h($faqItem['answer']) ?></p></details>
<?php endforeach; ?></div></div></section><?php kem_render_page_cta($pageKey); ?></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

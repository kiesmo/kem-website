<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/faq/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['faq'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><?php kem_render_page_hero($pageKey); ?><?php kem_render_breadcrumbs($pageKey); ?><section class="section"><div class="container faq-container"><span class="eyebrow">Fragen &amp; Antworten</span><h1>Häufige Fragen zu Reinigung, Ablauf und Angebot</h1><p class="lead narrow">Hier finden Sie Antworten auf allgemeine Fragen rund um die Zusammenarbeit mit KEM Gebäudereinigung. Fragen zu einer bestimmten Leistung klären wir gern direkt mit Ihnen.</p><div class="faq-list"><?php foreach (kem_page_data($pageKey)['schema_extra'][0]['mainEntity'] as $question): ?><details class="faq-item"><summary><?= kem_h($question['name']) ?></summary><p><?= kem_h($question['acceptedAnswer']['text']) ?></p></details><?php endforeach; ?></div></div></section><?php kem_render_page_cta($pageKey); ?></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

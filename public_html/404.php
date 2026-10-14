<?php http_response_code(404); ?>
<!DOCTYPE html>
<html lang="de"><?php $pageKey = '/404.php'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$headerMode = 'opaque'; $navActive = []; $servicesCurrent = false; $footerVariant = 'full';
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><section class="section"><div class="container narrow text-center"><span class="eyebrow">Fehler 404</span><h1>Diese Seite wurde nicht gefunden</h1><p>Die Adresse ist möglicherweise veraltet oder fehlerhaft. Über die Startseite und die Leistungsübersicht finden Sie alle aktuellen Inhalte.</p><p><a class="btn" href="/">Zur Startseite</a> <a class="btn secondary" href="/leistungen/">Zu den Leistungen</a></p></div></section></main>
<?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

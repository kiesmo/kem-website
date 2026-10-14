<?php http_response_code(404); ?>
<!DOCTYPE html>
<html lang="de"><?php $pageKey = '/404.php'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = []; $servicesCurrent = false; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><section class="section error-section"><div class="container narrow text-center"><p class="error-code" aria-hidden="true">404</p><h1>Diese Seite wurde nicht gefunden</h1><p>Die Adresse ist möglicherweise veraltet oder fehlerhaft. Über die Startseite und die Leistungsübersicht finden Sie alle aktuellen Inhalte.</p><p><a class="btn" href="/">Zur Startseite</a> <a class="btn secondary" href="/leistungen/">Zu den Leistungen</a></p></div></section></main>
<?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

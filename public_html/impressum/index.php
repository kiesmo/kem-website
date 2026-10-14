<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/impressum/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body ><?php
$headerMode = 'opaque';
$navActive = [];
$servicesCurrent = false;
$footerVariant = 'full';
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><?php kem_render_breadcrumbs($pageKey); ?><section class="section legal"><div class="container narrow"><h1>Impressum</h1><h2>Angaben gemäß § 5 DDG</h2><p>KEM Gebäudereinigung<br/>Kian Motlagh<br/><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?><br><?= kem_h($kem['country']) ?></p><h2>Kontakt</h2><p>Telefon: <a href="tel:<?= kem_h($kem['phone_href']) ?>"><?= kem_h($kem['phone_display']) ?></a><br/>E-Mail: <a href="mailto:<?= kem_h($kem['email']) ?>"><?= kem_h($kem['email']) ?></a></p><h2>Haftung für Inhalte</h2><p>Als Diensteanbieter sind wir für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich.</p><h2>Haftung für Links</h2><p>Für Inhalte externer Seiten ist der jeweilige Anbieter verantwortlich. Bei Bekanntwerden von Rechtsverletzungen werden entsprechende Links entfernt.</p><h2>Urheberrecht</h2><p>Die Inhalte und Gestaltung dieser Website unterliegen den jeweils geltenden Nutzungs- und Urheberrechten.</p></div></section></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>

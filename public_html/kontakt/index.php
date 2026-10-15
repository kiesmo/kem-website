<!DOCTYPE html>
<html lang="de"><?php
$pageKey = '/kontakt/';
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php';
?><body><?php
$navActive = ['contact'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main" class="task-page task-page--contact">
<?php kem_render_breadcrumbs($pageKey); ?>
<?php kem_render_page_intro($pageKey); ?>
<section class="section task-content">
<div class="container">
<section class="contact-direct" aria-labelledby="contact-direct-title">
<h2 id="contact-direct-title">Direkt Kontakt aufnehmen</h2>
<dl class="contact-direct__details">
<div><dt>Telefon</dt><dd><a href="tel:<?= kem_h($kem['phone_href']) ?>"><?= kem_h($kem['phone_display']) ?></a></dd></div>
<div><dt>E-Mail</dt><dd><a href="mailto:<?= kem_h($kem['email']) ?>"><?= kem_h($kem['email']) ?></a></dd></div>
<div><dt>Telefonisch erreichbar</dt><dd><?= kem_h($kem['opening_hours']['days_display']) ?>: <?= kem_h($kem['opening_hours']['opens']) ?> bis <?= kem_h($kem['opening_hours']['closes']) ?> Uhr</dd></div>
</dl>
<p class="contact-direct__note">Reinigungstermine nach Vereinbarung; Einsatzzeiten sind auch außerhalb dieser Zeiten möglich.</p>
</section>
<div class="contact-layout">
<div class="contact-message">
<h2>Nachricht senden</h2>
<p>Schreiben Sie uns hier eine allgemeine Nachricht. Für ein Angebot mit Angaben zu Objekt und gewünschter Leistung nutzen Sie die <?php kem_render_action(kem_offer_action($pageKey, 'detaillierte Angebotsanfrage'), 'inline'); ?>.</p>
<form action="/api/kontakt.php" data-ajax="" method="post"><input name="form_type" type="hidden" value="kontakt"/><div aria-hidden="true" class="hp"><label>Website<input autocomplete="off" name="website" tabindex="-1"/></label></div><div class="form-grid"><div class="field"><label for="name">Name *</label><input autocomplete="name" id="name" maxlength="100" name="name" required=""/></div><div class="field"><label for="email">E-Mail *</label><input autocomplete="email" id="email" maxlength="160" name="email" required="" type="email"/></div><div class="field"><label for="phone">Telefon</label><input autocomplete="tel" id="phone" inputmode="tel" maxlength="30" name="phone" pattern="[0-9+\(\) \/.\-]{6,30}" type="tel"/></div><div class="field full"><label for="message">Mitteilung *</label><textarea id="message" maxlength="5000" name="message" required=""></textarea></div><div class="field full checkbox"><input id="privacy" name="privacy" required="" type="checkbox" value="1"/><label for="privacy">Ich habe die <a href="/datenschutz/" rel="noopener" target="_blank"><u>Datenschutzerklärung</u></a> zur Kenntnis genommen. Meine Angaben werden zur Bearbeitung meiner Anfrage verarbeitet. *</label></div><div class="field full"><button class="btn" type="submit">Nachricht senden</button><div aria-live="polite" class="form-status" role="status"></div></div></div></form>
</div>
<aside class="content-card contact-location">
<h2>Firmensitz in Brühl</h2>
<address><strong><?= kem_h($kem['name']) ?></strong><br><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?><br><?= kem_h($kem['country']) ?></address>
<h3>Einsatzgebiet</h3>
<p>Wir sind in <a href="/gebaeudereinigung-koeln/">Köln</a>, <a href="/gebaeudereinigung-bruehl/">Brühl</a>, <a href="/gebaeudereinigung-bonn/">Bonn</a> und der umliegenden Region für Sie im Einsatz.</p>
<div class="contact-whatsapp"><p class="contact-whatsapp__text">Alternativ direkt schreiben:</p><?php kem_render_action(kem_whatsapp_action($pageKey)); ?></div>
</aside>
</div>
</div>
</section>
</main>
<?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?>
</body></html>

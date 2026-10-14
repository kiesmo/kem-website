<?php
require_once dirname(__DIR__) . '/bootstrap.php';
$kem = kem_site_config();
?>
<footer class="site-footer">
<div class="container footer-intro"><p>Sauberkeit, die bleibt.</p><a class="btn" href="/angebotsanfrage/">Ihr Objekt anfragen</a></div>
<div class="container footer-main">
<div class="footer-logo"><img alt="KEM Gebäudereinigung" src="/assets/branding/logo-inverted.svg" width="1050" height="250"><p>Professionelle Gebäudereinigung für private und gewerbliche Kunden in <?= kem_h($kem['service_area']) ?>.</p><p class="footer-area-links"><strong>Einsatzgebiete</strong><br><a href="/gebaeudereinigung-bruehl/">Brühl</a> · <a href="/gebaeudereinigung-koeln/">Köln</a> · <a href="/gebaeudereinigung-bonn/">Bonn</a></p></div>
<div><h2>Direkt in Kontakt</h2><address><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?><br><a href="tel:<?= kem_h($kem['phone_href']) ?>"><?= kem_h($kem['phone_display']) ?></a><br><a href="mailto:<?= kem_h($kem['email']) ?>"><?= kem_h($kem['email']) ?></a></address><p><a href="<?= kem_h($kem['whatsapp_url']) ?>" target="_blank" rel="noopener noreferrer">Per WhatsApp schreiben</a></p></div>
<div class="footer-services"><h2>Reinigungsleistungen</h2><ul><li><a href="/leistungen/buero-und-gewerberaumreinigung/">Büro- &amp; Gewerbereinigung</a></li><li><a href="/leistungen/glas-und-fensterreinigung/">Glas- &amp; Fensterreinigung</a></li><li><a href="/leistungen/grundreinigung/">Grund- &amp; Spezialreinigung</a></li><li><a href="/leistungen/">Alle Leistungen</a></li><li><a href="/galerie/">Einblicke in die Arbeit</a></li></ul></div>
<div><h2>Gut zu wissen</h2><ul><li><a href="/ueber-uns/">Über KEM</a></li><li><a href="/faq/">Fragen &amp; Antworten</a></li><li><a href="/jobs/">Arbeiten bei KEM</a></li></ul><p>Telefonisch erreichbar:<br><?= kem_h($kem['opening_hours']['days_display']) ?>: <?= kem_h($kem['opening_hours']['opens']) ?>–<?= kem_h($kem['opening_hours']['closes']) ?> Uhr</p><p>Einsatzzeiten auch außerhalb der Öffnungszeiten möglich.</p></div>
</div>
<div class="footer-meta"><div class="container"><span>© <?= date('Y') ?> KEM Gebäudereinigung</span><span class="footer-links"><a href="/kontakt/">Kontakt</a><a href="/impressum/">Impressum</a><a href="/datenschutz/">Datenschutz</a></span></div></div>
</footer>
<nav class="utility-nav" aria-label="Zur Seitenoberkante"><button class="backtop" type="button" aria-label="Nach oben">↑</button></nav>
<script defer src="/assets/js/core/main.js?v=<?= kem_h($kem['asset_version']) ?>"></script>

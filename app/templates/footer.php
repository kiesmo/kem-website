<?php
require_once dirname(__DIR__) . '/bootstrap.php';
$kem = $kem ?? kem_site_config();
$footerAction = kem_page_primary_action($pageKey ?? '/');
function kem_footer_meta(): void { ?>
<div class="footer-meta"><div class="container"><span>© <?= date('Y') ?> KEM Gebäudereinigung</span><span class="footer-links"><a href="/kontakt/">Kontakt</a><a href="/impressum/">Impressum</a><a href="/datenschutz/">Datenschutz</a></span></div></div>
<?php }
?>
<footer class="site-footer">
<div class="container footer-main">
<div class="footer-logo">
<img alt="KEM Gebäudereinigung" height="250" src="/assets/branding/logo-inverted.svg" width="1050">
<p>Gebäudereinigung für private und gewerbliche Objekte.</p>
<p class="footer-area-links"><strong>Einsatzgebiete</strong><br><a href="/gebaeudereinigung-bruehl/">Brühl</a> · <a href="/gebaeudereinigung-koeln/">Köln</a> · <a href="/gebaeudereinigung-bonn/">Bonn</a> und Umgebung</p>
</div>
<div class="footer-contact">
<h2>Kontakt</h2>
<address><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?><br><a href="tel:<?= kem_h($kem['phone_href']) ?>"><?= kem_h($kem['phone_display']) ?></a><br><a href="mailto:<?= kem_h($kem['email']) ?>"><?= kem_h($kem['email']) ?></a></address>
<p class="footer-hours"><strong>Öffnungszeiten</strong><br><?= kem_h($kem['opening_hours']['days_display']) ?>: <?= kem_h($kem['opening_hours']['opens']) ?> bis <?= kem_h($kem['opening_hours']['closes']) ?> Uhr<br><span>Einsatzzeiten auch außerhalb der Öffnungszeiten möglich.</span></p>
</div>
<div class="footer-services">
<h2>Leistungen</h2>
<ul><li><a href="/leistungen/buero-und-gewerberaumreinigung/">Büro- &amp; Gewerbereinigung</a></li><li><a href="/leistungen/glas-und-fensterreinigung/">Glas- &amp; Fensterreinigung</a></li><li><a href="/leistungen/grundreinigung/">Grund- &amp; Spezialreinigung</a></li><li><a href="/leistungen/">Alle Leistungen</a></li></ul>
<?php if ($footerAction !== null): ?>
<p class="footer-action"><?php kem_render_action($footerAction, 'inline', 'footer-primary-action'); ?></p>
<?php endif; ?>
</div>
</div>
<?php kem_footer_meta(); ?>
</footer>
<button aria-label="Nach oben" class="backtop" type="button">↑</button>
<script defer src="/assets/js/core/main.js?v=<?= kem_h($kem['asset_version']) ?>"></script>

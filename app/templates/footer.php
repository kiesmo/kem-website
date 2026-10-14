<?php
require_once dirname(__DIR__) . '/bootstrap.php';
$kem = $kem ?? kem_site_config();
$footerVariant = $footerVariant ?? 'full';
$footerShowMap = $footerShowMap ?? false;
function kem_footer_meta(): void { ?>
<div class="footer-meta"><div class="container"><span>© <?= date('Y') ?> KEM Gebäudereinigung</span><span class="footer-links"><a href="/kontakt/">Kontakt</a><a href="/impressum/">Impressum</a><a href="/datenschutz/">Datenschutz</a></span></div></div>
<?php }
?>
<?php if ($footerVariant === 'legal'): ?>
<footer class="site-footer site-footer-legal"><?php kem_footer_meta(); ?></footer>
<?php else: ?>
<?php if ($footerShowMap): ?><div class="site-footer-region"><?php endif; ?>
<footer class="site-footer">
<div class="container footer-main">
<div class="footer-logo"><img alt="KEM Gebäudereinigung" height="250" src="/assets/branding/logo-inverted.svg" width="1050"><p>Professionelle Gebäudereinigung für private und gewerbliche Kunden in <span><?= kem_h($kem['service_area']) ?></span>.</p></div>
<div><h2>Kontakt</h2><address><span><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?><br></span><a href="tel:<?= kem_h($kem['phone_href']) ?>"><?= kem_h($kem['phone_display']) ?></a><br><a href="mailto:<?= kem_h($kem['email']) ?>"><?= kem_h($kem['email']) ?></a></address><p class="footer-area-links"><strong>Einsatzgebiete</strong><br><a href="/gebaeudereinigung-bruehl/">Brühl</a> · <a href="/gebaeudereinigung-koeln/">Köln</a> · <a href="/gebaeudereinigung-bonn/">Bonn</a></p></div>
<div class="footer-services"><h2>Leistungen</h2><ul><li><a href="/leistungen/buero-und-gewerberaumreinigung/">Büro- &amp; Gewerbereinigung</a></li><li><a href="/leistungen/glas-und-fensterreinigung/">Glas- &amp; Fensterreinigung</a></li><li><a href="/leistungen/grundreinigung/">Grund- &amp; Spezialreinigung</a></li><li><a href="/leistungen/">Alle Leistungen</a></li></ul></div>
<div><h2>Öffnungszeiten</h2><p><?= kem_h($kem['opening_hours']['days_display']) ?>: <?= kem_h($kem['opening_hours']['opens']) ?> bis <?= kem_h($kem['opening_hours']['closes']) ?> Uhr</p><p>Einsatzzeiten auch außerhalb der Öffnungszeiten möglich.</p><p><a class="btn" href="/angebotsanfrage/">Kostenloses Angebot</a></p></div>
</div>
<?php if (!$footerShowMap) kem_footer_meta(); ?>
</footer>
<?php if ($footerShowMap): ?>
<section aria-label="Standort von KEM Gebäudereinigung in Brühl" class="location-map-section"><iframe allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=<?= rawurlencode($kem['street'] . ', ' . $kem['postal_code'] . ' ' . $kem['city']) ?>&amp;output=embed" title="Google Maps – <?= kem_h($kem['name']) ?>, <?= kem_h($kem['street']) ?> in <?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?>"></iframe></section>
<footer class="site-footer site-footer-legal"><?php kem_footer_meta(); ?></footer></div>
<?php endif; ?>
<?php endif; ?>
<a aria-label="WhatsApp-Chat mit KEM Gebäudereinigung öffnen" class="whatsapp-chat" href="<?= kem_h($kem['whatsapp_url']) ?>" rel="noopener noreferrer" target="_blank"><svg aria-hidden="true" class="whatsapp-chat__icon" focusable="false" viewBox="0 0 24 24"><path d="M19.11 4.93A9.77 9.77 0 0 0 12.13 2c-5.41 0-9.8 4.39-9.8 9.8 0 1.73.45 3.43 1.3 4.93L2 22l5.43-1.42A9.77 9.77 0 0 0 12.13 21c5.41 0 9.8-4.39 9.8-9.8a9.77 9.77 0 0 0-2.82-6.27Zm-6.98 14.45c-1.48 0-2.92-.4-4.18-1.15l-.3-.18-3.22.84.86-3.14-.2-.32a7.83 7.83 0 0 1-1.21-4.15c0-4.33 3.52-7.85 7.85-7.85 2.09 0 4.06.81 5.54 2.29a7.78 7.78 0 0 1 2.3 5.56c0 4.33-3.53 7.86-7.44 7.86Zm4.3-5.86c-.24-.12-1.43-.71-1.65-.79-.22-.08-.38-.12-.54.12-.16.24-.62.79-.76.95-.14.16-.28.18-.52.06-.24-.12-1.03-.38-1.95-1.2-.72-.64-1.2-1.43-1.34-1.67-.14-.24-.01-.37.11-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.48-.4-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 1.99s.86 2.31.98 2.47c.12.16 1.68 2.57 4.07 3.61.57.25 1.01.39 1.36.49.57.18 1.09.15 1.5.09.46-.07 1.43-.58 1.63-1.13.2-.55.2-1.03.14-1.13-.06-.1-.22-.16-.46-.28Z" fill="currentColor"></path></svg><span class="whatsapp-chat__label">WhatsApp</span></a>
<button aria-label="Nach oben" class="backtop" type="button">↑</button>
<script defer src="/assets/js/core/main.js?v=<?= kem_h($kem['asset_version']) ?>"></script>

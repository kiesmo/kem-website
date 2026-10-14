<?php
require_once dirname(__DIR__) . '/bootstrap.php';
$kem = kem_site_config();
$headerMode = $headerMode ?? 'opaque';
$navActive = $navActive ?? [];
$servicesCurrent = $servicesCurrent ?? false;
$hiddenNavItems = $hiddenNavItems ?? [];
$headerClass = $headerMode === 'overlay' ? 'site-header is-overlay' : 'site-header is-opaque';

if (!is_array($navActive)) {
    $navActive = $navActive === null ? [] : [$navActive];
}
if (!function_exists('kem_current_attr')) {
    function kem_current_attr(array $active, string $key): string
    {
        return in_array($key, $active, true) ? ' aria-current="page"' : '';
    }
}
?>
<a class="skip-link" href="#main">Zum Inhalt springen</a>
<header class="<?= htmlspecialchars($headerClass, ENT_QUOTES, 'UTF-8') ?>">
<div class="topbar">
<div class="container topbar-inner">
<span>WIR BERATEN SIE GERNE!</span>
<a aria-label="KEM Gebäudereinigung anrufen" href="tel:<?= htmlspecialchars($kem['phone_href'], ENT_QUOTES, 'UTF-8') ?>"><span aria-hidden="true">☎</span>&nbsp; <span><?= htmlspecialchars($kem['phone_display'], ENT_QUOTES, 'UTF-8') ?></span></a>
</div>
</div>
<div class="container header-inner">
<a<?= kem_current_attr($navActive, 'home') ?> aria-label="KEM Gebäudereinigung – Startseite" class="brand" href="/">
<img alt="KEM Gebäudereinigung" class="brand-logo brand-logo--solid" height="250" src="/assets/branding/logo.svg" width="1050"/>
<img alt="" aria-hidden="true" class="brand-logo brand-logo--overlay" height="250" src="/assets/branding/logo-inverted.svg" width="1050"/>
</a>
<button aria-controls="main-nav" aria-expanded="false" aria-label="Menü öffnen" class="menu-toggle" type="button"><span></span></button>
<nav aria-label="Hauptnavigation" class="nav" id="main-nav">
<ul class="nav-list">
<li><a<?= kem_current_attr($navActive, 'about') ?> href="/ueber-uns/">Über uns</a></li>
<li class="has-dropdown">
<button aria-expanded="false" class="drop-toggle<?= $servicesCurrent ? ' is-current' : '' ?>" type="button">Leistungen <span aria-hidden="true">⌄</span></button>
<ul class="dropdown">
<li><a<?= kem_current_attr($navActive, 'services') ?> href="/leistungen/">Alle Leistungen</a></li>
<li><a<?= kem_current_attr($navActive, 'service-office') ?> href="/leistungen/buero-und-gewerberaumreinigung/">Büro &amp; Gewerbe</a></li>
<li><a<?= kem_current_attr($navActive, 'service-glass') ?> href="/leistungen/glas-und-fensterreinigung/">Glas &amp; Fenster</a></li>
<li><a<?= kem_current_attr($navActive, 'service-basic') ?> href="/leistungen/grundreinigung/">Grund &amp; Spezial</a></li>
<?php if (!in_array('service-carpet', $hiddenNavItems, true)): ?><li><a<?= kem_current_attr($navActive, 'service-carpet') ?> href="/leistungen/teppichreinigung/">Teppichreinigung</a></li><?php endif; ?>
<li><a<?= kem_current_attr($navActive, 'service-upholstery') ?> href="/leistungen/polsterreinigung/">Polsterreinigung</a></li>
<li><a<?= kem_current_attr($navActive, 'service-clearance') ?> href="/leistungen/entruempelung/">Entrümpelung</a></li>
<li><a<?= kem_current_attr($navActive, 'service-facade') ?> href="/leistungen/fassadenreinigung/">Fassade &amp; Graffiti</a></li>
<li><a<?= kem_current_attr($navActive, 'service-solar') ?> href="/leistungen/solaranlagenreinigung/">Solar &amp; Photovoltaik</a></li>
</ul>
</li>
<li><a<?= kem_current_attr($navActive, 'gallery') ?> href="/galerie/">Galerie</a></li>
<li><a<?= kem_current_attr($navActive, 'faq') ?> href="/faq/">FAQ</a></li>
<li><a<?= kem_current_attr($navActive, 'jobs') ?> href="/jobs/">Jobs</a></li>
<li><a<?= kem_current_attr($navActive, 'contact') ?> href="/kontakt/">Kontakt</a></li>
<li class="mobile-offer-item"><a class="btn mobile-offer-cta" href="/angebotsanfrage/">Kostenloses Angebot anfordern</a></li>
</ul>
</nav>
<a<?= kem_current_attr($navActive, 'offer') ?> class="btn header-cta" href="/angebotsanfrage/">Angebot anfordern</a>
</div>
</header>

<?php
if (!function_exists('kem_render_page_hero')) {
    function kem_render_page_hero(string $pageKey): void {
        $hero = kem_page_data($pageKey)['hero'] ?? null;
        if (!$hero) return;
        $heroClass = trim('page-hero ' . ($hero['class'] ?? ''));
        $mobileTag = $hero['mobile_tag'] ?? $hero['tag'] ?? '';
        echo '<section aria-label="Seitenmotiv" class="' . kem_h($heroClass) . '"><div class="hero-picture">';
        echo '<img alt="' . kem_h($hero['alt'] ?? '') . '" fetchpriority="high" width="' . (int)$hero['width'] . '" height="' . (int)$hero['height'] . '" src="' . kem_h($hero['src']) . '">';
        echo '</div><div class="container"><div class="hero-tag"><span class="hero-tag-desktop">' . kem_h($hero['tag'] ?? '') . '</span><span class="hero-tag-mobile">' . kem_h($mobileTag) . '</span></div></div></section>';
    }
}
if (!function_exists('kem_render_breadcrumbs')) {
    function kem_render_breadcrumbs(string $pageKey): void {
        $crumbs = kem_page_data($pageKey)['breadcrumbs'] ?? [];
        if (!$crumbs) return;
        echo '<nav aria-label="Brotkrümelnavigation" class="breadcrumb-bar"><div class="container"><ol class="breadcrumbs">';
        $last = count($crumbs) - 1;
        foreach ($crumbs as $i => $crumb) {
            if ($i === $last) echo '<li><span aria-current="page">' . kem_h($crumb['name']) . '</span></li>';
            else echo '<li><a href="' . kem_h($crumb['path']) . '">' . kem_h($crumb['name']) . '</a></li>';
        }
        echo '</ol></div></nav>';
    }
}
if (!function_exists('kem_render_mobile_offer_cta')) {
    function kem_render_mobile_offer_cta(string $label = 'Kostenloses Angebot anfordern'): void {
        echo '<aside class="service-mobile-cta" aria-label="Angebot anfordern"><strong>Unverbindliches Angebot gewünscht?</strong><span>Schicken Sie uns kurz die wichtigsten Eckdaten zu Ihrem Objekt.</span><a class="btn" href="/angebotsanfrage/">' . kem_h($label) . '</a></aside>';
    }
}
if (!function_exists('kem_render_page_cta')) {
    function kem_render_page_cta(string $pageKey): void {
        $cta = kem_page_data($pageKey)['cta'] ?? null;
        if (!$cta) return;
        echo '<section class="' . kem_h($cta['class'] ?? 'cta-band') . '"><div class="container">';
        if (!empty($cta['content'])) kem_render_content($cta['content'], true);
        echo '</div></section>';
    }
}

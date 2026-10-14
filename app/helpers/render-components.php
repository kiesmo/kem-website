<?php
if (!function_exists('kem_render_page_hero')) {
    function kem_render_page_hero(string $pageKey, ?array $intro = null): void {
        $hero = kem_page_data($pageKey)['hero'] ?? null;
        if (!$hero) return;
        if ($intro === null) {
            static $intros = null;
            $intros ??= require KEM_CONFIG_DIR . '/page-intros.php';
            $intro = $intros[$pageKey] ?? null;
        }
        $heroClass = trim('page-hero ' . ($intro ? 'page-hero--service ' : 'page-hero--utility ') . ($hero['class'] ?? ''));
        $mobileTag = $hero['mobile_tag'] ?? $hero['tag'] ?? '';
        echo '<section ' . ($intro ? 'aria-labelledby="page-title"' : 'aria-label="Seitenmotiv"') . ' class="' . kem_h($heroClass) . '"><div class="container">';
        if ($intro) {
            echo '<div class="page-hero-copy"><span class="eyebrow">' . kem_h($intro['eyebrow'] ?? '') . '</span><h1 id="page-title">' . kem_h($intro['title']) . '</h1><p class="lead">' . kem_h($intro['lead']) . '</p><a class="btn" href="' . kem_h(kem_offer_url(kem_offer_context($pageKey))) . '">Kostenloses Angebot anfordern</a><p class="hero-assurance">Kostenlos und unverbindlich.</p></div>';
        }
        echo '<div class="hero-picture">';
        echo '<img alt="' . kem_h($hero['alt'] ?? '') . '" fetchpriority="high" width="' . (int)$hero['width'] . '" height="' . (int)$hero['height'] . '" src="' . kem_h($hero['src']) . '">';
        echo '</div>';
        if (!$intro) echo '<div class="hero-tag"><span class="hero-tag-desktop">' . kem_h($hero['tag'] ?? '') . '</span><span class="hero-tag-mobile">' . kem_h($mobileTag) . '</span></div>';
        echo '</div></section>';
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
    function kem_render_mobile_offer_cta(string $label = 'Kostenloses Angebot anfordern', ?string $pageKey = null): void {
        echo '<aside class="service-mobile-cta" aria-label="Angebot anfordern"><strong>Unverbindliches Angebot gewünscht?</strong><span>Schicken Sie uns kurz die wichtigsten Eckdaten zu Ihrem Objekt.</span><a class="btn" href="' . kem_h(kem_offer_url($pageKey ? kem_offer_context($pageKey) : [])) . '">' . kem_h($label) . '</a></aside>';
    }
}
if (!function_exists('kem_render_page_cta')) {
    function kem_render_page_cta(string $pageKey): void {
        $cta = kem_page_data($pageKey)['cta'] ?? null;
        if (!$cta) return;
        echo '<section class="' . kem_h($cta['class'] ?? 'cta-band') . '"><div class="container">';
        if (!empty($cta['content'])) kem_render_content($cta['content'], true, ['offer_url' => kem_offer_url(kem_offer_context($pageKey))]);
        echo '</div></section>';
    }
}

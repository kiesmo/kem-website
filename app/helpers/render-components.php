<?php
if (!function_exists('kem_offer_url')) {
    function kem_offer_url(string $pageKey): string {
        $serviceKeys = [
            'buero-und-gewerberaumreinigung' => 'office', 'glas-und-fensterreinigung' => 'window',
            'grundreinigung' => 'general', 'teppichreinigung' => 'carpet', 'polsterreinigung' => 'upholstery',
            'entruempelung' => 'clearance', 'fassadenreinigung' => 'graffiti', 'solaranlagenreinigung' => 'solar',
        ];
        $query = [];
        $slug = basename(trim($pageKey, '/'));
        if (isset($serviceKeys[$slug])) $query['leistung'] = $serviceKeys[$slug];
        if (preg_match('~^/(buero|fenster|gebaeude)reinigung-(koeln|bruehl|bonn)/$~', $pageKey, $match)) {
            $cities = ['koeln' => 'Köln', 'bruehl' => 'Brühl', 'bonn' => 'Bonn'];
            $query['ort'] = $cities[$match[2]];
            if ($match[1] !== 'gebaeude') $query['leistung'] = $match[1] === 'buero' ? 'office' : 'window';
        }
        return '/angebotsanfrage/' . ($query ? '?' . http_build_query($query) : '');
    }
}
if (!function_exists('kem_render_page_hero')) {
    function kem_render_page_hero(string $pageKey): void {
        $page = kem_page_data($pageKey);
        $hero = $page['hero'] ?? null;
        if (!$hero) return;
        $compact = in_array($pageKey, ['/faq/', '/kontakt/', '/jobs/', '/galerie/'], true);
        $classes = trim('page-hero ' . ($compact ? 'page-hero--compact ' : '') . ($hero['class'] ?? ''));
        echo '<section class="' . kem_h($classes) . '"><div class="container page-hero-grid"><div class="page-hero-copy">';
        echo '<span class="eyebrow">KEM Gebäudereinigung · Brühl, Köln &amp; Bonn</span>';
        echo '<h1>' . kem_h($hero['heading']) . '</h1><p class="hero-intro">' . kem_h($page['description']) . '</p>';
        echo '<div class="hero-actions">';
        if ($pageKey === '/jobs/') {
            echo '<a class="btn" href="mailto:' . kem_h(kem_site_config()['email']) . '?subject=Bewerbung%20bei%20KEM">Jetzt bewerben</a>';
        } else {
            echo '<a class="btn" href="' . kem_h(kem_offer_url($pageKey)) . '">Kostenloses Angebot</a>';
        }
        echo '<a class="btn secondary" href="' . ($pageKey === '/kontakt/' ? 'tel:' . kem_h(kem_site_config()['phone_href']) : '/kontakt/') . '">' . ($pageKey === '/kontakt/' ? 'Direkt anrufen' : 'Kontakt aufnehmen') . '</a></div></div>';
        echo '<div class="hero-picture"><img alt="' . kem_h($hero['alt'] ?? '') . '" fetchpriority="high" width="' . (int)$hero['width'] . '" height="' . (int)$hero['height'] . '" src="' . kem_h($hero['src']) . '"></div></div></section>';
    }
}
if (!function_exists('kem_render_service_cards')) {
    function kem_render_service_cards(string $variant = 'overview'): void {
        $cards = require KEM_CONFIG_DIR . '/services/cards.php';
        echo '<div class="service-grid">';
        $index = 0;
        foreach (kem_service_catalog() as $route => $service) {
            $card = $cards[$route];
            echo '<article class="service-card"><div class="service-card-image"><img alt="' . kem_h($service['label']) . '" src="' . kem_h($card['image']) . '" width="1200" height="800" loading="lazy"><span class="service-number" aria-hidden="true">' . sprintf('%02d', ++$index) . '</span></div><div class="body"><h3>' . kem_h($service['label']) . '</h3><p>' . kem_h($card[$variant === 'home' ? 'home_description' : 'description']) . '</p><a class="more" href="' . kem_h($route) . '">Mehr zur Leistung <span class="inline-arrow" aria-hidden="true"></span><span class="sr-only">: ' . kem_h($service['label']) . '</span></a></div></article>';
        }
        echo '</div>';
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
if (!function_exists('kem_render_page_cta')) {
    function kem_render_page_cta(string $pageKey): void {
        $cta = kem_page_data($pageKey)['cta'] ?? null;
        if (!$cta) return;
        echo '<section class="' . kem_h($cta['class'] ?? 'cta-band') . '"><div class="container">';
        if (!empty($cta['content'])) {
            $html = kem_content_html($cta['content'], true);
            echo str_replace('href="/angebotsanfrage/"', 'href="' . kem_h(kem_offer_url($pageKey)) . '"', $html);
        }
        echo '</div></section>';
    }
}

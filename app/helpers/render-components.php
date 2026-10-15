<?php
if (!function_exists('kem_render_page_intro')) {
    /** Visible page content stays separate from browser/SEO titles. */
    function kem_render_page_intro(string $pageKey, array $intro = [], array $options = []): void {
        $page = kem_page_data($pageKey);
        $intro = $intro ?: ($page['intro'] ?? []);
        if (empty($intro['title'])) {
            throw new RuntimeException('Seitenintro ohne Überschrift: ' . $pageKey);
        }
        $hero = $page['hero'] ?? null;
        $hasMedia = ($options['variant'] ?? $intro['variant'] ?? 'media') === 'media'
            && is_array($hero) && !empty($hero['src']);
        $classes = 'page-intro page-intro--' . ($hasMedia ? 'media' : 'compact');
        if ($hasMedia && !empty($hero['class'])) $classes .= ' ' . $hero['class'];
        $containerClass = $intro['container_class'] ?? '';
        if (!in_array($containerClass, ['faq-container', 'gallery-container'], true)) $containerClass = '';

        echo '<section aria-labelledby="page-title" class="' . kem_h($classes) . '"><div class="container ' . kem_h($containerClass) . '"><div class="page-intro__layout"><div class="page-intro__copy">';
        if (!empty($intro['eyebrow'])) echo '<span class="eyebrow">' . kem_h($intro['eyebrow']) . '</span>';
        echo '<h1 id="page-title">' . kem_h($intro['title']) . '</h1>';
        if (!empty($intro['lead'])) echo '<p class="lead">' . kem_h($intro['lead']) . '</p>';

        $pageAction = kem_page_primary_action($pageKey);
        $defaultActions = ($pageAction['intent'] ?? null) === 'offer' ? [kem_offer_action($pageKey)] : [];
        $actions = $options['actions'] ?? $intro['actions'] ?? $defaultActions;
        if ($actions) {
            echo '<div class="page-intro__actions">';
            foreach ($actions as $index => $action) {
                kem_render_action($action, $index === 0 ? 'primary' : 'inline');
            }
            echo '</div>';
        }
        echo '</div>';
        if ($hasMedia) {
            echo '<div class="page-intro__media"><img alt="' . kem_h($hero['alt'] ?? '') . '" fetchpriority="high" width="' . (int)$hero['width'] . '" height="' . (int)$hero['height'] . '" src="' . kem_h($hero['src']) . '"></div>';
        }
        echo '</div></div></section>';
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
        if (!empty($cta['content'])) kem_render_content($cta['content'], true);
        echo '</div></section>';
    }
}
if (!function_exists('kem_render_related_links')) {
    function kem_render_related_links(string $pageKey): void {
        $related = kem_page_data($pageKey)['related_links'] ?? [];
        if (empty($related['heading']) || empty($related['links'])) return;

        $heading = kem_h($related['heading']);
        echo '<section class="section related-links-section"><div class="container"><h2>' . $heading . '</h2>';
        echo '<nav class="service-nav" aria-label="' . $heading . '">';
        foreach ($related['links'] as $link) {
            if (empty($link['href']) || empty($link['label'])) continue;
            echo '<a href="' . kem_h($link['href']) . '">' . kem_h($link['label']) . '</a>';
        }
        echo '</nav></div></section>';
    }
}

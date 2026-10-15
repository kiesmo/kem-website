<?php
/** Shared discovery cards keep the homepage and overview on the same routes. */
function kem_service_discovery_data(): array {
    static $data = null;
    if ($data === null) $data = require KEM_CONFIG_DIR . '/services/discovery.php';
    return $data;
}

/** Original outline symbols for the homepage; the adjacent title names each service. */
function kem_service_discovery_icon(string $service): string {
    static $symbols = [
        'office' => '<rect x="12" y="10" width="30" height="44" rx="3"/>'
            . '<path d="M42 28h9a3 3 0 0 1 3 3v23H42M24 54V42h6v12M20 20h4m6 0h4M20 29h4m6 0h4M47 37h3m-3 8h3"/>',
        'window' => '<rect x="10" y="20" width="40" height="34" rx="3"/>'
            . '<path d="M30 20v34M10 37h40m-1-32 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z"/>',
        'general' => '<path d="m41 10-13 30M13 40h34l5 12H8ZM17 46h26m4-29 2 5 5 2-5 2-2 5-2-5-5-2 5-2Z"/>',
        'carpet' => '<rect x="14" y="12" width="36" height="40" rx="2"/>'
            . '<path d="m32 22 9 10-9 10-9-10Z"/>'
            . '<path d="M20 8v4m8-4v4m8-4v4m8-4v4M20 52v4m8-4v4m8-4v4m8-4v4"/>',
        'upholstery' => '<path d="M15 29v-9a6 6 0 0 1 6-6h22a6 6 0 0 1 6 6v9"/>'
            . '<rect x="8" y="28" width="10" height="13" rx="4"/>'
            . '<rect x="46" y="28" width="10" height="13" rx="4"/>'
            . '<path d="M18 36h28M8 37v9a4 4 0 0 0 4 4h40a4 4 0 0 0 4-4v-9M16 50v5m32-5v5"/>',
        'clearance' => '<path d="m12 24 20 9 20-9v23l-20 9-20-9Zm20 9v23M12 24l-6-9 20-8 6 9Zm20-8 6-9 20 8-6 9Z"/>',
        'graffiti' => '<rect x="10" y="16" width="34" height="38" rx="2"/>'
            . '<path d="M10 29h34M10 42h34M27 16v13M21 29v13M33 42v12m21-50 2 4 4 2-4 2-2 4-2-4-4-2 4-2Z"/>',
        'solar' => '<path d="M15 28h36l6 22H9ZM12 39h42M27 28l-2 22m14-22 2 22M28 50v7m8-7v7M21 57h22"/>'
            . '<circle cx="43" cy="13" r="5"/>'
            . '<path d="M43 3v2m0 16v2M33 13h2m16 0h2"/>',
    ];
    if (!isset($symbols[$service])) {
        throw new RuntimeException('Leistungssymbol fehlt: ' . $service);
    }
    return '<svg class="service-discovery__icon" aria-hidden="true" focusable="false" width="64" height="64" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">'
        . $symbols[$service] . '</svg>';
}

function kem_render_service_discovery(string $variant = 'home'): void {
    if (!in_array($variant, ['home', 'overview'], true)) {
        throw new InvalidArgumentException('Unbekannte Leistungsauswahl: ' . $variant);
    }
    $cards = kem_service_discovery_data();
    $withMedia = $variant === 'overview';
    $descriptionKey = $variant . '_description';
    echo '<div class="service-discovery service-discovery--' . kem_h($variant) . '">';
    foreach (kem_service_catalog() as $route => $service) {
        if (!isset($cards[$route])) throw new RuntimeException('Auswahlkarte fehlt: ' . $route);
        $card = $cards[$route];
        $label = $card['link_label'] ?? $service['label'];
        echo '<article class="service-discovery__card">';
        if ($withMedia) {
            $image = $card['image'];
            echo '<img class="service-discovery__image" alt="' . kem_h($image['alt']) . '" width="' . (int)$image['width'] . '" height="' . (int)$image['height'] . '" loading="lazy" src="' . kem_h($image['src']) . '">';
        }
        echo '<div class="service-discovery__body">';
        if (!$withMedia) echo kem_service_discovery_icon($service['offer_service']);
        echo '<h3 class="service-discovery__title"><a class="service-discovery__link" href="' . kem_h($route) . '">' . kem_h($label) . '</a></h3>';
        echo '<p class="service-discovery__description">' . kem_h($card[$descriptionKey]) . '</p></div></article>';
    }
    echo '</div>';
}

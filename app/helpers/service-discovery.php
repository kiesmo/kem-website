<?php
/** Shared discovery cards keep the homepage and overview on the same routes. */
function kem_service_discovery_data(): array {
    static $data = null;
    if ($data === null) $data = require KEM_CONFIG_DIR . '/services/discovery.php';
    return $data;
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
        echo '<div class="service-discovery__body"><h3 class="service-discovery__title"><a class="service-discovery__link" href="' . kem_h($route) . '">' . kem_h($label) . '</a></h3>';
        echo '<p class="service-discovery__description">' . kem_h($card[$descriptionKey]) . '</p></div></article>';
    }
    echo '</div>';
}

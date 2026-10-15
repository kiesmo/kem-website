<?php
/** Keep the originating route and resolve its explicit service/city context. */
function kem_offer_action(string $pageKey, string $label = 'Kostenloses Angebot anfordern'): array {
    return ['intent' => 'offer', 'page_key' => $pageKey, 'label' => $label, 'href' => kem_offer_url($pageKey)];
}

function kem_application_action(string $pageKey = '/jobs/', string $label = 'Bewerbung per E-Mail senden'): array {
    return [
        'intent' => 'application', 'page_key' => $pageKey, 'label' => $label,
        'href' => 'mailto:' . kem_site_config()['email'] . '?subject=Bewerbung%20bei%20KEM%20Geb%C3%A4udereinigung',
    ];
}

function kem_whatsapp_action(string $pageKey, string $label = 'Per WhatsApp schreiben'): array {
    return [
        'intent' => 'whatsapp', 'page_key' => $pageKey, 'label' => $label,
        'href' => kem_site_config()['whatsapp_url'], 'external' => true,
    ];
}

/** Purpose-specific actions for page intros and the footer; the header uses the offer action. */
function kem_page_primary_action(string $pageKey): ?array {
    if (in_array($pageKey, ['/angebotsanfrage/', '/kontakt/'], true)) return null;
    if ($pageKey === '/jobs/') return kem_application_action($pageKey, 'Jetzt bewerben');
    if ($pageKey === '/faq/') {
        return ['intent' => 'contact', 'page_key' => $pageKey, 'label' => 'Kontakt aufnehmen', 'href' => '/kontakt/'];
    }
    return kem_offer_action($pageKey, 'Angebot anfordern');
}

function kem_render_action(array $action, string $style = 'primary', string $extraClass = ''): void {
    if (empty($action['href']) || empty($action['label'])) return;
    $isWhatsApp = ($action['intent'] ?? '') === 'whatsapp';
    $classes = $isWhatsApp
        ? 'btn btn--whatsapp'
        : ($style === 'inline' ? 'action-link' : 'btn' . ($style === 'secondary' ? ' secondary' : ''));
    if ($extraClass !== '') $classes .= ' ' . $extraClass;
    echo '<a class="' . kem_h($classes) . '" href="' . kem_h($action['href']) . '"';
    echo ' data-action-intent="' . kem_h($action['intent'] ?? 'navigation') . '" data-action-page="' . kem_h($action['page_key'] ?? '') . '"';
    if (!empty($action['external'])) echo ' target="_blank" rel="noopener noreferrer"';
    echo '>';
    if ($isWhatsApp) {
        echo '<img class="whatsapp-button__icon" src="/assets/icons/whatsapp.svg" alt="" aria-hidden="true" width="24" height="24">';
        echo '<span class="whatsapp-button__label">' . kem_h($action['label']) . '</span>';
    } else {
        echo kem_h($action['label']);
    }
    echo '</a>';
}

function kem_render_action_group(array $primary, ?array $secondary = null, string $extraClass = ''): void {
    echo '<div class="action-group' . ($extraClass !== '' ? ' ' . kem_h($extraClass) : '') . '">';
    kem_render_action($primary);
    if ($secondary) kem_render_action($secondary, 'inline');
    echo '</div>';
}

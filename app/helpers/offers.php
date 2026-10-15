<?php
function kem_offer_cities(): array {
    static $cities = null;
    if ($cities === null) $cities = (require KEM_CONFIG_DIR . '/forms/offer.php')['cities'];
    return $cities;
}

/** Accept only known scalar tokens; an invalid part does not discard a valid one. */
function kem_offer_context_from_query(array $query): array {
    $context = [];
    $service = $query['service'] ?? null;
    if (is_string($service) && in_array($service, array_column(kem_service_catalog(), 'offer_service'), true)) {
        $context['service'] = $service;
    }
    $city = $query['city'] ?? null;
    if (is_string($city) && array_key_exists($city, kem_offer_cities())) {
        $context['city'] = $city;
    }
    return $context;
}

/** The route map is explicit: generic building-cleaning pages supply city only. */
function kem_offer_context_for_page(string $pageKey): array {
    $catalog = kem_service_catalog();
    if (isset($catalog[$pageKey])) {
        return kem_offer_context_from_query(['service' => $catalog[$pageKey]['offer_service'] ?? null]);
    }
    if (!isset(kem_page_map()[$pageKey])) return [];
    $context = kem_page_data($pageKey)['offer_context'] ?? [];
    return kem_offer_context_from_query(is_array($context) ? $context : []);
}

function kem_offer_url(string $pageKey): string {
    $context = kem_offer_context_for_page($pageKey);
    $query = http_build_query($context, '', '&', PHP_QUERY_RFC3986);
    return '/angebotsanfrage/' . ($query !== '' ? '?' . $query : '');
}

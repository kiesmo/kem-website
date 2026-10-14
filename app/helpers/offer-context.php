<?php
declare(strict_types=1);

function kem_offer_options(): array {
    static $options = null;
    return $options ??= require KEM_CONFIG_DIR . '/forms/contexts.php';
}

function kem_offer_context(string $pageKey): array {
    $options = kem_offer_options();
    if (isset($options['routes'][$pageKey])) return ['service' => $options['routes'][$pageKey]];
    if (preg_match('~^/(gebaeudereinigung|bueroreinigung|fensterreinigung)-(bruehl|koeln|bonn)/$~', $pageKey, $match)) {
        $context = ['city' => $match[2]];
        if ($match[1] === 'bueroreinigung') $context['service'] = 'office';
        if ($match[1] === 'fensterreinigung') $context['service'] = 'window';
        return $context;
    }
    return [];
}

function kem_offer_url(array $context = []): string {
    $options = kem_offer_options();
    $safe = [];
    if (is_string($context['service'] ?? null) && in_array($context['service'], $options['services'], true)) $safe['service'] = $context['service'];
    if (is_string($context['city'] ?? null) && isset($options['cities'][$context['city']])) $safe['city'] = $context['city'];
    return '/angebotsanfrage/' . ($safe ? '?' . http_build_query($safe, '', '&', PHP_QUERY_RFC3986) : '');
}

function kem_offer_request_context(): array {
    // Parse individual parameters: PHP's normal query map discards duplicate keys.
    $values = [];
    foreach (explode('&', $_SERVER['QUERY_STRING'] ?? '') as $part) {
        [$key, $value] = array_pad(explode('=', $part, 2), 2, '');
        $key = urldecode($key);
        if (in_array($key, ['service', 'city'], true)) $values[$key][] = urldecode($value);
    }
    $options = kem_offer_options();
    $context = [];
    if (count($values['service'] ?? []) === 1 && in_array($values['service'][0], $options['services'], true)) $context['service'] = $values['service'][0];
    if (count($values['city'] ?? []) === 1 && isset($options['cities'][$values['city'][0]])) $context['city'] = $values['city'][0];
    return $context;
}

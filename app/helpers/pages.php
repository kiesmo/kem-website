<?php
if (!function_exists('kem_page_map')) {
    function kem_page_map(): array {
        static $map = null;
        if ($map === null) $map = require KEM_CONFIG_DIR . '/pages.php';
        return $map;
    }
}
if (!function_exists('kem_page_data')) {
    function kem_page_data(string $pageKey): array {
        static $cache = [];
        if (isset($cache[$pageKey])) return $cache[$pageKey];
        $map = kem_page_map();
        if (!isset($map[$pageKey])) throw new RuntimeException('Unbekannte Seite: ' . $pageKey);
        $file = KEM_CONFIG_DIR . '/pages/' . $map[$pageKey] . '.php';
        if (!is_file($file)) throw new RuntimeException('Seitenkonfiguration fehlt: ' . $pageKey);
        return $cache[$pageKey] = require $file;
    }
}
if (!function_exists('kem_all_pages')) {
    function kem_all_pages(): array {
        $pages = [];
        foreach (array_keys(kem_page_map()) as $route) $pages[$route] = kem_page_data($route);
        return $pages;
    }
}

function kem_page_action(string $pageKey): array {
    static $roles = null;
    $roles ??= require KEM_CONFIG_DIR . '/page-actions.php';
    $role = $roles[$pageKey] ?? 'offer';
    return match ($role) {
        'active' => ['role' => $role, 'label' => 'Fragen? Kontakt', 'url' => '/kontakt/', 'compact' => false],
        'apply' => ['role' => $role, 'label' => 'Per E-Mail bewerben', 'url' => 'mailto:' . kem_site_config()['email'] . '?subject=' . rawurlencode('Bewerbung bei KEM Gebäudereinigung'), 'compact' => true],
        'help' => ['role' => $role, 'label' => 'Kontakt aufnehmen', 'url' => '/kontakt/', 'compact' => false],
        default => ['role' => $role, 'label' => 'Angebot anfordern', 'url' => kem_offer_url(kem_offer_context($pageKey)), 'compact' => true],
    };
}

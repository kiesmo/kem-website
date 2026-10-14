<?php
if (!function_exists('kem_service_catalog')) {
    function kem_service_catalog(): array {
        static $catalog = null;
        if ($catalog === null) $catalog = require KEM_CONFIG_DIR . '/services/catalog.php';
        return $catalog;
    }
}
if (!function_exists('kem_service_data')) {
    function kem_service_data(string $serviceKey): array {
        static $cache = [];
        if (isset($cache[$serviceKey])) return $cache[$serviceKey];
        if (!isset(kem_service_catalog()[$serviceKey])) throw new RuntimeException('Unbekannte Leistung: ' . $serviceKey);
        $slug = basename(trim($serviceKey, '/'));
        $file = KEM_CONFIG_DIR . '/services/' . $slug . '.php';
        if (!is_file($file)) throw new RuntimeException('Leistungskonfiguration fehlt: ' . $serviceKey);
        return $cache[$serviceKey] = require $file;
    }
}

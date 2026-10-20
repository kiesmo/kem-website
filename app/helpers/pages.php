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

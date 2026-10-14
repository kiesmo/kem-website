<?php
if (!function_exists('kem_url')) {
    function kem_url(string $path = '/'): string {
        if (preg_match('~^https?://~i', $path)) return $path;
        $base = rtrim(kem_site_config()['base_url'], '/');
        return $base . '/' . ltrim($path, '/');
    }
}
if (!function_exists('kem_absolutize_schema')) {
    function kem_absolutize_schema(array $data): array {
        $urlKeys = ['@id', 'url', 'sameAs', 'logo', 'image'];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = kem_absolutize_schema($value);
            } elseif (is_string($value) && in_array((string)$key, $urlKeys, true) && str_starts_with($value, '/')) {
                $data[$key] = kem_url($value);
            }
        }
        return $data;
    }
}

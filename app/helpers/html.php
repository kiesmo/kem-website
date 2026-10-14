<?php
if (!function_exists('kem_h')) {
    function kem_h(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
}
if (!function_exists('kem_site_config')) {
    function kem_site_config(): array {
        static $config = null;
        if ($config === null) $config = require KEM_CONFIG_DIR . '/site.php';
        return $config;
    }
}
if (!function_exists('kem_dynamic_html')) {
    function kem_dynamic_html(string $html, array $tokens = []): string {
        $kem = kem_site_config();
        $replacements = [
            '{{phone_display}}' => kem_h($kem['phone_display']),
            '{{phone_href}}' => kem_h($kem['phone_href']),
            '{{email}}' => kem_h($kem['email']),
            '{{street}}' => kem_h($kem['street']),
            '{{postal_code}}' => kem_h($kem['postal_code']),
            '{{city}}' => kem_h($kem['city']),
            '{{whatsapp_url}}' => kem_h($kem['whatsapp_url']),
        ];
        foreach ($tokens as $key => $value) {
            if (preg_match('/^[a-z_]+$/', (string)$key)) $replacements['{{' . $key . '}}'] = kem_h((string)$value);
        }
        return strtr($html, $replacements);
    }
}
if (!function_exists('kem_render_image')) {
    function kem_render_image(array $image): void {
        echo '<img alt="' . kem_h($image['alt'] ?? '') . '" width="' . (int)($image['width'] ?? 0) . '" height="' . (int)($image['height'] ?? 0) . '" src="' . kem_h($image['src']) . '"';
        if (!empty($image['loading'])) echo ' loading="' . kem_h($image['loading']) . '"';
        echo '>';
    }
}

if (!function_exists('kem_content_html')) {
    function kem_content_html(string $relativePath, bool $dynamic = false, array $tokens = []): string {
        $file = KEM_CONTENT_DIR . '/' . ltrim($relativePath, '/');
        if (!is_file($file)) throw new RuntimeException('Inhaltsdatei fehlt: ' . $relativePath);
        ob_start();
        require $file;
        $html = (string) ob_get_clean();
        return $dynamic || $tokens ? kem_dynamic_html($html, $tokens) : $html;
    }
}
if (!function_exists('kem_render_content')) {
    function kem_render_content(string $relativePath, bool $dynamic = false, array $tokens = []): void {
        echo kem_content_html($relativePath, $dynamic, $tokens);
    }
}

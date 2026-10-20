<?php
declare(strict_types=1);

// Keep the cascade explicit; see docs/css-maintenance.md before changing it.
$sources = [
    '00-tokens.css',
    '01-base.css',
    '02-components.css',
    '03-pages.css',
    '04-responsive.css',
    '05-forms.css',
    '06-service-pages.css',
    '07-gallery-faq.css',
    '09-local-pages.css',
];

if ($argc > 2 || ($argc === 2 && $argv[1] !== '--check')) {
    fwrite(STDERR, "Usage: php tools/build-css.php [--check]\n");
    exit(2);
}

$root = dirname(__DIR__);
$sourceDir = $root . '/resources/css';
$target = $root . '/public_html/assets/css/styles.css';
$available = array_map('basename', glob($sourceDir . '/*.css') ?: []);
$expected = $sources;
sort($available);
sort($expected);
if ($available !== $expected) {
    fwrite(STDERR, "CSS source files do not match the build list. Check tools/build-css.php.\n");
    exit(1);
}

$parts = [];
foreach ($sources as $source) {
    $css = file_get_contents($sourceDir . '/' . $source);
    if ($css === false) {
        fwrite(STDERR, "Could not read CSS source: " . $source . "\n");
        exit(1);
    }
    $parts[] = '/* Source: ' . $source . " */\n" . rtrim($css);
}
$bundle = "/* Generated from resources/css by tools/build-css.php. */\n\n"
    . implode("\n\n", $parts) . "\n";

if ($argc === 2) {
    if (!is_file($target) || file_get_contents($target) !== $bundle) {
        fwrite(STDERR, "CSS bundle is stale. Run: php tools/build-css.php\n");
        exit(1);
    }
    fwrite(STDOUT, "CSS bundle is up to date.\n");
    exit(0);
}

if (file_put_contents($target, $bundle) === false) {
    fwrite(STDERR, "Could not write the CSS bundle.\n");
    exit(1);
}
fwrite(STDOUT, 'Built public_html/assets/css/styles.css from ' . count($sources) . " sources.\n");

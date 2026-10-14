<?php
/** Build public_html/assets/css/styles.css from ordered source modules. */
$root = dirname(__DIR__);
$sourceDir = $root . '/resources/css';
$output = $root . '/public_html/assets/css/styles.css';
$files = glob($sourceDir . '/*.css') ?: [];
sort($files, SORT_STRING);
$bundle = "/* Generated from resources/css by tools/build-css.php. */\n";
foreach ($files as $file) {
    $bundle .= "\n/* Source: " . basename($file) . " */\n" . rtrim((string) file_get_contents($file)) . "\n";
}
file_put_contents($output, $bundle);
echo 'Built ' . $output . ' from ' . count($files) . " modules.\n";

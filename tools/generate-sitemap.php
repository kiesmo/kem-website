<?php
/** Build sitemap.xml from modular page configuration and real source modification times. */
$root = dirname(__DIR__);
$public = $root . '/public_html';
require_once $root . '/app/bootstrap.php';

$site = kem_site_config();
$pages = kem_all_pages();
$pageMap = kem_page_map();
$urls = [];

foreach ($pages as $route => $page) {
    if ($route === '/404.php' || str_starts_with($page['robots'] ?? '', 'noindex')) continue;

    $pageFile = $route === '/'
        ? $public . '/index.php'
        : $public . '/' . trim($route, '/') . '/index.php';
    if (!is_file($pageFile)) continue;

    $dependencies = [
        $pageFile,
        $root . '/config/pages/' . $pageMap[$route] . '.php',
        $root . '/app/templates/head.php',
    ];
    if (!empty($page['cta']['content'])) {
        $dependencies[] = $root . '/content/' . ltrim($page['cta']['content'], '/');
    }

    if (str_starts_with($route, '/leistungen/') && $route !== '/leistungen/') {
        $slug = basename(trim($route, '/'));
        $dependencies[] = $root . '/config/services/' . $slug . '.php';
        $dependencies[] = $root . '/app/templates/service-template.php';
        $service = kem_service_data($route);
        if (!empty($service['summary_content'])) $dependencies[] = $root . '/content/' . ltrim($service['summary_content'], '/');
        if (!empty($service['article']['body_content'])) $dependencies[] = $root . '/content/' . ltrim($service['article']['body_content'], '/');
    }
    if (preg_match('~^/(?:buero|fenster|gebaeude)reinigung-(?:koeln|bruehl|bonn)/$~', $route)) {
        $slug = trim($route, '/');
        $dependencies[] = $root . '/content/locations/' . $slug . '.php';
        $dependencies[] = $root . '/app/templates/location-template.php';
    }

    $mtime = 0;
    foreach ($dependencies as $file) if (is_file($file)) $mtime = max($mtime, filemtime($file));
    $urls[] = ['loc' => rtrim($site['base_url'], '/') . $route, 'lastmod' => gmdate('Y-m-d', $mtime ?: time())];
}

$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($urls as $url) {
    $loc = htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $xml .= "  <url>\n    <loc>{$loc}</loc>\n    <lastmod>{$url['lastmod']}</lastmod>\n  </url>\n";
}
$xml .= "</urlset>\n";
file_put_contents($public . '/sitemap.xml', $xml);
echo 'Generated ' . count($urls) . " sitemap entries.\n";

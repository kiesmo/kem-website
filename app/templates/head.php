<?php
require_once dirname(__DIR__) . '/bootstrap.php';
$kem = kem_site_config();
$pageData = kem_page_data($pageKey);
$canonical = kem_url($pageData['path']);
$ogImage = kem_url($pageData['og_image']);
$businessId = kem_url('/#business');
$business = [
    '@type' => 'LocalBusiness',
    '@id' => $businessId,
    'name' => $kem['name'],
    'url' => kem_url('/'),
    'logo' => kem_url('/assets/branding/logo.svg'),
    'image' => kem_url($kem['schema_image']),
    'telephone' => $kem['phone_href'],
    'email' => $kem['email'],
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $kem['street'],
        'postalCode' => $kem['postal_code'],
        'addressLocality' => $kem['city'],
        'addressRegion' => $kem['region'],
        'addressCountry' => $kem['country_code'],
    ],
    'areaServed' => array_merge($kem['service_cities'], ['Umgebung']),
    'description' => 'Professionelle Gebäudereinigung für private und gewerbliche Kunden in ' . $kem['service_area'] . '.',
    'contactPoint' => [[
        '@type' => 'ContactPoint',
        'telephone' => $kem['phone_href'],
        'email' => $kem['email'],
        'contactType' => 'customer service',
        'areaServed' => 'DE',
        'availableLanguage' => ['de'],
    ]],
    'openingHoursSpecification' => [[
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => $kem['opening_hours']['days_schema'],
        'opens' => $kem['opening_hours']['opens'],
        'closes' => $kem['opening_hours']['closes'],
    ]],
];
$graph = [$business];
$crumbs = $pageData['breadcrumbs'] ?? [];
if ($crumbs) {
    $items = [];
    foreach ($crumbs as $i => $crumb) {
        $path = $crumb['path'];
        $items[] = ['@type'=>'ListItem','position'=>$i+1,'name'=>$crumb['name'],'item'=>kem_url($path)];
    }
    $graph[] = ['@type'=>'BreadcrumbList','@id'=>$canonical.'#breadcrumb','itemListElement'=>$items];
    $webpage = [
        '@type'=>'WebPage','@id'=>$canonical.'#webpage','url'=>$canonical,'name'=>$pageData['title'],
        'breadcrumb'=>['@id'=>$canonical.'#breadcrumb'],'about'=>['@id'=>$businessId],'inLanguage'=>'de-DE'
    ];
    $extraTypes = array_column($pageData['schema_extra'] ?? [], '@type');
    if (in_array('Service',$extraTypes,true)) $webpage['mainEntity']=['@id'=>$canonical.'#service'];
    $graph[] = $webpage;
}
foreach ($pageData['schema_extra'] ?? [] as $extra) {
    if (($extra['@type'] ?? '') === 'JobPosting') {
        // Abgelaufene Stellenanzeigen nicht weiter als JobPosting an Suchmaschinen ausgeben.
        if (!empty($extra['validThrough'])) {
            try {
                $validThrough = new DateTimeImmutable($extra['validThrough']);
                $now = new DateTimeImmutable('now', new DateTimeZone('Europe/Berlin'));
                if ($validThrough < $now) continue;
            } catch (Exception $e) {
                // Bei einem fehlerhaften Datum lieber kein veraltetes JobPosting ausgeben.
                continue;
            }
        }
        $extra['hiringOrganization']=['@type'=>'Organization','name'=>$kem['name'],'sameAs'=>kem_url('/'), 'logo'=>kem_url('/assets/branding/logo.svg')];
        $extra['jobLocation']=['@type'=>'Place','address'=>['@type'=>'PostalAddress','streetAddress'=>$kem['street'],'postalCode'=>$kem['postal_code'],'addressLocality'=>$kem['city'],'addressRegion'=>$kem['region'],'addressCountry'=>$kem['country_code']]];
    }
    $graph[] = kem_absolutize_schema($extra);
}
$schema = ['@context'=>'https://schema.org','@graph'=>$graph];
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#0969B5">
<title><?= kem_h($pageData['title']) ?></title>
<meta name="description" content="<?= kem_h($pageData['description']) ?>">
<meta name="robots" content="<?= kem_h($pageData['robots'] ?? 'index,follow,max-image-preview:large') ?>">
<link rel="canonical" href="<?= kem_h($canonical) ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="de_DE">
<meta property="og:title" content="<?= kem_h($pageData['title']) ?>">
<meta property="og:description" content="<?= kem_h($pageData['description']) ?>">
<meta property="og:url" content="<?= kem_h($canonical) ?>">
<meta property="og:image" content="<?= kem_h($ogImage) ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="/assets/branding/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/assets/css/styles.css?v=<?= kem_h($kem['asset_version']) ?>">
<script id="site-schema" type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?></script>
</head>

<?php
declare(strict_types=1);

/** Run with `php tools/check-offer-context.php`; renders GET pages only, never submits. */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

// Each form render needs its own process because templates declare shared functions.
if (($argv[1] ?? '') === '--render-form') {
    $_GET = json_decode((string) base64_decode($argv[2] ?? '', true), true, 512, JSON_THROW_ON_ERROR);
    $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__) . '/public_html';
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/angebotsanfrage/?' . http_build_query($_GET);
    require $_SERVER['DOCUMENT_ROOT'] . '/angebotsanfrage/index.php';
    exit;
}

require dirname(__DIR__) . '/app/bootstrap.php';

$checks = 0;
$failures = [];
function check_offer(bool $passed, string $message): void {
    global $checks, $failures;
    $checks++;
    if (!$passed) $failures[] = $message;
}
function check_offer_context(array $actual, array $expected, string $message): void {
    ksort($actual);
    ksort($expected);
    check_offer($actual === $expected, $message . ': ' . json_encode($actual, JSON_UNESCAPED_UNICODE));
}
function render_offer_for_check(array $query): array {
    $process = proc_open(
        [PHP_BINARY, '-d', 'display_errors=stderr', __FILE__, '--render-form', base64_encode(json_encode($query, JSON_THROW_ON_ERROR))],
        [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
        $pipes
    );
    if (!is_resource($process)) throw new RuntimeException('Could not start the isolated form render.');
    $html = stream_get_contents($pipes[1]);
    $errors = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    if (proc_close($process) !== 0 || $errors !== '') {
        throw new RuntimeException('Form render failed: ' . $errors);
    }
    $document = new DOMDocument();
    $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
    return [$html, new DOMXPath($document)];
}

try {
    foreach (['kem_offer_context_for_page', 'kem_offer_context_from_query', 'kem_offer_cities', 'kem_offer_url'] as $function) {
        if (!function_exists($function)) throw new RuntimeException('Missing helper: ' . $function);
    }
    if (!class_exists('DOMDocument')) throw new RuntimeException('The form checks require PHP DOM.');

    $cities = ['koeln' => 'Köln', 'bruehl' => 'Brühl', 'bonn' => 'Bonn'];
    check_offer_context(kem_offer_cities(), $cities, 'City slugs and display labels');
    $fixtures = [
        '/leistungen/buero-und-gewerberaumreinigung/' => ['service' => 'office'],
        '/leistungen/glas-und-fensterreinigung/' => ['service' => 'window'],
        '/leistungen/grundreinigung/' => ['service' => 'general'],
        '/leistungen/teppichreinigung/' => ['service' => 'carpet'],
        '/leistungen/polsterreinigung/' => ['service' => 'upholstery'],
        '/leistungen/entruempelung/' => ['service' => 'clearance'],
        '/leistungen/fassadenreinigung/' => ['service' => 'graffiti'],
        '/leistungen/solaranlagenreinigung/' => ['service' => 'solar'],
    ];
    foreach (array_keys($cities) as $city) {
        $fixtures['/gebaeudereinigung-' . $city . '/'] = ['city' => $city];
        $fixtures['/bueroreinigung-' . $city . '/'] = ['service' => 'office', 'city' => $city];
        $fixtures['/fensterreinigung-' . $city . '/'] = ['service' => 'window', 'city' => $city];
    }
    foreach ($fixtures as $route => $expected) {
        check_offer_context(kem_offer_context_for_page($route), $expected, 'Explicit page mapping ' . $route);
        $url = kem_offer_url($route);
        check_offer(str_starts_with($url, '/angebotsanfrage/?') && !str_contains($url, '#'), 'Local offer destination ' . $route);
        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        check_offer_context($query, $expected, 'URL contains only expected context ' . $route);
        check_offer_context(kem_offer_context_from_query($query), $expected, 'URL/parser round trip ' . $route);
        check_offer(kem_offer_action($route)['href'] === $url, 'Action uses the context URL ' . $route);
    }
    foreach (['/', '/leistungen/', '/ueber-uns/', '/angebotsanfrage/', '/unknown/', '/leistungen/unknown/', '/gebaeudereinigung-hamburg/', '/leistungen/grundreinigung/?city=bonn'] as $route) {
        check_offer_context(kem_offer_context_for_page($route), [], 'Generic/unknown route does not infer a service ' . $route);
        check_offer(kem_offer_url($route) === '/angebotsanfrage/', 'Generic/unknown URL fallback ' . $route);
    }

    $invalidValues = [null, true, false, 1, 1.5, [], ['office'], ['nested' => ['office']], new stdClass(), '', 'other', 'OFFICE', ' office ', '<script>alert(1)</script>', "office\0"];
    foreach ($invalidValues as $value) {
        check_offer_context(kem_offer_context_from_query(['service' => $value, 'city' => 'bonn']), ['city' => 'bonn'], 'Invalid service preserves valid city');
        check_offer_context(kem_offer_context_from_query(['service' => 'window', 'city' => $value]), ['service' => 'window'], 'Invalid city preserves valid service');
    }
    foreach (['Köln', 'Brühl', 'hamburg', 'BONN', ' bonn ', '../bonn', 'bonn&service=office'] as $city) {
        check_offer_context(kem_offer_context_from_query(['city' => $city]), [], 'Only supported ASCII city slugs are initialised');
    }
    check_offer_context(kem_offer_context_from_query(['service' => 'solar', 'city' => 'koeln', 'type_general' => '1', 'cleaning_city' => 'Hamburg', 'redirect' => '//example.org']), ['service' => 'solar', 'city' => 'koeln'], 'Unknown query keys are ignored');
    check_offer_context(kem_offer_context_from_query([]), [], 'No query means no preselection');

    $renderCases = array_values($fixtures);
    $renderCases[] = [];
    $renderCases[] = ['service' => ['office'], 'city' => ['bonn']];
    $renderCases[] = ['service' => 'window', 'city' => 'invalid'];
    $renderCases[] = ['service' => 'invalid', 'city' => 'bruehl'];
    $payload = '"><script id="context-injection">alert(1)</script>';
    $renderCases[] = ['service' => $payload, 'city' => $payload, 'cleaning_city' => $payload, 'first_name' => $payload];
    $renderCases[] = ['service' => 'office', 'city' => 'koeln', 'cleaning_postcode' => '12345', 'cleaning_street' => 'Test street', 'first_name' => 'Test', 'email' => 'test@example.org', 'desired_date' => '2030-01-01'];
    $schemas = require KEM_CONFIG_DIR . '/forms/schemas.php';
    $allowedFields = array_merge($schemas['forms']['angebot']['allowed'], ['photos']);
    foreach ($renderCases as $index => $query) {
        [$html, $xpath] = render_offer_for_check($query);
        $expected = kem_offer_context_from_query($query);
        $prefix = 'Form case ' . ($index + 1) . ': ';
        $selected = [];
        foreach ($xpath->query('//form[@data-offer-form]//input[@data-cleaning-type and @checked]') as $input) {
            $selected[] = $input->getAttribute('name');
            check_offer(!$input->hasAttribute('disabled'), $prefix . 'preselected service remains editable');
        }
        check_offer($selected === (isset($expected['service']) ? ['type_' . $expected['service']] : []), $prefix . 'only the existing service checkbox is selected');
        $cityInput = $xpath->query('//input[@name="cleaning_city"]')->item(0);
        check_offer($cityInput !== null && $cityInput->getAttribute('value') === ($cities[$expected['city'] ?? ''] ?? '') && !$cityInput->hasAttribute('readonly') && !$cityInput->hasAttribute('disabled'), $prefix . 'city label is correct and editable');
        foreach (['cleaning_postcode', 'cleaning_street', 'first_name', 'email', 'desired_date'] as $name) {
            $input = $xpath->query('//form[@data-offer-form]//input[@name="' . $name . '"]')->item(0);
            check_offer($input !== null && $input->getAttribute('value') === '', $prefix . 'does not prefill ' . $name);
        }
        $names = [];
        foreach ($xpath->query('//form[@data-offer-form]//*[@name]') as $control) {
            $names[] = preg_replace('/\[\]$/', '', $control->getAttribute('name'));
        }
        check_offer(array_diff($names, $allowedFields) === [], $prefix . 'no new POST/provenance fields');
        check_offer($xpath->evaluate('string(//link[@rel="canonical"]/@href)') === kem_url('/angebotsanfrage/'), $prefix . 'canonical stays query-free');
        check_offer($xpath->evaluate('string(//meta[@property="og:url"]/@content)') === kem_url('/angebotsanfrage/'), $prefix . 'page identity stays query-free');
        $schema = json_decode($xpath->evaluate('string(//script[@id="site-schema"])'), true, 512, JSON_THROW_ON_ERROR);
        $webPages = array_values(array_filter($schema['@graph'], static fn(array $node): bool => ($node['@type'] ?? '') === 'WebPage'));
        check_offer(count($webPages) === 1 && $webPages[0]['url'] === kem_url('/angebotsanfrage/') && $webPages[0]['@id'] === kem_url('/angebotsanfrage/#webpage'), $prefix . 'structured page identity stays query-free');
        check_offer($xpath->query('//form[@data-offer-form]//section[contains(concat(" ", normalize-space(@class), " "), " form-step ") and contains(concat(" ", normalize-space(@class), " "), " active ")]')->length === 1 && $xpath->evaluate('string(//form[@data-offer-form]//section[contains(concat(" ", normalize-space(@class), " "), " active ")]/@data-step-name)') === 'Leistung', $prefix . 'starts at the editable service selection');
        check_offer(!str_contains($html, 'context-injection'), $prefix . 'invalid query payload is not reflected');
    }
} catch (Throwable $error) {
    $failures[] = $error->getMessage();
}

if ($failures) {
    fwrite(STDERR, implode("\n", array_map(static fn(string $failure): string => 'FAIL: ' . $failure, $failures)) . "\n");
    exit(1);
}
echo 'Offer context: ' . $checks . " checks passed (GET rendering only; no requests submitted).\n";

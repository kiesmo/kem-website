<?php
declare(strict_types=1);

/** Pure request-policy checks: no endpoint, private configuration, uploads or mail. */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require dirname(__DIR__) . '/app/forms/offer-request.php';
date_default_timezone_set('Europe/Berlin');

$checks = 0;
$failures = [];
function check_offer_request(bool $passed, string $message): void {
    global $checks, $failures;
    $checks++;
    if (!$passed) $failures[] = $message;
}
function request_rows(array $result): array {
    return array_column($result['mail_rows'], 1, 0);
}

try {
    $config = kem_offer_form_config();
    $policy = kem_offer_client_policy();
    $schemas = require dirname(__DIR__) . '/config/forms/schemas.php';
    $keys = ['office', 'window', 'general', 'carpet', 'upholstery', 'clearance', 'graffiti', 'solar', 'other'];
    check_offer_request(array_keys($config['services']) === $keys, 'All nine existing selections have one shared policy.');
    check_offer_request($policy === ['services' => $config['services'], 'optional_fields' => $config['optional_fields']], 'Client and server use the same relevance and required-field policy.');
    check_offer_request($config['optional_fields']['floor'] === $keys && $config['optional_fields']['furnishing'] === array_values(array_diff($keys, ['solar'])), 'Conservative optional-field matrix is explicit.');
    $allServiceFields = [];
    foreach ($config['services'] as $key => $service) {
        check_offer_request(array_diff(array_keys($service['required']), $service['fields']) === [], 'Required fields belong to ' . $key . '.');
        check_offer_request(array_diff($service['fields'], $schemas['offer_fields']) === [] && in_array('type_' . $key, $schemas['offer_fields'], true), 'No new POST names for ' . $key . '.');
        $allServiceFields = array_merge($allServiceFields, $service['fields']);
    }
    check_offer_request(count($allServiceFields) === count(array_unique($allServiceFields)), 'Service-specific fields have one owner.');
    check_offer_request(array_diff($allServiceFields, array_keys($config['mail_fields'])) === [] && array_diff(array_keys($config['mail_fields']), $allServiceFields) === [], 'Mail fields cover exactly the applicable service fields.');
    check_offer_request(!in_array('clearance_floor', $allServiceFields, true) && in_array('clearance_floor', $schemas['offer_fields'], true), 'Legacy floor is accepted only as a server compatibility alias.');

    $base = [
        'first_name' => 'Erika', 'last_name' => 'Mustermann', 'salutation' => 'Frau',
        'company' => 'Auftraggeber GmbH', 'cleaning_company' => 'Objektverwaltung AG',
        'cleaning_postcode' => '50321', 'cleaning_city' => 'Brühl', 'cleaning_street' => 'Beispielweg 1',
        'object_type' => 'Büro / Gewerbe', 'floor' => '3. OG, Zugang über Hof', 'furnishing' => 'Teilweise möbliert',
        'appointment_preference' => 'Flexibel', 'desired_date' => 'not-a-date', 'desired_time' => 'obsolete',
        'cleaning_types' => 'FORGED SERVICE SUMMARY',
    ];
    $details = [
        'office_area' => '120', 'office_frequency' => 'Wöchentlich',
        'window_sashes' => '12', 'window_scope' => 'Glas und Rahmen',
        'general_area' => '80', 'general_reason' => 'Einmalige Grundreinigung',
        'carpet_scope' => 'Auffrischung', 'carpet_soiling' => 'Mittel',
        'upholstery_scope' => 'Tiefenreinigung', 'upholstery_soiling' => 'Mittel', 'upholstery_two_seater' => '2',
        'clearance_area' => '90', 'clearance_scope' => 'Entrümpelung besenrein',
        'graffiti_area' => '20', 'graffiti_surface' => 'Putz',
        'solar_access' => 'Flachdach', 'solar_soiling' => 'Mittel', 'other_details' => 'Eine besondere Reinigungsaufgabe.',
    ];
    $prepare = static fn(array $data): array => kem_prepare_offer_request($data, 'qa@example.invalid', '+49 123 456789');
    $forServices = static function (array $selected) use ($base, $details): array {
        $data = array_merge($base, $details);
        foreach ($selected as $key) $data['type_' . $key] = '1';
        return $data;
    };
    $scenarios = [['window'], ['office'], ['upholstery'], ['solar'], ['clearance'], ['window', 'solar'], ['office', 'upholstery'], ['general'], ['carpet'], ['graffiti'], ['other']];
    $before = [$_POST, $_FILES, headers_list()];
    foreach ($scenarios as $selected) {
        $result = $prepare($forServices($selected));
        $name = implode('+', $selected);
        $expectedKeys = array_values(array_intersect($keys, $selected));
        check_offer_request($result['errors'] === [], $name . ': valid existing requirements pass.');
        check_offer_request(array_keys($result['selected_services']) === $expectedKeys, $name . ': selection comes from exact flags.');
        check_offer_request($result['offer']['cleaning_types'] === implode(' | ', array_values($result['selected_services'])), $name . ': forged display summary is replaced.');
        $rows = request_rows($result);
        check_offer_request(($rows['Gewünschte Reinigungsarten'] ?? '') === implode(', ', array_values($result['selected_services'])), $name . ': mail describes the same selection.');
        check_offer_request(($rows['Firma des Auftraggebers'] ?? '') === $base['company'] && ($rows['Firma / Objektbezeichnung am Einsatzort'] ?? '') === $base['cleaning_company'], $name . ': distinct companies remain distinct.');
        check_offer_request(($rows['Etage / Zugang zum Einsatzort'] ?? '') === $base['floor'] && count(array_filter($result['mail_rows'], static fn(array $row): bool => str_contains($row[0], 'Etage'))) === 1, $name . ': exactly one floor/access answer.');
        check_offer_request($result['offer']['desired_date'] === '' && $result['offer']['desired_time'] === '' && !isset($rows['Gewünschter Reinigungstermin']), $name . ': flexible date ignores stale date/time.');
        check_offer_request(isset($rows['Möblierung']) === ($selected !== ['solar']), $name . ': optional relevance uses the selection union.');
        foreach ($config['services'] as $key => $service) {
            if (in_array($key, $selected, true)) continue;
            foreach ($service['fields'] as $field) check_offer_request($result['offer'][$field] === '' && !isset($rows[$config['mail_fields'][$field]]), $name . ': inactive ' . $field . ' is neither retained nor mailed.');
        }
    }
    check_offer_request([$_POST, $_FILES, headers_list()] === $before, 'Pure preparation leaves request globals and headers untouched.');

    foreach ($config['services'] as $key => $service) {
        foreach (array_keys($service['required']) as $field) {
            $data = $forServices([$key]);
            $data[$field] = '';
            check_offer_request(isset($prepare($data)['errors'][$field]), 'Missing active requirement is reported: ' . $field);
        }
    }
    foreach ([true, 1, 0, '0', 'yes', ' 1 ', '1 ', [], null] as $flag) {
        $data = $base;
        $data['type_office'] = $flag;
        $result = $prepare($data);
        check_offer_request($result['selected_services'] === [] && isset($result['errors']['type_office']) && $result['offer']['cleaning_types'] === '', 'Only the exact string 1 selects a service.');
    }
    foreach (['first_name', 'last_name', 'cleaning_postcode', 'cleaning_city', 'object_type'] as $field) {
        $data = $forServices(['solar']);
        $data[$field] = '';
        check_offer_request(isset($prepare($data)['errors'][$field]), 'Universal requirement remains enforced for PV: ' . $field);
    }
    $data = $forServices(['solar']);
    $data['upholstery_two_seater'] = 'INVALID INACTIVE COUNT';
    $data['furnishing'] = 'INVALID INACTIVE ENUM';
    check_offer_request($prepare($data)['errors'] === [], 'Known irrelevant invalid counts/enums do not block PV.');
    $data['type_upholstery'] = '1';
    check_offer_request(isset($prepare($data)['errors']['upholstery_two_seater'], $prepare($data)['errors']['furnishing']), 'The same invalid fields are rejected when relevant.');
    $data = $forServices(['other']);
    $data['other_details'] = 'abcd';
    check_offer_request(isset($prepare($data)['errors']['other_details']), 'The existing minimum description length is preserved.');

    $data = $forServices(['clearance']);
    $data['floor'] = '';
    $legacy = str_repeat('a', 80);
    $data['clearance_floor'] = $legacy;
    $result = $prepare($data);
    check_offer_request($result['errors'] === [] && $result['offer']['floor'] === $legacy && $result['offer']['clearance_floor'] === '', 'Legacy-only floor retains at least 80 characters.');
    check_offer_request((request_rows($result)['Etage / Zugang zum Einsatzort'] ?? '') === $legacy, 'Legacy floor is mailed once through the canonical field.');
    $data['floor'] = $legacy;
    check_offer_request($prepare($data)['errors'] === [], 'Equal old/new floor answers are deduplicated.');
    $data['floor'] = 'Different floor';
    check_offer_request(isset($prepare($data)['errors']['floor']), 'Conflicting old/new floor answers require reconciliation.');
    $data = $forServices(['solar']);
    $data['clearance_floor'] = 'INACTIVE LEGACY VALUE';
    check_offer_request($prepare($data)['errors'] === [] && $prepare($data)['offer']['floor'] === $base['floor'] && $prepare($data)['offer']['clearance_floor'] === '', 'Inactive legacy floor cannot change another service request.');

    $data = $forServices(['office']);
    $data['office_area'] = 'Bitte vor Ort einschätzen';
    $result = $prepare($data);
    check_offer_request($result['errors'] === [] && (request_rows($result)['Büro / Gewerbe – Fläche'] ?? '') === $data['office_area'], 'Estimate remains a valid value without a spurious square-metre unit.');
    $data['appointment_preference'] = 'Konkreter Termin';
    $data['desired_date'] = (new DateTimeImmutable('tomorrow'))->format('Y-m-d');
    $data['desired_time'] = 'Vormittags';
    check_offer_request($prepare($data)['errors'] === [] && isset(request_rows($prepare($data))['Gewünschter Reinigungstermin']), 'Valid concrete appointment retains its mail row.');
    foreach (['', 'not-a-date', "2027-01-01\0", '2027-02-30', '2000-01-01'] as $date) {
        $data['desired_date'] = $date;
        check_offer_request(isset($prepare($data)['errors']['desired_date']), 'Invalid concrete dates return a field error.');
    }
    $data['desired_date'] = (new DateTimeImmutable('tomorrow'))->format('Y-m-d');
    $data['desired_time'] = 'invalid';
    check_offer_request(isset($prepare($data)['errors']['desired_time']), 'Concrete appointment time enum remains enforced.');
} catch (Throwable $error) {
    $failures[] = $error->getMessage();
}
if ($failures) {
    fwrite(STDERR, implode("\n", array_map(static fn(string $failure): string => 'FAIL: ' . $failure, $failures)) . "\n");
    exit(1);
}
echo 'Offer request: ' . $checks . " checks passed (pure preparation; no transport).\n";

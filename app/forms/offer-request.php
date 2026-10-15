<?php
declare(strict_types=1);

require_once __DIR__ . '/request-utils.php';

function kem_offer_form_config(): array {
    static $config = null;
    if ($config === null) $config = require dirname(__DIR__, 2) . '/config/forms/offer.php';
    return $config;
}

/** Only the relevance contract is exposed to the browser. */
function kem_offer_client_policy(): array {
    $config = kem_offer_form_config();
    return ['services' => $config['services'], 'optional_fields' => $config['optional_fields']];
}

/** Prepare cleaned fields without headers, uploads, configuration secrets or transport. */
function kem_prepare_offer_request(array $cleanOffer, string $email, string $phone): array {
    $config = kem_offer_form_config();
    $offer = [];
    foreach ((require dirname(__DIR__, 2) . '/config/forms/schemas.php')['offer_fields'] as $field) {
        $offer[$field] = is_string($cleanOffer[$field] ?? null) ? $cleanOffer[$field] : '';
    }
    $errors = [];
    $selected = [];
    $relevantFields = [];
    foreach ($config['services'] as $key => $service) {
        $active = $offer['type_' . $key] === '1';
        $offer['type_' . $key] = $active ? '1' : '';
        if ($active) {
            $selected[$key] = $service['label'];
            $relevantFields = array_merge($relevantFields, $service['fields']);
        }
    }
    $offer['cleaning_types'] = implode(' | ', array_values($selected));
    foreach ($config['services'] as $service) {
        foreach ($service['fields'] as $field) {
            if (!in_array($field, $relevantFields, true)) $offer[$field] = '';
        }
    }
    foreach ($config['optional_fields'] as $field => $services) {
        if (array_intersect(array_keys($selected), $services) === []) $offer[$field] = '';
    }

    // Accept old cached forms, but never silently choose between conflicting answers.
    if (isset($selected['clearance']) && $offer['clearance_floor'] !== '') {
        if ($offer['floor'] === '') {
            $offer['floor'] = $offer['clearance_floor'];
        } elseif ($offer['floor'] !== $offer['clearance_floor']) {
            $errors['floor'] = 'Die Angaben zu Etage / Zugang widersprechen sich. Bitte prüfen Sie beide bisherigen Angaben und tragen Sie eine gemeinsame Angabe ein.';
        }
    }
    $offer['clearance_floor'] = '';
    if ($offer['appointment_preference'] !== 'Konkreter Termin') {
        $offer['desired_date'] = '';
        $offer['desired_time'] = '';
    }

    if (textLength($offer['first_name']) < 2) $errors['first_name'] = 'Bitte geben Sie Ihren Vornamen an.';
    if (textLength($offer['last_name']) < 2) $errors['last_name'] = 'Bitte geben Sie Ihren Nachnamen an.';
    if (!preg_match('/^[0-9]{5}$/', $offer['cleaning_postcode'])) $errors['cleaning_postcode'] = 'Bitte geben Sie eine fünfstellige Postleitzahl für den Einsatzort ein.';
    if (textLength($offer['cleaning_city']) < 2) $errors['cleaning_city'] = 'Bitte geben Sie den Ort des Einsatzortes an.';
    if (!in_array($offer['salutation'], $config['salutations'], true)) $errors['salutation'] = 'Bitte wählen Sie eine gültige Anrede aus.';
    if (!in_array($offer['object_type'], $config['object_types'], true)) $errors['object_type'] = 'Bitte wählen Sie eine gültige Objektart aus.';
    if (!in_array($offer['furnishing'], $config['furnishing_values'], true)) $errors['furnishing'] = 'Bitte wählen Sie die Art der Möblierung aus.';
    if ($selected === []) $errors['type_office'] = 'Bitte wählen Sie mindestens eine Reinigungsart aus.';
    foreach ($selected as $key => $label) {
        foreach ($config['services'][$key]['required'] as $field => $message) {
            if ($offer[$field] === '' || ($field === 'other_details' && textLength($offer[$field]) < 5)) $errors[$field] = $message;
        }
    }
    foreach ($config['count_fields'] as $field) {
        if ($offer[$field] !== '' && !preg_match('/^[0-9]{1,4}$/', $offer[$field])) $errors[$field] = 'Bitte geben Sie eine gültige Anzahl ein.';
    }
    if (!in_array($offer['appointment_preference'], $config['appointment_preferences'], true)) $errors['appointment_preference'] = 'Bitte wählen Sie einen Terminwunsch aus.';
    if ($offer['appointment_preference'] === 'Konkreter Termin') {
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/D', $offer['desired_date']) || !validDateNotPast($offer['desired_date'])) $errors['desired_date'] = 'Bitte wählen Sie ein gültiges, zukünftiges Wunschdatum.';
        if (!in_array($offer['desired_time'], $config['appointment_times'], true)) $errors['desired_time'] = 'Bitte wählen Sie eine Tageszeit aus.';
    }

    $rows = [];
    $add = static function (string $label, string $value) use (&$rows): void {
        if (trim($value) !== '') $rows[] = [$label, $value];
    };
    $add('Name', trim($offer['salutation'] . ' ' . $offer['first_name'] . ' ' . $offer['last_name']));
    $add('Firma des Auftraggebers', $offer['company']);
    $add('E-Mail', $email);
    $add('Telefon', $phone);
    $add('Firma / Objektbezeichnung am Einsatzort', $offer['cleaning_company']);
    $address = trim($offer['cleaning_street'] . ($offer['cleaning_street'] !== '' ? ', ' : '') . $offer['cleaning_postcode'] . ' ' . $offer['cleaning_city']);
    $add('Einsatzort / Reinigungsadresse', $address);
    $add('Objektart', $offer['object_type']);
    $add('Etage / Zugang zum Einsatzort', $offer['floor']);
    $add('Möblierung', $offer['furnishing']);
    $add('Gewünschte Reinigungsarten', implode(', ', array_values($selected)));
    foreach ($selected as $key => $label) {
        foreach ($config['services'][$key]['fields'] as $field) {
            $value = $offer[$field];
            if ($value !== '' && $value !== 'Bitte vor Ort einschätzen' && in_array($field, $config['area_fields'], true)) $value .= ' m²';
            $add($config['mail_fields'][$field], $value);
        }
    }
    $add('Terminwunsch', $offer['appointment_preference']);
    if ($offer['appointment_preference'] === 'Konkreter Termin' && !isset($errors['desired_date']) && !isset($errors['desired_time'])) $add('Gewünschter Reinigungstermin', formatDateGerman($offer['desired_date']) . ' · ' . $offer['desired_time']);
    $add('Termin-Hinweis', $offer['appointment_notes']);
    $mailName = trim($offer['first_name'] . ' ' . $offer['last_name']);
    if ($offer['company'] !== '') $mailName .= ' – ' . $offer['company'];
    return ['offer' => $offer, 'selected_services' => $selected, 'errors' => $errors, 'mail_rows' => $rows, 'mail_name' => $mailName];
}

<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store, max-age=0');
date_default_timezone_set('Europe/Berlin');

require_once __DIR__ . '/request-utils.php';
require_once __DIR__ . '/photo-upload.php';
require_once dirname(__DIR__) . '/mail/smtp-mailer.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    fail('Nur POST-Anfragen sind erlaubt.', 405);
}

if (!extension_loaded('openssl')) {
    configError('Die PHP-Erweiterung openssl muss aktiviert sein.');
}

$domainRoot = dirname(__DIR__, 2);
$publicRoot = $domainRoot . '/public_html';
$configFile = $domainRoot . '/private/contact.php';
$autoloadFile = $domainRoot . '/vendor/autoload.php';

if (!is_file($configFile)) {
    configError('private/contact.php fehlt. Das Paket muss eine Ebene oberhalb von public_html entpackt werden.');
}
$config = require $configFile;
if (!is_array($config)) {
    configError('private/contact.php liefert keine gültige Konfiguration.');
}
if (!is_file($autoloadFile)) {
    configError('vendor/autoload.php fehlt außerhalb von public_html. PHPMailer ist nicht vollständig vorhanden.');
}
require $autoloadFile;

$recipient = trim((string) ($config['recipient'] ?? ''));
$fromEmail = trim((string) ($config['from_email'] ?? ''));
$fromName = trim((string) ($config['from_name'] ?? 'KEM Website'));
$smtp = $config['smtp'] ?? null;

if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
    configError('Ungültige Empfängeradresse.');
}
if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
    configError('Ungültige Absenderadresse.');
}
if (!is_array($smtp)) {
    configError('SMTP-Konfiguration fehlt.');
}

$smtpHost = trim((string) ($smtp['host'] ?? ''));
$smtpPort = (int) ($smtp['port'] ?? 0);
$smtpEncryption = strtolower(trim((string) ($smtp['encryption'] ?? 'tls')));
$smtpUsername = trim((string) ($smtp['username'] ?? ''));
$smtpPassword = trim((string) ($smtp['password'] ?? ''));
$smtpTimeout = max(5, min(30, (int) ($smtp['timeout'] ?? 15)));

if ($smtpHost === '' || $smtpPort < 1 || $smtpPort > 65535) {
    configError('SMTP-Server oder Port ist ungültig.');
}
if (!filter_var($smtpUsername, FILTER_VALIDATE_EMAIL)) {
    configError('Der SMTP-Benutzername ist ungültig.');
}
if ($smtpPassword === '' || str_starts_with($smtpPassword, 'HIER_')) {
    configError('Das SMTP-Passwort wurde noch nicht in private/contact.php eingetragen.');
}
if (!in_array($smtpEncryption, ['tls', 'ssl'], true)) {
    configError('Die SMTP-Verschlüsselung muss tls oder ssl sein.');
}

$formSchemaConfig = require $domainRoot . '/config/forms/schemas.php';
$offerFields = $formSchemaConfig['offer_fields'];
$schemas = $formSchemaConfig['forms'];

$formType = clean((string) ($_POST['form_type'] ?? ''), 20);
if (!isset($schemas[$formType])) {
    fail('Unbekannter Formulartyp.', 400);
}

foreach ($_POST as $value) {
    if (is_array($value)) {
        fail('Die Anfrage enthält ein ungültiges Feldformat.', 400);
    }
}
$unknownFields = array_diff(array_keys($_POST), $schemas[$formType]['allowed']);
if ($unknownFields !== []) {
    fail('Die Anfrage enthält nicht erlaubte Felder.', 400);
}
$allowedFileFields = $formType === 'angebot' ? ['photos'] : [];
$unknownFileFields = array_diff(array_keys($_FILES), $allowedFileFields);
if ($unknownFileFields !== []) {
    fail('Die Anfrage enthält nicht erlaubte Dateifelder.', 400);
}
if (clean((string) ($_POST['website'] ?? ''), 200) !== '') {
    fail('Spamverdacht.', 400);
}

$post = static fn(string $name, int $max = 5000): string => clean((string) ($_POST[$name] ?? ''), $max);
$rawEmail = trim((string) ($_POST['email'] ?? ''));
$email = filter_var($rawEmail, FILTER_VALIDATE_EMAIL);
$phone = $post('phone', 30);
$privacy = (string) ($_POST['privacy'] ?? '') === '1';
$errors = [];

if (!$email || preg_match('/[\r\n]/', $rawEmail)) {
    $errors['email'] = 'Bitte geben Sie eine gültige E-Mail-Adresse an.';
}
if ($phone !== '' && !preg_match('/^[0-9+() \/.\-]{6,30}$/', $phone)) {
    $errors['phone'] = 'Bitte geben Sie eine gültige Telefonnummer ein.';
}
if (!$privacy) {
    $errors['privacy'] = 'Bitte bestätigen Sie, dass Sie die Datenschutzerklärung zur Kenntnis genommen haben.';
}

$attachments = [];
$mailRows = [];
$mailName = '';
$mailSubjectPrefix = '';

if ($formType === 'kontakt') {
    $name = $post('name', 120);
    $subjectInput = $post('subject', 140);
    $message = $post('message', 5000);

    if (textLength($name) < 2) {
        $errors['name'] = 'Bitte geben Sie Ihren Namen oder Firmennamen an.';
    }
    if (textLength($message) < 2) {
        $errors['message'] = 'Bitte beschreiben Sie kurz Ihr Anliegen.';
    }

    $mailName = $name;
    $mailSubjectPrefix = 'Neue Kontaktanfrage';
    $mailRows = [
        ['Name/Firma', $name],
        ['E-Mail', (string) $email],
        ['Telefon', $phone],
    ];
    if ($subjectInput !== '') {
        $mailRows[] = ['Betreff', $subjectInput];
    }
    $mailRows[] = ['Mitteilung', $message];
}

if ($formType === 'angebot') {
    $offer = [];
    foreach ($offerFields as $field) {
        if (in_array($field, ['form_type', 'website', 'privacy'], true)) {
            continue;
        }
        $offer[$field] = $post($field, str_contains($field, 'notes') || $field === 'other_details' ? 3000 : 180);
    }

    $firstName = $offer['first_name'];
    $lastName = $offer['last_name'];
    $company = $offer['company'];
    $cleaningPostcode = $offer['cleaning_postcode'];
    $cleaningCity = $offer['cleaning_city'];
    $cleaningStreet = $offer['cleaning_street'];

    if (textLength($firstName) < 2) {
        $errors['first_name'] = 'Bitte geben Sie Ihren Vornamen an.';
    }
    if (textLength($lastName) < 2) {
        $errors['last_name'] = 'Bitte geben Sie Ihren Nachnamen an.';
    }
    if (!preg_match('/^[0-9]{5}$/', $cleaningPostcode)) {
        $errors['cleaning_postcode'] = 'Bitte geben Sie eine fünfstellige Postleitzahl für den Einsatzort ein.';
    }
    if (textLength($cleaningCity) < 2) {
        $errors['cleaning_city'] = 'Bitte geben Sie den Ort des Einsatzortes an.';
    }

    $allowedSalutations = ['', 'Frau', 'Herr', 'Divers', 'Keine Angabe'];
    $allowedObjectTypes = ['Wohnung', 'Einfamilienhaus', 'Mehrfamilienhaus', 'Büro / Gewerbe', 'Praxis / Kanzlei', 'Gastronomie / Hotel', 'Öffentliche Einrichtung', 'Industrie / Lager', 'Sonstiges Objekt'];
    $allowedFurnishing = ['', 'Unmöbliert / leer', 'Teilweise möbliert', 'Voll möbliert', 'Nicht relevant'];
    if (!in_array($offer['salutation'], $allowedSalutations, true)) {
        $errors['salutation'] = 'Bitte wählen Sie eine gültige Anrede aus.';
    }
    if (!in_array($offer['object_type'], $allowedObjectTypes, true)) {
        $errors['object_type'] = 'Bitte wählen Sie eine gültige Objektart aus.';
    }
    if ($offer['furnishing'] !== '' && !in_array($offer['furnishing'], $allowedFurnishing, true)) {
        $errors['furnishing'] = 'Bitte wählen Sie die Art der Möblierung aus.';
    }


    $serviceMap = [
        'type_office' => 'Büro- und Gewerberaumreinigung',
        'type_window' => 'Glas- und Fensterreinigung',
        'type_general' => 'Grund- und Spezialreinigung',
        'type_carpet' => 'Teppichreinigung',
        'type_upholstery' => 'Polsterreinigung',
        'type_clearance' => 'Entrümpelung',
        'type_graffiti' => 'Fassaden- und Graffitireinigung',
        'type_solar' => 'Solar- und Photovoltaikanlagenreinigung',
        'type_other' => 'Sonstige Leistung',
    ];
    $selectedServices = [];
    foreach ($serviceMap as $field => $label) {
        if ((string) ($_POST[$field] ?? '') === '1') {
            $selectedServices[$field] = $label;
        }
    }
    if ($selectedServices === []) {
        $errors['type_office'] = 'Bitte wählen Sie mindestens eine Reinigungsart aus.';
    }
    if (isset($selectedServices['type_other']) && textLength($offer['other_details']) < 5) {
        $errors['other_details'] = 'Bitte beschreiben Sie die gewünschte sonstige Leistung.';
    }

    if (isset($selectedServices['type_office'])) {
        if (textLength($offer['office_area']) < 1) $errors['office_area'] = 'Bitte geben Sie die ungefähre Fläche an.';
        if ($offer['office_frequency'] === '') $errors['office_frequency'] = 'Bitte wählen Sie den gewünschten Turnus aus.';
    }
    if (isset($selectedServices['type_general'])) {
        if (textLength($offer['general_area']) < 1) $errors['general_area'] = 'Bitte geben Sie die ungefähre Fläche an.';
        if ($offer['general_reason'] === '') $errors['general_reason'] = 'Bitte wählen Sie den Anlass der Reinigung aus.';
    }
    if (isset($selectedServices['type_window'])) {
        if (textLength($offer['window_sashes']) < 1) $errors['window_sashes'] = 'Bitte geben Sie die ungefähre Fensteranzahl an.';
        if ($offer['window_scope'] === '') $errors['window_scope'] = 'Bitte wählen Sie den gewünschten Reinigungsumfang aus.';
    }
    if (isset($selectedServices['type_carpet'])) {
        if ($offer['carpet_scope'] === '') $errors['carpet_scope'] = 'Bitte wählen Sie den Reinigungswunsch aus.';
        if ($offer['carpet_soiling'] === '') $errors['carpet_soiling'] = 'Bitte wählen Sie den Verschmutzungsgrad aus.';
    }
    if (isset($selectedServices['type_upholstery'])) {
        if ($offer['upholstery_scope'] === '') $errors['upholstery_scope'] = 'Bitte wählen Sie den Reinigungswunsch aus.';
        if ($offer['upholstery_soiling'] === '') $errors['upholstery_soiling'] = 'Bitte wählen Sie den Verschmutzungsgrad aus.';
    }
    if (isset($selectedServices['type_graffiti'])) {
        if (textLength($offer['graffiti_area']) < 1) $errors['graffiti_area'] = 'Bitte geben Sie die ungefähre Fläche an.';
        if ($offer['graffiti_surface'] === '') $errors['graffiti_surface'] = 'Bitte wählen Sie den Untergrund aus.';
    }
    if (isset($selectedServices['type_solar'])) {
        if ($offer['solar_access'] === '') $errors['solar_access'] = 'Bitte wählen Sie die Zugänglichkeit aus.';
        if ($offer['solar_soiling'] === '') $errors['solar_soiling'] = 'Bitte wählen Sie den Verschmutzungsgrad aus.';
    }
    if (isset($selectedServices['type_clearance'])) {
        if (textLength($offer['clearance_area']) < 1) $errors['clearance_area'] = 'Bitte geben Sie die ungefähre Objektfläche an.';
        if ($offer['clearance_scope'] === '') $errors['clearance_scope'] = 'Bitte wählen Sie den gewünschten Umfang aus.';
    }

    $allowedAppointmentPreferences = ['Schnellstmöglich', 'Flexibel', 'Konkreter Termin'];
    $allowedTimes = ['Vormittags', 'Nachmittags', 'Abends', 'Flexibel'];
    if (!in_array($offer['appointment_preference'], $allowedAppointmentPreferences, true)) {
        $errors['appointment_preference'] = 'Bitte wählen Sie einen Terminwunsch aus.';
    }
    if ($offer['appointment_preference'] === 'Konkreter Termin') {
        if ($offer['desired_date'] === '' || !validDateNotPast($offer['desired_date'])) {
            $errors['desired_date'] = 'Bitte wählen Sie ein gültiges, zukünftiges Wunschdatum.';
        }
        if (!in_array($offer['desired_time'], $allowedTimes, true)) {
            $errors['desired_time'] = 'Bitte wählen Sie eine Tageszeit aus.';
        }
    }

    $countFields = [
        'upholstery_two_seater', 'upholstery_three_seater', 'upholstery_corner_small', 'upholstery_corner_large',
        'upholstery_armchair', 'upholstery_stool', 'upholstery_chair_seat', 'upholstery_chair_back', 'upholstery_custom_seats',
    ];
    foreach ($countFields as $field) {
        if ($offer[$field] !== '' && !preg_match('/^[0-9]{1,4}$/', $offer[$field])) {
            $errors[$field] = 'Bitte geben Sie eine gültige Anzahl ein.';
        }
    }

    if (isset($_FILES['photos'])) {
        try {
            $upload = kem_validate_photo_upload($_FILES['photos']);
        } catch (InvalidArgumentException $exception) {
            fail($exception->getMessage(), 400);
        }
        $attachments = $upload['attachments'];
        if ($upload['error'] !== null) $errors['photos[]'] = $upload['error'];
    }

    $mailName = trim($firstName . ' ' . $lastName);
    if ($company !== '') {
        $mailName .= ' – ' . $company;
    }
    $mailSubjectPrefix = 'Neue Angebotsanfrage';

    $addRow = static function (array &$rows, string $label, string $value): void {
        if (trim($value) !== '') {
            $rows[] = [$label, $value];
        }
    };

    $addRow($mailRows, 'Name', trim($offer['salutation'] . ' ' . $firstName . ' ' . $lastName));
    $addRow($mailRows, 'Firma', $company);
    $addRow($mailRows, 'E-Mail', (string) $email);
    $addRow($mailRows, 'Telefon', $phone);
    $addRow($mailRows, 'Reinigungsobjekt / Firma', $offer['cleaning_company']);
    $cleaningAddress = trim($cleaningStreet . ($cleaningStreet !== '' ? ', ' : '') . $cleaningPostcode . ' ' . $cleaningCity);
    $addRow($mailRows, 'Einsatzort / Reinigungsadresse', $cleaningAddress);
    $addRow($mailRows, 'Objektart', $offer['object_type']);
    $addRow($mailRows, 'Stockwerk / Etage', $offer['floor']);
    $addRow($mailRows, 'Möblierung', $offer['furnishing']);
    $addRow($mailRows, 'Gewünschte Reinigungsarten', implode(', ', array_values($selectedServices)));

    $formatArea = static fn(string $value): string => $value === '' ? '' : ($value === 'Bitte vor Ort einschätzen' ? $value : $value . ' m²');

    if (isset($selectedServices['type_office'])) {
        $addRow($mailRows, 'Büro / Gewerbe – Fläche', $formatArea($offer['office_area']));
        $addRow($mailRows, 'Büro / Gewerbe – Turnus', $offer['office_frequency']);
        $addRow($mailRows, 'Büro / Gewerbe – Räume', $offer['office_rooms']);
        $addRow($mailRows, 'Büro / Gewerbe – Verschmutzung', $offer['office_soiling']);
        $addRow($mailRows, 'Büro / Gewerbe – Hinweise', $offer['office_notes']);
    }
    if (isset($selectedServices['type_general'])) {
        $addRow($mailRows, 'Allgemeine Reinigung – Fläche', $formatArea($offer['general_area']));
        $addRow($mailRows, 'Allgemeine Reinigung – Anlass', $offer['general_reason']);
        $addRow($mailRows, 'Allgemeine Reinigung – Verschmutzung', $offer['general_soiling']);
        $addRow($mailRows, 'Allgemeine Reinigung – Hinweise', $offer['general_notes']);
    }
    if (isset($selectedServices['type_window'])) {
        $addRow($mailRows, 'Fenster – maximale Höhe', $offer['window_max_height']);
        $addRow($mailRows, 'Fenster – Anzahl / Flügel', $offer['window_sashes']);
        $addRow($mailRows, 'Fenster – Reinigungswunsch', $offer['window_scope']);
        $addRow($mailRows, 'Fenster – Verschmutzung', $offer['window_soiling']);
        $addRow($mailRows, 'Fenster – Hinweise', $offer['window_notes']);
    }
    if (isset($selectedServices['type_carpet'])) {
        $addRow($mailRows, 'Teppich – lose Teppiche', $offer['carpet_loose_count']);
        $addRow($mailRows, 'Teppich – Fläche lose', $offer['carpet_loose_area'] !== '' ? $offer['carpet_loose_area'] . ' m²' : '');
        $addRow($mailRows, 'Teppich – festverlegte Fläche', $offer['carpet_fitted_area'] !== '' ? $offer['carpet_fitted_area'] . ' m²' : '');
        $addRow($mailRows, 'Teppich – Reinigungswunsch', $offer['carpet_scope']);
        $addRow($mailRows, 'Teppich – Verschmutzung', $offer['carpet_soiling']);
        $addRow($mailRows, 'Teppich – Hinweise', $offer['carpet_notes']);
    }
    if (isset($selectedServices['type_upholstery'])) {
        $upholsteryLabels = [
            'upholstery_two_seater' => '2-Sitzer', 'upholstery_three_seater' => '3-Sitzer',
            'upholstery_corner_small' => 'Ecksofa klein', 'upholstery_corner_large' => 'Ecksofa groß',
            'upholstery_armchair' => 'Sessel', 'upholstery_stool' => 'Hocker',
            'upholstery_chair_seat' => 'Polsterstuhl ohne Lehne', 'upholstery_chair_back' => 'Polsterstuhl mit Lehne',
            'upholstery_custom_seats' => 'Individuelles Sofa / Sitzflächen',
        ];
        foreach ($upholsteryLabels as $field => $label) {
            $addRow($mailRows, 'Polster – ' . $label, $offer[$field]);
        }
        $addRow($mailRows, 'Polster – Reinigungswunsch', $offer['upholstery_scope']);
        $addRow($mailRows, 'Polster – Verschmutzung', $offer['upholstery_soiling']);
        $addRow($mailRows, 'Polster – Hinweise', $offer['upholstery_notes']);
    }
    if (isset($selectedServices['type_graffiti'])) {
        $addRow($mailRows, 'Fassade / Graffiti – Fläche', $formatArea($offer['graffiti_area']));
        $addRow($mailRows, 'Fassade / Graffiti – Untergrund', $offer['graffiti_surface']);
        $addRow($mailRows, 'Fassade / Graffiti – Reinigungswunsch', $offer['graffiti_scope']);
        $addRow($mailRows, 'Fassade / Graffiti – Hinweise', $offer['graffiti_notes']);
    }
    if (isset($selectedServices['type_solar'])) {
        $addRow($mailRows, 'Solar – Module', $offer['solar_modules']);
        $addRow($mailRows, 'Solar – Fläche', $offer['solar_area'] !== '' ? $offer['solar_area'] . ' m²' : '');
        $addRow($mailRows, 'Solar – Zugang', $offer['solar_access']);
        $addRow($mailRows, 'Solar – Verschmutzung', $offer['solar_soiling']);
        $addRow($mailRows, 'Solar – Hinweise', $offer['solar_notes']);
    }
    if (isset($selectedServices['type_clearance'])) {
        $addRow($mailRows, 'Entrümpelung – Objektfläche', $formatArea($offer['clearance_area']));
        $addRow($mailRows, 'Entrümpelung – Volumen', $offer['clearance_volume']);
        $addRow($mailRows, 'Entrümpelung – Etage / Zugang', $offer['clearance_floor']);
        $addRow($mailRows, 'Entrümpelung – Aufzug', $offer['clearance_elevator']);
        $addRow($mailRows, 'Entrümpelung – Umfang', $offer['clearance_scope']);
        $addRow($mailRows, 'Entrümpelung – Hinweise', $offer['clearance_notes']);
    }
    if (isset($selectedServices['type_other'])) {
        $addRow($mailRows, 'Sonstige Leistung', $offer['other_details']);
    }

    $addRow($mailRows, 'Terminwunsch', $offer['appointment_preference']);
    if ($offer['appointment_preference'] === 'Konkreter Termin') {
        $addRow($mailRows, 'Gewünschter Reinigungstermin', formatDateGerman($offer['desired_date']) . ' · ' . $offer['desired_time']);
    }
    $addRow($mailRows, 'Termin-Hinweis', $offer['appointment_notes']);
    if ($attachments !== []) {
        $addRow($mailRows, 'Anhänge', count($attachments) . ' Foto(s)');
    }
}

if ($errors !== []) {
    fail('Bitte prüfen Sie die markierten Felder.', 422, $errors);
}

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate = max(15, (int) ($config['rate_limit_seconds'] ?? 45));
$key = sys_get_temp_dir() . '/kem_form_' . hash('sha256', $ip);
if (is_file($key) && time() - (int) filemtime($key) < $rate) {
    header('Retry-After: ' . $rate);
    fail('Bitte warten Sie kurz, bevor Sie erneut senden.', 429);
}
@touch($key);

$body = "Neue Website-Anfrage\n=====================\n\n";
$body .= 'Formular: ' . ($formType === 'angebot' ? 'Detaillierte Angebotsanfrage' : 'Kontaktanfrage') . "\n\n";
foreach ($mailRows as [$label, $value]) {
    if ($value === '') {
        continue;
    }
    $body .= $label . ': ' . $value . "\n\n";
}
$body .= 'Zeit: ' . date('d.m.Y H:i:s') . "\n";

$mailSubject = $mailSubjectPrefix . ' – ' . $mailName;
$mailSubject = str_replace(["\r", "\n"], ' ', $mailSubject);
try {
    kem_send_smtp_mail([
        'host' => $smtpHost,
        'port' => $smtpPort,
        'encryption' => $smtpEncryption,
        'username' => $smtpUsername,
        'password' => $smtpPassword,
        'timeout' => $smtpTimeout,
    ], [
        'from_email' => $fromEmail,
        'from_name' => $fromName,
        'recipient' => $recipient,
        'reply_to' => (string) $email,
        'reply_name' => $mailName,
        'subject' => $mailSubject,
        'body' => $body,
        'attachments' => $attachments,
    ]);
} catch (Throwable $exception) {
    error_log('KEM Kontaktformular – SMTP: ' . str_replace(["\r", "\n"], ' ', $exception->getMessage()));
    fail('Ihre Anfrage konnte technisch nicht versendet werden. Bitte rufen Sie uns an.', 500);
}

$successMessage = $formType === 'angebot'
    ? 'Vielen Dank. Ihre Angebotsanfrage wurde erfolgreich gesendet. Jemand aus unserem Team meldet sich in Kürze bei Ihnen.'
    : 'Vielen Dank. Ihre Nachricht wurde erfolgreich gesendet. Jemand aus unserem Team meldet sich in Kürze bei Ihnen.';

respond(['ok' => true, 'message' => $successMessage]);

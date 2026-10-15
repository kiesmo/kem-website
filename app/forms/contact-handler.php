<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store, max-age=0');
date_default_timezone_set('Europe/Berlin');

require_once __DIR__ . '/request-utils.php';
require_once __DIR__ . '/photo-upload.php';
require_once __DIR__ . '/offer-request.php';
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
    $cleanOffer = [];
    foreach ($offerFields as $field) {
        if (in_array($field, ['form_type', 'website', 'privacy'], true)) continue;
        // Selection flags are exact tokens, not arbitrary nonempty values or summaries.
        $cleanOffer[$field] = str_starts_with($field, 'type_')
            ? (is_string($_POST[$field] ?? null) ? $_POST[$field] : '')
            : $post($field, str_contains($field, 'notes') || $field === 'other_details' ? 3000 : 180);
    }
    $prepared = kem_prepare_offer_request($cleanOffer, (string) $email, $phone);
    $offer = $prepared['offer'];
    $errors = array_merge($errors, $prepared['errors']);
    $mailRows = $prepared['mail_rows'];
    $mailName = $prepared['mail_name'];
    $mailSubjectPrefix = 'Neue Angebotsanfrage';

    if (isset($_FILES['photos'])) {
        try {
            $upload = kem_validate_photo_upload($_FILES['photos']);
        } catch (InvalidArgumentException $exception) {
            fail($exception->getMessage(), 400);
        }
        $attachments = $upload['attachments'];
        if ($upload['error'] !== null) $errors['photos[]'] = $upload['error'];
    }
    if ($attachments !== []) $mailRows[] = ['Anhänge', count($attachments) . ' Foto(s)'];
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

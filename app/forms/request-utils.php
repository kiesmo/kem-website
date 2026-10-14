<?php
declare(strict_types=1);

function respond(array $payload, int $status = 200): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function fail(string $message, int $status = 422, array $errors = []): never
{
    $payload = ['ok' => false, 'message' => $message];
    if ($errors !== []) $payload['errors'] = $errors;
    respond($payload, $status);
}

function clean(string $value, int $max = 5000): string
{
    $value = trim(str_replace(["\r\n", "\r"], "\n", $value));
    $value = strip_tags($value);
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

function textLength(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
}

function configError(string $detail): never
{
    error_log('KEM Kontaktformular – Konfigurationsfehler: ' . str_replace(["\r", "\n"], ' ', $detail));
    fail('Das Formular ist noch nicht vollständig konfiguriert. Bitte rufen Sie uns an.', 503);
}

function validDateNotPast(string $value): bool
{
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    $dateErrors = DateTimeImmutable::getLastErrors();
    $valid = $date instanceof DateTimeImmutable
        && ($dateErrors === false || ($dateErrors['warning_count'] === 0 && $dateErrors['error_count'] === 0))
        && $date->format('Y-m-d') === $value;
    return $valid && $date >= new DateTimeImmutable('today', new DateTimeZone('Europe/Berlin'));
}

function formatDateGerman(string $value): string
{
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    return $date instanceof DateTimeImmutable ? $date->format('d.m.Y') : $value;
}

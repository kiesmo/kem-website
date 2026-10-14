<?php
declare(strict_types=1);

$smtpConfig = require __DIR__ . '/smtp-config.php';
$password = is_array($smtpConfig) ? (string) ($smtpConfig['password'] ?? '') : '';

return [
    'recipient' => 'info@kem-gebaeudereinigung.de',
    'from_email' => 'info@kem-gebaeudereinigung.de',
    'from_name' => 'KEM Website',
    'smtp' => [
        'host' => 'smtp.hostinger.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'info@kem-gebaeudereinigung.de',
        'password' => is_string($password) ? trim($password) : '',
        'timeout' => 15,
    ],
    'rate_limit_seconds' => 45,
];

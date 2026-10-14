<?php
declare(strict_types=1);

/** @return array{attachments: array<int,array{path:string,name:string,mime:string}>, error: string|null} */
function kem_validate_photo_upload(array $files): array
{
    if (!is_array($files['name'] ?? null) || !is_array($files['tmp_name'] ?? null) || !is_array($files['error'] ?? null) || !is_array($files['size'] ?? null)) {
        throw new InvalidArgumentException('Die hochgeladenen Dateien haben ein ungültiges Format.');
    }
    $fileCount = count($files['name']);
    if ($fileCount > 5) return ['attachments' => [], 'error' => 'Bitte laden Sie höchstens 5 Fotos hoch.'];

    $allowedMimes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $attachments = [];
    $totalSize = 0;
    for ($i = 0; $i < $fileCount; $i++) {
        $error = (int) ($files['error'][$i] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) continue;
        if ($error !== UPLOAD_ERR_OK) return ['attachments' => [], 'error' => 'Mindestens ein Foto konnte nicht vollständig hochgeladen werden.'];

        $tmpName = (string) ($files['tmp_name'][$i] ?? '');
        $size = (int) ($files['size'][$i] ?? 0);
        if ($size < 1 || $size > 5 * 1024 * 1024) return ['attachments' => [], 'error' => 'Jedes Foto darf höchstens 5 MB groß sein.'];
        $totalSize += $size;
        if ($totalSize > 15 * 1024 * 1024) return ['attachments' => [], 'error' => 'Die Fotos dürfen zusammen höchstens 15 MB groß sein.'];
        if (!is_uploaded_file($tmpName)) return ['attachments' => [], 'error' => 'Eine hochgeladene Datei konnte nicht verifiziert werden.'];

        $mime = '';
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo !== false) {
                $mime = (string) finfo_file($finfo, $tmpName);
                finfo_close($finfo);
            }
        }
        if (!isset($allowedMimes[$mime])) return ['attachments' => [], 'error' => 'Erlaubt sind ausschließlich JPG-, PNG- und WebP-Dateien.'];

        $base = pathinfo((string) ($files['name'][$i] ?? 'Foto'), PATHINFO_FILENAME);
        $base = preg_replace('/[^A-Za-z0-9_-]+/', '-', $base) ?: 'Foto';
        $attachments[] = [
            'path' => $tmpName,
            'name' => substr($base, 0, 60) . '-' . ($i + 1) . '.' . $allowedMimes[$mime],
            'mime' => $mime,
        ];
    }
    return ['attachments' => $attachments, 'error' => null];
}

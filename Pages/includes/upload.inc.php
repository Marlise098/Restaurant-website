<?php

function admin_upload_image(array $file): array
{
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['image' => '', 'error' => ''];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['image' => '', 'error' => 'The uploaded image could not be processed. Please try again.'];
    }

    $uploadDir = dirname(__DIR__) . '/images';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $fileMimeType = @mime_content_type($file['tmp_name']) ?: '';

    if (!in_array($fileMimeType, $allowedMimeTypes, true)) {
        return ['image' => '', 'error' => 'Please upload a valid image file (JPG, PNG, WEBP, or GIF).'];
    }

    $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
    $safeBaseName = preg_replace('/[^A-Za-z0-9_-]+/', '-', $originalName);
    $safeBaseName = trim((string) $safeBaseName, '-');
    $safeBaseName = $safeBaseName !== '' ? $safeBaseName : 'dish';

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($extension === '') {
        $extension = match ($fileMimeType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => 'jpg',
        };
    }

    $image = $safeBaseName . '-' . time() . '.' . $extension;
    $targetPath = $uploadDir . '/' . $image;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['image' => '', 'error' => 'The image upload failed. Please try again.'];
    }

    return ['image' => $image, 'error' => ''];
}

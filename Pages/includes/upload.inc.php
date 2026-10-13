<?php

function admin_upload_image(array $uploadedFile): array
{
    // Geen bestand gekozen? Dan hoeft er niets te worden opgeslagen.
    if ($uploadedFile['error'] === UPLOAD_ERR_NO_FILE) {
        return ['image' => '', 'error' => ''];
    }

    if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
        return ['image' => '', 'error' => 'The uploaded image could not be processed. Please try again.'];
    }

    // Ga twee mappen omhoog naar de images-map van de website.
    $uploadDirectory = dirname(__DIR__, 2) . '/images';
    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
        return ['image' => '', 'error' => 'The image folder could not be created.'];
    }

    // Controleer het echte bestandstype; een bestandsnaam kan misleidend zijn.
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    $detectedMimeType = @mime_content_type($uploadedFile['tmp_name']) ?: '';

    if (!in_array($detectedMimeType, $allowedMimeTypes, true)) {
        return ['image' => '', 'error' => 'Please upload a valid image file (JPG, PNG, WEBP, or GIF).'];
    }

    // Haal de extensie weg en vervang ongeschikte tekens door een streepje.
    $originalFilename = pathinfo($uploadedFile['name'], PATHINFO_FILENAME);
    $safeFilename = preg_replace('/[^A-Za-z0-9_-]+/', '-', $originalFilename);
    $safeFilename = trim((string) $safeFilename, '-');
    $safeFilename = $safeFilename !== '' ? $safeFilename : 'dish';

    // Kies de extensie die bij het echte afbeeldingstype hoort.
    $extension = match ($detectedMimeType) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
        default => 'jpg',
    };

    // Voeg een willekeurige code toe zodat uploads elkaar niet overschrijven.
    $imageFilename = substr($safeFilename, 0, 100) . '-' . bin2hex(random_bytes(8)) . '.' . $extension;
    $destinationPath = $uploadDirectory . '/' . $imageFilename;

    // Verplaats het tijdelijke uploadbestand naar de images-map.
    if (!move_uploaded_file($uploadedFile['tmp_name'], $destinationPath)) {
        return ['image' => '', 'error' => 'The image upload failed. Please try again.'];
    }

    return ['image' => $imageFilename, 'error' => ''];
}

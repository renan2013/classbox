<?php
/**
 * Classbox CMS & Sitio Web - Enrutador Principal en Producción
 */
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? ''
);

// Si la URL solicita el panel admin
if (str_contains($uri, '/admin') || str_contains($uri, '/classbox_laravel')) {
    header("Location: /classbox_laravel/public/admin");
    exit;
}

// Por defecto, dirigir al Sitio Web Público
header("Location: /web_site_laravel/public/");
exit;
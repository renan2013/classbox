<?php
/**
 * Classbox CMS & Sitio Web - Enrutador Principal en Producción
 */
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Si la URL contiene /admin o /classbox_laravel, dirigir al panel CMS
if (str_contains($uri, '/admin') || str_contains($uri, '/classbox_laravel')) {
    header("Location: /classbox/classbox_laravel/public/admin");
    exit;
}

// Por defecto, dirigir al Sitio Web Público
header("Location: /classbox/web_site_laravel/public/");
exit;
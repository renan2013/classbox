<?php
/**
 * Script para crear los enlaces simbólicos de almacenamiento (storage) en Hostinger
 */

$results = [];

// 1. Enlace para classbox_laravel
$target1 = __DIR__ . '/classbox_laravel/storage/app/public';
$link1 = __DIR__ . '/classbox_laravel/public/storage';

if (!file_exists($link1)) {
    @symlink($target1, $link1);
    $results['classbox_laravel'] = file_exists($link1) ? 'Symlink creado exitosamente' : 'No se pudo crear symlink (se usará ruta de fallback)';
} else {
    $results['classbox_laravel'] = 'Symlink ya existe';
}

// 2. Enlace para web_site_laravel apuntando al almacenamiento compartido de classbox_laravel
$target2 = __DIR__ . '/classbox_laravel/storage/app/public';
$link2 = __DIR__ . '/web_site_laravel/public/storage';

if (!file_exists($link2)) {
    @symlink($target2, $link2);
    $results['web_site_laravel'] = file_exists($link2) ? 'Symlink creado hacia classbox storage exitosamente' : 'No se pudo crear symlink (se usará ruta de fallback)';
} else {
    $results['web_site_laravel'] = 'Symlink ya existe';
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);

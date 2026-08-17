<?php
/**
 * Script para crear enlaces simbólicos de almacenamiento (storage) en Hostinger
 */

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

$res = [];
if (!file_exists($link)) {
    $ok = @symlink($target, $link);
    $res['status'] = $ok ? 'created' : 'failed';
    $res['message'] = $ok ? 'Enlace simbolico creado exitosamente!' : 'No se pudo crear symlink';
} else {
    $res['status'] = 'exists';
    $res['message'] = 'El enlace simbolico ya existe';
}

header('Content-Type: application/json');
echo json_encode($res, JSON_PRETTY_PRINT);

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Optimiza, redimensiona y convierte una imagen a WebP antes de guardarla.
     *
     * @param UploadedFile $file
     * @param string $folder Carpeta dentro de storage (ej: 'posts', 'categories', 'testimonios')
     * @param int $maxWidth Ancho máximo en píxeles (default: 1200px)
     * @param int $quality Calidad de compresión WebP 1-100 (default: 80)
     * @return string Ruta relativa del archivo guardado (ej: 'posts/uuid.webp')
     */
    public static function optimizeAndStore(UploadedFile $file, string $folder, int $maxWidth = 1200, int $quality = 80): string
    {
        // 1. Cargar imagen con Intervention Image v3
        $image = Image::read($file);

        // 2. Redimensionar inteligentemente solo si excede el ancho máximo
        $image->scaleDown(width: $maxWidth);

        // 3. Convertir a formato WebP optimizado
        $encoded = $image->toWebp($quality);

        // 4. Generar nombre único
        $filename = Str::uuid() . '.webp';
        $path = $folder . '/' . $filename;

        // 5. Guardar en el disco 'public'
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}

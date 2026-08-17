<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GraduacionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Portada Principal
Route::get('/', [HomeController::class, 'index'])->name('site.home');

// Portafolio de Trabajos
Route::get('/portafolio', [PortfolioController::class, 'index'])->name('site.portfolio');

// Cursos y Categorías
Route::get('/categoria/{id}', [CourseController::class, 'byCategory'])->name('site.category');
Route::get('/curso/{id}', [CourseController::class, 'show'])->name('site.course.show');

// Graduaciones
Route::get('/graduaciones', [GraduacionController::class, 'index'])->name('site.graduaciones');
Route::get('/graduacion/{id}', [GraduacionController::class, 'show'])->name('site.graduacion.show');

// Páginas Institucionales
Route::get('/quienes-somos', [PageController::class, 'about'])->name('site.about');
Route::get('/docentes', [PageController::class, 'team'])->name('site.team');
Route::get('/testimonios', [PageController::class, 'testimonials'])->name('site.testimonials');

// Contacto & Admisión
Route::get('/contacto', [ContactController::class, 'index'])->name('site.contact');
Route::post('/contacto', [ContactController::class, 'submit'])->name('site.contact.submit');

// Ruta nativa para servir archivos de storage subidos desde el CMS sin depender de symlinks
Route::get('storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        // Buscar en la carpeta de almacenamiento de classbox_laravel
        $altPath = base_path('../classbox_laravel/storage/app/public/' . $path);
        if (file_exists($altPath)) {
            $filePath = $altPath;
        } else {
            abort(404);
        }
    }
    return response()->file($filePath);
})->where('path', '.*');

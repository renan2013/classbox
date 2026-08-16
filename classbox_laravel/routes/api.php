<?php

use App\Http\Controllers\Api\V1\AdmisionController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ClientDataController;
use App\Http\Controllers\Api\V1\GraduacionController;
use App\Http\Controllers\Api\V1\HomeSectionController;
use App\Http\Controllers\Api\V1\MediaController;
use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\TestimonioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Constructor de Portada (Secciones Modulares)
    Route::get('/home-sections', [HomeSectionController::class, 'index']);

    // Banners y Sliders
    Route::get('/banners', [BannerController::class, 'index']);

    // Páginas Estáticas
    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/pages/{slug}', [PageController::class, 'show']);

    // Publicaciones / Cursos
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);

    // Categorías
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    // Menús
    Route::get('/menus', [MenuController::class, 'index']);

    // Testimonios
    Route::get('/testimonios', [TestimonioController::class, 'index']);

    // Datos del Cliente
    Route::get('/client-data', [ClientDataController::class, 'show']);

    // Admisiones / Formulario de Matrícula
    Route::post('/admisiones', [AdmisionController::class, 'store']);

    // Graduaciones
    Route::get('/graduaciones', [GraduacionController::class, 'index']);
    Route::get('/graduaciones/{id}', [GraduacionController::class, 'show']);

    // Biblioteca de Medios
    Route::get('/media', [MediaController::class, 'index']);
    Route::get('/media/{id}', [MediaController::class, 'show']);
});

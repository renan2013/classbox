<?php

use App\Http\Controllers\Admin\AdmisionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientDataController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GraduacionController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\PortfolioItemController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TestimonioController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Redirigir la raíz al panel o login
Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Rutas de autenticación
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas protegidas por autenticación
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Módulo: Publicaciones
        Route::middleware('module:posts')->group(function () {
            Route::post('posts/upload-editor-image', [PostController::class, 'uploadEditorImage'])->name('posts.upload_editor_image');
            Route::resource('posts', PostController::class);
            Route::delete('attachments/{id}', [PostController::class, 'deleteAttachment'])->name('attachments.destroy');
            Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
        });

        // Módulo: Admisiones
        Route::middleware('module:admisiones')->group(function () {
            Route::get('admisiones/export-csv', [AdmisionController::class, 'exportCsv'])->name('admisiones.export');
            Route::resource('admisiones', AdmisionController::class)->only(['index', 'show', 'update', 'destroy']);
        });

        // Módulo: Menús
        Route::middleware('module:menus')->group(function () {
            Route::post('menus/seed-defaults', [MenuController::class, 'seedDefaults'])->name('menus.seed_defaults');
            Route::resource('menus', MenuController::class)->except(['create', 'show']);
        });

        // Módulo: Datos del Cliente
        Route::middleware('module:client_data')->group(function () {
            Route::get('client-data', [ClientDataController::class, 'index'])->name('client_data.index');
            Route::match(['put', 'post'], 'client-data', [ClientDataController::class, 'update'])->name('client_data.update');
            Route::get('client_data', [ClientDataController::class, 'index'])->name('client-data.index');
            Route::match(['put', 'post'], 'client_data', [ClientDataController::class, 'update'])->name('client-data.update');
        });

        // Módulo: Testimonios
        Route::middleware('module:testimonios')->group(function () {
            Route::resource('testimonios', TestimonioController::class)->except(['create', 'show', 'edit']);
        });

        // Módulo: Galerías y Graduaciones
        Route::middleware('module:galerias')->group(function () {
            Route::resource('graduaciones', GraduacionController::class)->except(['create', 'show', 'edit']);
            Route::delete('graduaciones-attachments/{id}', [GraduacionController::class, 'deleteAttachment'])->name('graduaciones.attachment.destroy');
        });

        // Módulo: Biblioteca de Medios
        Route::middleware('module:media')->group(function () {
            Route::resource('media', MediaController::class)->except(['create', 'show', 'edit']);
        });

        // Módulo: Banners y Sliders
        Route::middleware('module:banners')->group(function () {
            Route::post('banners/{id}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle_status');
            Route::resource('banners', BannerController::class)->except(['show']);
        });

        // Módulo: Páginas Estáticas
        Route::middleware('module:pages')->group(function () {
            Route::resource('pages', PageController::class)->except(['show']);
        });

        // Módulo: Portafolio de Trabajos
        Route::middleware('module:portfolio')->prefix('portfolio')->name('portfolio.')->group(function () {
            Route::resource('categories', PortfolioCategoryController::class)->except(['create', 'show', 'edit']);
            Route::resource('items', PortfolioItemController::class)->except(['show']);
        });

        // Módulo: Constructor de Portada (Page Builder)
        Route::middleware('module:home_sections')->group(function () {
            Route::post('home-sections/order', [HomeSectionController::class, 'updateOrder'])->name('home_sections.order');
            Route::post('home-sections/{id}/toggle-status', [HomeSectionController::class, 'toggleStatus'])->name('home_sections.toggle_status');
            Route::resource('home-sections', HomeSectionController::class)->names('home_sections')->except(['create', 'show', 'edit']);
        });

        // Módulo: Usuarios
        Route::middleware('module:users')->group(function () {
            Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
        });
    });
});

// Ruta nativa para servir archivos de storage en producción sin depender de symlinks
Route::get('storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ClientData;
use App\Models\HomeSection;
use App\Models\Menu;
use App\Models\Module;
use App\Models\Post;
use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Módulos del Sistema
        $modules = [
            ['name' => 'posts', 'display_name' => 'Gestor de Publicaciones', 'description' => 'Crear, editar y eliminar publicaciones del blog.'],
            ['name' => 'admisiones', 'display_name' => 'Gestor de Admisiones', 'description' => 'Gestiona las solicitudes de matrícula recibidas.'],
            ['name' => 'menus', 'display_name' => 'Gestor de Menús', 'description' => 'Controlar la navegación del sitio web principal.'],
            ['name' => 'users', 'display_name' => 'Gestor de Usuarios', 'description' => 'Administrar usuarios administradores.'],
            ['name' => 'client_data', 'display_name' => 'Datos Cliente', 'description' => 'Gestionar la información de contacto y redes sociales del cliente.'],
            ['name' => 'galerias', 'display_name' => 'Gestor de Galerías', 'description' => 'Administrar álbumes de fotos y graduaciones independientes.'],
            ['name' => 'testimonios', 'display_name' => 'Gestor de Testimonios', 'description' => 'Administrar comentarios de estudiantes.'],
            ['name' => 'media', 'display_name' => 'Biblioteca de Medios', 'description' => 'Subir y administrar archivos, documentos, videos y fotos globales.'],
            ['name' => 'banners', 'display_name' => 'Banners & Sliders', 'description' => 'Administrar carruseles y banners promocionales del inicio.'],
            ['name' => 'pages', 'display_name' => 'Páginas Estáticas', 'description' => 'Crear y editar páginas independientes (Quiénes Somos, Políticas, etc.).'],
            ['name' => 'home_sections', 'display_name' => 'Constructor de Portada', 'description' => 'Configurar el orden y visualización de módulos de la página principal.'],
        ];

        $moduleIds = [];
        foreach ($modules as $mod) {
            $m = Module::updateOrCreate(['name' => $mod['name']], $mod);
            $moduleIds[] = $m->id;
        }

        // 2. Secciones Modulares de la Portada
        $defaultSections = [
            [
                'section_key' => 'slider',
                'name' => 'Carrusel / Sliders de Portada',
                'title' => null,
                'subtitle' => null,
                'order' => 1,
                'is_active' => true,
                'settings' => ['autoplay' => true, 'interval' => 5000],
            ],
            [
                'section_key' => 'categories',
                'name' => 'Áreas de Formación / Escuelas',
                'title' => 'Áreas de Formación',
                'subtitle' => 'Nuestras Escuelas',
                'order' => 2,
                'is_active' => true,
                'settings' => ['show_courses_count' => true],
            ],
            [
                'section_key' => 'featured_posts',
                'name' => 'Cursos Populares / Destacados',
                'title' => 'Programas Destacados',
                'subtitle' => 'Cursos Populares',
                'order' => 3,
                'is_active' => true,
                'settings' => ['limit' => 6, 'show_category_badge' => true],
            ],
            [
                'section_key' => 'testimonials',
                'name' => 'Testimonios de Estudiantes',
                'title' => 'Lo Que Dicen Nuestros Estudiantes',
                'subtitle' => 'Testimonios',
                'order' => 4,
                'is_active' => true,
                'settings' => ['limit' => 5],
            ],
            [
                'section_key' => 'graduaciones',
                'name' => 'Graduaciones & Galería de Éxito',
                'title' => 'Nuestras Graduaciones',
                'subtitle' => 'Casos de Éxito',
                'order' => 5,
                'is_active' => true,
                'settings' => ['limit' => 4],
            ],
            [
                'section_key' => 'cta_banner',
                'name' => 'Banner de Matrícula / Llamada a la Acción',
                'title' => '¿Listo para Iniciar Tu Carrera Profesional?',
                'subtitle' => 'Matrícula Abierta 2026',
                'order' => 6,
                'is_active' => true,
                'settings' => ['button_text' => 'Solicitar Información', 'button_url' => '/contacto'],
            ],
        ];

        foreach ($defaultSections as $sec) {
            HomeSection::firstOrCreate(['section_key' => $sec['section_key']], $sec);
        }

        // 3. Usuario SuperAdmin
        $admin = User::updateOrCreate(
            ['username' => 'renangalvan'],
            [
                'full_name' => 'Renan Galvan',
                'name' => 'Renan Galvan',
                'email' => 'admin@classbox.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $admin->modules()->sync($moduleIds);

        // 4. Datos del Cliente
        ClientData::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'CEFI - Centro de Formación Integral',
                'email' => 'contacto@ceficr.com',
                'phone' => '+(506) 22217870 / +(506) 22212502',
                'whatsapp_country_code' => '506',
                'whatsapp_number' => '87220999',
                'address' => "Costado oeste de la Clínica Bíblica\nTorre Omega piso 9, San José, Costa Rica",
                'facebook_url' => 'https://www.facebook.com/ceficr',
                'instagram_url' => 'https://www.instagram.com/ceficr',
                'youtube_url' => 'https://www.youtube.com',
                'tiktok_url' => '',
            ]
        );
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('portfolio_categories')) {
            Schema::create('portfolio_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('portfolio_items')) {
            Schema::create('portfolio_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->nullable()->constrained('portfolio_categories')->onDelete('set null');
                $table->string('title');
                $table->string('client_name')->nullable();
                $table->text('description')->nullable();
                $table->string('image_path');
                $table->string('project_url')->nullable();
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Registrar módulo en la tabla modules
        if (Schema::hasTable('modules')) {
            DB::table('modules')->updateOrInsert(
                ['name' => 'portfolio'],
                ['display_name' => 'Portafolio de Trabajos', 'description' => 'Gestión de proyectos, logos, clientes y portafolio interactivo', 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Registrar sección por defecto en home_sections si existe la tabla
        if (Schema::hasTable('home_sections')) {
            $maxOrder = DB::table('home_sections')->max('order') ?? 0;
            DB::table('home_sections')->updateOrInsert(
                ['section_key' => 'portfolio'],
                [
                    'name' => 'Portafolio de Trabajos',
                    'title' => 'Portafolio de Trabajos',
                    'subtitle' => 'A lo largo de más de 25 años de trabajo queremos compartir algunos de nuestros trabajos que ponemos a su disposición',
                    'order' => $maxOrder + 1,
                    'is_active' => true,
                    'settings' => json_encode(['limit' => 12, 'show_filters' => true]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
        Schema::dropIfExists('portfolio_categories');

        if (Schema::hasTable('modules')) {
            DB::table('modules')->where('name', 'portfolio')->delete();
        }

        if (Schema::hasTable('home_sections')) {
            DB::table('home_sections')->where('section_key', 'portfolio')->delete();
        }
    }
};

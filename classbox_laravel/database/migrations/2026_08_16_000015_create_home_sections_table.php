<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 50); // slider, categories, featured_posts, testimonials, graduaciones, cta_banner, custom_content
            $table->string('name'); // Nombre en el panel administrativo
            $table->string('title')->nullable(); // Título en el sitio web
            $table->string('subtitle')->nullable(); // Subtítulo o badge
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable(); // configuraciones extras (limite, background, etc.)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};

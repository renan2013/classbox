<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('graduaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('synopsis')->nullable();
            $table->string('main_image')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();
        });

        Schema::create('graduaciones_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('graduacion_id')->constrained('graduaciones')->onDelete('cascade');
            $table->enum('type', ['pdf', 'youtube', 'gallery_image'])->default('gallery_image');
            $table->string('value');
            $table->string('file_name')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('graduaciones_attachments');
        Schema::dropIfExists('graduaciones');
    }
};

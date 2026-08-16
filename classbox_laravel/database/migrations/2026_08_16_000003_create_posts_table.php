<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('synopsis')->nullable();
            $table->longText('content')->nullable();
            $table->string('main_image')->nullable();
            $table->integer('order')->default(0);
            $table->string('instructor_name')->nullable();
            $table->string('instructor_title')->nullable();
            $table->string('instructor_photo')->nullable();
            $table->boolean('show_in_instructors')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

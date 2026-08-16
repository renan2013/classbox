<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('title_weight', 20)->default('light')->nullable()->after('title_size');
            $table->string('font_family', 30)->default('roboto')->nullable()->after('title_weight');
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->string('slider_title_weight', 20)->default('light')->nullable()->after('slider_title_size');
            $table->string('slider_font_family', 30)->default('roboto')->nullable()->after('slider_title_weight');
            $table->string('slider_button_style', 20)->default('text_link')->nullable()->after('slider_font_family');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['title_weight', 'font_family']);
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn(['slider_title_weight', 'slider_font_family', 'slider_button_style']);
        });
    }
};

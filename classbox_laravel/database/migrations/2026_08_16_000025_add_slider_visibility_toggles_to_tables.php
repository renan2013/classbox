<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->boolean('show_subtitle')->default(true)->after('button_style');
            $table->boolean('show_title')->default(true)->after('show_subtitle');
            $table->boolean('show_button')->default(true)->after('show_title');
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->boolean('slider_show_subtitle')->default(false)->after('slider_button_style');
            $table->boolean('slider_show_title')->default(true)->after('slider_show_subtitle');
            $table->boolean('slider_show_button')->default(true)->after('slider_show_title');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['show_subtitle', 'show_title', 'show_button']);
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn(['slider_show_subtitle', 'slider_show_title', 'slider_show_button']);
        });
    }
};

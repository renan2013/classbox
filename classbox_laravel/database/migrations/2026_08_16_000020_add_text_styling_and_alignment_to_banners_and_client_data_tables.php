<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('content_alignment', 20)->default('left')->nullable()->after('overlay_style');
            $table->string('title_color', 20)->default('#ffffff')->nullable()->after('content_alignment');
            $table->string('title_size', 20)->default('lg')->nullable()->after('title_color');
            $table->string('subtitle_color', 20)->default('#06BBCC')->nullable()->after('title_size');
            $table->string('button_style', 20)->default('primary')->nullable()->after('subtitle_color');
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->string('slider_content_alignment', 20)->default('left')->nullable()->after('slider_overlay_style');
            $table->string('slider_title_color', 20)->default('#ffffff')->nullable()->after('slider_content_alignment');
            $table->string('slider_title_size', 20)->default('lg')->nullable()->after('slider_title_color');
            $table->string('slider_subtitle_color', 20)->default('#06BBCC')->nullable()->after('slider_title_size');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'content_alignment',
                'title_color',
                'title_size',
                'subtitle_color',
                'button_style',
            ]);
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn([
                'slider_content_alignment',
                'slider_title_color',
                'slider_title_size',
                'slider_subtitle_color',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->string('slider_default_subtitle', 255)->default('EDUCACIÓN PROFESIONAL')->nullable()->after('slider_subtitle_color');
            $table->string('slider_default_title', 255)->default('Aprende habilidades técnicas con futuro')->nullable()->after('slider_default_subtitle');
            $table->string('slider_default_button_text', 100)->default('Matricularme Hoy')->nullable()->after('slider_default_title');
            $table->string('slider_default_button_url', 255)->default('/contacto')->nullable()->after('slider_default_button_text');
        });
    }

    public function down(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn([
                'slider_default_subtitle',
                'slider_default_title',
                'slider_default_button_text',
                'slider_default_button_url',
            ]);
        });
    }
};

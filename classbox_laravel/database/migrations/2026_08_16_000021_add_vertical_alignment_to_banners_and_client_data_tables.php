<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('content_vertical_alignment', 20)->default('center')->nullable()->after('content_alignment');
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->string('slider_content_vertical_alignment', 20)->default('center')->nullable()->after('slider_content_alignment');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('content_vertical_alignment');
        });

        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn('slider_content_vertical_alignment');
        });
    }
};

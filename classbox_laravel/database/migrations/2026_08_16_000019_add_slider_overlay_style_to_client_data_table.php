<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->string('slider_overlay_style', 50)->default('bottom_gradient')->nullable()->after('card_border_color');
        });
    }

    public function down(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn('slider_overlay_style');
        });
    }
};

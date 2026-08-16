<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->string('primary_color', 20)->default('#06BBCC')->nullable()->after('maintenance_bypass_key');
            $table->string('secondary_color', 20)->default('#181d38')->nullable()->after('primary_color');
            $table->string('topbar_bg_color', 20)->default('#181d38')->nullable()->after('secondary_color');
            $table->string('topbar_text_color', 20)->default('#ffffff')->nullable()->after('topbar_bg_color');
            $table->string('navbar_bg_color', 20)->default('#ffffff')->nullable()->after('topbar_text_color');
            $table->string('navbar_text_color', 20)->default('#181d38')->nullable()->after('navbar_bg_color');
            $table->string('footer_bg_color', 20)->default('#181d38')->nullable()->after('navbar_text_color');
            $table->string('footer_text_color', 20)->default('#ffffff')->nullable()->after('footer_bg_color');
            $table->string('card_bg_color', 20)->default('#f8fafc')->nullable()->after('footer_text_color');
            $table->string('card_border_color', 20)->default('#e2e8f0')->nullable()->after('card_bg_color');
        });
    }

    public function down(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color',
                'secondary_color',
                'topbar_bg_color',
                'topbar_text_color',
                'navbar_bg_color',
                'navbar_text_color',
                'footer_bg_color',
                'footer_text_color',
                'card_bg_color',
                'card_border_color',
            ]);
        });
    }
};

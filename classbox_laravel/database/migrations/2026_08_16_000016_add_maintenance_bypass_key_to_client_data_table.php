<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->string('maintenance_bypass_key', 50)->default('cefi2026')->nullable()->after('maintenance_message');
        });
    }

    public function down(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn('maintenance_bypass_key');
        });
    }
};

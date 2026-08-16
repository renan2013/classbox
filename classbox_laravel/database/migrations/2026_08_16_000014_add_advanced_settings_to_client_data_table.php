<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->string('favicon_path')->nullable()->after('logo_path');
            $table->string('logo_dark_path')->nullable()->after('favicon_path');
            $table->string('website_url')->nullable()->after('company_name');
            $table->string('schedule_info')->nullable()->after('address');
            $table->string('meta_title')->nullable()->after('linkedin_url');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('google_analytics_id', 50)->nullable()->after('meta_keywords');
            $table->string('meta_pixel_id', 50)->nullable()->after('google_analytics_id');
            $table->text('custom_head_scripts')->nullable()->after('meta_pixel_id');
            $table->text('custom_body_scripts')->nullable()->after('custom_head_scripts');
            $table->boolean('maintenance_mode')->default(false)->after('custom_body_scripts');
            $table->text('maintenance_message')->nullable()->after('maintenance_mode');
        });
    }

    public function down(): void
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn([
                'favicon_path',
                'logo_dark_path',
                'website_url',
                'schedule_info',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'google_analytics_id',
                'meta_pixel_id',
                'custom_head_scripts',
                'custom_body_scripts',
                'maintenance_mode',
                'maintenance_message',
            ]);
        });
    }
};

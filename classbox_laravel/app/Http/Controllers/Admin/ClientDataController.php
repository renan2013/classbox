<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientData;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientDataController extends Controller
{
    public function index()
    {
        $client_data = ClientData::firstOrCreate(['id' => 1]);
        return view('admin.client_data.index', compact('client_data'));
    }

    public function update(Request $request)
    {
        $client_data = ClientData::firstOrCreate(['id' => 1]);

        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'website_url' => 'nullable|string|max:255',
            'whatsapp_country_code' => 'nullable|string|max:10',
            'whatsapp_number' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'schedule_info' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|string',
            'facebook_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'youtube_url' => 'nullable|string',
            'tiktok_url' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_analytics_id' => 'nullable|string|max:50',
            'meta_pixel_id' => 'nullable|string|max:50',
            'custom_head_scripts' => 'nullable|string',
            'custom_body_scripts' => 'nullable|string',
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
            'maintenance_bypass_key' => 'nullable|string|max:50',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'topbar_bg_color' => 'nullable|string|max:20',
            'topbar_text_color' => 'nullable|string|max:20',
            'navbar_bg_color' => 'nullable|string|max:20',
            'navbar_text_color' => 'nullable|string|max:20',
            'footer_bg_color' => 'nullable|string|max:20',
            'footer_text_color' => 'nullable|string|max:20',
            'card_bg_color' => 'nullable|string|max:20',
            'card_border_color' => 'nullable|string|max:20',
            'slider_overlay_style' => 'nullable|string|max:50',
            'slider_content_alignment' => 'nullable|string|max:20',
            'slider_content_vertical_alignment' => 'nullable|string|max:20',
            'slider_title_color' => 'nullable|string|max:20',
            'slider_title_size' => 'nullable|string|max:20',
            'slider_subtitle_color' => 'nullable|string|max:20',
            'slider_default_subtitle' => 'nullable|string|max:255',
            'slider_default_title' => 'nullable|string|max:255',
            'slider_default_button_text' => 'nullable|string|max:100',
            'slider_default_button_url' => 'nullable|string|max:255',
            'slider_title_weight' => 'nullable|string|max:20',
            'slider_font_family' => 'nullable|string|max:30',
            'slider_button_style' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:10240',
            'favicon' => 'nullable|mimes:ico,png,svg,jpg,jpeg,webp|max:5120',
            'logo_dark' => 'nullable|image|max:10240',
        ]);

        $data = $request->except(['logo', 'favicon', 'logo_dark']);
        $data['maintenance_mode'] = $request->boolean('maintenance_mode') ? 1 : 0;
        $data['slider_show_subtitle'] = $request->boolean('slider_show_subtitle') ? 1 : 0;
        $data['slider_show_title'] = $request->boolean('slider_show_title') ? 1 : 0;
        $data['slider_show_button'] = $request->boolean('slider_show_button') ? 1 : 0;

        // 1. Logo principal
        if ($request->hasFile('logo')) {
            if ($client_data->logo_path && Storage::disk('public')->exists($client_data->logo_path)) {
                Storage::disk('public')->delete($client_data->logo_path);
            }
            $data['logo_path'] = ImageService::optimizeAndStore($request->file('logo'), 'client_data', 600, 85);
        }

        // 2. Favicon
        if ($request->hasFile('favicon')) {
            if ($client_data->favicon_path && Storage::disk('public')->exists($client_data->favicon_path)) {
                Storage::disk('public')->delete($client_data->favicon_path);
            }
            $file = $request->file('favicon');
            $data['favicon_path'] = $file->storeAs('client_data', 'favicon.' . $file->getClientOriginalExtension(), 'public');
        }

        // 3. Logo versión oscura
        if ($request->hasFile('logo_dark')) {
            if ($client_data->logo_dark_path && Storage::disk('public')->exists($client_data->logo_dark_path)) {
                Storage::disk('public')->delete($client_data->logo_dark_path);
            }
            $data['logo_dark_path'] = ImageService::optimizeAndStore($request->file('logo_dark'), 'client_data', 600, 85);
        }

        $client_data->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Configuración general, SEO y datos corporativos guardados exitosamente.'
            ]);
        }

        return back()->with('success', 'Configuración general, SEO, scripts y datos corporativos actualizados exitosamente.');
    }
}

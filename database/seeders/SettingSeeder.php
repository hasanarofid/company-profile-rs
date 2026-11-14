<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'RSU Medika Nusantara', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Layanan Kesehatan Terpadu & Berstandar Internasional', 'type' => 'text'],
            ['key' => 'site_description', 'value' => 'Rumah Sakit Umum Medika Nusantara menghadirkan layanan kesehatan holistik dengan dokter spesialis berpengalaman, teknologi medis modern, serta pelayanan 24 jam penuh empati.', 'type' => 'textarea'],
            ['key' => 'site_logo', 'value' => null, 'type' => 'image'],
            ['key' => 'whatsapp_number', 'value' => '6281234567890', 'type' => 'text'],
            ['key' => 'emergency_phone', 'value' => '(021) 500-911', 'type' => 'text'],
            ['key' => 'phone', 'value' => '(021) 555-0199', 'type' => 'text'],
            ['key' => 'email', 'value' => 'info@medikanusantara.id', 'type' => 'text'],
            ['key' => 'address', 'value' => 'Jl. Kesehatan Raya No. 88, Kebayoran Baru, Jakarta Selatan 12120', 'type' => 'textarea'],
            ['key' => 'maps_url', 'value' => 'https://maps.google.com/?q=Jakarta+Selatan', 'type' => 'url'],
            ['key' => 'working_hours', 'value' => 'IGD & Farmasi 24 Jam | Poliklinik: Senin - Sabtu 07.00 - 21.00 WIB', 'type' => 'text'],
            ['key' => 'playstore_link', 'value' => 'https://demo.hasanarofid.site/', 'type' => 'url'],

            // Theme Customizer Colors (Hex)
            ['key' => 'theme_primary', 'value' => '#0D6E6E', 'type' => 'color'],
            ['key' => 'theme_dark', 'value' => '#0A3D4A', 'type' => 'color'],
            ['key' => 'theme_deep', 'value' => '#062832', 'type' => 'color'],
            ['key' => 'theme_cream', 'value' => '#F5F9F9', 'type' => 'color'],
            ['key' => 'theme_sand', 'value' => '#E6F2F2', 'type' => 'color'],
            ['key' => 'theme_gold', 'value' => '#D97706', 'type' => 'color'],
            ['key' => 'show_emergency_bar', 'value' => '1', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}

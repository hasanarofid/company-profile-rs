<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $siteSettings = [];
        try {
            $raw = Setting::pluck('value', 'key')->toArray();
            $siteLogo = $raw['site_logo'] ?? null;
            $logoUrl = null;
            if ($siteLogo) {
                $logoUrl = str_starts_with($siteLogo, 'http') || str_starts_with($siteLogo, '/')
                    ? $siteLogo
                    : asset('storage/' . $siteLogo);
            }

            $siteSettings = [
                'site_name' => $raw['site_name'] ?? 'RSU Medika Nusantara',
                'site_tagline' => $raw['site_tagline'] ?? 'Layanan Kesehatan Terpadu & Berstandar Internasional',
                'site_description' => $raw['site_description'] ?? '',
                'site_logo_url' => $logoUrl,
                'whatsapp_number' => $raw['whatsapp_number'] ?? '6281234567890',
                'emergency_phone' => $raw['emergency_phone'] ?? '(021) 500-911',
                'phone' => $raw['phone'] ?? '(021) 555-0199',
                'email' => $raw['email'] ?? 'info@medikanusantara.id',
                'address' => $raw['address'] ?? 'Jl. Kesehatan Raya No. 88, Jakarta Selatan',
                'maps_url' => $raw['maps_url'] ?? 'https://maps.google.com',
                'working_hours' => $raw['working_hours'] ?? 'IGD 24 Jam | Poli: Senin - Sabtu 07.00 - 21.00',
                'theme_primary' => $raw['theme_primary'] ?? '#0D6E6E',
                'theme_dark' => $raw['theme_dark'] ?? '#0A3D4A',
                'theme_deep' => $raw['theme_deep'] ?? '#062832',
                'theme_cream' => $raw['theme_cream'] ?? '#F5F9F9',
                'theme_sand' => $raw['theme_sand'] ?? '#E6F2F2',
                'theme_gold' => $raw['theme_gold'] ?? '#D97706',
                'show_emergency_bar' => ($raw['show_emergency_bar'] ?? '1') === '1',
            ];
        } catch (\Throwable $e) {
            // Fallback before migrations run
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'siteSettings' => $siteSettings,
        ];
    }
}

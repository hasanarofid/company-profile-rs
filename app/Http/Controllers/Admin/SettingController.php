<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function index(): Response
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $logo = $settings['site_logo'] ?? null;
        $settings['site_logo_url'] = $logo
            ? (str_starts_with($logo, '/') || str_starts_with($logo, 'http') ? $logo : asset('storage/' . $logo))
            : null;

        return Inertia::render('Admin/Settings', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'nullable|string|max:200',
            'site_description' => 'nullable|string|max:500',
            'whatsapp_number' => 'nullable|string|max:30',
            'emergency_phone' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:120',
            'address' => 'nullable|string|max:500',
            'maps_url' => 'nullable|string|max:255',
            'working_hours' => 'nullable|string|max:255',
            'playstore_link' => 'nullable|string|max:255',
            'theme_primary' => 'nullable|string|max:20',
            'theme_dark' => 'nullable|string|max:20',
            'theme_deep' => 'nullable|string|max:20',
            'theme_cream' => 'nullable|string|max:20',
            'theme_sand' => 'nullable|string|max:20',
            'theme_gold' => 'nullable|string|max:20',
            'show_emergency_bar' => 'nullable|boolean',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('site_logo')) {
            $dir = public_path('uploads/logo');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $request->file('site_logo');
            $filename = 'hospital-logo-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            Setting::setValue('site_logo', '/uploads/logo/' . $filename, 'image');
        }

        $textKeys = [
            'site_name' => 'text',
            'site_tagline' => 'text',
            'site_description' => 'textarea',
            'whatsapp_number' => 'text',
            'emergency_phone' => 'text',
            'phone' => 'text',
            'email' => 'text',
            'address' => 'textarea',
            'maps_url' => 'url',
            'working_hours' => 'text',
            'playstore_link' => 'url',
            'theme_primary' => 'color',
            'theme_dark' => 'color',
            'theme_deep' => 'color',
            'theme_cream' => 'color',
            'theme_sand' => 'color',
            'theme_gold' => 'color',
        ];

        foreach ($textKeys as $key => $type) {
            if (array_key_exists($key, $validated)) {
                Setting::setValue($key, $validated[$key] ?? '', $type);
            }
        }

        Setting::setValue('show_emergency_bar', $request->boolean('show_emergency_bar') ? '1' : '0', 'boolean');

        return redirect()->back()->with('success', 'Pengaturan rumah sakit & tema visual berhasil diperbarui.');
    }
}

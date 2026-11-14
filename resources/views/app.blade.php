<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'RSU Medika Nusantara') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300..800;1,9..40,400..700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

        @php
            $hexToRgb = function (?string $hex, string $fallback): string {
                $hex = ltrim((string) $hex, '#');
                if (strlen($hex) === 3) {
                    $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
                }
                if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
                    return $fallback;
                }
                return hexdec(substr($hex, 0, 2)).' '.hexdec(substr($hex, 2, 2)).' '.hexdec(substr($hex, 4, 2));
            };

            try {
                $themeSettings = \App\Models\Setting::whereIn('key', [
                    'theme_primary', 'theme_dark', 'theme_deep', 'theme_cream', 'theme_sand', 'theme_gold'
                ])->pluck('value', 'key');
            } catch (\Throwable $e) {
                $themeSettings = collect();
            }
        @endphp

        <style id="dynamic-theme-vars">
            :root {
                --brand-primary: {{ $hexToRgb($themeSettings['theme_primary'] ?? null, '13 110 110') }};
                --brand-dark: {{ $hexToRgb($themeSettings['theme_dark'] ?? null, '10 61 74') }};
                --brand-deep: {{ $hexToRgb($themeSettings['theme_deep'] ?? null, '6 40 50') }};
                --brand-cream: {{ $hexToRgb($themeSettings['theme_cream'] ?? null, '245 249 249') }};
                --brand-sand: {{ $hexToRgb($themeSettings['theme_sand'] ?? null, '230 242 242') }};
                --brand-gold: {{ $hexToRgb($themeSettings['theme_gold'] ?? null, '217 119 6') }};
            }
        </style>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    cream: 'rgb(var(--brand-cream) / <alpha-value>)',
                    sand: 'rgb(var(--brand-sand) / <alpha-value>)',
                    blush: 'rgb(var(--brand-blush) / <alpha-value>)',
                    dark: 'rgb(var(--brand-dark) / <alpha-value>)',
                    deep: 'rgb(var(--brand-deep) / <alpha-value>)',
                    primary: 'rgb(var(--brand-primary) / <alpha-value>)',
                    light: 'rgb(var(--brand-light) / <alpha-value>)',
                    leaf: 'rgb(var(--brand-leaf) / <alpha-value>)',
                    gold: 'rgb(var(--brand-gold) / <alpha-value>)',
                    cta: 'rgb(var(--brand-primary) / <alpha-value>)',
                    ctaHover: 'rgb(var(--brand-dark) / <alpha-value>)',
                },
            },
            fontFamily: {
                serif: ['"Plus Jakarta Sans"', '"DM Sans"', ...defaultTheme.fontFamily.sans],
                sans: ['"Plus Jakarta Sans"', '"DM Sans"', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'fashion': '0 20px 45px -15px rgba(10, 61, 74, 0.08)',
                'card-hover': '0 25px 50px -12px rgba(10, 61, 74, 0.14)',
                'cta-glow': '0 10px 30px -5px rgba(13, 110, 110, 0.35)',
            },
        },
    },

    plugins: [forms],
};

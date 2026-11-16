import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                // Buy Property Nairobi brand palette
                'emerald':       '#004536',
                'emerald-dark':  '#003528',
                'emerald-light': '#005a45',
                'gold':          '#c5a05a',
                'gold-dark':     '#a9772e',
                'gold-light':    '#d9ab59',
                'cream':         '#faf9f6',
                'cream-warm':    '#fbfaf8',
                'ink':           '#13243b',
                'ink-soft':      '#21314a',
                'muted':         '#647080',
                'border-soft':   '#ece9e3',
            },
            fontFamily: {
                sans: ['Arial', 'Helvetica', ...defaultTheme.fontFamily.sans],
                serif: ['Georgia', 'serif'],
            },
        },
    },
    plugins: [forms],
};
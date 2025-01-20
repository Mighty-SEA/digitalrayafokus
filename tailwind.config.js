import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Open Sans', 'sans-serif'],
            },
            colors: {
                'biru': '#4F98CA',
                'mint': '#00FFCA',
                'head': '#088395',
                'foot': '#0A4D68',
                green: {
                    500: '#22c55e',
                },
            },
            transitionDuration: {
                '300': '300ms',
                '500': '500ms',
            },
        },
    },
    plugins: [],
};

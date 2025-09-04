import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php', // <-- BARIS INI PALING PENTING
    ],

    theme: {
        extend: {},
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
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
        colors: {
            brand: {
                light: '#2D47EBE6',
                DEFAULT: '#2D47EB',
            },
            black: '#171A1F',
            midBlack: '#21252A',
            white: '#FFFFFF',
            transparent: 'rgba(255, 255, 255, 0)', // Definir tu color aquí

        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};

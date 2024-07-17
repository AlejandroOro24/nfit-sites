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
            transparent: 'rgba(255, 255, 255, 0)',
            nfit: {
                DEFAULT: '#01FFC2',
                light: '#01FFC240',
                disabled: '#01FFC280'
            },
            gray: '#1f2937',
            caution:{
                DEFAULT: '#EC0B43',
                light: '#EC0B4340',
                disabled: '#EC0B4380'
            },
        },
        extend: {
            fontSize: {
                "1.5xl": "22px",
                "2.5xl": "26px",
                "3.5xl": "34px",
              },
            fontFamily: {
                sans: [
                    '"Inter", sans-serif'
                  ]            },
            screens: {
                '1.5xl': '1440px',
                '3xl': '1680px',
                '4xl': '1920px',
                '5xl': '2240px',
              },
              maxWidth: {
                '8xl': '88rem',
                '9xl': '96rem',
              }
        },
    },

    plugins: [forms],
};

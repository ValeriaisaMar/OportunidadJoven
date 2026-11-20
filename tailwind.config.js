import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Colores del diseño de Figma
            colors: {
                oj: {
                    primary: '#10375d',
                    accent: '#05647a',
                    secondary: '#6db8bb',
                    muted: '#869684',
                    bg: '#e0e2d5',
                },
            },
            // Escala de bordes del diseño de Figma (--radius: 0.625rem)
            borderRadius: {
                sm: '6px',
                md: '8px',
                lg: '10px',
                xl: '14px',
            },
        },
    },

    plugins: [forms],
};

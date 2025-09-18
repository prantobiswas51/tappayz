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
                'sans': ['ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji'],
            },
            colors: {
                'bg': '#dadada',
                'bg-elev': '#111831',
                'panel': '#151e3d',
                'muted': '#8b93a7',
                'text': '#e7ecf7',
                'brand': '#6ee7ff',
                'brand-strong': '#3dd0ff',
                'accent': '#9b8cff',
                'danger': '#ff6b6b',
                'success': '#2ee6a8',
                'warning': '#ffd166',
                'border': 'rgba(255,255,255,0.08)',
            },
            boxShadow: {
                'custom': '0 6px 20px rgba(0,0,0,0.35)',
                'card': '0 6px 20px rgba(0,0,0,0.35)',
                'brand': '0 4px 12px rgba(61,208,255,0.3)',
                'brand-hover': '0 6px 16px rgba(61,208,255,0.4)',
                'danger': '0 8px 24px rgba(255,107,107,0.3)',
            },
            borderRadius: {
                'custom': '12px',
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
            },
            animation: {
                'float': 'float 6s ease-in-out infinite alternate',
                'pulse-ring': 'pulse-ring 2.4s ease-out infinite',
                'slide': 'slide 1.3s linear infinite',
                'fill': 'fill 2.2s ease-in-out infinite alternate',
            },
            keyframes: {
                'float': {
                    '0%': { transform: 'translateY(0) rotate(-1.2deg)' },
                    '50%': { transform: 'translateY(-8px) rotate(0deg)' },
                    '100%': { transform: 'translateY(-16px) rotate(1.2deg)' },
                },
                'pulse-ring': {
                    '0%': { transform: 'scale(0.4)', opacity: '0.8' },
                    '100%': { transform: 'scale(2.2)', opacity: '0' },
                },
                'slide': {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(100%)' },
                },
                'fill': {
                    'from': { width: '30%' },
                    'to': { width: '90%' },
                },
            }
        },
    },

    plugins: [forms],
};

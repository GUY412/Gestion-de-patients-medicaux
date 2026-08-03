import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                background: 'rgb(var(--c-background) / <alpha-value>)',
                foreground: 'rgb(var(--c-foreground) / <alpha-value>)',
                card: 'rgb(var(--c-card) / <alpha-value>)',
                border: 'rgb(var(--c-border) / <alpha-value>)',
                ring: 'rgb(var(--c-ring) / <alpha-value>)',
                primary: {
                    DEFAULT: 'rgb(var(--c-primary) / <alpha-value>)',
                    foreground: 'rgb(var(--c-primary-foreground) / <alpha-value>)',
                },
                secondary: {
                    DEFAULT: 'rgb(var(--c-secondary) / <alpha-value>)',
                    foreground: 'rgb(var(--c-secondary-foreground) / <alpha-value>)',
                },
                accent: {
                    DEFAULT: 'rgb(var(--c-accent) / <alpha-value>)',
                    foreground: 'rgb(var(--c-accent-foreground) / <alpha-value>)',
                },
                destructive: {
                    DEFAULT: 'rgb(var(--c-destructive) / <alpha-value>)',
                    foreground: 'rgb(var(--c-destructive-foreground) / <alpha-value>)',
                },
                muted: {
                    DEFAULT: 'rgb(var(--c-secondary) / <alpha-value>)',
                    foreground: 'rgb(var(--c-muted-foreground) / <alpha-value>)',
                },
            },
            fontFamily: {
                display: ['Fraunces', 'ui-serif', 'serif'],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
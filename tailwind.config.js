import defaultTheme from 'tailwindcss/defaultTheme';
import flowbite from 'flowbite/plugin';

/*
 * Design tokens for the shop. Pages use these names (ink-*, accent-*,
 * rounded-card, shadow-card, font-display) instead of raw Tailwind colours.
 *
 * ink    graphite neutrals: text, surfaces, dark header and hero
 * accent brake-caliper orange: calls to action, focus rings, highlights.
 *        Text on accent-500 is ink-950 (white on it fails contrast).
 */
const accent = {
    50: '#fff6ed',
    100: '#ffead4',
    200: '#ffd1a8',
    300: '#ffb070',
    400: '#ff8a3d',
    500: '#ff6b1a',
    600: '#e85410',
    700: '#c0400e',
    800: '#993414',
    900: '#7c2d14',
    950: '#431308',
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './public/js/app.js',
    ],
    theme: {
        extend: {
            colors: {
                ink: {
                    50: '#f6f7f8',
                    100: '#eceef1',
                    200: '#d9dde2',
                    300: '#b8bfc8',
                    400: '#8b95a1',
                    500: '#66707c',
                    600: '#4d5560',
                    700: '#3a4049',
                    800: '#272b31',
                    900: '#1b1e22',
                    950: '#111316',
                },
                accent,
                // Flowbite's form styles read "primary".
                primary: accent,
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Barlow Semi Condensed"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                control: '0.5rem',
                card: '0.875rem',
            },
            boxShadow: {
                card: '0 1px 2px rgb(17 19 22 / 0.06), 0 1px 3px rgb(17 19 22 / 0.08)',
                'card-hover': '0 4px 8px rgb(17 19 22 / 0.06), 0 12px 24px -6px rgb(17 19 22 / 0.14)',
                panel: '0 24px 48px -12px rgb(17 19 22 / 0.35)',
            },
            flex: {
                100: '0 0 100%', // carousel slides
            },
        },
    },
    plugins: [flowbite],
};

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/themes/jisedai/jiken-web_202404/style.css',
                'resources/themes/jisedai/jiken-web_202404/common/js/modernizr.js',
                'resources/themes/jisedai/css/custom.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});

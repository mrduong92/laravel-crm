import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'themes/jisedai/jiken-web_202404/style.css',
                'themes/jisedai/jiken-web_202404/common/js/modernizr.js',
                'resources/themes/jisedai/css/custom.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});

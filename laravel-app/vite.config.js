import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/assets/vendor/fonts/remixicon/remixicon.css',
                'resources/assets/vendor/js/bootstrap.js'
            ],
            refresh: true,
        }),
    ],
});

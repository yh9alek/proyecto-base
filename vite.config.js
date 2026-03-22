import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'fast-glob';

const pages = glob.sync('resources/assets/js/pages/**/*.js', {
    cwd: process.cwd(),
});

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/app.css',
                'resources/assets/js/app.js',
                ...pages,
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: '192.168.1.38', // tu IP local
        },
    },
});

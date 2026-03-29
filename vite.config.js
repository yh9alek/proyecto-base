import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'fast-glob';

const pages = glob.sync('resources/views/js/**/*.js', {
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
            host: '192.168.1.14', //IP local para exponer en la red
        },
    },
});

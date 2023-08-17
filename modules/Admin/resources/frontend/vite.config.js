import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['src/js/app.ts', 'src/js/map.ts', 'src/css/app.css'],
            publicDirectory: '.',
            refresh: false,
        }),
    ],
});
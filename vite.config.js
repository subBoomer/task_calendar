import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { createVuePlugin } from 'vite-plugin-vue2'; // Import Vue 2 plugin
import { viteCommonjs } from '@originjs/vite-plugin-commonjs';

export default defineConfig({
    plugins: [
        viteCommonjs(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        createVuePlugin(), // Use Vue 2 plugin instead of Vue 3 plugin
    ],
});

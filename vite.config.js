import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    // Ye block add karna hai warnings chup karane ke liye
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['import', 'global-builtin'],
                quietDeps: true,
            },
        },
    },
});

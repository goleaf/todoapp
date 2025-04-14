import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/accessibility.css',
                'resources/js/accessibility.js',
                'resources/css/animations.css'
            ],
            refresh: [`resources/views/**/*`],
        }),
    ],
    server: {
        cors: true,
    },
});
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
import basicSsl from '@vitejs/plugin-basic-ssl'
export default defineConfig({

    plugins: [
        basicSsl(),

        laravel({
            input: [
                'node_modules/flowbite/dist/flowbite.js',
                'resources/js/app.js',

            ],

            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});

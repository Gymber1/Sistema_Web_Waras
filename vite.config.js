import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/biblioteca.css',
                'resources/css/biblioteca-libro.css',
                'resources/css/biblioteca-revista.css',
                'resources/css/biblioteca-autor.css',
                'resources/css/biblioteca-editorial.css',
                'resources/css/biblioteca-especial.css',
                'resources/css/fototeca.css',
                'resources/css/fototeca-foto.css',
                'resources/css/fototeca-fotografo.css',
                'resources/css/fototeca-donador.css',
                'resources/css/fototeca-especial.css',
                'resources/css/login.css',
                'resources/css/admin.css',
                'resources/css/contacto.css',
                'resources/css/nosotros.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/tailwind.css",
                "resources/css/app.css",
                "resources/js/app.js",
                "node_modules/@fortawesome/fontawesome-free/css/fontawesome.css",
                "node_modules/@fortawesome/fontawesome-free/css/solid.css",
            ],
            refresh: true,
        }),
    ],
});

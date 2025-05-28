import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcssPostcssPlugin from "@tailwindcss/postcss";
import autoprefixer from "autoprefixer";

export default defineConfig({
    publicDir: "public",
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [tailwindcssPostcssPlugin, autoprefixer],
        },
    },
});

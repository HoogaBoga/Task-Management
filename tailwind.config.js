// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // Make sure these paths correctly point to all your template files
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        // Add any other paths where you use Tailwind classes
    ],
    theme: {
        extend: {
            colors: {
                "logo-bg": "#your_logo_bg_color", // If logo has a specific bg
                "pastel-blue-dark": "#627C97", // Eyedropper these colors from the image
                "pastel-lavender": "#D7D8F3",
                "pastel-blue-medium": "#8AA3B9",
                "pastel-pink": "#EFC1D2",
                "pastel-blue-light": "#A9C4D4",
                "pastel-coral": "#F3A6A2",
                "brand-blue": "#4A90E2", // For the Sign Up button
                "body-bg": "#E9F7F8",
            },

            borderRadius: {
                "4xl": "2rem",
                "5xl": "2.5rem",
                "6xl": "3rem",
            },

            fontFamily: {
                // This sets 'Instrument Sans' as your default sans-serif font
                // You can then use `font-sans` class in your HTML
                sans: [
                    '"Instrument Sans"', // Font name from Google Fonts
                    "ui-sans-serif", // Tailwind's default sans-serif stack
                    "system-ui",
                    "-apple-system",
                    "BlinkMacSystemFont",
                    '"Segoe UI"',
                    "Roboto",
                    '"Helvetica Neue"',
                    "Arial",
                    '"Noto Sans"',
                    "sans-serif",
                    '"Apple Color Emoji"',
                    '"Segoe UI Emoji"',
                    '"Segoe UI Symbol"',
                    '"Noto Color Emoji"',
                ],
                // This allows you to use `font-krona` class
                krona: ['"Krona One"', "sans-serif"], // Fallback to a generic sans-serif
                // This allows you to use `font-inter` class
                inter: ['"Inter"', "sans-serif"], // Fallback to a generic sans-serif
            },
        },
    },
    plugins: [],
};

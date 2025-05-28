// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
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
        },
    },
    plugins: [],
};

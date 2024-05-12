/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        // extend: {},
        fontFamily: {
            sans: ["Rubik", "sans-serif"],
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography')
    ],
}


const defaultTheme = require("tailwindcss/defaultTheme");
const forms = require("@tailwindcss/forms");
const rtl = require("tailwindcss-rtl");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Tajawal", ...defaultTheme.fontFamily.sans],
            },

            keyframes: {
                shake: {
                    "0%, 100%": { transform: "translateX(0)" },
                    "20%": { transform: "translateX(-4px)" },
                    "40%": { transform: "translateX(4px)" },
                    "60%": { transform: "translateX(-4px)" },
                    "80%": { transform: "translateX(4px)" },
                },
            },

            animation: {
                shake: "shake 0.4s ease-in-out",
            },
        },
    },

    plugins: [forms, rtl],
};

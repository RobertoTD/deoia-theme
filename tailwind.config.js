/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.{php,html,js}",
    "./template-parts/*.{php,html,js}",
    "./assets/js/**/*.js",
  ],
  safelist: [
    // Clases dinámicas para validaciones del widget premium
    "ring-2",
    "ring-amber-400",
    "border-amber-400",
    "text-amber-400",
    "bg-amber-500/20",
    "border-amber-500/50",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};

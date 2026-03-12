/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'void-bg': '#050505',
                'void-card': '#121212',
                'void-red': '#ff003c',
                'void-green': '#00ff41',
            },
            fontFamily: {
                'mono': ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace'],
            }
        },
    },
    plugins: [],
}
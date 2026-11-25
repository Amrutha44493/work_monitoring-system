import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './resources/views/**/*.blade.php',
    ],
    safelist: [
        'bg-yellow-100', 'text-yellow-700',
        'bg-blue-100',   'text-blue-700',
        'bg-green-100',  'text-green-700',
        'bg-red-100',    'text-red-700',
        'bg-orange-100', 'text-orange-700',
        'bg-gray-100',   'text-gray-700',
        'bg-teal-100',   'text-teal-700',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
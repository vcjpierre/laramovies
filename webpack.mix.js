const mix = require('laravel-mix');
require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css')
    .options({
        postCss: [require('tailwindcss')]
    })
    .purgeCss();
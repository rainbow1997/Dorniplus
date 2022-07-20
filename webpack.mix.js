const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
// mix.js('node_modules/persian-datepicker/dist/js/persian-datepicker.js','public/js');
//mix.js('node_modules/persian-date/dist/persian-date.js','public/js');
mix.postCss('node_modules/persian-datepicker/dist/css/persian-datepicker.min.css','public/css');
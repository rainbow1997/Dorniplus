
module.exports = {
    //...
    experiments: {
        asyncWebAssembly: true,
        buildHttp: true,
        layers: true,
        lazyCompilation: true,
        outputModule: true,
        syncWebAssembly: true,
        topLevelAwait: true,
    },
};

const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [require('tailwindcss'), require('autoprefixer')])
    .alias({
        '@': 'resources/js',
    });
mix.js('node_modules/flowbite/dist/flowbite.js','public/js');

// mix.copyDirectory('./vendor/tinymce/tinymce', 'public/js/tinymce');
if (mix.inProduction()) {
    mix.version();
}



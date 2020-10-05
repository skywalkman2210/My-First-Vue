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
    .postCss('resources/css/app.css', 'public/css', [
        
    ]);

mix.copy('resources/js/modal.vue','public/js/modal.vue');

mix.webpackConfig({
    resolve: {
        alias: {
            'vue$': '/node_modules/vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
        }
    }
});
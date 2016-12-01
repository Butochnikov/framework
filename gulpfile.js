const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix
        .less('framework.less', 'public/admin-lte/framework.css')
        .webpack('framework.js', 'public/admin-lte/framework.js')
        .copy('resources/assets/images', 'public/admin-lte/images')
        .copy('node_modules/bootstrap/fonts', 'public/admin-lte/fonts')
        .copy('node_modules/font-awesome/fonts', 'public/admin-lte/fonts')
        .copy('node_modules/open-sans-all/fonts', 'public/admin-lte/fonts');
});

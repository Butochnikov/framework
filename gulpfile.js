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
        .webpack('framework.js', 'public/admin-lte/framework.js', false, {
            resolve: {
                // add alias for application code directory
                alias: {
                    jquery: path.resolve(__dirname, './node_modules/jquery/dist/jquery'),
                    moment: path.resolve(__dirname, './node_modules/moment/moment')
                }
            }
        })
});

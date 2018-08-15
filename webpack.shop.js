let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 | 参考网址：https://segmentfault.com/a/1190000010437630
 */

mix.js('resources/assets/js/shop.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/shop.scss', 'public/css');

if (mix.inProduction()) { //生产环境加版本号
    mix.version();
}
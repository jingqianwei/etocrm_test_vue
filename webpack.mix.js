let mix = require('laravel-mix');

if (process.env.MIX_SENTRY_DSN_PUBLIC == 'shop') {
    require(`${__dirname}\\webpack.shop.js`);
    return;
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 | 参考网址：https://segmentfault.com/a/1190000010437630
 | https://blog.csdn.net/a0405221/article/details/79608711
 | https://blog.csdn.net/daily886/article/details/81316866
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/vue.scss', 'public/css');

if (mix.inProduction()) { //生产环境加版本号
    mix.version();
}
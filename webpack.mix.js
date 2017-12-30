let mix = require('laravel-mix');

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

mix.setPublicPath('public_html/')
	.autoload({jquery: ['$', 'window.jQuery', 'jQuery']})
	.react('resources/assets/js/app.jsx', 'public_html/js')
	.sass('resources/assets/sass/app.scss', 'public_html/css')
	.sass('resources/assets/sass/exchange.scss', 'public_html/css')
	.extract(['react', 'react-dom'])
	.sourceMaps();

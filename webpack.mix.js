/* eslint-disable import/no-extraneous-dependencies */
const mix = require('laravel-mix');
const tailwindCss = require('tailwindcss');

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

mix.js('resources/assets/js/app.js', 'public/js').vue();
mix.js('resources/assets/js/scripts/script.js', 'public/js');

mix
  .sass('resources/assets/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwindCss('tailwind.config.js')],
  })
  .version();

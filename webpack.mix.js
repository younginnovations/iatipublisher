/* eslint-disable import/no-extraneous-dependencies */
const mix = require('laravel-mix');
require('laravel-mix-svg-vue');
const tailwindCss = require('tailwindcss');

if (mix.inProduction()) {
  mix.options({
    terser: {
      terserOptions: {
        compress: {
          drop_console: true,
        },
      },
    },
  });
} else {
  mix.webpackConfig({ devtool: 'inline-source-map' }).sourceMaps();
}

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

mix.ts('resources/assets/js/app.ts', 'public/js').vue();

mix.js('resources/assets/js/scripts/script.js', 'public/js');

mix
  .sass('resources/assets/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwindCss('tailwind.config.js')],
  })
  .svgVue({
    svgPath: 'resources/assets/images/svg',
  })
  .version();

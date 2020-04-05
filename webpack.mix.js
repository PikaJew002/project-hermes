const mix = require('laravel-mix');

mix.webpackConfig({
  resolve: {
    extensions: ['.js','.vue'],
    alias: {
      '@': __dirname + '/resources'
    }
  }
});

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
    .postCss('resources/css/app.css', 'public/css', [
      require('tailwindcss'),
      //  require('@fullhuman/postcss-purgecss')({
      //   content: [
      //     './resources/js/pages/*.vue',
      //     './resources/views/app.blade.php',
      //   ],
      //   defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g) || []
      // }),
    ]);

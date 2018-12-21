const mix = require('laravel-mix')

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

mix.webpackConfig({
  resolve: {
    alias: {
      '@api': path.resolve(__dirname, 'resources/js/api'),
      '@components': path.resolve(__dirname, 'resources/js/components'),
      '@utils': path.resolve(__dirname, 'resources/js/utils'),
      '@views': path.resolve(__dirname, 'resources/js/views')
    }
  }
})

mix.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css')

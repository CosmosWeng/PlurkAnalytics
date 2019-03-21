const path = require('path')
const mix = require('laravel-mix')

const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin')
const svgSourcePath = 'resources/js/icons/svg/*.svg'
const svgSpriteDestination = '/svg/sprite.svg'

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

mix.browserSync({
  host: '192.168.10.10',
  proxy: 'plurk.test',
  open: false
})

mix.options({
  extractVueStyles: true, //extractVueStyles:提取 .vue 組件樣式(CSS在<style>標籤內)到一個專用文件，而不是將其嵌入到HTML中。
  processCssUrls: true,
  uglify: {},
  purifyCss: false,
  //purifyCss: {},
  postCss: [require('autoprefixer')],
  clearConsole: true
})

mix.webpackConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js')
    }
  },
  module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  plugins: [
    // new SVGSpritemapPlugin(svgSourcePath, {
    //   output: {
    //     filename: svgSpriteDestination,
    //     svg4everybody: true,
    //     svgo: true
    //   }
    // })
  ]
})

mix.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css')

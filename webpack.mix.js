let mix = require('laravel-mix');

const MonacoWebpackPlugin = require('monaco-editor-webpack-plugin');














mix.js('resources/assets/js/games.js', 'public/js/games.js')
   .js('resources/assets/js/forum.js', 'public/js/forum.js')
   .js('resources/assets/js/ide.js', 'public/js/ide.js')
   .webpackConfig({
      output: {
         publicPath: "/"
      }
   })
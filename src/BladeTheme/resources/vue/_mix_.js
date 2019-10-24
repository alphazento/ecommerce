const mix = require('laravel-mix');
require('laravel-mix-alias');
require('laravel-mix-merge-manifest');

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
});
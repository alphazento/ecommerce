const mix = require('laravel-mix');
require('laravel-mix-alias');
require('laravel-mix-merge-manifest');

mix.webpackConfig({
  resolve: {
    alias: {
      '@node_modules': path.resolve('node_modules')
    }
  }
})

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
});
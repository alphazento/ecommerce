const mix = require('laravel-mix');
require('laravel-mix-alias');
require('laravel-mix-merge-manifest');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')

mix.options({
        postCss: [
            require('autoprefixer'),
        ],
    })
    .webpackConfig({
        resolve: {
            alias: {
                '@node_modules': path.resolve('node_modules')
            }
        }
    })

mix.babelConfig({
    plugins: ['@babel/plugin-syntax-dynamic-import'],
});


mix.alias('@node_modules', path.resolve('node_modules'));

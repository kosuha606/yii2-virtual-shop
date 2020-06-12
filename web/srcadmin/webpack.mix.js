const mix = require('laravel-mix');

// mix.config.fileLoaderDirs.fonts = 'private/dist/fonts';
const webpack = require('webpack');

mix.webpackConfig({
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ]
});

mix
    .setPublicPath('dist')
    .js('src/admin.js', '')
    .sass('src/css/admin.scss', '')
    .version()
    .sourceMaps()
;

const mix = require('laravel-mix');

// mix.config.fileLoaderDirs.fonts = 'private/dist/fonts';

mix
    .setPublicPath('dist')
    .js('src/admin.js', '')
    .js('src/css/admin.scss', '')
    .version()
;

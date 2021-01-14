const mix = require('laravel-mix');
require('laravel-mix-purgecss');

// mix.js('resources/js/app.js', 'public/js')
//     .extract(['vue'])
//     .sass('resources/sass/app.scss', 'public/css')
//     .version();

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/vue.js', 'public/js')
    .js('resources/js/app-with-vue.js', 'public/js')
    .js('resources/js/quill-script.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css').purgeCss().postCss('public/css/app.css','public/css');

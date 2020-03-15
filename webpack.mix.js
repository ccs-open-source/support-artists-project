const mix = require('laravel-mix');
const glob = require('glob');

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

let jsFiles = glob.sync('./resources/js/controllers/*.controller.js');

// If each file is its own entry file
jsFiles.forEach(filename => {
    mix.js(filename, 'public/js/controllers/');
});

mix
    .js('resources/js/app.js', 'public/js').extract()
    .sass('resources/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}

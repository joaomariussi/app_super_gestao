const mix = require('laravel-mix');
const glob = require('glob');

function mixAssetsDir(query, cb) {
    (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/');
        cb(f, f.replace('resources', 'public'));
    });
}

mix.copy('resources/css', 'public/css');

mix.copy('resources/js', 'public/js');

mix.copy('resources/img', 'public/img');

mix.copy('node_modules/jquery/dist/jquery.js', 'public/js/jquery.js');

mixAssetsDir('node_modules/bootstrap/dist/js/**/*.js', (src, dest) => mix.js(src, dest));
mixAssetsDir('node_modules/bootstrap/dist/css/**/*.css', (src, dest) => mix.css(src, dest));

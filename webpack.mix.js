const mix = require('laravel-mix');

const glob = require('glob')

function mixAssetsDir(query, cb) {
    (glob.sync('resources/' + query) || []).forEach(f => {
        f = f.replace(/[\\\/]+/g, '/');
        cb(f, f.replace('resources', 'public'));
    });
}
mixAssetsDir('js/**/*.js', (src, dest) => mix.js(src, dest));



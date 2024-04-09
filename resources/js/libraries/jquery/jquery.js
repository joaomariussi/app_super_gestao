import * as jQuery from 'jquery'

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}


export { jQuery }

'use strict';

// Uncomment to put into production mode
// Handles switch to production for React
//process.env.NODE_ENV = 'production';

// Global setting for gulp tasks to check against
global.isProd = false;

// Temporary overrides for dev mode
global.devOverrides = {
    autoprefixer: true
};

let fs    = require('fs');
let path  = require('path');
let gutil = require('gulp-util');

/**
 * Filters out non .js files.
 * Prevents accidental inclusion of possible hidden files and speeds up tasks
 *
 * @param name
 * @returns {boolean}
 */
function scriptFilter(name) {
    return /(\.(js)$)/i.test(path.extname(name));
}

const tasks = fs.readdirSync('./gulp/tasks/').filter(scriptFilter);

tasks.forEach(task => {
    gutil.log('Loading task ' + task);
    require('./tasks/' + task);
});
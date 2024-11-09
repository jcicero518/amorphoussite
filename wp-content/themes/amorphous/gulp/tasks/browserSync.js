'use strict';

let gulp        = require('gulp');
let browserSync = require('browser-sync').create();
let config      = require('../config');

gulp.task('browser-sync', function() {
    let files = [
        '**/*.php',
        '**/*.html',
        '**/*.js',
        '**/*.css',
        '**/*.{png,jpg,gif}'
    ];

    browserSync.init(files, {
        proxy: config.proxy, // local VM host
        notify: true,
        browser: "Google Chrome",
        injectChanges: true
    });
});

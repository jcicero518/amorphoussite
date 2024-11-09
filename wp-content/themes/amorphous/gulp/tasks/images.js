'use strict';

let config = require('../config');
let gulp = require('gulp');

let gulpif      = require('gulp-if');
let newer       = require('gulp-newer');
let imagemin    = require('gulp-imagemin');
let pngquant    = require('imagemin-pngquant');
let browserSync = require('browser-sync');

gulp.task('images', function() {
    gulp.src(config.images.src)
        // Add the newer pipe to pass through newer images only
        .pipe(newer(global.isProd ? config.images.prodDest : config.images.dest))
        .pipe(imagemin({
            progressive: true,
            plugins: [pngquant({quality: '75-90'})]
        }))
        .pipe(gulp.dest(global.isProd ? config.images.prodDest : config.images.dest))
        .pipe(browserSync.stream({ once: true }));
});
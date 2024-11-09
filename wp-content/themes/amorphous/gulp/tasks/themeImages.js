'use strict';

let config = require('../config');
let gulp = require('gulp');

let gulpif      = require('gulp-if');
let imagemin    = require('gulp-imagemin');
let pngquant    = require('imagemin-pngquant');
let browserSync = require('browser-sync');

gulp.task('themeImages', function() {
    gulp.src(config.themeImages.src)
        .pipe(imagemin({
            progressive: true,
            plugins: [pngquant({quality: '75-90'})]
        }))
        .pipe(gulp.dest(global.isProd ? config.themeImages.prodDest : config.themeImages.dest))
        .pipe(browserSync.stream({ once: true }));
});
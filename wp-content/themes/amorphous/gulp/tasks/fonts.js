'use strict';

let config = require('../config');
let gulp = require('gulp');
let changed = require('gulp-changed');
let browserSync = require('browser-sync');

gulp.task('fonts', function() {

  return gulp.src(config.fonts.src)
    .pipe(changed(config.fonts.dest)) // Ignore unchanged files
    .pipe(gulp.dest(global.isProd ? config.fonts.prodDest : config.fonts.dest))
    .pipe(browserSync.stream({ once: true }));

});

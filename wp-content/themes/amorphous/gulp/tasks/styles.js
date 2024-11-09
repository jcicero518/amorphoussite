'use strict';

let config       = require('../config');
let gulp         = require('gulp');
let gulpif       = require('gulp-if');
let changed      = require('gulp-changed');
let source       = require('vinyl-source-stream');
let buffer       = require('vinyl-buffer');
let sourcemaps   = require('gulp-sourcemaps');
let sass         = require('gulp-sass');
let autoprefixer = require('autoprefixer');
let postcss      = require('gulp-postcss');
let cssnano      = require('cssnano');

let plumber      = require('gulp-plumber');
let handleErrors = require('../util/handleErrors');
let browserSync  = require('browser-sync');

/**
 * Check for dev env overrides
 * call postcss processors if in prod or is overridden
 **/
function maybeCallProcessors() {
    let override = global.devOverrides.autoprefixer;
    return !!( !global.isProd || override );
}

gulp.task('styles', function() {

    const processors = [ autoprefixer( 'last 3 versions' ) ];
    const createSourceMap = !global.isProd;

    gulp.src(config.styles.src)
        .pipe(plumber({
            errorHandler: handleErrors
        }))
        .pipe(gulpif(createSourceMap, sourcemaps.init()))
        .pipe(sass({
            errLogToConsole: true,
            lineNumbers: true,
            style: global.isProd ?  'compressed' : 'nested'
        }))
        .on('error', handleErrors)
        .pipe(gulpif(maybeCallProcessors, postcss(processors)))
        .pipe(gulpif(createSourceMap, sourcemaps.write('./maps')))
        .pipe(gulp.dest(global.isProd ? config.styles.prodDest : config.styles.dest))
        .pipe(browserSync.stream({ match: "**/*.css" }));
});
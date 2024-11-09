'use strict';

//process.env.NODE_ENV = 'production';

let config       = require('../config');
let gulp         = require('gulp');
let gulpif       = require('gulp-if');
let source       = require('vinyl-source-stream');
let buffer       = require('vinyl-buffer');
let sourcemaps   = require('gulp-sourcemaps');

let browserify   = require('browserify');
let babelify     = require('babelify');
let watchify     = require('watchify');
let notify       = require('gulp-notify');
let uglify       = require('gulp-uglify');
let assign       = require('lodash.assign');

let gutil        = require('gulp-util');
let handleErrors = require('../util/handleErrors');
let browserSync  = require('browser-sync').create();

let browserifyOpts = {
    entries: config.scripts.entryFile,
    debug: true
};

let babelOpts = {
    presets: ["es2015"]
};

let opts = assign({}, watchify.args, browserifyOpts);
// b for bundle
let b = watchify(browserify(opts)).transform("babelify", babelOpts);

gulp.task('buildBundle', bundle);
b.on('update', bundle);
b.on('log', gutil.log);

function bundle() {
    return b.bundle()
        .on('error', function(err) {
            gutil.log.bind(gutil, 'Browserify error: ' + err);
            console.log('Error: ' + err.message);
            // end this stream
            // this prevents browserify to crash on compilation error
            this.emit('end');
        })
        .pipe(source(config.scripts.outputFile))
        .pipe(buffer())
        .pipe(sourcemaps.init({loadMaps: true}))
        //.pipe(uglify())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest(global.isProd ? config.scripts.prodDest : config.scripts.dest))
        .pipe(browserSync.stream({ once: true, match: '**/*.js' }));
}

gulp.task('scripts', function () {
    let start = Date.now();
    // app.js is your main JS file with all your module inclusions
    return browserify({entries: config.scripts.entryFile, debug: true})
        .transform("babelify", { presets: ["es2015"] })
        .bundle()
        .on('error', function(err) {
            console.log(err);
            console.log('Error: ' + err.message);
            // end this stream
            // this prevents browserify to crash on compilation error
            this.emit('end');
        })
        .pipe(source(config.scripts.outputFile))
        .pipe(buffer())
        .pipe(sourcemaps.init())
        //.pipe(uglify())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest(global.isProd ? config.scripts.prodDest : config.scripts.dest))
        .pipe(notify(function displayBundleMessage() {
            console.log('APP bundle built in ' + (Date.now() - start) + 'ms');
        }))
        .pipe(browserSync.stream({ once: true, match: '**/*.js' }));
});
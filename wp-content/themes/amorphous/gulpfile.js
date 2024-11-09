"use strict";

let config      = require('./gulp/config');
let gulp        = require('gulp');

// Loads the gulp directory index file
require('./gulp');

// deprecated
let enabled = {
    isProd: false,
    cssnano: false,
    aprefixer: true,
    jshint: false,
    sourcemaps: true,
    stripdebug: false
};

gulp.task('watch', ['browser-sync'], function () {
    gulp.watch(config.styles.src, ['styles']);
    gulp.watch(config.scripts.src, ['buildBundle']);
    gulp.watch(config.images.src, ['images']);
    gulp.watch(config.themeImages.src, ['themeImages']);
    gulp.watch(config.fonts.src, ['fonts']);
});

gulp.task('default', ['watch']);
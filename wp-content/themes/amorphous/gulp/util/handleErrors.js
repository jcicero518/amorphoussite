'use strict';

let notify = require('gulp-notify');
let plumber = require('gulp-plumber');

module.exports = function(error) {
  console.log( 'An error has occured: ', error.message );
  this.emit( 'end' );
};
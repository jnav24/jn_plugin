// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

// Note:
// The input/output directories must be different for gulp-changed 
// to work properly.
// glob watch only works if all the files are in one directory

// ::::::::::::::: Sass

var sassop = 'css/';
var sassip = 'sass/';
var ops = 'compressed';

// ::::::::::::::: JS

var jsop = 'js/';
var jsip = 'js-dev/';

// ::::::::::::::: Global Gulp

var gulp = require('gulp'),
    path = require('path'),
    browserSync = require('browser-sync'),
    changed = require('gulp-changed'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch'),
    livereload= require('gulp-livereload'),
    plumber = require('gulp-plumber'),
    // ===========================================================================
    // you can only use one of these at a time. sassy = not using. sass = using.
    // just change the desired on to 'sass' and the other to 'sassy'.
    sassy = require('gulp-sass'),
    sass = require('gulp-ruby-sass'),
    // ===========================================================================

    connect = require('gulp-connect'),
    notify = require('gulp-notify'),
    growl = require('gulp-notify-growl'),
    phpunit = require('gulp-phpunit');

// ===========================================================================
// Initialize the notifier
var growlNotifier = growl({
  hostname : '10.16.20.42' // IP or Hostname to notify, default to localhost
});

// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::


// ===========================================================================
// Concatenate & Minify JS 
// Do NOT create a main.js file or a file you are concatenating to.


gulp.task('scripts', function() {
    return gulp.src(jsip+'*.js')
        .pipe(watch({
            glob: jsip + '*.js',
            emit: 'all',
            emitOnGlob: false
        }, function(files) {
            return files.pipe(plumber())
                .pipe(concat('main.js'))
                .pipe(uglify())
                .pipe(rename({
                    suffix: '.min'
                }))
                .pipe(gulp.dest(jsop))
                // the error handler isn't really needed because this check for errors
                // so with each save you will get a success . Perhaps use jshint.
                .pipe(plumber({errorHandler: growlNotifier.onError('<%= error.message %>')}))
                .pipe(growlNotifier({
                    title: 'Success',
                    message: 'Compiled <%= file.relative %>'
                }))
                .pipe(browserSync.reload({stream:true}));
        }))        
});


// ===========================================================================
// Ruby Sass (to run: sudo gulp)
gulp.task('sassy', function () {
    return gulp.src([sassip + '**/*.scss', sassip + '**/*.sass'])
        .pipe(watch({
            glob: [sassip + '**/*.scss', sassip + '**/*.sass'],
            emit: 'all',
            emitOnGlob: false
        }, function(files) {
            return files.pipe(plumber())
                .pipe(sass({
                    style: ops
                }))
                .pipe(gulp.dest(sassop));
        }))
        .pipe(plumber({errorHandler: growlNotifier.onError('<%= error.message %>')}))
        // ===========================================================================
        // Change watches for changed files then runs sass
        // which is why the sass command is repeated below
        .pipe(changed(sassop, { extension: '.css' }))
        .pipe(sass({
            style: ops
        }))
        .pipe(gulp.dest(sassop))
        .pipe(growlNotifier({
            title: 'Success',
            message: 'Compiled <%= file.relative %>'
        }))
        // ===========================================================================
        .pipe(browserSync.reload({stream:true}));;
});

// ===========================================================================
// Sass (not ruby)
gulp.task('sass', function() {
    return gulp.src([sassip + '**/*.scss', sassip + '**/*.sass'])
        .pipe(watch({
            glob: ['sass/**/*.scss', 'sass/**/*.sass'],
            emit: 'all',
            emitOnGlob: false
        }, function(files) {
            return files.pipe(plumber())
                .pipe(sass({
                    errLogToConsole: true,
                    outputStyle: ops
                }))
                .pipe(gulp.dest(sassop));
        }))
        .pipe(plumber({errorHandler: growlNotifier.onError('<%= error.message %>')}))
        // ===========================================================================
        // Change watches for changed files then runs sass
        // which is why the sass command is repeated below
        .pipe(changed(sassop, { extension: '.css' }))
        .pipe(sass({
            errLogToConsole: true,
            outputStyle: ops
        }))
        .pipe(gulp.dest(sassop))
        .pipe(growlNotifier({
            title: 'Success',
            message: 'Compiled Sass <%= file.relative %>'
        }))
        // ===========================================================================
        .pipe(browserSync.reload({stream:true}));;
});

// ===========================================================================
// Watch HTML
gulp.task('browser-sync', function() {
    browserSync.init([
        '**/*.php',
        '*.html'
        ], {
        proxy: {
            host: "10.16.20.65"
          }
    });
});

// ===========================================================================
// Default Task
gulp.task('default', ['sassy','browser-sync','scripts']);
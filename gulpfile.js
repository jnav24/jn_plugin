// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

// Note:
// The input/output directories must be different for gulp-changed 
// to work properly.
// glob watch only works if all the files are in one directory

// ::::::::::::::: Sass

var sassop = './';
var sassip = 'App/resources/assets/sass/';
var ops = 'compressed';
var sass = 'nodeSass';

// ::::::::::::::: JS

var jsop = './';
var jsip = 'App/resources/assets/js/';
var jsDir = './';
var phpDir = 'tests/';

// ::::::::::::::: Global Gulp

var gulp = require('gulp'),
    path = require('path'),
    browserSync = require('browser-sync'),
    changed = require('gulp-changed'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    watch = require('gulp-watch'),
    plumber = require('gulp-plumber'),
    rubySass = require('gulp-ruby-sass'),
    nodeSass = require('gulp-sass'),
    connect = require('gulp-connect'),
    notify = require('gulp-notify'),
    phpunit = require('gulp-phpunit'),
    jasminet = require('gulp-jasmine'),
    reload = browserSync.reload;

// ===========================================================================
// JS
gulp.task('scripts', function() {
    return gulp.src(jsip+'*.js')
        .pipe(plumber({errorHandler: notify.onError('<%= error.message %>')}))
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(jsop))
        .pipe(notify({
            title: 'Success',
            message: 'Compiled <%= file.relative %>'
        }))
        .pipe(browserSync.reload({stream:true}));
});

// ===========================================================================
// Ruby Sass
gulp.task('rubySass', function() {
    return rubySass(sassip, { style: ops })
        .pipe(plumber({errorHandler: notify.onError('<%= error.message %>')}))
        .pipe(gulp.dest(sassop))
        .pipe(notify({
            title: 'Success',
            message: 'Compiled <%= file.relative %>'
        }))
        .pipe(reload({stream: true}));
});

// ===========================================================================
// Node Sass
gulp.task('nodeSass', function() {
    gulp.src(sassip + '*.scss')
    .pipe(plumber())
    .pipe(nodeSass({outputStyle: ops, errLogToConsole: true}))
        .pipe(gulp.dest(sassop))
        .pipe(reload({stream: true}));
});

// ===========================================================================
// Browser Sync
// the baseDir goes to localhost:3000
// the proxy goes to 192.168.33.10:3000/path/to/dir
gulp.task('browser-sync', function() {
    //browserSync({
      //  server: {
        //    baseDir: './' 
        //}
        // proxy: "192.168.33.10" 
    //});
    browserSync.init([
    '**/*.php',
    '*.html'
   ],{
    proxy: {
        host: "192.168.1.81"
    }
   });
});

// ===========================================================================
// PhpUnit
gulp.task('phpunit', function() {
    var options = {debug: false, notify: true};
    gulp.src('phpunit.xml')
        .pipe(phpunit('', options))
        .on('error', notify.onError({
            title: "Failed Tests!",
            message: "<%= error.message %>"
        }))
        .pipe(notify({
            title: 'Success',
            message: '<%= file.relative %>'
        }));
});

// ===========================================================================
// Jasmine
gulp.task('jasmine', function() {
    gulp.src(jsDir + 'spec/*_spec.js')
	.pipe(jasmine())
});

// ===========================================================================
// All Watch commands
gulp.task('watch', function(){
    gulp.watch(phpDir + '/**/*.php', function(){
        gulp.run('phpunit');
    });
    gulp.watch([sassip + '**/*.scss', sassip + '**/*.sass'], [sass]);
    gulp.watch(jsip+'*.js', ['scripts']);
    gulp.watch("./*.html").on('change', reload);
    gulp.watch(jsDir + "spec/*._spec.js", ['jasmine']);
});

// ===========================================================================
// Default Task
gulp.task('default', ['watch','nodeSass','scripts','phpunit']);

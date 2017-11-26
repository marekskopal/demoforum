'use strict';

var gulp = require('gulp');
var mainBowerFiles = require('gulp-main-bower-files');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var gulpFilter = require('gulp-filter');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');

var dest = './www/';

gulp.task('sass-compile', function () {
    return gulp.src('./src/sass/**/*.scss')
    .pipe(sass({
      outputStyle: 'compressed',
      precision: 10,
      includePaths: ['.']
    }).on('error', sass.logError))
    .pipe(autoprefixer('last 4 version'))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(dest + 'css'));
});

gulp.task('sass', function () {
    gulp.watch('./src/sass/**/*.scss', ['sass-compile']);
});

gulp.task('javascript', function() {
    var filterJS = gulpFilter('**/*.js', { restore: true });
    return gulp.src(
            [
                './bower_components/jquery/dist/jquery.min.js',
                './bower_components/nette.ajax/*.js',
                './vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
            ]
        )
        .pipe(filterJS)
        .pipe(concat('vendor.js'))
        //.pipe(uglify())
        .pipe(filterJS.restore)
        .pipe(gulp.dest(dest + 'js'));
});
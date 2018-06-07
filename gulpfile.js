'use strict';

var gulp          = require('gulp'),
    sourcemaps    = require('gulp-sourcemaps'),
    autoprefixer  = require('gulp-autoprefixer'),
    concat        = require('gulp-concat'),
    sass          = require('gulp-sass'),
    cleanCSS      = require('gulp-clean-css'),
    livereload    = require('gulp-livereload');

gulp.task('watch', function(){
  livereload.listen();
  gulp.watch('frontend/sass/*.sass', gulp.series( 'sass'));
  gulp.watch('public/wp-content/themes/zapchasti/**/*.php').on('change', livereload.changed);
  gulp.watch('public/wp-content/themes/zapchasti/css/*.css').on('change', livereload.changed);
  gulp.watch('public/wp-content/themes/zapchasti/js/*.js').on('change', livereload.changed);
});

gulp.task('production-sass', function () {
  return gulp.src(['../node_modules/bootstrap/scss/bootstrap-zapchasti.scss', 'frontend/sass/concat.sass'])
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.init())
    .pipe(autoprefixer())
    .pipe(concat('template.css'))
    .pipe(cleanCSS({ keepBreaks: true, compatibility: 'ie8' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('public/wp-content/themes/zapchasti/css/'));
});

gulp.task('bootstrap-sass', function(){
  return gulp.src('../node_modules/bootstrap/scss/bootstrap-zapchasti.scss')
      .pipe(sourcemaps.init())
      .pipe(sass().on('error', sass.logError))
      .pipe(autoprefixer())
      .pipe(cleanCSS({ keepBreaks: true, compatibility: 'ie8' }))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('public/wp-content/themes/zapchasti/css/'))
});

gulp.task('sass', function () {
  return gulp.src('frontend/sass/concat.sass')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('public/wp-content/themes/zapchasti/css/'))
});

gulp.task(
  'default',
  gulp.series(
    'watch'
  )
);
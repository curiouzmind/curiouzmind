var gulp = require('gulp'),
    php  = require('gulp-connect-php'),
    browserSync = require('browser-sync');
var sass = require('gulp-sass');
var cssnano = require('gulp-cssnano');
var autoprefixer = require('gulp-autoprefixer');
var eslint = require('gulp-eslint');
var jasmine = require('gulp-jasmine-phantom');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var babel = require('gulp-babel');
var sourcemaps = require('gulp-sourcemaps');
var imagemin = require('gulp-imagemin');
var imageminPngquant = require('imagemin-pngquant');
var cache = require('gulp-cache');
var useref = require('gulp-useref');
var gulpIf = require('gulp-if');
var del = require('del');
var runSequence = require('run-sequence');
var minify = require('html-minifier').minify;


// Development Tasks 
// -----------------

// PHP Server with BrowserSync
var reload = browserSync.reload;
gulp.task('php', function() {
    php.server({ base: '/prod', port: 8010, keepalive: true});
});
gulp.task('browser-sync', ['php'], function() {
    browserSync({
      proxy: '127.0.0.1:8010',
      port: 8080,
      open: true,
      notify: true
    });
});
// sass
gulp.task('sass', function() {
  return  gulp.src('dev/sass/**/*.scss')
        .pipe(sass())
        .pipe(autoprefixer({
          browsers: ['last 2 versions']
        }))
        .pipe(gulp.dest('dev/css'))
        .pipe(browserSync.stream());
});
// eslint
gulp.task('lint', function () {
  return gulp.src(['dev/js/**/*.js','!node_modules/**'])
        // eslint() attaches the lint output to the "eslint" property
        // of the file object so it can be used by other modules.
        .pipe(eslint())
        // eslint.format() outputs the lint results to the console.
        // Alternatively use eslint.formatEach() (see Docs).
        .pipe(eslint.format())
        // To have the process exit with an error code (1) on
        // lint error, return the stream and pipe to failAfterError last.
        .pipe(eslint.failAfterError());
});
gulp.task('watch', ['browser-sync'], function() {
    gulp.watch(['*.php'], [reload]);
    gulp.watch(['dev/index.php'], [reload]);
    gulp.watch('dev/sass/**/*.scss', ['sass']);
    gulp.watch('dev/css/**/*.css', ['useref']);
    gulp.watch('dev/js/**/*.js', ['useref']);
    gulp.watch('dev/js/**/*.js', ['lint']);    
    gulp.watch('dev/img/**/*.css', ['images']);
});
// Optimization & copy Tasks 
// ------------------

// optimize js & css and copy to prod
gulp.task('useref', function() {
  return gulp.src('dev/index.php')
              .pipe(useref())
              .pipe(gulpIf('*.js', uglify()))
              .pipe(gulpIf('*.css', autoprefixer({
                browsers: ['last 2 versions']
              })))
              .pipe(gulpIf('*.css', cssnano()))
              .pipe(gulp.dest('/Users/bolaj/projects/work/curiouzmind'))
});
// optimize images and copy to prod
gulp.task('images', function() {
  gulp.src('dev/img/**/*.+(png|jpg|gif|svg)')
    .pipe(cache(imagemin()))
    .pipe(gulp.dest('prod/img'));
});
// copy fonts to prod folder
gulp.task('fonts', function() {
  return gulp.src('dev/fonts/**/*')
        .pipe(gulp.dest('prod/fonts'))
});
// clean automatically generated files
// Cleaning 
gulp.task('clean', function() {
  return del.sync('prod').then(function(cb) {
    return cache.clearAll(cb);
  });
});
gulp.task('clean:prod', function() {
  return del.sync(['prod/**/*', '!prod/img', '!prod/img/**/*']);
});
// Build Sequences
// ---------------
gulp.task('default', function(callback) {
  runSequence(['browser-sync', 'watch'],
    callback
  )
});
gulp.task('build', function(callback) {
  runSequence(
    'clean:prod', 'sass',
    ['images', 'fonts'], 'useref',
    callback
  )
});
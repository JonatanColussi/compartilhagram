var gulp = require('gulp');


// **************************
// Run sequence default Tasks
// **************************
var runSequence = require('run-sequence');

gulp.task('default', function(done) {
    runSequence(
            'browser-sync', 
            'watch-styles',
            'watch-deploy-style', 
            'watch-deploy-img',
            'watch-scripts',
            'watch-deploy-scripts',
            'watch-scripts-admin',
            'watch-deploy-scripts-admin',
            'watch-php',

            function() {
                console.log('Afirmativo e operante!!!');
                done();
            }
    );
});

// ***********************
// Watch scripts to minify
// ***********************
gulp.task('watch-scripts',function() {
    gulp.watch([
        'assets/js/src/**/*.js'
    ],
    ['concat-scripts-global', 'concat-scripts-contextual']);
});


// ***********************
// Watch scripts to deploy
// ***********************
gulp.task('watch-deploy-scripts',function() {
    gulp.watch([
        'assets/js/dist/scripts.min.js'

    ],
    ['deploy-scripts']);
});


// *****************************************************
// Sass watching and compile all *.scss files into /sass
// Obs: Acho que poderia ser sÃ³ o main.scss
// *****************************************************
gulp.task('watch-styles',function() {
    gulp.watch('assets/scss/src/*.scss',['styles']);
});


// **********************
// Sass (task default)
// **********************
var sass = require('gulp-sass');

gulp.task('styles', function() {
    gulp.src('sass/main.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(sass({ outputStyle: 'compressed' }))
        .pipe(gulp.dest('./css'))

});


// *******************
// Clean/Minify CSS
// *******************
var cleanCSS = require('gulp-clean-css');

gulp.task('cssmin', function() {
  return gulp.src('css/*.css')
    .pipe(cleanCSS({compatibility: 'ie8'}))
    .pipe(gulp.dest('dist/css'));
});


// *******************
// Mininfy HTML e PHP
// *******************
var htmlmin = require('gulp-htmlmin');
 
gulp.task('min', function() {
  return gulp.src(['**/*.html', '**/*.php', '!./libs/**', '!./php/**', '!./googlede54d636ea67bfa9.html', '!./dist/**', '!./arquivos/**', '!./node_modules/**','!./exemplo/**', '!./email/**'])
    .pipe(htmlmin({
    	collapseWhitespace: true,
    	preserveLineBreaks : true,
    	removeComments : true
    }))
    .pipe(gulp.dest('dist'))
});

// Se rolar tretas na minificaÃ§Ã£o de html/php tente:
// <!-- htmlmin:ignore -->


// *************************
// Concat and minify scripts
// *************************
gp_concat = require('gulp-concat'),
gp_rename = require('gulp-rename'),
gp_uglify = require('gulp-uglify'),
gp_sourcemaps = require('gulp-sourcemaps');

// Scripts Global
gulp.task('concat-scripts-global', function(){
    return gulp.src([
        './js/functions/*.js',
        './js/components/*.js',
        './js/layout/*.js'
        ])
        .pipe(gp_sourcemaps.init())
        .pipe(gp_concat('scripts.js'))
        .pipe(gulp.dest('./js'))
        .pipe(gp_rename('scripts.min.js'))
        .pipe(gp_uglify())
        .pipe(gp_sourcemaps.write('./'))
        .pipe(gulp.dest('./js'));
});

// Scripts Contextual
var uglify = require('gulp-uglify');
var pump = require('pump');

gulp.task('concat-scripts-contextual', function (cb) {
  pump([
        gulp.src('./js/pages/*.js'),
        uglify(),
        gulp.dest('./js/pages/min/')
    ],
    cb
  );
});

gulp.task('minify-scripts-admin', function (cb) {
  pump([
        gulp.src('./admin/js/*.js'),
        uglify(),
        gulp.dest('./admin/js/min/')
    ],
    cb
  );
});


// ****************
// Minify images
// ****************
const imagemin = require('gulp-imagemin');
 
gulp.task('imgmin', () =>
	gulp.src(['**/*.{jpg,png,gif,ico}', '!./libs/**', '!./php/**', '!./dist/**', '!./arquivos/**', '!./node_modules/**'])
		.pipe(imagemin())
		.pipe(gulp.dest('dist/'))
);


gulp.task('watch-php', function(){
    gulp.watch('*.php').on('change', browserSync.reload);
    
    var globs = [
        '*.php'
    ];

    return gulp.src( globs, { base: '.', buffer: false } )
        .pipe( conn.newer( '/' ) ) // only upload newer files
        .pipe( conn.dest( './' ) );
});
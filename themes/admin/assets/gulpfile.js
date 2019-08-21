var gulp = require('gulp'),
    clean = require('gulp-clean'),
    jshint = require('gulp-jshint'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    sass = require('gulp-sass'),
    minifyCss = require('gulp-minify-css'),
    browsersync = require('browser-sync'),
    reload = browsersync.reload,
    debug = require('gulp-debug'),

    bases = {
        app: 'sources/',
        dist: '../dist/',
        fonts: 'fonts/',
        root: '../../'
    },
    paths = {
        scripts: [
            'js/custom.js',
            'js/../../../../../module/**/template/sources/js/*',
            'js/_plugins/*.js'
        ],
        libs: [
            '../../node_modules/jquery/dist/jquery.js',
            '../../sources/libraries/jquery-ui/jquery-ui.min.js',
            '../../node_modules/popper.js/dist/umd/popper.js',
            '../../node_modules/bootstrap/dist/js/bootstrap.js',
            '../../node_modules/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
            '../../node_modules/blueimp-file-upload/js/jquery.fileupload.js'
        ],
        styles: [
            'scss/index.scss',
            'scss/../../../../../module/**/template/sources/scss/*'
        ],
        _views: [],
        fonts: ['fonts/**/*', '!libs/**/*'],
        images: ['images/**/*.*'],
        extras: ['crossdomain.xml', 'humans.txt', 'manifest.appcache', 'robots.txt', 'favicon.ico'],
    };

// Delete the dist directory
gulp.task('clean', function () {
    // gulp.src(bases.fonts)
    //     .pipe(clean());
    // gulp.src(bases.dist)
    //     .pipe(clean());
});


// Copy fonts
gulp.task('fonts', function () {
    gulp.src(paths.fonts, {cwd: 'sources/**'})
        .pipe(gulp.dest(bases.dist));
});


// Process scripts and concatenate them into one output file
gulp.task('scripts', ['clean'], function () {
    gulp.src(paths.scripts, {cwd: bases.app})
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(uglify().on('error', function (e) {
            console.log(e);
        }))
        .pipe(concat('script.js'))
        .pipe(gulp.dest(bases.dist + 'scripts/'));
});

// Combine all external libraries
gulp.task('scripts_lib', ['clean'], function () {
    // Concat lib scripts
    gulp.src(paths.libs, {cwd: 'sources/**'})
        .pipe(uglify({output: {max_line_len: 120000}}).on('error', function (e) {
            console.log(e);
        }))
        .pipe(concat('lib.js'))
        .pipe(gulp.dest(bases.dist + 'scripts/'));
});

// SCSS compile and minify
gulp.task('styles', ['clean'], function () {
    gulp.src(paths.styles, {cwd: bases.app})
    // .pipe(debug({minimal:false}))
        .pipe(sass().on('error', sass.logError))
        .pipe(minifyCss()) //minifies the CSS files
        .pipe(concat('main.css'))
        .pipe(gulp.dest(bases.dist + 'styles/'))
        .pipe(browsersync.reload({stream: true}));
});

// Imagemin images and ouput them in dist
gulp.task('imagemin', ['clean'], function () {
    gulp.src(paths.images, {cwd: bases.app})
    // .pipe(imagemin()) // use it on live
        .pipe(gulp.dest(bases.dist + 'images/'));
});


// Watch for changes
gulp.task('watch', function () {
    gulp.watch('../../../module/**/template/sources/**/*', ['scripts', 'styles', 'imagemin']);
    gulp.watch('sources/**/*', ['scripts', 'styles', 'imagemin']);//, 'imagemin', 'fonts', '_views'
    // gulp.watch('app/styles/**/*', ['styles']);
    browsersync({
        port: 3333
    });
});

// Define the default task as a sequence of the above tasks
gulp.task('default', ['clean', 'scripts', 'scripts_lib', 'styles', 'fonts', 'imagemin']);//,'_views'

// Include gulp from our installed npm package dependencies
const gulp = require('gulp');

// Include the rest of our installed npm package dependencies:

// this auto prefixes certain css rules that might have browser vendor prefixes
const autoprefixer = require('autoprefixer');

// bourbon is a set of kinda cool sass functions you can find here: https://www.bourbon.io/docs/latest/
const bourbon = require('bourbon').includePaths;

// babel lets you use modern/next gen JS in your source, and it spits out something compatible with more browsers
const babel = require('gulp-babel');

// this is our linter for js - fix and warn about common js code issues and potential bugs
const jshint = require('gulp-jshint');

// our scss/sass processor - a much better way to write CSS
const sass = require('gulp-sass')(require('sass'));

// lets you combine files into 1
const concat = require('gulp-concat');

// runs uglify - a js minifier. compresses js file size
const uglify = require('gulp-uglify');

// lets you rename files
const rename = require('gulp-rename');

// kinda like uglify, but for css
const minifycss = require('gulp-clean-css');

// process the css file with auto prefixer from above, and pxtorem from below
const postcss = require('gulp-postcss');

// write all your units as pixels, and this will also create a second rule of it as rem - all the benefits of using relative unit without the math
const pxtorem = require('postcss-pxtorem');

// ----------------------------------------------------------------------

//Basic structure of all gulp functions:
// - first, use .src to collect a bunch of files, using asterisks to mark wildcards
// - then use .pipe to send the data into a series of packages/functions
// - the functions to be piped to can include any of the packages we imported,
//   or gulp.dest in order to spit out the processed info into a file.

// Lint Scripts - comb through our custom scripts to look for common issues,
// some which will be fixed,
// others which will be reported to the command line as warnings or errors.
function lintScripts() {
    return gulp
        .src([
            'library/custom-theme/js/header-scripts.js',
            'library/custom-theme/js/footer-scripts.js',
            'views/conditional/**/modules/**/assets/js/*.js',
            'views/conditional/**/**/modules/**/assets/js/*.js',
            'views/conditional/**/**/widgets/**/assets/js/*.js',
            '!views/conditional/pages/locations-page/modules/**/*.js',
            'views/global/header/navigation/**/assets/js/*.js',
            'views/global/modules/**/assets/js/*.js',
            'views/global/widgets/**/assets/js/*.js',
            'views/conditional/pages/front-page/title-area/assets/js/*.js',
        ])
        .pipe(
            jshint({
                asi: true,
                expr: true,
                esnext: true,
                sub: true,
                eqnull: true,
                multistr: true,
                laxbreak: true,
            })
        )
        .pipe(jshint.reporter('default'));
}

// Compile SASS - make the sass css,
// then run it through postcss, minify that,
// and then spit it out into the root theme folder as style.css.
// It's important to note that any sass file without _ (underscore) at the front of it will be spit out,
// and style.scss should be the only sass file like that.
function compileSass() {
    return gulp
        .src(
            [
                'style.scss',
                'library/custom-theme/scss/**/**/**/*.scss',
                'library/vendor/scss/**/**/**/*.scss',
                'views/**/**/**/**/**/**/*.scss',
                '!views/conditional/pages/locations-page/modules/**/*.scss',
            ],
            {
                sourcemaps: false,
            }
        )
        .pipe(
            sass({
                outputStyle: 'expanded',
                sourceComments: true,
                precision: 10,
                includePaths: bourbon,
            }).on('error', sass.logError)
        )
        .pipe(postcss(processors))
        .pipe(minifycss({ compatibility: 'ie8' }))
        .pipe(gulp.dest('./', { sourcemaps: false }));
}

function compileMandRBrandingSCSS() {
    return gulp
        .src(
            [
                //'library/mandr/scss/**/**/**/*.scss',
                'library/mandr/*.scss',
            ],
            {
                sourcemaps: false,
            }
        )
        .pipe(
            sass({
                outputStyle: 'expanded',
                sourceComments: true,
                precision: 10,
                includePaths: bourbon,
            }).on('error', sass.logError)
        )
        .pipe(postcss(processors))
        .pipe(minifycss({ compatibility: 'ie8' }))
        .pipe(rename('mandr-style.css'))
        .pipe(gulp.dest('./library/mandr', { sourcemaps: false }));
}

function compileLocationMapSCSS() {
    return gulp
        .src(
            [
                'views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/scss/*.scss',
            ],
            {
                sourcemaps: false,
            }
        )
        .pipe(
            sass({
                outputStyle: 'expanded',
                sourceComments: true,
                precision: 10,
                includePaths: bourbon,
            }).on('error', sass.logError)
        )
        .pipe(postcss(processors))
        .pipe(minifycss({ compatibility: 'ie8' }))
        .pipe(rename('locations-map-style.css'))
        .pipe(
            gulp.dest(
                './views/conditional/pages/locations-page/modules/locations-map/dist/css',
                { sourcemaps: false }
            )
        );
}

// Post CSS options, used above
const processors = [
    autoprefixer({
        overrideBrowserslist: ['last 2 versions', 'ie > 8'],
    }),
    pxtorem({
        root_value: 10,
        prop_white_list: [],
        replace: false,
    }),
];

// Compile JS - combine all the js src files, make it all.min.js,
// minify it, and then spit it out in a new folder.
function compileHeaderScripts() {
    return gulp
        .src(
            [
                'library/custom-theme/js/header-scripts.js',
                'library/vendor/js/jQuery/jquery.ba-throttle-debounce.js',
                'library/vendor/js/magnific/magnific.js',
                'library/vendor/js/slick/slick.js',
            ],
            { sourcemaps: false }
        )
        .pipe(concat('header.js'))
        .pipe(rename('header.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('.', { sourcemaps: false }));
}

// Compile JS #2 - just like above, but with different files. This compiled JS file
// will be included in the footer of the site instead of the head.
// If you ever have JS that needs to be included more/less often, you can always create a new compile function to process it.
function compileFooterScripts() {
    return gulp
        .src(
            [
                'library/custom-theme/js/footer-scripts.js',
                'views/conditional/**/modules/**/assets/js/*.js',
                'views/conditional/**/**/modules/**/assets/js/*.js',
                '!views/conditional/pages/locations-page/modules/**/*.js',
                'views/conditional/**/**/widgets/**/assets/js/*.js',
                'views/global/header/assets/js/*.js',
                'views/global/header/navigation/**/assets/js/*.js',
                'views/global/modules/**/assets/js/*.js',
                'views/global/widgets/**/assets/js/*.js',
                'views/conditional/pages/front-page/title-area/assets/js/*.js',
            ],
            { sourcemaps: false }
        )
        .pipe(babel({ presets: ['@babel/env'] }))
        .pipe(concat('footer.js'))
        .pipe(rename('footer.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('.', { sourcemaps: false }));
}

function compileScripts() {
    compileHeaderScripts();
    compileFooterScripts();
}

// Watch all the necesary files,
// then run the functions created above whenever one of their files change.
function watch() {
    gulp.watch(
        [
            'library/custom-theme/js/header-scripts.js',
            'library/custom-theme/js/footer-scripts.js',
            'views/conditional/**/modules/**/assets/js/*.js',
            'views/conditional/**/**/modules/**/assets/js/*.js',
            'views/conditional/**/**/widgets/**/assets/js/*.js',
            '!views/conditional/pages/locations-page/modules/**/*.js',
            'views/global/header/assets/js/*.js',
            'views/global/header/navigation/**/assets/js/*.js',
            'views/global/modules/**/assets/js/*.js',
            'views/global/widgets/**/assets/js/*.js',
            'views/conditional/pages/front-page/title-area/assets/js/*.js',
        ],
        lintScripts
    );

    gulp.watch(
        [
            'library/custom-theme/js/header-scripts.js',
            //the other vender scripts in the library don't need to be included here, because you shouldn't need to ever edit them
        ],
        compileHeaderScripts
    );

    gulp.watch(
        [
            'library/custom-theme/js/footer-scripts.js',
            'views/conditional/**/modules/**/assets/js/*.js',
            'views/conditional/**/**/modules/**/assets/js/*.js',
            'views/conditional/**/**/widgets/**/assets/js/*.js',
            '!views/conditional/pages/locations-page/modules/**/*.js',
            'views/global/header/assets/js/*.js',
            'views/global/header/navigation/**/assets/js/*.js',
            'views/global/modules/**/assets/js/*.js',
            'views/global/widgets/**/assets/js/*.js',
            'views/conditional/pages/front-page/title-area/assets/js/*.js',
        ],
        compileFooterScripts
    );

    gulp.watch(
        [
            'style.scss',
            'library/custom-theme/scss/**/**/**/*.scss',
            'library/vendor/scss/**/**/**/*.scss',
            'views/**/**/**/**/**/**/**/*.scss',
            'views/**/**/**/**/**/**/*.scss',
        ],
       compileSass
    );

    gulp.watch(
        [
            'library/mandr/scss/**/**/**/*.scss',
            'library/mandr/*.scss'
        ],
       compileMandRBrandingSCSS
    ); 
    
        
    //gulp.watch(
    //    [
    //        'views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/scss/*.scss',
    //    ],
    //    compileLocationMapSCSS
    //);
}

// This let's you run the functions above from the commandline, but all I ever do is type "npx gulp" from the master theme folder
// which will run the default "watch"
// which in turn does everything else automatically until we cancel it in the terminal.
exports.watch = watch;
exports.js = compileScripts;
exports.sass = compileSass;

gulp.task('default', watch);

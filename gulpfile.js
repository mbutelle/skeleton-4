// import de gulp et del (qui n'est pas un plugin gulp)
var gulp = require('gulp'), del = require('del');

// chargement automatique des plugins
// var rename = require('rename'); sera $.rename()
var $ = require('gulp-load-plugins')({ lasy: true });

var dest = "./public/";

///////////////////////////////////////////////////
//  CSS
///////////////////////////////////////////////////

// récupération des fonts pour les mettre dans notre dossier css
gulp.task('font-awesome-fonts', function () {
    return gulp.src(['node_modules/font-awesome/fonts/*.*'])
        .pipe(gulp.dest(dest + 'css/fonts'));
});

// transformation de nos sources scss en css
gulp.task('foundation-style', ['font-awesome-fonts'], function () {

    return gulp.src('sass/*.scss') // fichiers sources
        .pipe($.sass({ // transformation du sass en css
            outputStyle: 'nested',
            precision: 5,
            includePaths: [ // chemin à inclure pour faire fonctionner les @import
                'node_modules/foundation-sites/scss',
                'node_modules/font-awesome/scss',
                'node_modules/toastr'
            ]
        }))
        .pipe($.rename('app.css')) // renommage du fichier
        .pipe($.autoprefixer({ // ajout des préfixes des navigateurs
            browsers: ['last 2 versions', 'ie >= 11', 'ios_saf >= 9', 'and_chr >= 5.0']
        }))
        .pipe(gulp.dest(dest + 'css')) // copie du fichier dans sa destination
        .pipe($.rename('app.min.css')) // renommage du flux avec .min
        .pipe($.csso()) // minification du css
        .pipe(gulp.dest(dest + 'css')); // copie du fichier dans sa destination
});

///////////////////////////////////////////////////
//  JavaScript
///////////////////////////////////////////////////

gulp.task('js', function () {
    return gulp.src(['node_modules/jquery/dist/jquery.js', 'js/*.js'])
        .pipe($.concat('app.js'))
        .pipe($.uglify())
        .pipe(gulp.dest(dest + '/js'));
});


///////////////////////////////////////////////////
//  Images
///////////////////////////////////////////////////

gulp.task('img', function () {
    return gulp.src('./img/*')
        .pipe($.image({
            pngquant: true,
            optipng: false,
            zopflipng: true,
            jpegRecompress: false,
            mozjpeg: true,
            guetzli: false,
            gifsicle: true,
            svgo: true,
            concurrent: 10,
            quiet: true
        }))
        .pipe(gulp.dest('./public/img'));
});

///////////////////////////////////////////////////
//  Watcher
///////////////////////////////////////////////////

gulp.task('default', ['foundation-style', 'js', 'img'], function () {
    gulp.watch('sass/**/*.scss', ['foundation-style']);
    gulp.watch('js/**/*.js', ['js']);
    gulp.watch('img/**/*.js', ['img']);
});
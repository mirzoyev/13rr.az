import gulp from 'gulp';

import del from 'del';
import autoprefixer from 'gulp-autoprefixer';
import cleanCss from 'gulp-clean-css';
import cssCopy from 'postcss-copy';
import debug from 'gulp-debug';
import htmlmin from 'gulp-htmlmin';
import gulpif from 'gulp-if';
import less from 'gulp-less';
import notify from 'gulp-notify';
import postcss from 'gulp-postcss';
import rename from 'gulp-rename';
//import sftp from 'gulp-sftp';
import sftp from 'gulp-sftp-up4';
import sourcemaps from 'gulp-sourcemaps';
//import gutil from 'gulp-util';
//import ftp from 'vinyl-ftp';

let isDevelopement = true;
if (process.env.NODE_ENV && process.env.NODE_ENV.trim() !== 'development') {
    isDevelopement = false;
}

const paths = {
    src: './',
    dst: '../'
};

const remote = {
    host: '91.201.42.81',
    user: 'roman_gulp@91.201.42.81',
    pass: 'sG1jF9aE1g14',
    path: '/var/www/roman/data/www/alfa.roman.az'
};

function clean() {
    return del([
        paths.dst + 'assets',
        paths.dst + 'templates'
    ], {
        force: true
    });
}

function templates() {
    return gulp.src(paths.src + 'templates/**/*.html')
        .pipe(htmlmin({
            collapseWhitespace: true
        }))
        .pipe(gulp.dest(paths.dst + 'templates'));
}

function styles() {
    return gulp.src(paths.src + 'styles/index.less')
        .pipe(debug({
            title: process.env.NODE_ENV
        }))
        .pipe(gulpif(isDevelopement, sourcemaps.init()))
        .pipe(less({
            relativeUrls: true
        }))
        .on('error', notify.onError(function (error) {
            return error.message;
        }))
        .pipe(debug({
            title: 'styles:less'
        }))
        .pipe(postcss([
            cssCopy({
                basePath: [paths.src],
                dest: paths.dst + 'assets',
                template: '[path]/[name].[ext][query]'
            })
        ]))
        .pipe(debug({
            title: 'postcss:copy'
        }))
        .pipe(autoprefixer({
            overrideBrowserslist: [
                'last 3 version',
                '> 0.5%',
                'maintained node versions',
                'not dead'
            ],
            cascade: false
        }))
        .pipe(debug({
            title: 'styles:autoprefixer'
        }))
        .pipe(cleanCss())
        .pipe(debug({
            title: 'styles:cleanCss'
        }))
        .pipe(gulpif(isDevelopement, sourcemaps.write()))
        .pipe(rename('main.css'))
        .pipe(gulp.dest(paths.dst + 'assets'));
}

function watch() {
    gulp.watch(paths.src + 'styles/**/*', styles);
    gulp.watch(paths.src + 'templates/**/*.html', templates);
}

function upload() {
    return gulp.src('../media/**/*.*')
        .pipe(sftp({
            host: remote.host,
            user: remote.user,
            pass: remote.pass,
            remotePath: remote.path + '/media'
        }));
}

const archive = gulp.series(
    function copy_media() {
        return gulp.src('../media/**/*.*')
            .pipe(gulp.dest('../archive'));
    },
    function clean_media() {
        return del('../media/**/*.*', {
            force: true
        });
    }
);
exports.build = gulp.series(clean, styles, templates);
exports.update = gulp.series(upload, archive);

const index = gulp.series(styles, templates, watch);
export default index;

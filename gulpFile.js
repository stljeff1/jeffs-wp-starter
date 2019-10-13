"use strict";

const gulp = require('gulp');
const gulpsass = require('gulp-sass');
const cssnano = require('cssnano');
const autoprefixer = require('gulp-autoprefixer');
const sassglob = require('gulp-sass-glob');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');


const webpack = require('webpack-stream');

const buildDir = './build/';
const paths = {
	build: {
		theme: buildDir + 'theme',
		fonts: buildDir + 'webfonts' 
	}
}


gulp.task('copy-fontawesome', () => {

    return gulp.src('node_modules/@fortawesome/fontawesome-free/webfonts/*')
        .pipe(gulp.dest(paths.build.fonts));
})

gulp.task('js', () => {
	return gulp.src('src/js/main.js')
		.pipe(webpack( require('./webpack.config.js') ))
		.pipe(gulp.dest(paths.build.theme));
});

gulp.task('styles', () => {
	return gulp.src('src/styles/site.scss')
		.pipe(sassglob())
		.pipe(gulpsass({
			includePaths: [
				'node_modules/foundation-sites/scss/',
				'node_modules/@fortawesome/'
			]
		}))
		.pipe(autoprefixer())
		.pipe(gulp.dest(paths.build.theme));
});

gulp.task('watch-styles', () => {
	return gulp.watch(['src/styles/**/*.scss'], gulp.series('styles'));
});

gulp.task('watch-js', () => {
	return gulp.watch(['src/js/**/*.js'], gulp.series('js'));
});

const watchers = gulp.parallel(['watch-styles', 'watch-js']);

const prebuild = gulp.series('copy-fontawesome');


gulp.task('watch', watchers);

gulp.task('build', gulp.series( prebuild, gulp.parallel(['styles', 'js']) ));

gulp.task('default', gulp.parallel(['build', 'watch']));

"use strict";

const gulp = require('gulp');
const gulpsass = require('gulp-sass');
const cssnano = require('cssnano');
const autoprefixer = require('gulp-autoprefixer');
const sassglob = require('gulp-sass-glob');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');


const webpack = require('webpack-stream');


gulp.task('js', () => {
	return gulp.src('src/js/main.js')
		.pipe(webpack( require('./webpack.config.js') ))
		.pipe(gulp.dest('./build'));
});

gulp.task('styles', () => {
	return gulp.src('src/styles/site.scss')
		.pipe(sassglob())
		.pipe(gulpsass({
			includePaths: [
				'node_modules/foundation-sites/scss/'
			]
		}))
		.pipe(autoprefixer())
		.pipe(gulp.dest('./build'));
});

gulp.task('watch-styles', () => {
	return gulp.watch(['src/styles/**/*.scss'], gulp.series('styles'));
});

gulp.task('watch-js', () => {
	return gulp.watch(['src/js/**/*.js'], gulp.series('js'));
});

gulp.task('watch', gulp.parallel(['watch-styles', 'watch-js']))

gulp.task('default', gulp.parallel(['styles', 'js', 'watch-styles', 'watch-js']))

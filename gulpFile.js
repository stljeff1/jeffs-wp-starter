"use strict";

const gulp = require('gulp');
const gulpsass = require('gulp-sass');
const cssnano = require('cssnano');
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');

gulp.task('styles', () => {
	return gulp.src(['src/styles/main.scss'])
		.pipe(gulpsass())
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('./build'));
});


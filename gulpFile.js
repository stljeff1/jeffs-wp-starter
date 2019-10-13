"use strict";

const gulp = require('gulp');
const gulpsass = require('gulp-sass');
const cssnano = require('cssnano');
const autoprefixer = require('gulp-autoprefixer');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');

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


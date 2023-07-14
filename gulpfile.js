const gulp = require( 'gulp' );
const zip = require( 'gulp-zip' );

function bundle() {
	return gulp
		.src([
			'./app/**/*',
			'./vendor/**/*',
			'newsletter.php',
		], { base: '.' })
		.pipe( zip( 'newsletter.zip' ) )
		.pipe( gulp.dest( 'bundle' ) );
}

exports.bundle = bundle;

var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var contains = require('gulp-contains');

gulp.task('check-php-shorthand', (done) => {
	gulp.src('**/*.php')
		.pipe(contains({
			search: /<\?(?!=|php)/,
			onFound: function(string, file, cb) {
				console.log('Found PHP short open tag (<?) in ' + file.path);
				return false;
			}
		}));
	browserSync.reload();
	done();
});

gulp.task('browser-sync', (done) => {
	browserSync.init({
		injectChanges: false,
		proxy        : 'https://checkmijnkenteken.local',
		startPath	 : '/',
		notify       : false,
		https        : true,
		open 			 : true,
		browser		 : "google chrome",
		reloadOnRestart: true,
		port			 : 3000,
		ui: {
			port: 3001
		},
		ghostMode    : {
			clicks: false,
			scroll: false,
			links : false,
			forms : false
		},
		reloadDelay  : 0,
		// watchOptions : {
		// 	debounceDelay: 10
		// }
	});
	done();
});

gulp.task('watch', (done) => {
	gulp.watch('**/*.php', { delay: 100 }, gulp.series( ['check-php-shorthand']) );
	done();
});

gulp.task('default', gulp.series( ['check-php-shorthand', 'watch', 'browser-sync'] ) );

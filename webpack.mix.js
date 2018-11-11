const Mix = require('laravel-mix');
const Path = require('path');

let src = (relPath) => Path.resolve(__dirname, 'resources/assets/src/', relPath),
	dist = (relPath) => Path.resolve(__dirname, 'dist/', relPath);

// Use window version of jQuery.
Mix.webpackConfig({
	externals: {
		"jquery": "jQuery"
	}
});

// Setup Laravel Mix.
Mix.setPublicPath('dist');
Mix.setResourceRoot('../');
Mix.options({ processCssUrls: false });

Mix.sass(src('sass/style.scss'), dist('css'));
Mix.js(src('scripts/theme.js'), dist('scripts'));
Mix.copyDirectory(src('images'), dist('images'));

if (!Mix.inProduction()) {
	// Include sourcemaps.
	Mix.webpackConfig({
		devtool: 'source-map'
	});
	Mix.sourceMaps();
} else {
	// Append unique version ID to cache-bust production assets.
	Mix.version();
}

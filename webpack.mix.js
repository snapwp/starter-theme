const Mix = require('laravel-mix');
const Path = require('path');

let src = (relPath) => Path.resolve(__dirname, 'resources/assets/src/', relPath),
	public = (relPath) => Path.resolve(__dirname, 'public/', relPath);

// Use window version of jQuery.
Mix.webpackConfig({
	externals: {
		"jquery": "jQuery"
	}
});

// Setup Laravel Mix.
Mix.setPublicPath('public');
Mix.setResourceRoot('../');
Mix.options({ processCssUrls: false });

Mix.sass(src('sass/style.scss'), public('css'));
Mix.js(src('scripts/theme.js'), public('scripts'));
Mix.copyDirectory(src('images'), public('images'));

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

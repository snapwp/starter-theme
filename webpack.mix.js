const mix = require('laravel-mix');
const path = require('path');

let src = (relPath) => path.resolve(__dirname, 'resources/assets/src/', relPath),
	dist = (relPath) => path.resolve(__dirname, 'dist/', relPath);

mix.webpackConfig({
	externals: {
		"jquery": "jQuery"
	}
});

mix
	.setPublicPath('dist')
	.setResourceRoot('../')
	.options({ processCssUrls: false })
	.sass(src('sass/style.scss'), dist('css'))
	.copyDirectory(src('images'), dist('images'))
	.js(src('scripts/theme.js'), dist('scripts'))
	.version();

if (mix.inProduction()) {
	mix
		.options({ processCssUrls: false });
} else {
	mix
		.webpackConfig({
			devtool: 'source-map'
		})
		.sourceMaps();
}

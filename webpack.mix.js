const mix = require('laravel-mix')
const path = require('path');

let src = (relPath) => path.resolve(__dirname, 'resources/assets/', relPath),
	dist = (relPath) => path.resolve(__dirname, 'public/', relPath);

mix
	.setPublicPath('public')
	.setResourceRoot('../')
	.js(src('scripts/theme.js'), dist('scripts'))
	.sass(src('sass/style.scss'), dist('css'))
	.options({
		postCss: [
			require("tailwindcss"),
		],
	})
	.version()

mix.webpackConfig({
	externals: {
		"jquery": "jQuery"
	}
})

if (!mix.inProduction()) {
	// Include separate source maps in development builds.
	mix
		.webpackConfig({ devtool: 'cheap-module-source-map' })
		.sourceMaps()
}
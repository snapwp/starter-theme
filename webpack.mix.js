const mix = require('laravel-mix');
const path = require('path');

let src = (relPath) => path.resolve(__dirname, 'resources/assets/', relPath),
    dist = (relPath) => path.resolve(__dirname, 'public/', relPath);

// If you are using jQuery via CDN, let webpack know.
mix.webpackConfig({
    externals: {
        "jquery": "jQuery"
    }
});

// Set some basic options.
mix.setPublicPath('public')
    .setResourceRoot('../');

mix.js(src('scripts/theme.js'), dist('scripts'))

	// Run SASS compilation using node-sass.
    .sass(src('sass/style.scss'), dist('css'))

    // Copy any images from resources to public.
    .copyDirectory(src('images/placeholders'), dist('images/placeholders'))

    // Append version strings in mix-manifest.
    .version();

if (!mix.inProduction()) {
    // Include separate source maps in development builds.
    mix.webpackConfig({
        devtool: 'source-map'
    });

    mix.sourceMaps();
}

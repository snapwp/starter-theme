import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin } from '@roots/vite-plugin'
const path = require('path')

let rootDir = path.normalize(__dirname.substring(__dirname.match(/wp-content/)['index'] -1)).split(path.sep).join("/")

export default defineConfig({
	base: process.env.NODE_ENV === 'production' ? `${rootDir}/public/` : '/',
	build: {
		// laravel-vite-plugin defaults to Laravel's public/build layout;
		// override manifest/outDir/assetsDir to match Snap's expected paths
		// (config/assets.php -> manifest_path: '/public/manifest.json').
		manifest: 'manifest.json',
		emptyOutDir: true,
		outDir: 'public',
		assetsDir: 'build',
	},
	plugins: [
		laravel({
			input: [
				'resources/assets/js/theme.js',
				'resources/assets/css/main.css',
				'resources/assets/css/editor.css'
			],
			publicDirectory: 'public',
			buildDirectory: 'build',
			refresh: true,
		}),
		tailwindcss(),
		wordpressPlugin(),
	],
	server: {
		cors: true,
		strictPort: true,
		port: 3000
	}
})
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin } from '@roots/vite-plugin'
import { readdirSync } from 'node:fs'
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
				'resources/assets/css/editor.css',
				// Every image, so Blade can link the hashed build files via theme_asset() (theme/helpers.php).
				// Read once at startup: restart `npm run build-watch` / `npm run dev` after adding images.
				...readdirSync('resources/assets/images', { recursive: true })
					.filter(f => /\.(svg|png|jpe?g|webp|avif|gif)$/i.test(f))
					// Inserter previews are embedded straight from resources/ by Gutenberg.php
					.filter(f => !f.startsWith(`block-previews${path.sep}`))
					.map(f => `resources/assets/images/${f.split(path.sep).join('/')}`),
			],
			publicDirectory: 'public',
			buildDirectory: 'build',
			refresh: true,
		}),
		tailwindcss(),
		wordpressPlugin(),
	],
	server: {
		// IPv4 on purpose: with the default host, Node on Windows binds to ::1 and the hot file becomes
		// http://[::1]:3000. TinyMCE 4 can't parse IPv6 URLs, so the editor stylesheet (Gutenberg.php
		// registerEditorStyle) became http://[:1]:3000, never loaded, and every ACF WYSIWYG stopped saving.
		host: '127.0.0.1',
		cors: true,
		strictPort: true,
		port: 3000
	}
})
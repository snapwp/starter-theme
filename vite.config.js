import { defineConfig } from 'vite'
import snap from './vite.plugin'
const path = require('path')

let rootDir = path.normalize(__dirname.substring(__dirname.match(/wp-content/)['index'] -1)).split(path.sep).join("/")

export default defineConfig({
	base: process.env.NODE_ENV === 'production' ? `${rootDir}/public/` : '/',
	publicDir: 'resources/public',
	build: {
		manifest: true,
		emptyOutDir: true,
		outDir: 'public',
		assetsDir: 'build',
		rollupOptions: {
			input: {
				js: 'resources/assets/scripts/theme.js',
				styles: 'resources/assets/sass/style.scss'
			}
		}
	},
	plugins: [snap()],
	server: {
		cors: true,
		strictPort: true,
		port: 3000
	}
})
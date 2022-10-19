import { defineConfig } from 'vite'
import snap from './vite.plugin'

export default defineConfig({
	base: process.env.NODE_ENV === 'production' ? `/wp-content/themes/starter-theme/public/` : '/', // todo
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
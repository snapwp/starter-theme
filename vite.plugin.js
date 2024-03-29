import path from 'path'
import fs from 'fs'

/**
 * A small plugin to help snap know when the vite dev server is running.
 * Based off laravel-vite-plugin npm package
 */
export default function snap() {
	return {
		name: 'snap-vite',

		configureServer(server) {
			if (!fs.existsSync(server.config.build.outDir)) {
				fs.mkdirSync(server.config.build.outDir, { recursive: true })
			}

			const hotPath = path.join(server.config.build.outDir, 'hot')

			server.httpServer?.once('listening', () => {
				setTimeout(() => {
					const urls = server.resolvedUrls
					let hotUrl = urls.local[0]
					if (urls.network.length) {
						hotUrl = urls.network[0]
					}
					fs.writeFileSync(hotPath, hotUrl)
				}, 100)
			})

			let exitHandlersBound

			if (!exitHandlersBound) {
				const clean = () => {
					if (fs.existsSync(hotPath)) {
						fs.rmSync(hotPath)
					}
				}

				process.on('exit', clean)
				process.on('SIGINT', process.exit)
				process.on('SIGTERM', process.exit)
				process.on('SIGHUP', process.exit)

				exitHandlersBound = true
			}

			return () => server.middlewares.use((req, res, next) => {
				next()
			})
		}
	}
}

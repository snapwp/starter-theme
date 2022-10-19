import path from 'path'
import fs from 'fs'

/**
 * A small plugin to help snap know when the vite dev server is running.
 * Based off laravel-vite-plugin npm package
 */
export default function snap() {
	function resolveDevServerUrl(address, config) {
		const configHmrProtocol = typeof config.server.hmr === 'object' ? config.server.hmr.protocol : null
		const clientProtocol = configHmrProtocol ? (configHmrProtocol === 'wss' ? 'https' : 'http') : null
		const serverProtocol = config.server.https ? 'https' : 'http'
		const protocol = clientProtocol ?? serverProtocol

		const configHmrHost = typeof config.server.hmr === 'object' ? config.server.hmr.host : null
		const configHost = typeof config.server.host === 'string' ? config.server.host : null
		const serverAddress = isIpv6(address) ? `[${address.address}]` : address.address
		const host = configHmrHost ?? configHost ?? serverAddress

		const configHmrClientPort = typeof config.server.hmr === 'object' ? config.server.hmr.clientPort : null
		const port = configHmrClientPort ?? address.port

		return `${protocol}://${host}:${port}`
	}

	function isIpv6(address) {
		return address.family === 'IPv6' || address.family === 6;
	}

	return {
		name: 'snap-vite',

		configureServer(server) {
			const hotPath = path.join(server.config.build.outDir, 'hot')

			server.httpServer?.once('listening', () => {
				const address = server.httpServer?.address()

				const isAddressInfo = (x) => typeof x === 'object'
				if (isAddressInfo(address)) {
					const viteDevServerUrl = resolveDevServerUrl(address, server.config)
					fs.writeFileSync(hotPath, viteDevServerUrl)
				}
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

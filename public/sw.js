const SW_VERSION = 'portfolio-sw-v1';
const APP_SHELL_CACHE = `${SW_VERSION}-app-shell`;
const RUNTIME_CACHE = `${SW_VERSION}-runtime`;
const OFFLINE_URL = '/offline.html';
const MANIFEST_URL = '/build/manifest.json';

const CORE_ASSETS = [
	'/',
	OFFLINE_URL,
	'/manifest.webmanifest',
	'/favicon.ico',
	'/icons/icon-192.svg',
	'/icons/icon-512.svg',
	'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Sora:wght@400;600;700&display=swap',
];

self.addEventListener('install', (event) => {
	event.waitUntil(
		(async () => {
			const cache = await caches.open(APP_SHELL_CACHE);
			await cache.addAll(CORE_ASSETS);

			try {
				const manifestResponse = await fetch(MANIFEST_URL, { cache: 'no-store' });
				if (manifestResponse.ok) {
					const viteManifest = await manifestResponse.json();
					const assetUrls = new Set();

					Object.values(viteManifest).forEach((entry) => {
						if (entry.file) {
							assetUrls.add(`/build/${entry.file}`);
						}

						if (Array.isArray(entry.css)) {
							entry.css.forEach((cssFile) => assetUrls.add(`/build/${cssFile}`));
						}
					});

					await cache.addAll(Array.from(assetUrls));
				}
			} catch {
				// App shell core cache still works even when build manifest fetch fails.
			}

			await self.skipWaiting();
		})()
	);
});

self.addEventListener('activate', (event) => {
	event.waitUntil(
		(async () => {
			const keys = await caches.keys();
			await Promise.all(
				keys
					.filter((key) => ![APP_SHELL_CACHE, RUNTIME_CACHE].includes(key))
					.map((key) => caches.delete(key))
			);

			await self.clients.claim();
		})()
	);
});

self.addEventListener('fetch', (event) => {
	const { request } = event;

	if (request.method !== 'GET') {
		return;
	}

	if (request.mode === 'navigate') {
		event.respondWith(
			(async () => {
				try {
					const networkResponse = await fetch(request);
					const cache = await caches.open(RUNTIME_CACHE);
					cache.put(request, networkResponse.clone());
					return networkResponse;
				} catch {
					const cachedPage = await caches.match(request);
					if (cachedPage) {
						return cachedPage;
					}

					return caches.match(OFFLINE_URL);
				}
			})()
		);
		return;
	}

	const destination = request.destination;
	const isShellAsset = ['style', 'script', 'font'].includes(destination);
	const isGoogleFontsRequest = request.url.startsWith('https://fonts.googleapis.com') || request.url.startsWith('https://fonts.gstatic.com');

	if (isShellAsset || isGoogleFontsRequest) {
		event.respondWith(
			(async () => {
				const cached = await caches.match(request);
				if (cached) {
					return cached;
				}

				try {
					const networkResponse = await fetch(request);
					const cache = await caches.open(RUNTIME_CACHE);
					cache.put(request, networkResponse.clone());
					return networkResponse;
				} catch {
					return caches.match(OFFLINE_URL);
				}
			})()
		);
	}
});

const CACHE_NAME = 'lanjo-pwa-v5';
const OFFLINE_URL = '/offline.html';
const urlsToCache = [
    '/images/icon-192x192.png',
    '/images/icon-512x512.png',
    '/images/pwa-icon.svg',
    '/manifest.json',
    OFFLINE_URL
];

self.addEventListener('install', event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                // Use Promise.all with individual catch blocks to ensure one missing file doesn't break the whole SW installation
                return Promise.all(
                    urlsToCache.map(url => {
                        return cache.add(url).catch(error => {
                            console.error('Failed to cache:', url, error);
                        });
                    })
                );
            })
    );
});

self.addEventListener('fetch', event => {
    // Only intercept GET requests
    if (event.request.method !== 'GET') return;
    
    event.respondWith(
        fetch(event.request).catch(() => {
            return caches.match(event.request).then(response => {
                if (response) {
                    return response;
                }
                // If it's a page navigation request, return the offline fallback
                if (event.request.mode === 'navigate') {
                    return caches.match(OFFLINE_URL);
                }
                return undefined;
            });
        })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(self.clients.claim());
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

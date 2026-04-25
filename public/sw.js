const CACHE_NAME = "vda-v1";

const urlsToCache = [
    "/",
    "/offline",
];

// INSTALL
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

// ACTIVATE (nettoyage ancien cache)
self.addEventListener("activate", event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            );
        })
    );
});

// FETCH (mode intelligent)
self.addEventListener("fetch", event => {

    // Pour les requêtes HTML
    if (event.request.mode === "navigate") {
        event.respondWith(
            fetch(event.request)
                .catch(() => caches.match("/offline"))
        );
        return;
    }

    // Pour images / assets
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
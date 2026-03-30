"use strict";

var CACHE_STATIC_NAME = 'static-v27';

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_STATIC_NAME)
      .then((cache) => {
        return cache.addAll([
          '/offline',
          '/assets/pwa/offline.png',
        ]).catch(error => {
          
        });
      })
  );
});

self.addEventListener('activate', function (event) {
 
  event.waitUntil(
    caches.keys()
      .then(function (keyList) {
        return Promise.all(keyList.map(function (key) {
          if (key !== CACHE_STATIC_NAME) {
        
            return caches.delete(key);
          }
        }));
      })
  );
  return self.clients.claim();
});
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {
        if (response) {
          return response;
        } else {
          return fetch(event.request)
            .catch(function (err) {
              return caches.open(CACHE_STATIC_NAME)
                .then(function (cache) {
                  return cache.match('/offline');
                });
            });
        }
      })
  );
});
self.addEventListener('push', function (e) {
  if (!(self.Notification && self.Notification.permission === 'granted')) {
  
    return;
  }
  if (e.data) {
    var msg = e.data.json();
    
    var options = {
      body: msg.body,
      icon: msg.icon
    };
    if (msg.actions && msg.actions.length > 0) {
      options.actions = msg.actions;
    }
    e.waitUntil(self.registration.showNotification(msg.title, options));
  }
});
self.addEventListener('notificationclick', function (e) {
  if (e.action.length > 0) {
    self.clients.openWindow(e.action);
  }
});

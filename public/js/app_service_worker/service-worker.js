// // Copyright 2016 Google Inc.
// // 
// // Licensed under the Apache License, Version 2.0 (the "License");
// // you may not use this file except in compliance with the License.
// // You may obtain a copy of the License at
// // 
// //      http://www.apache.org/licenses/LICENSE-2.0
// // 
// // Unless required by applicable law or agreed to in writing, software
// // distributed under the License is distributed on an "AS IS" BASIS,
// // WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// // See the License for the specific language governing permissions and
// // limitations under the License.

// var dataCacheName = 'newsData-v1';
// var cacheName = 'newsPWA-final-1';
// var filesToCache = [
//   /*'/PWA_DEMO',
//   '/PWA_DEMO/index.html',
//   '/PWA_DEMO/scripts/app.js',
//   '/PWA_DEMO/styles/inline.css',
//   '/PWA_DEMO/images/ic_add_white_24px.svg',
//   '/PWA_DEMO/images/ic_refresh_white_24px.svg'*/
// ];

// self.addEventListener('push', function(event) {
//   var data = event.data;

//   // if(data.trigger_date!=null || data.trigger_date!='undefined'){

//   //   var trigger_date=data.trigger_date;
//   //   var todo_id=data.todo_id;
//   //   var reminder_id=data.reminder_id;
//   // }

//   // if(data.snooze_id!=null || data.snooze_id!='undefined'){

//   // var snooze_id = data.snooze_id;
//   // var user_id = data.user_id;
//   // var employee_id = data.employee_id;
//   // var snooze_time = data.snooze_time;
//   // }

//   snooze_id="sss";

//   var snooze_id=data.snooze_id;
  
//    var pushData = null;
//    if(data.data){
//      pushData = data.data;
//  }

//    var body = {
//     'body': data.message,
//      'data': pushData,
//      'tag': 'Meetkpi',
//    };

//    console.log(snooze_id);

//   self.clients.matchAll().then(all => all.map(client => client.postMessage(data)));

 
// });


// self.addEventListener('install', function(e) {
//   console.log('[ServiceWorker] Install');
//   e.waitUntil(
//     caches.open(cacheName).then(function(cache) {
//       console.log('[ServiceWorker] Caching app shell');
//       return cache.addAll(filesToCache);
//     })
//   );
// });

// self.addEventListener('notificationclick', function(event) {
//   console.log('On notification click: ', event.notification.tag);
//   event.notification.close();
//   // This looks to see if the current is already open and
//   // focuses if it is
//   console.log(event);
//   event.waitUntil(clients.matchAll({
//     type: "window"
//   }).then(function(clientList) {
//     for (var i = 0; i < clientList.length; i++) {
//       var client = clientList[i];
//       if (client.url == '/' && 'focus' in client)
//         return client.focus();
//     }
//     console.log(event.notification);
//     if (clients.openWindow)
//         if(event.notification.data == null){
//           return clients.openWindow('/?blockType=showMessage&message=' + event.notification.body);
//       }else{
//         return clients.openWindow('/?' + event.notification.data.query);
//       }
//   }));
// });

// self.addEventListener('activate', function(e) {
//   console.log('[ServiceWorker] Activate');
//   e.waitUntil(
//     caches.keys().then(function(keyList) {
//       return Promise.all(keyList.map(function(key) {
//         if (key !== cacheName && key !== dataCacheName) {
//           console.log('[ServiceWorker] Removing old cache', key);
//           return caches.delete(key);
//         }
//       }));
//     })
//   );
//   /*
//    * Fixes a corner case in which the app wasn't returning the latest data.
//    * You can reproduce the corner case by commenting out the line below and
//    * then doing the following steps: 1) load app for first time so that the
//    * initial New York City data is shown 2) press the refresh button on the
//    * app 3) go offline 4) reload the app. You expect to see the newer NYC
//    * data, but you actually see the initial data. This happens because the
//    * service worker is not yet activated. The code below essentially lets
//    * you activate the service worker faster.
//    */
//   return self.clients.claim();
// });

// self.addEventListener('fetch', function(e) {
//   console.log('[Service Worker] Fetch', e.request.url);
//   var dataUrl = 'http://localhost:8888/PWA_DEMO/news.json';
  
//   if (e.request.url.indexOf(dataUrl) > -1) {
//     /*
//      * When the request URL contains dataUrl, the app is asking for fresh
//      * weather data. In this case, the service worker always goes to the
//      * network and then caches the response. This is called the "Cache then
//      * network" strategy:
//      * https://jakearchibald.com/2014/offline-cookbook/#cache-then-network
//      */
//     e.respondWith(
//       caches.open(dataCacheName).then(function(cache) {
//         return fetch(e.request).then(function(response){
//           cache.put(e.request.url, response.clone());
//           return response;
//         });
//       })
//     );
//   } else {
//     /*
//      * The app is asking for app shell files. In this scenario the app uses the
//      * "Cache, falling back to the network" offline strategy:
//      * https://jakearchibald.com/2014/offline-cookbook/#cache-falling-back-to-network
//      */
//     e.respondWith(
//       caches.match(e.request).then(function(response) {
//         return response || fetch(e.request);
//       })
//     );
//   }
// });





self.addEventListener('push', function(event) {
  if (event.data) {
    var data = event.data.json();
    self.registration.showNotification(data.title,{
      body: data.body,
      icon: data.icon
    });
    console.log('This push event has data: ', event.data.text());
  } else {
    console.log('This push event has no data.');
  }
});
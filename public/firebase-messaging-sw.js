importScripts("https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js");
// importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js');
// importScripts('https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js');

// Initialize the Firebase app in the service worker
firebase.initializeApp({
    messagingSenderId: self.registration.scope, // Use the sender ID passed from the front-end
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    // console.log('[firebase-messaging-sw.js] Received background message ', payload.data.title);
    // Customize notification here

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        image: payload.notification.image,
        icon: payload.data.logo, //your logo here
        data: {
            time: new Date(Date.now()).toString(),
            click_action: payload.data.click_action,
        },
    };

    //   const notificationTitle = 'Background Message Title';
    // const notificationOptions = {
    //     body: 'Background Message body.',
    //     icon: 'https://jyotishmuni.com/uploads/setting/67321.png' //your logo here
    // };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});

self.addEventListener("notificationclick", function (event) {
    console.log(event);
    var action_click = event.notification.data.click_action;
    // event.notification.close();

    event.waitUntil(clients.openWindow(action_click));
});

// self.addEventListener('notificationclick', function(event) {
//     event.notification.close();
//     var action_click = event.notification.data.click_action;

//     const myPromise = new Promise(function(resolve, reject) {
//         // Do you work here
//         clients.openWindow(action_click)
//         // Once finished, call resolve() or  reject().
//         resolve();
//     });

//     event.waitUntil(myPromise);
// });

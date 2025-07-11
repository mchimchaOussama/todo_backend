// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// /**
//  * Echo exposes an expressive API for subscribing to channels and listening
//  * for events that are broadcast by Laravel. Echo and event broadcasting
//  * allow your team to quickly build robust real-time web applications.
//  */
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//   key: import.meta.env.VITE_PUSHER_APP_KEY,
//   cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
// });
// import './echo';
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Only initialize Echo if we have the required environment variables
if (import.meta.env.VITE_PUSHER_APP_KEY && import.meta.env.VITE_PUSHER_APP_CLUSTER) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true,
        wsHost: 'ws-mt1.pusher.com',
        wsPort: 443,
        wssPort: 443,
        disableStats: true,
        enabledTransports: ['ws', 'wss'],
        authEndpoint: import.meta.env.VITE_API_URL + '/broadcasting/auth',
        auth: {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }
    });
}
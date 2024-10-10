import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
});

// Replace any occurrences of process.env with import.meta.env
// For example:
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.baseURL = process.env.APP_URL;
window.axios.defaults.baseURL = import.meta.env.VITE_APP_URL;

// Initialize Echo only if the user is authenticated
if (document.querySelector('meta[name="user-id"]')) {
    const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');
    window.Echo.private(`notifications.${userId}`)
        .listen('.new.notification', (e) => {
            console.log('New notification:', e.notification);
            // Implement your notification handling logic here
        });
}

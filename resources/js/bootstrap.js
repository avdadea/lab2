import Echo from 'laravel-echo';

// Import Laravel Echo and Pusher at the top of the file

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// Subscribe to the 'chat' channel and listen for the 'MessageSent' event
Echo.channel('chat')
    .listen('.MessageSent', (e) => {
        console.log('New message received:', e.message);
        // Handle the received message here
    });

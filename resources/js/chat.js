// Configuración de Pusher
const pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Suscripción al canal de chat
const channel = pusher.subscribe('chat-channel');

// Actualizar estado de usuario online
function updateOnlineStatus() {
    fetch('/chat/update-last-seen', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
}

// Actualizar cada minuto
setInterval(updateOnlineStatus, 60000);

// Escuchar nuevos mensajes
channel.bind('new-message', function(data) {
    const chatWidget = document.querySelector('[x-data]').__x;
    
    if (chatWidget.selectedChat === data.message.from || chatWidget.selectedChat === data.message.to) {
        chatWidget.loadMessages();
    }
});

// Cargar usuarios online
async function loadOnlineUsers() {
    const response = await fetch('/chat/online-users');
    const users = await response.json();
    
    const chatWidget = document.querySelector('[x-data]').__x;
    chatWidget.onlineUsers = users;
}

// Actualizar lista de usuarios online cada 30 segundos
setInterval(loadOnlineUsers, 30000); 
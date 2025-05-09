// Actualizar estado de usuario online
function updateOnlineStatus() {
    fetch('/chatify/update-last-seen', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
}

// Actualizar cada minuto
setInterval(updateOnlineStatus, 60000);

// Cargar usuarios online
async function loadOnlineUsers() {
    const response = await fetch('/chatify/online-users');
    const users = await response.json();
    
    const chatWidget = document.querySelector('[x-data]').__x;
    if (chatWidget) {
        chatWidget.onlineUsers = users;
    }
}

// Actualizar lista de usuarios online cada 30 segundos
setInterval(loadOnlineUsers, 30000); 
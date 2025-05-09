@props(['onlineUsers' => []])

<div x-data="{ 
    isOpen: false,
    selectedChat: null,
    onlineUsers: @json($onlineUsers),
    
    init() {
        // Cargar usuarios online al iniciar
        this.loadOnlineUsers();
    },
    
    async loadOnlineUsers() {
        const response = await fetch('/chatify/online-users');
        this.onlineUsers = await response.json();
    },
    
    openChat(userId) {
        // Redirigir a la conversación de Chatify
        window.location.href = `/chatify/${userId}`;
    }
}" class="fixed bottom-4 right-4 z-50">
    <!-- Botón flotante -->
    <button 
        @click="isOpen = !isOpen"
        class="bg-blue-500 hover:bg-blue-600 text-white rounded-full p-4 shadow-lg transition-all duration-300"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>

    <!-- Panel de chat -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute bottom-16 right-0 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl"
    >
        <!-- Lista de usuarios online -->
        <div class="p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Amigos Conectados</h3>
            <div class="space-y-2">
                <template x-for="user in onlineUsers" :key="user.id">
                    <button 
                        @click="openChat(user.id)"
                        class="flex items-center space-x-2 w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                    >
                        <div class="relative">
                            <img :src="user.avatar" class="w-10 h-10 rounded-full">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></div>
                        </div>
                        <span class="text-gray-800 dark:text-white" x-text="user.name"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Botón para ver todos los chats -->
        <div class="p-4">
            <a href="/chatify" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-4 py-2 transition-colors">
                Ver todos los chats
            </a>
        </div>
    </div>
</div> 
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Sugerencias de Amigos</h3>
    
    {{-- Barra de búsqueda --}}
    <div class="mb-4">
        <input type="text" 
               wire:model.live="searchTerm" 
               placeholder="Buscar usuarios..." 
               class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- Lista de sugerencias --}}
    <div class="space-y-4">
        @forelse($suggestions as $user)
            <div class="flex items-center justify-between p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/profiles/' . $user->profile) }}" 
                         alt="{{ $user->username }}" 
                         class="w-10 h-10 rounded-full">
                    <div>
                        <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            @{{ $user->username }}
                        </p>
                    </div>
                </div>
                <button wire:click="sendFriendRequest({{ $user->id }})"
                        class="px-3 py-1 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                    Agregar
                </button>
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                No hay sugerencias disponibles
            </p>
        @endforelse
    </div>
</div> 
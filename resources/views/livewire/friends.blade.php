<div class="container px-6 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Lista de amigos --}}
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Mis Amigos</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($friends as $friend)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <img src="{{ asset('images/profiles/' . $friend->profile) }}" 
                                 alt="{{ $friend->username }}" 
                                 class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ $friend->first_name }} {{ $friend->last_name }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    @{{ $friend->username }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">
                                No tienes amigos aún. ¡Agrega algunos!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sugerencias de amigos --}}
        <div class="md:col-span-1">
            <livewire:components.friend-suggestions />
        </div>
    </div>
</div> 
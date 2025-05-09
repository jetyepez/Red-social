{{-- Menú lateral --}}
<div class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-gray-800 shadow-lg transform transition-transform duration-300 ease-in-out z-50 {{ $isOpen ? 'translate-x-0' : '-translate-x-full' }}">
    <div class="h-full overflow-y-auto">
        <div class="p-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Leander</h2>

            {{-- Menú Principal --}}
            <div class="space-y-6">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Inicio
                    </a>
                </div>

                @if(auth()->user()->role === 'admin')
                    {{-- Botón para ir al Panel de Control --}}
                    <div>
                        <a href="{{ route('admin') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Panel de Control
                        </a>
                    </div>
                @endif

                {{-- Menú de usuario --}}
                <div>
                    <a href="{{ route('profile.show', auth()->user()->username) }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Mi Perfil
                    </a>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Grupos</h3>
                    <ul class="space-y-2 pl-2">
                        <li>
                            <a href="{{ route('squads') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Grupos Públicos</a>
                        </li>
                        <li>
                            <a href="{{ route('my-squads') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Mis Grupos</a>
                        </li>
                        <li>
                            <a href="{{ route('create-squad') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Nuevo Grupo</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Canales</h3>
                    <ul class="space-y-2 pl-2">
                        <li>
                            <a href="{{ route('channels') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Canales Públicos</a>
                        </li>
                        <li>
                            <a href="{{ route('my-channels') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Mis Canales</a>
                        </li>
                        <li>
                            <a href="{{ route('create-channel') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Nuevo Canal</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Comunicación</h3>
                    <ul class="space-y-2 pl-2">
                        <li>
                            <a href="{{ route('chat') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Chat</a>
                        </li>
                        <li>
                            <a href="{{ route('notification') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Notificaciones</a>
                        </li>
                        <li>
                            <a href="{{ route('friends') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Amigos</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-2">Gestionar</h3>
                    <ul class="space-y-2 pl-2">
                        <li>
                            <a href="{{ route('profile.show', auth()->user()->username) }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Perfil</a>
                        </li>
                        <li>
                            <a href="{{ route('save-posts') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-500">Publicaciones Guardadas</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

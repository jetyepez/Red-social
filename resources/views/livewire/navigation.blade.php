@php
    $notifications = auth()->check() ? App\Models\Notification::where('user_id', auth()->id())
        ->whereNull('read_at')
        ->orderBy('created_at', 'desc')
        ->get() : collect();
@endphp

<header class="z-10 py-4 bg-blue-100 shadow-md dark:bg-blue-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto">
        <!-- Logo -->
        <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-blue-800 dark:text-blue-200">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Leander" width="40" height="auto" class="mb-2">
                </a>
        </div>

        <!-- Mobile hamburger -->
        <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-blue"
            @click="toggleSideMenu" aria-label="Menu">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}" class="flex items-center text-blue-700 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Inicio
            </a>
            @auth
                <a href="{{ route('friends') }}" class="flex items-center text-blue-700 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Amigos
                </a>
                <a href="{{ route('channels') }}" class="flex items-center text-blue-700 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Canales
                </a>
                <a href="{{ route('squads') }}" class="flex items-center text-blue-700 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Squads
                </a>
            @endauth
        </nav>

        <!-- Right Side Menu -->
        <ul class="flex items-center space-x-6">
            @auth
                <!-- New Post Button -->
                <li class="flex">
                    @if (auth()->user()->banned_to > now('Asia/Yangon'))
                        <div class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg">
                            Nueva Publicación
                        </div>
                    @else
                        <a href="{{ route('create-post') }}">
                            <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nueva Publicación
                            </button>
                        </a>
                    @endif
                </li>

                <!-- Notifications -->
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            @keydown.escape.window="open = false"
                            @click.away="open = false"
                            class="flex items-center text-blue-700 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if($notifications && count($notifications) > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count($notifications) }}
                            </span>
                        @endif
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 w-96 mt-2 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50"
                         style="display: none; width: 32rem;">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-sm font-semibold">Notificaciones</h3>
                            @if(count($notifications) > 0)
                                <a href="{{ route('mark-all-as-read') }}" class="text-xs text-blue-500 hover:underline">Marcar todas como leídas</a>
                            @endif
                        </div>
                        <div class="max-h-[600px] overflow-y-auto">
                            @forelse($notifications as $notification)
                                @php
                                    $senderName = strtok($notification->message, ' ');
                                    $notificationFrom = App\Models\User::where('username', $senderName)->first();
                                @endphp
                                @if($notificationFrom !== null)
                                    <a href="{{ url($notification->url) }}" class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md">
                                        <img src="{{ asset('storage/images/profiles/' . $notificationFrom->profile) }}" alt="Avatar"
                                            class="w-8 h-8 rounded-full mr-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notification->type }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('mark-as-read', $notification->id) }}" class="text-xs text-blue-500 hover:underline ml-2">
                                            Marcar como leída
                                        </a>
                                    </a>
                                @endif
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No hay notificaciones nuevas</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('notification') }}" class="block text-center text-sm text-blue-500 hover:underline">
                                Ver todas las notificaciones
                            </a>
                        </div>
                    </div>
                </li>

                <!-- Theme toggler -->
               

                <!-- Profile Menu -->
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            @keydown.escape.window="open = false"
                            @click.away="open = false"
                            class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none">
                        <img class="object-cover w-8 h-8 rounded-full"
                             src="{{ auth()->user()->profile ? asset('storage/images/profiles/' . auth()->user()->profile) : asset('images/default-avatar.png') }}"
                             alt="{{ auth()->user()->first_name }}" aria-hidden="true" />
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 w-64 mt-2 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50"
                         style="display: none;">
                        <!-- User Info -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-3">
                                <img class="object-cover w-12 h-12 rounded-full border-2 border-white dark:border-gray-600"
                                     src="{{ auth()->user()->profile ? asset('storage/images/profiles/' . auth()->user()->profile) : asset('images/default-avatar.png') }}"
                                     alt="{{ auth()->user()->first_name }}" />
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ '@' . auth()->user()->username }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <ul>
                            <li>
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="{{ route('profile.show', auth()->user()->username) }}">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Perfil</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile-edit', auth()->user()->username) }}"
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Editar Perfil</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('save-posts') }}"
                                    class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                    </svg>
                                    <span>Guardados</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>Cerrar Sesión</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth
        </ul>
    </div>
</header>

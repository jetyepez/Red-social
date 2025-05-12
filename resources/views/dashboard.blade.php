<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de control') }}
        </h2>
    </x-slot>

    <style>
        .profile-container {
            margin-top: 50px;
            margin-bottom: 50px;
            padding: 40px;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }
        .stats-container {
            margin: 40px 0;
            padding: 0 60px;
        }
        .stats-container > div {
            padding: 0 40px;
            border-right: 1px solid #e5e7eb;
        }
        .stats-container > div:last-child {
            border-right: none;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
            margin: 40px 0;
            padding: 0 20px;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
        }
        .stats-number {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .stats-label {
            font-size: 0.875rem;
        }
        .info-card {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="profile-container shadow-lg">
                <!-- Foto de Perfil y Nombre -->
                <div class="flex flex-col items-center">
                    <img src="{{ auth()->user()->profile ? asset('storage/images/profiles/' . auth()->user()->profile) : asset('images/default-avatar.png') }}"
                        class="w-40 h-40 rounded-full border-4 border-white shadow-lg"
                        alt="Foto de perfil">
                    
                    <h1 class="text-2xl font-bold text-gray-800 mt-8 mb-4">
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    </h1>

                    <!-- Estadísticas -->
                    <div class="flex justify-center stats-container">
                        <div class="text-center">
                            <span class="block stats-number text-gray-800 mb-2">{{ auth()->user()->friends_count ?? 0 }}</span>
                            <span class="stats-label text-gray-600">Amigos</span>
                        </div>
                        <div class="text-center">
                            <span class="block stats-number text-gray-800 mb-2">{{ auth()->user()->posts_count ?? 0 }}</span>
                            <span class="stats-label text-gray-600">Publicaciones</span>
                        </div>
                        <div class="text-center">
                            <span class="block stats-number text-gray-800 mb-2">{{ auth()->user()->comments_count ?? 0 }}</span>
                            <span class="stats-label text-gray-600">Comentarios</span>
                        </div>
                    </div>
                </div>

                <!-- Información Personal -->
                <div class="mt-12">
                    <h2 class="section-title text-gray-800 mb-8 text-center">Información Personal</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if (auth()->user()->school)
                            <div class="info-card">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-gray-700">{{ auth()->user()->school }}</span>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->college)
                            <div class="info-card">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-gray-700">{{ auth()->user()->college }}</span>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->university)
                            <div class="info-card">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-gray-700">{{ auth()->user()->university }}</span>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->work)
                            <div class="info-card">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-gray-700">{{ auth()->user()->work }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

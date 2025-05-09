<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" :class="{ 'theme-dark': dark }" x-data="data()">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Elimina favicon si no existe -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png"> -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
    <!-- Alpine.js v3 solo una vez -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Elimina scripts de charts si no existen -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" /> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script> -->
    <!-- <script src="{{ asset('js/charts-lines.js') }}" defer></script> -->
    <script src="{{ asset('js/init-alpine.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="ml-0 transition-all duration-300">
            @if (Auth::check())
                @if (Auth::user()->role === 'admin')
                    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
                        @include('layouts.admin-desktop_sidebar')
                        <div class="flex flex-col flex-1 w-full">
                            @include('layouts.navigation')
                            <main class="h-full overflow-y-auto bg-blue-100 dark:bg-gray-900">
                                @if (session()->has('success'))
                                    <script>
                                        setTimeout(function() {
                                            document.querySelector('.alert').remove();
                                        }, 5000);
                                    </script>
                                    <div role="alert"
                                        class="alert w-auto absolute z-10 top-right-5 mb-2 p-2 bg-blue-600 rounded-full items-center text-green-100 leading-none lg:rounded-full flex lg:inline-flex">
                                        <span
                                            class="flex rounded-full bg-blue-500 uppercase px-2 py-1 text-xs font-bold mr-3">Operación exitosa"</span>
                                        <span class="font-semibold mr-2 text-left flex-auto">{{ session('success') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                    @php
                                        session()->forget('success');
                                    @endphp
                                @endif

                                @if (session()->has('error'))
                                    <script>
                                        setTimeout(function() {
                                            document.querySelector('.alert').remove();
                                        }, 5000);
                                    </script>
                                    <div role="alert"
                                        class="alert w-auto absolute z-10 top-right-5 mb-2 p-2 bg-red-800 rounded-full items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex">
                                        <span
                                            class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                                        <span class="font-semibold mr-2 text-left flex-auto">{{ session('error') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                    @php
                                        session()->forget('error');
                                    @endphp
                                @endif
                                @yield('content')
                            </main>
                        </div>
                    </div>
                @elseif (Auth::user()->is_private === 0)
                    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
                        @include('layouts.desktop_sidebar')
                        @include('layouts.mobile_sidebar')
                        <div class="flex flex-col flex-1 w-full">
                            @include('layouts.navigation')
                            <main class="h-full overflow-y-auto bg-blue-100 dark:bg-gray-900">
                                @if (auth()->user()->banned_to > now('Asia/Yangon'))
                                    <div
                                        class="w-auto absolute z-10 bottom-right-5 mb-2 p-2 bg-red-800 rounded-full items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex">
                                        <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Usuario Bloqueado
                                            </span>
                                        <span class="font-semibold mr-2 text-left flex-auto">Tu cuenta está bloqueada hasta
                                            {{ auth()->user()->banned_to }}</span>
                                    </div>
                                @endif
                                @if (session()->has('success'))
                                    <script>
                                        setTimeout(function() {
                                            document.querySelector('.alert').remove();
                                        }, 5000);
                                    </script>
                                    <div role="alert"
                                        class="alert w-auto absolute z-10 top-right-5 mb-2 p-2 bg-blue-600 rounded-full items-center text-green-100 leading-none lg:rounded-full flex lg:inline-flex">
                                        <span
                                            class="flex rounded-full bg-blue-500 uppercase px-2 py-1 text-xs font-bold mr-3">Operación exitosa
                                        </span>
                                        <span class="font-semibold mr-2 text-left flex-auto">{{ session('success') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                    @php
                                        session()->forget('success');
                                    @endphp
                                @endif

                                @if (session()->has('error'))
                                    <script>
                                        setTimeout(function() {
                                            document.querySelector('.alert').remove();
                                        }, 5000);
                                    </script>
                                    <div role="alert"
                                        class="alert w-auto absolute z-10 top-right-5 mb-2 p-2 bg-red-800 rounded-full items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex">
                                        <span
                                            class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                                        <span class="font-semibold mr-2 text-left flex-auto">{{ session('error') }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                    @php
                                        session()->forget('error');
                                    @endphp
                                @endif
                                @yield('content')
                            </main>
                        </div>
                    </div>
                @endif
            @else
                @if (!in_array(request()->route()->getName(), ['register', 'login', 'password.request', 'password.reset', 'password.confirm']))
                <div class="flex items-center justify-center h-screen">
                    <div class="flex flex-col items-center justify-center">
                        <img src="{{ asset('images/website/security.gif') }}" alt="security" class="w-1/2" />
                        <h1 class="text-3xl font-bold mt-2 text-center">Tu cuenta está bloqueada. Por favor, contacta al
                            administrador.
                        </h1>
                        <div class="flex gap-6">
                            <a href="mailto:snpoc.info@gmail.com?subject=My Account is Locked &body=Hello%20Admin%2C"
                                class="flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                                Contactar al administrador
                            </a>
                            <a href="{{ route('logout') }}"
                                class="flex items-center justify-center px-4 py-2 mt-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
                @else
                    @yield('content')
                @endif
            @endif
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    @auth
        <x-chat-widget :online-users="[]" />
    @endauth
</body>

</html>

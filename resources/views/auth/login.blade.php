@extends('layouts.guest')
@section('title', 'Iniciar sesión')
@section('content')
    <div class="flex h-screen bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600">
        <div class="container px-6 mx-auto flex flex-col justify-center items-center relative">

            <!-- Cuadro de inicio de sesión con diseño más moderno -->
            <div class="p-10 bg-white rounded-lg shadow-xl w-1/2">
                <div class="flex justify-center mb-8">
                    <!-- Logo más grande y estilizado -->
                    <img src="{{ asset('images/logo.png') }}" alt="Leander Logo" class="h-32 w-auto">
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Iniciar sesión</h2>

                <!-- Errores de validación -->
                @foreach ($errors->all() as $error)
                    <div role="alert"
                        class="w-full p-2 bg-red-800 rounded-full items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">ERROR</span>
                        <span class="font-semibold mr-2 text-left flex-auto">¡Nombre de usuario o contraseña incorrectos!</span>
                    </div>
                @endforeach
                <form class="flex flex-col" method="POST" action="{{ route('login') }}">
                    @csrf

                    <label class="block text-sm mt-2">
                        <div class="relative text-gray-500 focus-within:text-indigo-600">
                            <input required type="text" name="username" value="{{ old('username') }}" id="username"
                                class="block w-full pl-10 mt-1 text-sm text-black focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo form-input"
                                placeholder="Nombre de usuario" />
                            <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        </div>
                    </label>

                    <label class="block mt-2 text-sm">
                        <div class="relative text-gray-500 focus-within:text-indigo-600">
                            <input type="password" name="password" id="password" required
                                class="block w-full pl-10 mt-1 text-sm text-black focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo form-input"
                                placeholder="Contraseña" />
                            <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                        </div>
                    </label>

                    <!-- Recordar Me -->
                    <div class="flex mt-2 text-sm justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input type="checkbox" name="remember" id="remember_me"
                                class="text-indigo-600 form-checkbox focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo " />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                        </label>
                        <label class="flex items-center">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-400 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif
                        </label>
                    </div>

                    <button
                        class="text-white font-bold w-1/4 py-2 px-4 mt-4 mx-auto rounded-md border-2 bg-black hover:bg-black "
                        type="submit">Iniciar sesión</button>
                    <span class="text-black text-sm text-center mt-4">¿No tienes una cuenta? <a
                            href="{{ route('register') }}" class="text-indigo-600 font-semibold">Regístrate</a></span>
                </form>
            </div>
        </div>
    </div>

    <script>
        function password_show_hide() {
            var input_box = document.getElementById("password");
            var show = document.getElementById("show");
            var hide = document.getElementById("hide");

            if (input_box.type === "password") {
                input_box.type = "text";
                show.classList.remove("hidden");
                hide.classList.add("hidden");
            } else {
                input_box.type = "password";
                hide.classList.remove("hidden");
                show.classList.add("hidden");
            }
        }
    </script>
@endsection

@extends('layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8 max-w-lg mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">Crear Cuenta</h2>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Nombre -->
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
            <input id="first_name" name="first_name" type="text" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                value="{{ old('first_name') }}" />
            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Apellido -->
        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apellido</label>
            <input id="last_name" name="last_name" type="text" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                value="{{ old('last_name') }}" />
            @error('last_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Usuario -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Usuario</label>
            <input id="username" name="username" type="text" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                value="{{ old('username') }}" />
            @error('username')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input id="email" name="email" type="email" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                value="{{ old('email') }}" />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Género -->
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Género</label>
            <select id="gender" name="gender" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white">
                <option value="">Selecciona tu género</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
            </select>
            @error('gender')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Foto de Perfil -->
        <div class="flex flex-col items-center">
            <div class="mb-2">
                <div class="h-24 w-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 border-indigo-300">
                    <img id="profile-preview" src="#" alt="Vista previa" class="hidden h-full w-full object-cover">
                    <span id="profile-placeholder" class="text-gray-400 text-3xl">?</span>
                </div>
            </div>
            <label for="profile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">Foto de Perfil (Obligatoria)</label>
            <input type="file" name="profile" id="profile" accept="image/*" required
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                onchange="previewImage(this)">
            @error('profile')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
            <input id="password" name="password" type="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white" />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-white" />
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Registrarse
            </button>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Inicia sesión
                </a>
            </p>
        </div>
    </form>
</div>
<script>
    function previewImage(input) {
        const preview = document.getElementById('profile-preview');
        const placeholder = document.getElementById('profile-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
</script>
@endsection
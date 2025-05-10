@extends('layouts.guest')

@section('title', 'Registro')
@section('content')
<div class="min-h-screen bg-gray-50 flex">
  <!-- === CONTENEDOR IZQUIERDO === -->
  <div class="w-full md:w-1/2 flex items-center justify-center p-8 relative">
    <!-- === DIV DEL FORMULARIO === -->
    <div class="login">
      <!-- Logo y Foto de Perfil -->
      <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Leander" width="100" height="auto" class="mb-4">
        

      </div>

      <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Crear Cuenta</h2>
      <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Primera fila: Nombre y Apellido -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input id="first_name" name="first_name" type="text" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value="{{ old('first_name') }}" />
            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Apellido</label>
            <input id="last_name" name="last_name" type="text" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value="{{ old('last_name') }}" />
            @error('last_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Segunda fila: Usuario y Trayecto -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Usuario</label>
            <input id="username" name="username" type="text" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value="{{ old('username') }}" />
            @error('username')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="trayecto" class="block text-sm font-medium text-gray-700">Trayecto</label>
            <select id="trayecto" name="trayecto" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Selecciona tu trayecto</option>
                <option value="1" {{ old('trayecto') == '1' ? 'selected' : '' }}>Trayecto 1</option>
                <option value="2" {{ old('trayecto') == '2' ? 'selected' : '' }}>Trayecto 2</option>
                <option value="3" {{ old('trayecto') == '3' ? 'selected' : '' }}>Trayecto 3</option>
                <option value="4" {{ old('trayecto') == '4' ? 'selected' : '' }}>Trayecto 4</option>
            </select>
            @error('trayecto')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Tercera fila: Email y Género -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value="{{ old('email') }}" />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">Género</label>
            <select id="gender" name="gender" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Selecciona tu género</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
            </select>
            @error('gender')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Cuarta fila: Contraseñas -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input id="password" name="password" type="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
          </div>
        </div>

        <!-- Botón de Registro -->
        <div>
          <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition duration-300">
              Registrarse
          </button>
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Inicia sesión
                </a>
            </p>
        </div>
      </form>
    </div>
    <!-- Efecto de degradado izquierdo -->
    <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent"></div>
  </div>

  <!-- === IMAGEN COMPLETA A LA DERECHA === -->
  <div class="hidden md:block w-1/2 h- relative">
    <!-- Efecto de degradado derecho -->
    <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-50 to-transparent"></div>
    <img src="{{ asset('images/377385819206610953.png') }}"
         alt="Fondo Leander"
         class="w-full h-full object-cover">
  </div>
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const login = document.querySelector('.login');
    login.style.border = '2px solid rgba(101, 158, 250, 0.76)';
    login.style.boxShadow = '0 4px 20px rgba(146, 185, 247, 0.3)';
    login.style.backgroundColor = 'white';
    login.style.padding = '1rem';
    login.style.position = 'relative';
    login.style.zIndex = '10';
    login.style.width = '400px';
    login.style.height = '930px';
  });
</script>

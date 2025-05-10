@extends('layouts.guest')
@section('title', 'Iniciar sesión')
@section('content')
<div class="min-h-screen bg-gray-50 flex">
  <!-- === CONTENEDOR IZQUIERDO === -->
  <div class="w-full md:w-1/2 flex items-center justify-center p-8 relative">
    <!-- === DIV DEL FORMULARIO === -->
    <div class="login">
      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Leander" width="100" height="auto">
      </div>

      <!-- Formulario de inicio de sesión -->
      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Usuario -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Usuario</label>
          <input id="email" type="text" name="email" required autofocus
                 class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-blue-600 @error('email') border-red-500 @enderror"
                 placeholder="Usuario" value="{{ old('email') }}">
          @error('email')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
          @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
          <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Contraseña</label>
          <input id="password" type="password" name="password" required
                 class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-blue-600 @error('password') border-red-500 @enderror"
                 placeholder="••••••••">
          @error('password')
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
          @enderror
        </div>

        <!-- Botón -->
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition duration-300">
          Iniciar Sesión
        </button>

        <!-- Registro -->
        <p class="text-center text-sm text-gray-600 mt-6">
          ¿No tienes cuenta? <br>
          <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate aquí</a>
        </p>
      </form>
    </div>
    <!-- Efecto de degradado -->
    <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white via-white/80 to-transparent"></div>
  </div>

  <!-- === IMAGEN COMPLETA A LA DERECHA === -->
  <div class="hidden md:block w-1/2 h-screen relative">
    <!-- Efecto de degradado -->
    <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-50 via-gray-50/80 to-transparent"></div>
    <img src="{{ asset('images/377385819206610953.png') }}"
         alt="Fondo Leander"
         class="w-full h-full object-cover">
  </div>
</div>
@endsection
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const login = document.querySelector('.login');
    login.style.border = '2px solid rgba(101, 158, 250, 0.76)';
    login.style.boxShadow = '0 4px 20px rgba(146, 185, 247, 0.3)';
    login.style.backgroundColor = 'white';
    login.style.padding = '1.5rem';
    login.style.position = 'relative';
    login.style.zIndex = '10';
    login.style.width = '400px';
  });
</script>

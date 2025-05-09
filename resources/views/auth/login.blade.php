@extends('layouts.guest')
@section('title', 'Iniciar sesión')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <!-- wrapper sin border -->
  <div class="flex w-full max-w-4xl shadow-lg overflow-hidden rounded-xl">
    
    <!-- === IZQUIERDA: FORMULARIO con border menos el lado derecho === -->
    <div class="w-full md:w-1/2 flex flex-col justify-center 
                px-8 py-10 bg-white
                border border-gray-300 border-r-0 
                rounded-l-xl">
      <!-- Logo -->
      <div class="flex justify-center mb-6">
        <span class="text-3xl font-bold text-blue-500">Leander</span>
      </div>
      <!-- Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm mb-2">Correo electrónico</label>
          <input id="email" type="email" name="email" required autofocus
            class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-500"
            placeholder="ejemplo@correo.com" value="{{ old('email') }}">
          @error('email')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>
        <!-- Contraseña -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm mb-2">Contraseña</label>
          <input id="password" type="password" name="password" required
            class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:border-blue-500"
            placeholder="••••••••">
          @error('password')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
          @enderror
        </div>
        <!-- Olvidaste -->
        <div class="flex justify-end mb-4">
          <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-blue-500">
            ¿Olvidaste tu contraseña?
          </a>
        </div>
        <!-- Botón -->
        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold transition duration-300">
          Iniciar Sesión
        </button>
        <!-- Registro -->
        <p class="text-center text-sm text-gray-600 mt-6">
          ¿No tienes cuenta?
          <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Regístrate aquí</a>
        </p>
      </form>
    </div>
    
    <!-- === DERECHA: IMAGEN semitransparente con border menos el lado izquierdo === -->
    <div class=" md:flex md:w-1/2 items-center justify-center
                bg-gray-100 bg-opacity-50
                filter brightness-50
                border border-gray-300 border-l-0
                rounded-r-xl">
      <img src="{{ asset('images/unnamed.png') }}" alt="Login Image" class="w-full h-full object-cover">
    </div>

  </div>
</div>
@endsection

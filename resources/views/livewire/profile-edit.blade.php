{{-- Close your eyes. Count to one. That is how long forever feels. --}}
@php
    $user = auth()->user();
    $users = App\Models\User::where('id', '!=', $user->id)->get();
@endphp


<div class="container px-6 mx-auto grid">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-700 dark:text-gray-200">Editar Perfil</h2>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="profileEdit" class="space-y-8">
           
            <!-- Información Personal -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-600">Información Personal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col items-center justify-start">
                        @if($profile)
                            @if (is_string($profile))
                                @if(file_exists(public_path('storage/images/profiles/' . $profile)))
                                    <img class="h-14 w-14 object-cover rounded-full border-2 border-white shadow mb-2" src="{{ asset('storage/images/profiles/' . $profile) }}" alt="Foto de perfil actual">
                                @else
                                    <div class="h-14 w-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-2 border-white shadow mb-2">
                                        <span class="text-gray-500 dark:text-gray-300 text-lg">{{ substr(Auth::user()->first_name, 0, 1) }}</span>
                                    </div>
                                @endif
                            @else
                                <img class="h-14 w-14 object-cover rounded-full border-2 border-white shadow mb-2" src="{{ $profile->temporaryUrl() }}" alt="Nueva foto de perfil">
                            @endif
                        @else
                            <div class="h-14 w-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-2 border-white shadow mb-2">
                                <span class="text-gray-500 dark:text-gray-300 text-lg">{{ substr(Auth::user()->first_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <label for="dropzone-file" class="mt-2 cursor-pointer text-xs text-purple-600 hover:underline">Cambiar foto
                            <input id="dropzone-file" type="file" class="hidden" wire:model="profile" accept="image/*" />
                        </label>
                        @error('profile') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="relative text-gray-500 focus-within:text-purple-600">
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                            <input type="text" wire:model.live="first_name" id="first_name" 
                                class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                                placeholder="Tu nombre" />
                            @error('first_name') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                        </div>
                        <div class="relative text-gray-500 focus-within:text-purple-600">
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Apellido</label>
                            <input type="text" wire:model.live="last_name" id="last_name" 
                                class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                                placeholder="Tu apellido" />
                            @error('last_name') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                        </div>
                        <div class="relative text-gray-500 focus-within:text-purple-600">
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de Usuario</label>
                            <input type="text" wire:model.live="username" id="username" 
                                class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                                placeholder="Tu nombre de usuario" />
                            @error('username') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                        </div>
                        <div class="relative text-gray-500 focus-within:text-purple-600">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" wire:model.live="email" id="email" 
                                class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                                placeholder="Tu email" />
                            @error('email') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Género</label>
                                <select wire:model.live="gender" id="gender" 
                                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select rounded-lg">
                                    <option value="">Selecciona tu género</option>
                                    <option value="male">Masculino</option>
                                    <option value="female">Femenino</option>
                                </select>
                                @error('gender') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="trayecto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trayecto</label>
                                <select wire:model.live="trayecto" id="trayecto" 
                                    class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select rounded-lg">
                                    <option value="">Selecciona tu trayecto</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @error('trayecto') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6 pb-2 border-b border-gray-200 dark:border-gray-600">Información Adicional</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea wire:model.live="description" id="description" rows="3" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-textarea rounded-lg"
                            placeholder="Cuéntanos sobre ti"></textarea>
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                            </svg>
                        </div>
                        @error('description') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="work" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trabajo</label>
                        <input type="text" wire:model.live="work" id="work" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                            placeholder="Tu trabajo actual" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                        @error('work') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="school" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Escuela</label>
                        <input type="text" wire:model.live="school" id="school" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                            placeholder="Tu escuela" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>
                        @error('school') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="college" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Colegio</label>
                        <input type="text" wire:model.live="college" id="college" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                            placeholder="Tu colegio" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>
                        @error('college') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="university" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Universidad</label>
                        <input type="text" wire:model.live="university" id="university" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                            placeholder="Tu universidad" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>
                        @error('university') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección</label>
                        <input type="text" wire:model.live="address" id="address" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                            placeholder="Tu dirección" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        @error('address') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sitio Web</label>
                        <input type="url" wire:model.live="website" id="website" 
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input rounded-lg"
                            placeholder="Tu sitio web" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none mt-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        @error('website') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>
          

      <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('profile.show', auth()->user()->username) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Guardar Cambios
                </button>
            </div>
  </div>
        </form>
    
</div>


<script>
    // Eliminado el script de previsualización, Livewire lo maneja automáticamente
</script>

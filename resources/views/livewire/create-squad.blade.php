{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
<div class="container px-6 mx-auto">
    <div class="mt-4 p-4 rounded-lg bg-gray-100 shadow-md dark:bg-gray-700">
        <h2 class="mb-2 text-center text-2xl font-bold text-gray-700 dark:text-gray-200">Crear tu propio grupo</h2>
        <p class="mb-4 text-center text-sm text-gray-600 dark:text-gray-400">
            Los grupos son espacios para compartir contenido con tus miembros. Solo tú podrás administrar el grupo.
        </p>

        @if (session('error'))
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form class="flex flex-col" method="POST" action="{{ route('create-squad') }}" enctype="multipart/form-data">
            @csrf

            <div class="flex justify-between gap-6">
                <label class="w-full text-sm mt-2">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="text" name="name" id="name"
                            class="block w-full pl-10 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none form-input"
                            placeholder="Nombre del Grupo" value="{{ old('name') }}" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 20h9" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4h9" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 12h16" />
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <select name="type" id="type"
                            class="block w-full pl-10 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none form-select">
                            <option value="">Selecciona el tipo de grupo</option>
                            <option value="educacion">Educación</option>
                            <option value="noticias">Noticias</option>
                            <option value="entretenimiento">Entretenimiento</option>
                            <option value="tutoriales">Tutoriales</option>
                            <option value="otros">Otros</option>
                        </select>
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </div>
                    @error('type')
                        <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                    @enderror
                </label>

                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="text" name="location" id="location"
                            class="block w-full pl-10 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none form-input"
                            placeholder="Ubicación del grupo" value="{{ old('location') }}" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6l4 2" /><circle cx="12" cy="12" r="10" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                    @error('location')
                        <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <textarea name="description" id="description" rows="3"
                        class="block w-full pl-10 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none form-textarea"
                        placeholder="Descripción del grupo">{{ old('description') }}</textarea>
                </label>
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <!-- Foto de perfil del canal -->
                <div class="w-1/2">
                    <label for="icon"
                        class="flex flex-col items-center justify-center w-full h-56 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <span class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Foto de perfil del canal</span>
                        <span class="mb-2 text-xs text-gray-500 dark:text-gray-400">Esta imagen será el avatar circular del canal.</span>
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG o GIF (MAX. 800x800px)</p>
                        </div>
                        <input id="icon" type="file" class="hidden" name="icon" />
                    </label>
                    @error('icon')
                        <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Foto de portada del canal -->
                <div class="w-1/2">
                    <label for="thumbnail"
                        class="flex flex-col items-center justify-center w-full h-56 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <span class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Foto de portada del canal</span>
                        <span class="mb-2 text-xs text-gray-500 dark:text-gray-400">Esta imagen será la cabecera grande del canal.</span>
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG o GIF (MAX. 1200x400px)</p>
                        </div>
                        <input id="thumbnail" type="file" class="hidden" name="thumbnail" />
                    </label>
                    @error('thumbnail')
                        <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple mt-4">
                Crear Grupo
            </button>
        </form>
    </div>
</div>

{{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
<style>
    .main-container {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-top: 1rem;
    }
</style>

<div class="container p-6 mx-auto top-10">
    <div class="main-container">
        @foreach ($errors->all() as $error)
            <div class="text-red-600" role="alert">
                {{ $error }}
            </div>
        @endforeach

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
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            placeholder="Nombre del grupo" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="w-6 h-6">
                                <path fill="currentColor"
                                    d="M10.871 1.015a.5.5 0 0 1 .364.606l-.25 1a.5.5 0 1 1-.97-.242l.25-1a.5.5 0 0 1 .606-.364Zm2.983 1.132a.5.5 0 0 1 0 .707l-1 1a.5.5 0 1 1-.707-.707l1-1a.5.5 0 0 1 .707 0Zm-7.57 10.886a2 2 0 0 0 3.63-1.605l-3.63 1.605Zm-.92.406l-.998.442a1.4 1.4 0 0 1-1.555-.29l-.4-.399a1.394 1.394 0 0 1-.293-1.548l3.871-8.808a1.4 1.4 0 0 1 2.269-.427l5.332 5.316a1.395 1.395 0 0 1-.422 2.264l-2.335 1.032a3 3 0 0 1-5.469 2.418ZM14.5 5h-1a.5.5 0 0 0 0 1h1a.5.5 0 1 0 0-1ZM6.905 3.238l-3.872 8.808a.394.394 0 0 0 .083.438l.401.4a.4.4 0 0 0 .444.082l8.802-3.892a.395.395 0 0 0 .12-.64l-5.33-5.318a.4.4 0 0 0-.647.12Z" />
                            </svg>
                        </div>
                    </div>
                </label>
                @error('name')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <select name="type" id="type"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                            <option value="">Selecciona el tipo de grupo</option>
                            <option value="educacion">Educación</option>
                            <option value="noticias">Noticias</option>
                            <option value="entretenimiento">Entretenimiento</option>
                            <option value="tutoriales">Tutoriales</option>
                            <option value="otros">Otros</option>
                        </select>
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                        </div>
                    </div>
                    @error('type')
                        <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <textarea name="description" id="description" rows="3"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-textarea"
                            placeholder="Descripción del grupo"></textarea>
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                            </svg>
                        </div>
                    </div>
                </label>
                @error('description')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="text" name="location" id="location"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            placeholder="Ubicación del grupo" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                    </div>
                </label>
                @error('location')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="file" name="icon" id="icon"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            accept="image/*" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                    </div>
                </label>
                @error('icon')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="file" name="thumbnail" id="thumbnail"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            accept="image/*" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>
                    </div>
                </label>
                @error('thumbnail')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                   <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4">
                Crear Grupo
            </button>
        </form>
    </div>
</div>

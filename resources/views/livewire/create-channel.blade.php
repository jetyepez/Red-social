{{-- The whole world belongs to you. --}}
{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
@php
    $path = parse_url(url()->current())['path'];
    $uuid = substr($path, strrpos($path, '/') + 1);
    $channel = \App\Models\Page::where('uuid', $uuid)->first();
@endphp

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

        <h2 class="mb-2 text-center text-2xl font-bold text-gray-700 dark:text-gray-200">Crear tu propio canal</h2>
        <p class="mb-4 text-center text-sm text-gray-600 dark:text-gray-400">Los canales son espacios para compartir contenido con tus seguidores. Solo tú podrás publicar contenido.</p>
        
        <form class="flex flex-col" method="post" action="{{ route('create-channel') }}" enctype="multipart/form-data">
            @csrf
            @if($channel)
                <input type="text" name="page_id" id="" value="{{ $channel->id }}" hidden>
            @endif

            <div class="flex justify-between gap-6">
                <label class="w-full text-sm mt-2">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="text" name="name" id="name"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            placeholder="Nombre del canal" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="w-6 h-6">
                                <path fill="currentColor"
                                    d="M10.871 1.015a.5.5 0 0 1 .364.606l-.25 1a.5.5 0 1 1-.97-.242l.25-1a.5.5 0 0 1 .606-.364Zm2.983 1.132a.5.5 0 0 1 0 .707l-1 1a.5.5 0 1 1-.707-.707l1-1a.5.5 0 0 1 .707 0Zm-7.57 10.886a2 2 0 0 0 3.63-1.605l-3.63 1.605Zm-.92.406l-.998.442a1.4 1.4 0 0 1-1.555-.29l-.4-.399a1.394 1.394 0 0 1-.293-1.548l3.871-8.808a1.4 1.4 0 0 1 2.269-.427l5.332 5.316a1.395 1.395 0 0 1-.422 2.264l-2.335 1.032a3 3 0 0 1-5.469 2.418ZM14.5 5h-1a.5.5 0 0 0 0 1h1a.5.5 0 1 0 0-1ZM6.905 3.238l-3.872 8.808a.394.394 0 0 0 .083.438l.401.4a.4.4 0 0 0 .444.082l8.802-3.892a.395.395 0 0 0 .12-.64l-5.33-5.318a.4.4 0 0 0-.647.12Z" />
                            </svg>
                        </div>
                    </div>
                </label>
                {{-- error --}}
                @error('name')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <select name="type" id="type"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-select">
                            <option value="">Selecciona el tipo de canal</option>
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
                </label>
                {{-- error --}}
                @error('type')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror

                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <input type="text" name="location" id="location"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            placeholder="Ubicación del canal" />
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                            </svg>
                        </div>
                    </div>
                </label>
                {{-- error --}}
                @error('location')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between gap-6 mt-4">
                <label class="w-full text-sm">
                    <div class="relative text-gray-500 focus-within:text-purple-600">
                        <textarea name="description" id="description" rows="3"
                            class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-textarea"
                            placeholder="Descripción del canal"></textarea>
                        <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                            </svg>
                        </div>
                    </div>
                </label>
                {{-- error --}}
                @error('description')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <!-- Foto de portada del canal -->
                <label for="thumbnail"
                    class="flex flex-col items-center justify-center w-full h-56 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                    id="thumbnail-drop-area">
                    <span class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">Foto de portada del canal</span>
                    <span class="mb-2 text-xs text-gray-500 dark:text-gray-400">Esta imagen será la cabecera grande del canal.</span>
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="thumbnail-preview-container">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG o GIF (MAX. 1200x400px)</p>
                    </div>
                    <input id="thumbnail" type="file" class="hidden" name="thumbnail" accept="image/*" onchange="previewThumbnail(this)" />
                </label>
                @error('thumbnail')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4" type="submit">Crear
                Canal</button>
        </form>
    </div>
</div>

<script>
    function previewThumbnail(input) {
        const dropArea = document.getElementById('thumbnail-drop-area');
        const previewContainer = document.getElementById('thumbnail-preview-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Ocultar el contenedor de preview por defecto
                previewContainer.style.display = 'none';
                
                // Crear y mostrar la imagen de preview
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover rounded-lg';
                dropArea.appendChild(img);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Permitir arrastrar y soltar archivos
    const dropArea = document.getElementById('thumbnail-drop-area');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('border-blue-500');
    }

    function unhighlight(e) {
        dropArea.classList.remove('border-blue-500');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        const input = dropArea.querySelector('input[type="file"]');
        
        input.files = files;
        previewThumbnail(input);
    }
</script>

<div>
    <div class="flex flex-col items-center">
        <div class="w-3/4 max-w-md bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800 p-6 mt-2">
            @foreach ($errors->all() as $error)
                <div class="text-red-600" role="alert">
                    {{ $error }}
                </div>
            @endforeach
            <form class="flex flex-col" method="POST" action="{{ route('createpost') }}" enctype="multipart/form-data">
                @csrf

                <div class="flex flex-col items-center justify-center w-full mb-4">
                    <label class="w-full text-sm mb-4">
                        <div class="relative text-gray-500 focus-within:text-purple-600">
                            <input type="text" name="title" id="title"
                                class="block w-full pl-10 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                placeholder="Título de tu publicación" required/>
                            <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none" id="title-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                                </svg>
                            </div>
                        </div>
                    </label>

                    <label for="content" class="w-full text-sm mb-4">
                        <textarea name="content" id="content" rows="4" required
                            class="block w-full mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                            placeholder="Escribe el contenido de tu publicación"></textarea>
                    </label>

                    <label for="dropzone-file"
                        class="drop_area flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 mb-4">
                        <div class="img_view flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Haz click para
                                    subir imagen</span> o arrastra y suelta</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG o GIF
                                (MAX. 5MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="thumbnail" required accept="image/*"/>
                    </label>

                    <label for="documents"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="docs_view flex flex-col items-center justify-center pt-5 pb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                                stroke="currentColor" class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Haz click para
                                    subir archivos</span> o arrastra y suelta</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, PPT, ZIP, RAR
                                (MAX. 25MB)</p>
                        </div>
                        <input type="file" id="documents" class="hidden" name="documents[]" multiple 
                            accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.zip,.rar"/>
                    </label>

                    <div id="selected-files" class="w-full mt-4 space-y-2"></div>
                </div>

                <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4" type="submit">Publicar</button>
            </form>
        </div>
    </div>

    <style>
        .file-preview {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background-color: #f3f4f6;
            border-radius: 0.5rem;
        }
        .dark .file-preview {
            background-color: #374151;
        }
        .file-preview .remove-file {
            margin-left: auto;
            cursor: pointer;
            color: #ef4444;
        }
    </style>

    <script>
        let dropArea = document.querySelector('.drop_area');
        let dropFile = document.querySelector('#dropzone-file');
        let imgView = document.querySelector('.img_view');
        let documentsInput = document.getElementById('documents');
        let selectedFiles = document.getElementById('selected-files');

        dropFile.addEventListener("change", uploadImage);

        function uploadImage() {
            let imgLink = URL.createObjectURL(dropFile.files[0]);
            dropArea.style.backgroundImage = `url(${imgLink})`;
            dropArea.style.backgroundSize = `cover`;
            imgView.style.display = 'none';
        }

        documentsInput.addEventListener('change', function(e) {
            selectedFiles.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                let fileDiv = document.createElement('div');
                fileDiv.className = 'file-preview';
                fileDiv.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-sm">${file.name}</span>
                    <span class="remove-file" onclick="this.parentElement.remove()">×</span>
                `;
                selectedFiles.appendChild(fileDiv);
            });
        });
    </script>
</div>

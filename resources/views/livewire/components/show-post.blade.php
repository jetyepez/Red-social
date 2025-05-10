@php
    $path = parse_url(url()->current())['path'];
    $uuid = substr($path, strrpos($path, '/') + 1);
    $post = App\Models\Post::where('uuid', $uuid)->first();
@endphp
<div class="flex flex-col items-center">
    <script>
        function openModal(title) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
            document.getElementById('modal-title').innerHTML = title;
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('flex');
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
    <div id="modal"
        class=" hidden absolute z-10 center-absolute w-1/4 bg-red-100 border-t-8 border-red-600 rounded-b-lg px-4 py-4 flex-col justify-around shadow-md dark:bg-white text-gray-700 dark:text-gray-700">
        <div class="flex flex-col justify-center items-center">
            <img src="{{ asset('images/website/trash_bin.gif') }}" alt="" width="100px">
            <h2 class="text-lg font-bold mt-2 text-center">¿Estás seguro de querer eliminar <span id="modal-title"></span> ?</h2>
            <div class="flex justify-between gap-6 mt-2">
                <a href="{{ route('post.delete', $uuid, 'delete') }}"
                    class="bg-red-600 active:bg-red-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150"
                    type="button">
                    Eliminar
                </a>
                <button
                    class="bg-gray-600 active:bg-gray-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150"
                    type="button" onclick="closeModal()">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <div class="w-3/4 max-w-md bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800 p-6 mt-2 mb-2">
        <div style="background-image: url({{ asset('images/thumbnails/' . $post->thumbnail) }}); background-size: cover; background-position: center; background-repeat: no-repeat;"
            class="min-h-xs flex items-center justify-center rounded-lg">
            <div class="glass-morphic min-w-xl text-center">
                <h1 class="text-3xl font-bold text-white">{{ $post->title }}
                </h1>
            </div>
        </div>
        <div class="mt-4 flex justify-between text-gray-700 dark:text-gray-100">
            <div class="flex">
                <div>
                    <img src="{{ asset('images/profiles/' . $post->user->profile) }}" alt="Avatar"
                        class="w-12 h-12 rounded-full mr-4">
                </div>
                <div>
                    <span class="text-sm font-bold">Por <a
                            href="{{ route('profile.show', $post->user->username) }}">{{ $post->user->username }}</a></span><br>
                    <span class="text-sm font-bold">{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @if (auth()->id() == $post->user_id)
                <div class="flex items-center justify-between gap-6">
                    <a href="{{ route('post.edit', $post->uuid) }}"
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Editar
                    </a>
                    <button onclick="openModal('{{ $post->title }}')"
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple">
                        Eliminar
                    </button>
                </div>
            @endif

            @if (auth()->user()->username == 'snpoc_admin')
                <div class="flex items-center justify-between gap-6">
                    <a href="{{ route('delete&ban', $post->uuid) }}"
                        class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple">
                        Eliminar publicación
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-4 dark:text-white">
            {!! $post->content !!}
        </div>

        @if($post->documents)
        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h3 class="text-lg font-semibold mb-2 dark:text-white">Archivos adjuntos:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach(json_decode($post->documents) as $document)
                    <a href="{{ asset('documents/posts/' . $document) }}" 
                        class="flex items-center p-3 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow"
                        target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                            stroke="currentColor" class="w-6 h-6 text-gray-500 dark:text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300 truncate">{{ basename($document) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @php
            $post_media = App\Models\PostMedia::where('post_id', $post->id)->first();
        @endphp
        @if ($post_media && $post_media->file_type == 'image')
            @php
                $medias = json_decode($post_media->file);
            @endphp
            <div class="mt-4 p-4 rounded-lg text-gray-700 dark:text-gray-100 dark:bg-gray-900">
                <div class="m-4 flex flex-row justify-between">
                    @foreach ($medias as $media)
                        <img src="{{ asset('images/posts/' . $media) }}" alt="post image" class="rounded-lg"
                            width="20%">
                    @endforeach
                </div>
            </div>
        @endif


        <hr class="mt-4 border-2" />
        <div class="mt-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">Comentarios</h2>

            <div class="mt-4">
                <form method="POST" action="{{ route('post.comment', $post->id, 'comment') }}">
                    @csrf
                    @if (auth()->user()->banned_to > now('Asia/Yangon'))
                        <div
                            class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg">
                            No puedes comentar porque tu cuenta está bloqueada.
                        </div>
                    @else
                        <label class="w-full text-sm mt-4">
                            <div class="relative text-gray-500 focus-within:text-purple-600">
                                <input type="text" name="comment" id="comment"
                                    class="block w-full  mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                                    placeholder="Escribe tu comentario" />

                                <button type="submit"
                                    class="w-24 absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                    Comentar</button>
                            </div>
                        </label>
                    @endif
                </form>
            </div>

            <div class="mt-4">
                @php
                    $comments = App\Models\Comment::with('post')->get('*');
                @endphp
                @forelse ($comments as $comment)
                    @if ($comment->post_id == $post->id)
                        <div
                            class="mt-4 p-4 rounded-lg flex flex-col text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-900">

                            <div class="flex flex-row">
                                <div>
                                    <img src="{{ asset('images/profiles/' . $comment->user->profile) }}" alt="Avatar"
                                        class="w-12 h-12 rounded-full mr-4">
                                </div>
                                <div class="min-w-lg">
                                    <span class="text-sm font-bold">Por <a
                                            href="{{ route('profile.show', $comment->user->username) }}">{{ '@' . $comment->user->username }}</a></span><br>
                                    <span class="text-sm font-bold">
                                        {{ $comment->created_at->diffForHumans() }}</span>

                                </div>
                            </div>
                            <div class="mt-4 p-4 rounded-lg border dark:text-gray-100 dark:bg-gray-800">
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @endif

                @empty
                    <p>No hay comentarios</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

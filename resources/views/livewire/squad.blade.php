@php
    $path = parse_url(url()->current())['path'];
    $uuid = substr($path, strrpos($path, '/') + 1);
    $squad = App\Models\Group::where('uuid', $uuid)->first();
    $posts = App\Models\Post::where('group_id', $squad->id)
        ->get()
        ->sortByDesc('created_at');
    $joined = App\Models\GroupMember::where('user_id', auth()->id())
        ->where('group_id', $squad->id)
        ->exists();
@endphp

<style>
    .profile-container {
        background-color: #f9fafb;
        border-radius: 1rem;
        overflow: hidden;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .profile-header {
        position: relative;
        padding: 2rem 0;
    }
    .profile-name {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .stats-container {
        gap: 3rem;
        margin-top: 1.5rem;
    }
    .stats-number {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .stats-label {
        font-size: 0.875rem;
    }
    .info-text {
        font-size: 0.875rem;
    }
    .post-title {
        font-size: 1rem;
        font-weight: 600;
    }
    .post-meta {
        font-size: 0.75rem;
    }
    .post-actions {
        font-size: 0.875rem;
    }
    .posts-section {
        padding: 2rem;
    }
</style>

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6">
        <div class="bg-gray-50 rounded-lg shadow-lg border border-gray-200 profile-container">
            <!-- Foto de Perfil -->
            <div class="flex flex-col items-center profile-header">
                @if ($squad->icon)  <!-- Foto de perfil del grupo -->
                <img src="{{ asset('storage/squads/' . $squad->icon) }}" alt="Avatar"
                class="w-48 h-48 rounded-full mr-4">
                @else
                    <img class="w-24 h-24 rounded-full border-4 border-white object-cover mb-4"
                         src="https://picsum.photos/200/200" alt="Default Profile Image">
                @endif

                <h1 class="profile-name text-gray-800 mt-4 mb-4">
                    {{ $squad->name }}
                </h1>

                <!-- Estadísticas -->
                <div class="flex justify-center stats-container">
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $squad->members }}</span>
                        <span class="stats-label text-gray-600">Miembros</span>
                    </div>
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $posts->count() }}</span>
                        <span class="stats-label text-gray-600">Publicaciones</span>
                    </div>
                </div>

                <div class="flex justify-center gap-6 mt-6"> <!-- Mayor separación entre botones -->
                    @if ($joined)  <!-- Solo visible para el propietario -->
                        <a href="{{ route('squad.create-post', $squad->uuid) }}"
                           class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            Crear Publicación
                        </a>
                    @else
                        <p class="text-center text-gray-500">Solo el propietario puede crear publicaciones.</p>
                    @endif

                    @if ($joined)  <!-- Solo visible para los miembros que están en el grupo -->
                        <a href="{{ route('leave-squad', $squad->id) }}"
                           class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Salir del grupo
                        </a>
                    @else
                        <p class="text-center text-gray-500">No eres miembro de este grupo.</p>
                    @endif
                </div>




            </div>
            <!-- Botón Eliminar grupo (solo visible para el propietario) -->
            @if ($squad->user_id == auth()->id())
                <div class="text-center ">
                    <button onclick="squadDelete()"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Eliminar Grupo
                    </button>
                </div>
            @endif

            <!-- Publicaciones -->
            <div class="posts-section mt-8">
                <h2 class="section-title text-gray-800 mb-8">Publicaciones</h2>
                @if ($posts->count() > 0)
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 post-grid">
                        @foreach ($posts as $post)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <img src="{{ asset('images/groups/thumbnails/' . $squad->thumbnail) }}" alt="Avatar"
                                            class="w-10 h-10 rounded-full mr-3 border-2 border-white object-cover">
                                        <div>
                                            <h3 class="post-title text-gray-800">
                                                {{ $squad->name }}
                                            </h3>
                                            <p class="text-sm text-gray-600">{{ $squad->members }} miembros</p>
                                        </div>
                                    </div>

                                    <h4 class="post-title text-gray-800 mb-4">{{ $post->title }}</h4>

                                    <img src="{{ asset('images/thumbnails/' . $post->thumbnail) }}"
                                        alt="Post Image"
                                        class="w-full h-48 object-cover rounded-lg mb-4">

                                    <div class="flex justify-between items-center text-sm text-gray-600">
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        <div class="flex space-x-4">
                                            @if ($post->likes > 0)
                                                <span>{{ $post->likes }} Me gusta</span>
                                            @endif
                                            @if ($post->comments > 0)
                                                <span>{{ $post->comments }} Comentarios</span>
                                            @endif
                                            @if ($post->shares > 0)
                                                <span>{{ $post->shares }} Compartidos</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-between border-t pt-4">
                                        <a href="{{ route('squad.post.show', $post->uuid) }}"
                                            class="flex items-center post-actions text-gray-500 hover:text-blue-500 px-3 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Comentar
                                        </a>
                                        <a href="{{ route('share-post', $post->id) }}"
                                            class="flex items-center post-actions text-gray-500 hover:text-blue-500 px-3 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                            </svg>
                                            Compartir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center">No hay publicaciones aún</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function squadDelete() {
        document.getElementById('squadDelete').classList.remove('hidden');
        document.getElementById('squadDelete').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('squadDelete').classList.remove('flex');
        document.getElementById('squadDelete').classList.add('hidden');
    }
</script>

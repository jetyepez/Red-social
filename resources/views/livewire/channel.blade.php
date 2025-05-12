{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
@php
    $path = parse_url(url()->current())['path'];
    $uuid = substr($path, strrpos($path, '/') + 1);
    $channel = App\Models\Page::where('uuid', $uuid)->first();
    $posts = App\Models\Post::where('page_id', $channel->id)
        ->get()
        ->sortByDesc('created_at');
    $followed = App\Models\PageLike::where('user_id', auth()->id())
        ->where('page_id', $channel->id)
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
            <!-- Foto de Perfil y Nombre -->
            <div class="flex flex-col items-center profile-header">
                @if ($channel->thumbnail)
                <img class="w-full h-80 rounded-lg"
                    src="{{ asset('storage/pages/thumbnails/' . $channel->thumbnail) }}" alt="">
            @else
                <img class="w-full h-32 rounded-lg" src="https://picsum.photos/200/300"
                    alt="">
            @endif

                <h1 class="profile-name text-gray-800 mt-8 mb-4">
                    {{ $channel->name }}
                </h1>

                <!-- Estadísticas -->
                <div class="flex justify-center stats-container">
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $channel->members }}</span>
                        <span class="stats-label text-gray-600">Seguidores</span>
                    </div>
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $posts->count() }}</span>
                        <span class="stats-label text-gray-600">Publicaciones</span>
                    </div>
                </div>

                <!-- Botón Seguir -->
                @if (!$followed)
                    <a href="{{ route('follow-channel', $channel->id) }}"
                        class="mt-6 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Seguir
                    </a>
                @else
                    <a href="{{ route('unfollow-channel', $channel->id) }}"
                        class="mt-6 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Dejar de seguir
                    </a>
                @endif
            </div>
            <div class="container mx-auto px-6 py-8">
                <!-- Verifica si el usuario es el propietario del canal -->
                @if($channel->user_id == auth()->id())
                    <div class="text-center mb-6">
                        <a href="{{ route('channel.create-post', $channel->uuid) }}"
                            class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            Crear Publicación
                        </a>
                    </div>
                @else
                    <p class="text-center text-gray-500">Solo el propietario puede crear publicaciones.</p>
                @endif
            </div>

            <!-- Publicaciones -->
            <div class="posts-section">
                <h2 class="section-title text-gray-800 mb-8">Publicaciones</h2>
                @if ($posts->count() > 0)
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 post-grid">
                        @foreach ($posts as $post)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                       
                                        <div>
                                            <h3 class="post-title text-gray-800">
                                                {{ $channel->name }}
                                            </h3>
                                            <p class="text-sm text-gray-600">{{ $channel->members }} seguidores</p>
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
                                        <a href="{{ route('channel.post.show', $post->uuid) }}"
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

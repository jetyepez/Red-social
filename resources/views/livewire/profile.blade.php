{{-- Care about people's approval and you will be their prisoner. --}}
@php
    $path = parse_url(url()->current())['path'];
    $username = substr($path, strrpos($path, '/') + 1);
    $user = App\Models\User::where('username', $username)->first();

    $posts = App\Models\Post::where('user_id', $user->id)
        ->where('is_page_post', 0)
        ->where('is_group_post', 0)
        ->get()
        ->sortByDesc('created_at');

    $numOfFriends = 0;
    $numOfFriends += App\Models\Friend::where('user_id', $user->id)
        ->where('status', 'accepted')
        ->count();
    $numOfFriends += App\Models\Friend::where('friend_id', $user->id)
        ->where('status', 'accepted')
        ->count();
    $user->numOfFriends = $numOfFriends;

    $friends = App\Models\Friend::where('user_id', $user->id)
        ->where('status', 'accepted')
        ->get();
    $get_friends = App\Models\Friend::where('friend_id', $user->id)
        ->where('status', 'accepted')
        ->get();

    $numOfComments = App\Models\Comment::where('user_id', $user->id)->count();
@endphp

<style>
    .profile-container {
        margin-top: 50px;
        margin-bottom: 50px;
        padding: 40px;
        background-color: #f3f4f6;
    }
    .stats-container {
        margin: 40px 0;
        padding: 0 60px;
    }
    .stats-container > div {
        padding: 0 40px;
        border-right: 1px solid #e5e7eb;
    }
    .stats-container > div:last-child {
        border-right: none;
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 40px;
        margin: 40px 0;
        padding: 0 20px;
    }
    .friends-section {
        text-align: left;
        padding-right: 30px;
    }
    .personal-info {
        text-align: center;
        padding-left: 30px;
    }
    .personal-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 20px;
    }
    .personal-info-item {
        padding: 15px;
        margin-bottom: 0;
        background: white;
        border-radius: 8px;
        text-align: left;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .personal-info-item .flex {
        justify-content: flex-start;
    }
    .posts-section {
        margin-top: 50px;
        padding: 0 20px;
    }
    .post-grid {
        margin-top: 30px;
    }
    .profile-header {
        padding: 0 40px;
    }
    .friends-grid {
        display: grid;
        grid-template-cols: repeat(3, 1fr);
        gap: 20px;
        padding: 20px 0;
    }
    .friend-item {
        padding: 15px;
        background: white;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
    }
    .stats-number {
        font-size: 1.5rem;
        font-weight: 700;
    }
    .stats-label {
        font-size: 0.875rem;
    }
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
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
</style>

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6">
        <div class="bg-gray-50 rounded-lg shadow-lg border border-gray-200 profile-container">
            <!-- Foto de Perfil y Nombre -->
            <div class="flex flex-col items-center profile-header">
                <img src="{{ asset('storage/images/profiles/' . $user->profile) }}"
                    class="w-40 h-40 rounded-full border-4 border-white shadow-lg"
                    alt="Foto de perfil">
                
                <h1 class="profile-name text-gray-800 mt-8 mb-4">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h1>

                <!-- Estadísticas -->
                <div class="flex justify-center stats-container">
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $user->numOfFriends }}</span>
                        <span class="stats-label text-gray-600">Amigos</span>
                    </div>
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $posts->count() }}</span>
                        <span class="stats-label text-gray-600">Publicaciones</span>
                    </div>
                    <div class="text-center">
                        <span class="block stats-number text-gray-800 mb-2">{{ $numOfComments }}</span>
                        <span class="stats-label text-gray-600">Comentarios</span>
                    </div>
                </div>

                <!-- Botón Conectar -->
                @if ($user->username != auth()->user()->username)
                    <a href="{{ url('envoy', $user->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full shadow-md transition duration-300 text-sm">
                        Conectar
                    </a>
                @endif
            </div>

            <!-- Información Personal y Amigos -->
            <div class="info-grid">
                <!-- Sección de Amigos -->
                <div class="friends-section">
                    <h2 class="section-title text-gray-800 mb-8">Amigos ({{ $user->numOfFriends }})</h2>
                    <div class="friends-grid">
                        @foreach ($friends as $friend)
                            @php
                                $friend = App\Models\User::find($friend->friend_id);
                            @endphp
                            <div class="friend-item">
                                <img class="h-16 w-16 rounded-full mx-auto mb-3 object-cover shadow-md border-2 border-white"
                                    src="{{ asset('images/profiles/' . $friend->profile) }}" alt="">
                                <a href="{{ route('profile.show', $friend->username) }}"
                                    class="text-xs font-medium text-gray-700 hover:text-blue-500">
                                    {{ $friend->username }}
                                </a>
                            </div>
                        @endforeach
                        @foreach ($get_friends as $friend)
                            @php
                                $friend = App\Models\User::find($friend->user_id);
                            @endphp
                            <div class="friend-item">
                                <img class="h-16 w-16 rounded-full mx-auto mb-3 object-cover shadow-md border-2 border-white"
                                    src="{{ asset('images/profiles/' . $friend->profile) }}" alt="">
                                <a href="{{ route('profile.show', $friend->username) }}"
                                    class="text-xs font-medium text-gray-700 hover:text-blue-500">
                                    {{ $friend->username }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sección de Información Personal -->
                <div class="personal-info">
                    <h2 class="section-title text-gray-800 mb-8">Información Personal</h2>
                    <div class="personal-info-grid">
                        @if ($user->school)
                            <div class="personal-info-item">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="info-text text-gray-700">{{ $user->school }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($user->college)
                            <div class="personal-info-item">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="info-text text-gray-700">{{ $user->college }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($user->university)
                            <div class="personal-info-item">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="info-text text-gray-700">{{ $user->university }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($user->work)
                            <div class="personal-info-item">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="info-text text-gray-700">{{ $user->work }}</span>
                                </div>
                            </div>
                        @endif
                        @if ($user->website)
                            <div class="personal-info-item">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    <a href="{{ $user->website }}" class="info-text text-blue-500 hover:text-blue-700">{{ $user->website }}</a>
                                </div>
                            </div>
                        @endif
                        @if ($user->address)
                            <div class="personal-info-item">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="info-text text-gray-700">{{ $user->address }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sección de Publicaciones -->
            <div class="posts-section">
                <h2 class="section-title text-gray-800 mb-8">Publicaciones</h2>
                @if ($posts->count() > 0)
                    <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-3 post-grid">
                        @foreach ($posts as $post)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <img src="{{ asset('images/profiles/' . $user->profile) }}" alt="Avatar"
                                            class="w-10 h-10 rounded-full mr-3 border-2 border-white">
                                        <div>
                                            <h3 class="post-title text-gray-800">
                                                {{ $user->first_name }} {{ $user->last_name }}
                                            </h3>
                                    
                                        </div>
                                    </div>

                                    <h4 class="post-title text-gray-800 mb-4">{{ $post->title }}</h4>
                                    
                                    <img src="{{ asset('images/thumbnails/' . $post->thumbnail) }}" 
                                        alt="Post Image"
                                        class="w-full h-48 object-cover rounded-lg mb-4">

                                    <div class="flex justify-between items-center post-meta text-gray-500 mb-4">
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

                                    <div class="flex justify-between border-t pt-4">
                                        @php
                                            $like = App\Models\Like::where([
                                                'post_id' => $post->id,
                                                'user_id' => auth()->id(),
                                            ])->exists();
                                        @endphp
                                        <a href="{{ $like ? route('post.dislike', $post->id) : route('post.like', $post->id) }}"
                                            class="flex items-center post-actions text-gray-500 hover:text-blue-500 px-3 py-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                            </svg>
                                            Me gusta
                                        </a>
                                        <a href="{{ route('post.show', $post->uuid) }}"
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
                    <div class="text-center py-8">
                        <h3 class="section-title text-gray-700 mb-2">No hay publicaciones</h3>
                        <p class="info-text text-gray-500">Este usuario aún no ha compartido ninguna publicación.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

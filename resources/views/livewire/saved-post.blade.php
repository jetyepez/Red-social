{{-- Stop trying to control. --}}
@php
    $savedPosts = App\Models\SavedPost::where('user_id', auth()->id())->get();
    $posts = [];
    foreach ($savedPosts as $savedPost) {
        $post = App\Models\Post::where('id', $savedPost->post_id)->first();
        array_push($posts, $post);
    }
@endphp

<style>
    .saved-posts-container {
        margin-top: 50px;
        margin-bottom: 50px;
        padding: 40px;
        background-color: #f3f4f6;
    }
    .post-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .post-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .post-user {
        display: flex;
        align-items: center;
    }
    .post-actions {
        display: flex;
        gap: 10px;
    }
    .post-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin: 15px 0;
    }
    .post-stats {
        display: flex;
        gap: 20px;
        margin: 15px 0;
        color: #6b7280;
        font-size: 0.875rem;
    }
    .post-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #e5e7eb;
    }
    .post-interactions {
        display: flex;
        gap: 20px;
    }
</style>

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6">
        <div class="bg-gray-50 rounded-lg shadow-lg border border-gray-200 saved-posts-container">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Publicaciones Guardadas</h1>
            
            @if (session()->has('message'))
                <script>
                    setTimeout(function() {
                        document.querySelector('.alert').remove();
                    }, 5000);
                </script>
                <div class="alert absolute z-10 top-0 right-0 w-64 bg-gray-100 rounded-b-lg border-t-8 border-green-600 px-4 py-4 flex flex-col justify-around shadow-md">
                    <div class="flex justify-between items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ session('message') }}
                    </div>
                </div>
                @php
                    session()->forget('message');
                @endphp
            @endif

            @if (count($posts) > 0)
                <div class="grid gap-6 my-8 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
                    @foreach ($posts as $post)
                        <div class="post-card">
                            <div class="post-header">
                                <div class="post-user">
                                    @if ($post->is_page_post == 1)
                                        <img src="{{ 'images/pages/thumbnails/' . $post->page->thumbnail }}" alt="Avatar"
                                            class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <a href="{{ route('channel.show', $post->page->uuid) }}"
                                                class="text-sm font-bold text-gray-700">
                                                {{ $post->page->name }}
                                            </a>
                                            <p class="text-xs text-gray-600">{{ $post->page->members }} seguidores</p>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/images/profiles/' . $post->user->profile) }}" alt="Avatar"
                                            class="w-12 h-12 rounded-full mr-4">
                                        <div>
                                            <a href="{{ route('profile.show', $post->user->username) }}"
                                                class="text-sm font-bold text-gray-700">
                                                {{ $post->user->first_name }} {{ $post->user->last_name }}
                                            </a>
                                
                                        </div>
                                    @endif
                                </div>

                                <div class="post-actions">
                                    @if ($post->is_page_post == 1)
                                        <a href="{{ route('channel.post.show', $post->uuid) }}"
                                            class="px-2 py-1 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-l-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white">
                                            Leer Más
                                        </a>
                                    @else
                                        <a href="{{ route('post.show', $post->uuid) }}"
                                            class="px-2 py-1 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-l-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white">
                                            Leer Más
                                        </a>
                                    @endif

                                    <a href="{{ route('unsave-post', $post->id) }}"
                                        class="px-2 py-1 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-r-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m3 3 1.664 1.664M21 21l-1.5-1.5m-5.485-1.242L12 17.25 4.5 21V8.742m.164-4.078a2.15 2.15 0 0 1 1.743-1.342 48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185V19.5M4.664 4.664 19.5 19.5" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <h2 class="text-xl font-bold text-gray-700 mb-4">{{ $post->title }}</h2>
                            
                            <img src="{{ 'images/thumbnails/' . $post->thumbnail }}" alt="Post Image"
                                class="post-image">

                            <div class="post-stats">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
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

                            <div class="post-footer">
                                <div class="post-interactions">
                                    @php
                                        $like = App\Models\Like::where([
                                            'post_id' => $post->id,
                                            'user_id' => auth()->id(),
                                        ])->exists();
                                    @endphp
                                    <a href="{{ $like ? route('post.dislike', $post->id) : route('post.like', $post->id) }}"
                                        class="flex items-center text-gray-700 hover:text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        <span class="ml-1">Me gusta</span>
                                    </a>
                                    <a href="{{ route('post.show', $post->uuid) }}"
                                        class="flex items-center text-gray-700 hover:text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="ml-1">Comentar</span>
                                    </a>
                                    <a href="{{ route('share-post', $post->id) }}"
                                        class="flex items-center text-gray-700 hover:text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                        </svg>
                                        <span class="ml-1">Compartir</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-160">
                    <img src="{{ asset('images/website/zoom.gif') }}" alt="" width="150px">
                    <div class="text-center mt-6">
                        <h1 class="text-2xl font-semibold text-gray-700">No hay publicaciones guardadas</h1>
                        <p class="text-gray-500 mt-2">No hay publicaciones guardadas. Por favor, vuelve más tarde.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

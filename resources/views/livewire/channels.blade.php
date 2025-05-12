{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
@php
    // Get all channels except the user's own channels and the channels the user is already following
    $channels = \App\Models\Page::all()->where('user_id', '!=', auth()->id());
@endphp

<style>
    .main-container {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-top: 50px
    }
</style>

<div class="container px-6 mx-auto grid">
    <div class="main-container">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">Canales Públicos</h2>
        </div>
        @if ($channels->count() > 0)
            <div class="grid gap-6 my-8 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ($channels as $channel)
                    @if (App\Models\PageLike::where('user_id', auth()->id())->where('page_id', $channel->id)->exists())
                        @continue
                    @else
                        <div class="flex flex-col p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <div class="flex flex-col rounded-lg shadow-lg">
                                <div class="flex-shrink-0">
                                    @if ($channel->thumbnail)
                                        <img class="w-full h-32 rounded-lg"
                                            src="{{ 'images/pages/thumbnails/' . $channel->thumbnail }}" alt="">
                                    @else
                                        <img class="w-full h-32 rounded-lg" src="https://picsum.photos/200/300"
                                            alt="">
                                    @endif
                                </div>
                                <div class="flex-1 p-4">
                                    <div class="flex flex-col">
                                        <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            {{ $channel->name }}
                                        </h2>
                                        @if ($channel->members > 0)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                {{ $channel->members }} Seguidores
                                            </p>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex justify-between gap-4">
                                        <a href="{{ route('channel.show', $channel->uuid) }}"
                                            class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                                            Ver Canal
                                        </a>
                                        <a href="{{ route('follow-channel', $channel->id) }}"
                                            class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                                            Seguir Canal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-160">
                <img src="{{ asset('images/website/zoom.gif') }}" alt="" width="150px">
                <div class="text-center mt-6">
                    <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">No hay canales</h1>
                    <p class="text-gray-500 dark:text-gray-300 mt-2">No hay canales. Por favor, revisa más tarde.</p>
                </div>
            </div>
        @endif
    </div>
</div>

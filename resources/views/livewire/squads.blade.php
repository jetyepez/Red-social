{{-- Stop trying to control. --}}
@php
    // Get all squads except the user's own squads and the squads the user is already following
$squads = \App\Models\Group::all()->where('user_id', '!=', auth()->id());
@endphp

<style>
    .main-container {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-top: 50px;
    }
</style>

<div class="container px-6 mx-auto grid">
    <div class="main-container">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-700 dark:text-gray-100">Grupos Públicos</h2>
        </div>
        @if ($squads->count() > 0)
            <div class="grid gap-6 my-8 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
                @foreach ($squads as $squad)
                    @if (App\Models\GroupMember::where('user_id', auth()->id())->where('group_id', $squad->id)->exists())
                        @continue
                    @else
                        <div class="flex flex-col p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                            <div class="flex flex-col rounded-lg shadow-lg">
                                <div class="flex-shrink-0">
                                    @if ($squad->thumbnail)
                                        <img class="w-full h-32 rounded-lg"
                                            src="{{ 'images/squads/thumbnails/' . $squad->thumbnail }}" alt="">
                                    @else
                                        <img class="w-full h-32 rounded-lg" src="https://picsum.photos/200/300"
                                            alt="">
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-2">
                                        {{ $squad->name }}
                                    </h2>
                                    @if ($squad->members > 0)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            {{ $squad->members }} Miembros
                                        </p>
                                    @endif
                                </div>
                                <div class="mt-4 flex justify-between gap-4">
                                    <a href="{{ route('squad.show', $squad->uuid) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                                        Ver Grupo
                                    </a>
                                    <a href="{{ route('join-squad', $squad->id) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-purple">
                                        Unirse al Grupo
                                    </a>
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
                    <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">No hay Grupos</h1>
                    <p class="text-gray-500 dark:text-gray-300 mt-2">No hay grupos. Por favor, revisa más tarde.</p>
                </div>
            </div>
        @endif
    </div>
</div>

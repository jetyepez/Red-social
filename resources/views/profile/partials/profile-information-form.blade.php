<div class="flex items-center gap-4">
    <div class="relative">
        @if($user->profile)
            <img src="{{ asset('storage/' . $user->profile) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
        @else
            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-2xl text-gray-500">{{ substr($user->name, 0, 1) }}</span>
            </div>
        @endif
    </div>
    <div>
        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
        <p class="text-sm text-gray-500">{{ $user->email }}</p>
    </div>
</div> 
<div class="flex items-start space-x-3">
    <div class="flex-shrink-0">
        @if($post->user->profile)
            <img src="{{ asset('storage/' . $post->user->profile) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover">
        @else
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-sm text-gray-500">{{ substr($post->user->name, 0, 1) }}</span>
            </div>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900">
            {{ $post->user->name }}
        </p>
        <p class="text-sm text-gray-500">
            {{ $post->created_at->diffForHumans() }}
        </p>
    </div>
</div> 
<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
        
        <h2 class="text-lg font-bold text-center">{{ $tag->name }}</h2>
        <p class="text-sm text-center">{{ $tag->description }}</p>
        <p class="text-sm text-center">Followed by: {{ $tag->follower_count }}</p>
        @if (Auth::check())
            
        <form method="POST" action="{{ route('tags.toggle-follow', $tag->id) }}">
            @csrf
            <button 
                id="follow-toggle" 
                class="px-4 py-2 text-l w-24 text-white bg-red-500 rounded-lg hover:bg-red-700"
                type="submit"
            >
                {{ $tag->is_following ? 'Unfollow' : 'Follow' }}
            </button>
        </form>
        @else
        <div class="px-4 py-2 text-l text-white bg-red-500 rounded-lg hover:bg-red-700 text-center">
            <a href="{{ route('login') }}" class="font-bold text-center">
            Login to Follow this Tag
            </a>
        </div>
        @endif
    </div>
</aside>


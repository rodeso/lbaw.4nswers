<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
        
        <h2 class="text-lg font-bold text-center">{{ $tag->name }}</h2>
        <p class="text-sm text-center">{{ $tag->description }}</p>
        <p class="text-sm text-center">Followed by: {{ $tag->follower_count }}</p>
        <form method="POST" action="{{ route('admin-dashboard.deleteTag', $tag->id) }}">
            @csrf
            @method('POST')
            <button 
                type="submit" 
                class="px-4 py-2 text-l w-24 text-white bg-red-500 rounded-lg hover:bg-red-700"
            >
                Follow
            </button>
        </form>
    </div>
</aside>

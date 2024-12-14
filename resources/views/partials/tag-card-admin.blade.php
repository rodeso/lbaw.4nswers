<section class="w-[800px] h-full">
    <!-- Post's Question -->
    <section class="w-auto h-25 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-2">
        <div class="relative flex space-x-[10px] items-center">
            <div class="relative flex items-center w-full p-4 text-white bg-[color:#4B1414] rounded-md font-bold">

                <span class="px-4 py-2 mr-8 text-l w-36 text-center text-white bg-green-500 rounded-lg">{{ $tag->name }}</span>
            
                <span class="px-4 py-2 mr-8 text-l w-52 text-center text-white bg-blue-500 rounded-lg">{{ $tag->description }}</span>
        
                <span class="px-4 py-2 mr-8 text-l w-36 text-center text-white bg-gray-700 rounded-lg">Followers: {{ $tag->follower_count }}</span>

                <form method="POST" action="{{ route('admin-dashboard.deleteTag', $tag->id) }}">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-l w-32 text-white bg-red-500 rounded-lg hover:bg-red-700"
                    >
                        Delete Tag
                    </button>
                </form>

            </div>
        </div>
    </section>
</section>

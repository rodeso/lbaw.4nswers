<section class="w-[800px] h-full">
    <section class="w-auto h-25 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-2">
        <div class="relative flex justify-between space-x-[10px] items-center">
            <div class="relative flex items-center justify-between w-full p-4 text-white bg-[color:#4B1414] rounded-md font-bold">

                <a href="{{ route('tag', ['id' => $tag->id]) }}"><span class="px-4 py-2 text-l w-28 text-center text-white bg-green-500 rounded-lg">{{ $tag->name }}</span></a>
            
                <span class="px-4 py-2 text-l flex-1 mx-4 text-center text-white bg-gray-700 rounded-lg">{{ $tag->description }}</span>
        
                <span class="px-4 py-2  text-l w-40 mr-4 text-center text-white bg-gray-700 rounded-lg">Followers: {{ $tag->follower_count }}</span>

                <div class="flex flex-col space-y-2">
                    <!-- Edit Button -->
                    <a 
                        href="{{ route('tag.edit', $tag->id) }}" 
                        class="px-4 py-2 text-l w-24 text-white bg-blue-500 rounded-lg hover:bg-blue-700 text-center"
                    >
                        Edit
                    </a>
                    
                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('tag.delete', $tag->id) }}">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="px-4 py-2 text-l w-24 text-white bg-red-500 rounded-lg hover:bg-red-700"
                        >
                            Delete
                        </button>
                    </form>

                    
                </div>
            </div>
        </div>
    </section>
</section>

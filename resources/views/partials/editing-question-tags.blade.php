<!-- CSS for tags -->
<style>
    .tag {
        cursor: pointer;
        transition: background-color 0.3s ease;
        padding: 5px 10px;
        border-radius: 5px;
        margin: 5px;
    }

    .tag.selected {
        background-color: #FFD700; /* Gold for selected */
    }

    .tag.not-selected {
        background-color: #4B1414; /* Default */
        color: white;
    }

    .tag:hover {
        background-color: #FCF403; /* Light yellow on hover */
    }
</style>

<section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-5">
    <header class="flex items-center justify-between bg-[color:#4B1414] p-4 rounded-t-lg">
        <div class="flex items-center space-x-4">
            <img
                src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}"
                alt="Profile Picture"
                class="w-14 h-14 rounded-full"
            />
            <p class="text-lg text-white">Editing as {{ Auth::user()->nickname }}</p>
        </div>
    </header>

    <form action="{{ route('question.update-tags', $question->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <input type="hidden" id="selected-tags" name="selected_tags" value="">
        <input type="hidden" id="new-tags" name="new_tags" value="">

        <!-- Existing Tags -->
        <div class="space-y-2">
            <label for="tags" class="text-white">Tags</label>
            <div id="tags-container" class="flex flex-wrap">
                @foreach ($tags as $tag)
                    <div 
                        class="tag {{ $question->tags->contains($tag->id) ? 'bg-[color:#FCF403]' : 'bg-gray-300' }} text-black-800 px-2 py-1 rounded cursor-pointer"
                        data-id="{{ $tag->id }}"
                    >
                        {{ $tag->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add New Tags -->
        <div class="space-y-2">
                <!-- Input for new tags -->
                <div class="flex items-center space-x-4">
                    <input 
                        type="text" 
                        id="new-tag-name" 
                        class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]" 
                        placeholder="New Tag Name"
                    >
                    <input 
                        type="text" 
                        id="new-tag-description" 
                        class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]" 
                        placeholder="Tag Description"
                    >
                </div>
                <!-- Add Tag Button -->
                <div class="flex justify-center">
                    <button 
                        type="button" 
                        id="add-new-tag" 
                        class="w-[12rem] px-6 py-2 text-sm bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
                    >
                        Add Tag
                    </button>
                </div>
            </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full p-2 bg-[color:#4B1414] text-white rounded-lg">Save Changes</button>
    </form>
</section>

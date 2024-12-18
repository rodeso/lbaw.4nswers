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
            <p class="text-lg text-white">Asking as {{ Auth::user()->nickname }}</p>
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
            <label for="new-tags" class="text-white">Add New Tags</label>
            <div class="flex space-x-2">
                <input 
                    type="text" 
                    id="new-tag-name" 
                    placeholder="Tag Name" 
                    class="w-full p-2 bg-[color:#4B1414] text-white rounded-lg"
                />
                <input 
                    type="text" 
                    id="new-tag-description" 
                    placeholder="Description" 
                    class="w-full p-2 bg-[color:#4B1414] text-white rounded-lg"
                />
                <button type="button" id="add-new-tag" class="p-2 bg-[color:#4B1414] text-white rounded-lg">
                    Add
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full p-2 bg-[color:#4B1414] text-white rounded-lg">Save Changes</button>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tagsContainer = document.getElementById('tags-container');
        const selectedTagsInput = document.getElementById('selected-tags');
        const newTagsInput = document.getElementById('new-tags');
        const newTagNameField = document.getElementById('new-tag-name');
        const newTagDescriptionField = document.getElementById('new-tag-description');
        const addNewTagButton = document.getElementById('add-new-tag');

        let selectedTags = []; // Array to store selected tag IDs
        let newTags = []; // Array to store new tags as objects with name and description

        // Toggle selection of existing tags
        tagsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('tag')) {
                const tag = e.target;
                const tagId = tag.getAttribute('data-id');

                if (selectedTags.includes(tagId)) {
                    selectedTags = selectedTags.filter(id => id !== tagId);
                    tag.classList.remove('bg-[color:#FCF403]');
                    tag.classList.add('bg-gray-300');
                } else {
                    selectedTags.push(tagId);
                    tag.classList.remove('bg-gray-300');
                    tag.classList.add('bg-[color:#FCF403]');
                }

                selectedTagsInput.value = selectedTags.join(',');
            }
        });

        // Add new tags dynamically
        addNewTagButton.addEventListener('click', () => {
            const newTagName = newTagNameField.value.trim();
            const newTagDescription = newTagDescriptionField.value.trim();

            if (newTagName && newTagDescription) {
                const newTagObj = { name: newTagName, description: newTagDescription };

                // Create a new span for the new tag
                const newTagSpan = document.createElement('span');
                newTagSpan.className = "tag bg-[color:#FCF403] text-black-800 text-sm font-bold px-2 py-1 rounded cursor-pointer";
                newTagSpan.textContent = newTagName;

                // Add a custom attribute to track its index in `newTags`
                const tagIndex = newTags.length;
                newTagSpan.setAttribute('data-index', tagIndex);

                // Add event listener to toggle selection for the new tag
                newTagSpan.addEventListener('click', () => {
                    const index = parseInt(newTagSpan.getAttribute('data-index'));

                    // Toggle selection
                    if (newTagSpan.classList.contains('bg-[color:#FCF403]')) {
                        newTagSpan.classList.remove('bg-[color:#FCF403]');
                        newTagSpan.classList.add('bg-gray-300');
                        delete newTags[index]; // Remove from newTags
                    } else {
                        newTagSpan.classList.remove('bg-gray-300');
                        newTagSpan.classList.add('bg-[color:#FCF403]');
                        newTags[index] = newTagObj; // Re-add to newTags
                    }

                    // Filter out any `undefined` values from newTags and update hidden input
                    newTagsInput.value = JSON.stringify(newTags.filter(tag => tag));
                });

                // Append the new tag span and add it to the newTags array
                tagsContainer.appendChild(newTagSpan);
                newTags.push(newTagObj);

                // Clear the input fields
                newTagNameField.value = '';
                newTagDescriptionField.value = '';
                newTagsInput.value = JSON.stringify(newTags);
            } else {
                alert('Please provide both a name and a description for the new tag.');
            }
        });

    });
</script>
<style>
    .tag {
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .tag:hover {
        background-color: #FFD700; /* Gold on hover */
    }
</style>
<section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-5">
    <header class="flex items-center justify-between bg-[color:#4B1414]">
        <div class="relative flex items-center space-x-16">
            <div class="absolute w-14 h-14 bg-gray-300 rounded-2xl -left-1">
                <img 
                    src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="absolute w-14 h-14 bg-gray-300 rounded-2xl"
                />
            </div>
            <p class="text-lg text-white">Asking as: {{ Auth::user()->nickname }}</p>
        </div>
    </header>
    <form action="{{ route('question.store') }}" method="POST">
        @csrf
        <!-- Title of the question -->
        <div class= "mb-6 pt-2">
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                placeholder="Enter the title of your question..."
                required
            >
        </div>
        <div class= "mb-4">
            <!-- Body of the question -->
            <textarea 
                name="body" 
                id="body" 
                cols="30" 
                rows="5" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                placeholder="Provide details about your question..."
                required
            ></textarea>
        </div>
        <div class= "mb-6">
            <!-- Urgency Level -->
            <label for="urgency" class="block text-gray-700 font-bold mb-2">Urgency Level:</label>
            <select 
                name="urgency" 
                id="urgency" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                required
            >
                <option value="Red">Red (Most Urgent)</option>
                <option value="Orange">Orange</option>
                <option value="Yellow">Yellow</option>
                <option value="Green">Green (Least Urgent)</option>
            </select>
        </div>
        <div class="mb-6"> <!--Tags Selection & Creation-->
            <label class="block text-gray-700 font-bold mb-2">Tags:</label>
            <div id="tags-container" class="flex flex-wrap gap-2 mb-4">
                @foreach($tags as $tag)
                    <span 
                        class="tag bg-gray-300 text-black-800 text-sm font-bold px-2 py-1 rounded cursor-pointer" 
                        data-id="{{ $tag->id }}"
                    >
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
            <!-- Hidden input to store selected tag IDs -->
            <input type="hidden" name="tags" id="selected-tags" value="">
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
            <!-- Hidden input to store new tag names and descriptions -->
            <input type="hidden" name="new_tags" id="new-tags" value="">
        </div>
        <div class= "mb-6">
            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
            >
                Post Question
            </button>
        </div>
    </form>
</section>

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
            <p class="text-lg text-white">Editing as {{ Auth::user()->nickname }}</p>
        </div>
    </header>

    <form action="{{ route('question.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Title of the question -->
        <div class="mb-6 pt-2">
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                placeholder="Enter the title of your question..."
                value="{{ old('title', $question->title) }}"
                required
            >
        </div>

        <!-- Body of the question -->
        <div class="mb-4">
            <textarea 
                name="body" 
                id="body" 
                cols="30" 
                rows="5" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                placeholder="Provide details about your question..."
                required
            >{{ old('body') ?? $post->body }}</textarea>
        </div>

        <!-- Urgency Level -->
        <div class="mb-6">
            <label for="urgency" class="block text-gray-700 font-bold mb-2">Urgency Level: <span class="text-[color:#FF006E]">*</span></label>
            <select 
                name="urgency" 
                id="urgency" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                required
            >
                <option value="Red" {{ old('urgency', $question->urgency) == 'Red' ? 'selected' : '' }}>Red (Most Urgent)</option>
                <option value="Orange" {{ old('urgency', $question->urgency) == 'Orange' ? 'selected' : '' }}>Orange</option>
                <option value="Yellow" {{ old('urgency', $question->urgency) == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                <option value="Green" {{ old('urgency', $question->urgency) == 'Green' ? 'selected' : '' }}>Green (Least Urgent)</option>
            </select>
        </div>

        <div class="mb-6">
            <button 
                type="submit" 
                class="w-full p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
            >
                Update Question
            </button>
        </div>
    </form>
</section>

</script>


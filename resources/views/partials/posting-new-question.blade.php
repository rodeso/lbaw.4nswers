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
        <input 
            type="text" 
            name="title" 
            id="title" 
            class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
            placeholder="Enter the title of your question..."
            required
        >
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
        <!-- Urgency Level -->
        <label for="urgency" class="block text-sm text-white">Urgency Level:</label>
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
        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
        >
            Post Question
        </button>
    </form>
</section>

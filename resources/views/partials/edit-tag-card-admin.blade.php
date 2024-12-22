<section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-5">
    <header class="flex items-center justify-between bg-[color:#4B1414] p-4 rounded-md">
        <div class="relative flex items-center space-x-16">
            <div class="absolute w-14 h-14 bg-gray-300 rounded-2xl -left-1">
                <img 
                    src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="absolute w-14 h-14 bg-gray-300 rounded-2xl"
                />
            </div>
            <p class="text-lg text-white">Editing Tag</p>
        </div>
    </header>

    <form action="{{ route('admin.updateTag', $tag->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Tag Name Input -->
        <div class="mb-4">
            <input 
                type="text" 
                name="name" 
                value="{{ $tag->name }}" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A] text-black bg-gray-100"
                placeholder="Tag Name"
                required
            />
        </div>

        <!-- Tag Description Input -->
        <div class="mb-4">
            <textarea 
                name="description" 
                id="description" 
                cols="30" 
                rows="4" 
                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A] text-black bg-gray-100"
                placeholder="Provide details about the tag..."
            >{{ $tag->description }}</textarea>
        </div>

        <!-- Submit Button -->
        <div class="mb-6">
            <button 
                type="submit" 
                class="w-full p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
            >
                Save Tag
            </button>
        </div>
    </form>
</section>

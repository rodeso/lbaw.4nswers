<section class="w-[700px] h-[100px]">
    <!-- Post's Question -->
    <section class="w-auto h-25 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-2">
        <div class="relative flex space-x-[10px] items-center">
            <p class="text-4xl text-white p-4 bg-[color:#4B1414] rounded-full w-[80px] text-center">{{ $count }}</p>
            <div class="w-20 h-20 bg-gray-300 rounded-2xl ml-20 overflow-hidden">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="w-full h-full object-cover"
                />
            </div>
            <div class="relative flex items-center space-x-[100px] flex-grow p-4 ml-4 mr-4 bg-[color:#4B1414] rounded-md">
                <a 
                    href="{{ Auth::id() === $user->id ? route('profile') : route('user.profile', ['id' => $user->id]) }}" 
                    class="ml-[50px] text-2xl text-white hover:text-gray-500"
                >
                    {{ $user->nickname }}
                </a>
                <p class="text-2xl text-white absolute left-[180px]">Aura: {{ $user->aura }}</p>
            </div>
        </div>
    </section>
</section>

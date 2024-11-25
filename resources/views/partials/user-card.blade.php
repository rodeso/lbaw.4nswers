<section class="w-[650px] h-[100px]">
    <!-- Post's Question -->
    <section class="w-auto h-25 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-2">
        <div class="relative flex space-x-[10px] items-center">
            <p class="text-4xl text-white p-4 bg-[color:#4B1414] rounded-full w-[100px] text-center">{{ $count }}</p>
            <div class="w-20 h-20 bg-gray-300 rounded-2xl ml-20">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="w-20 h-20 bg-gray-300 rounded-2xl !m-0"
                />
            </div>
            <div class="relative flex items-center space-x-[100px] w-full p-4 ml-4 mr-4  bg-[color:#4B1414] rounded-md">
                <p class="ml-[50px] text-2xl text-white !mr-1rem">{{ $user->nickname }}</p>
                <p class="text-2xl text-white absolute left-[180px]">Aura: {{ $user->aura }}</p>
            </div>
        </div>
    </section>
</section>
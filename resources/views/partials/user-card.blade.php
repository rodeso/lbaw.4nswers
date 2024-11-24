<section class="w-[700px] h-[100px]">
    <!-- Post's Question -->
    <section class="w-auto h-25 m-0 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-4">
        <div class="relative flex m-0 space-x-[10px] items-center">
            <p class="text-3xl text-white p-4 m-4 bg-[color:#4B1414] rounded-full">{{ $count }}</p>
            <div class="w-20 h-20 bg-gray-300 rounded-2xl ml-20">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="w-20 h-20 bg-gray-300 rounded-2xl !m-0"
                />
            </div>
            <div class="relative flex items-center ml-[200px] space-x-[100px] w-full p-4 m-4 bg-[color:#4B1414] rounded-md">
                <p class="ml-[40px] text-2xl text-white">User: {{ $user->nickname }}</p>
                <p class="text-2xl text-white absolute left-[220px]">Aura: {{ $user->aura }}</p>
            </div>
        </div>
    </section>
</section>
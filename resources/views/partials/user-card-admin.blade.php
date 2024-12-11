<section class="w-[650px] h-[100px]">
    <!-- Post's Question -->
    <section class="w-auto h-25 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-2">
        <div class="relative flex space-x-[10px] items-center">
            <div class="w-20 h-20 bg-gray-300 rounded-2xl ml-0">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="w-20 h-20 bg-gray-300 rounded-2xl !m-0"
                />
            </div>
            <div class="relative flex items-center space-x-[100px] w-full p-4 ml-4 mr-4 bg-[color:#4B1414] rounded-md">
                <a 
                    href="{{ Auth::id() === $user->id ? route('profile') : route('user.profile', ['id' => $user->id]) }}" 
                    class="ml-[50px] text-2xl text-white hover:text-gray-500"
                >
                    {{ $user->nickname }}
                </a>
                <form method="POST" action="{{ route('user.toggleMod', ['id' => $user->id]) }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-2xl text-white bg-blue-500 rounded-lg hover:bg-blue-700"
                    >
                        {{ $user->is_mod ? 'Remove Mod' : 'Make Mod' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('user.toggleBlock', ['id' => $user->id]) }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="px-4 py-2 text-2xl text-white bg-red-500 rounded-lg hover:bg-red-700"
                    >
                        {{ $user->is_blocked ? 'Unblock User' : 'Block User' }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</section>

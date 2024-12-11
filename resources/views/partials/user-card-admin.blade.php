<section class="w-[1000px] h-[100px]">
    <!-- Post's Question -->
    <section class="w-auto h-25 bg-[color:#C18A8A] rounded-lg shadow-md p-3 space-y-2">
        <div class="relative flex space-x-[10px] items-center">
            <div class="w-20 h-20 bg-gray-300 rounded-2xl ml-0 overflow-hidden">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="w-full h-full object-cover"
                />
            </div>
            <div class="relative flex items-center w-full p-4 ml-4 mr-4 bg-[color:#4B1414] rounded-md">
                <a 
                    href="{{ Auth::id() === $user->id ? route('profile') : route('user.profile', ['id' => $user->id]) }}" 
                    class="text-2xl ml-12 text-white hover:text-gray-500"
                >
                    {{ $user->nickname }}
                </a>
                <div class="absolute right-10 flex">
                    @if (Auth::user()->is_admin)
                        @if ($user->is_admin)
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-green-500 rounded-lg">Admin</span>
                        @elseif ($user->is_blocked)
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-gray-700 rounded-lg">Not Available</span>
                        @else
                            <form method="POST" action="{{ route('user.toggleMod', ['id' => $user->id]) }}">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 mr-10 text-xl w-40 text-white bg-blue-500 rounded-lg hover:bg-blue-700"
                                >
                                    {{ $user->is_mod ? 'Remove Mod' : 'Make Mod' }}
                                </button>
                            </form>
                        @endif
                        @if ($user->is_admin || $user->is_mod)
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-gray-700 rounded-lg">Not Available</span>
                        @else
                            <form method="POST" action="{{ route('user.toggleBlock', ['id' => $user->id]) }}">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 mr-10 text-xl w-40 text-white bg-red-500 rounded-lg hover:bg-red-700"
                                >
                                    {{ $user->is_blocked ? 'Unblock User' : 'Block User' }}
                                </button>
                            </form>
                        @endif
                        @if ($user->is_admin || $user->is_mod)
                            <span class="px-4 py-2 text-xl w-40 text-center text-white bg-gray-700 rounded-lg">Not Available</span>
                        @else
                            <form method="POST" action="">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 text-xl w-40 text-white bg-red-500 rounded-lg hover:bg-red-700"
                                >
                                    Delete User
                                </button>
                            </form>
                        @endif
                    @elseif (!Auth::user()->is_admin && Auth::user()->is_mod)
                        @if ($user->is_admin)
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-green-500 rounded-lg">Admin</span>
                        @elseif ($user->is_mod)
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-blue-500 rounded-lg">Moderator</span>
                        @else
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-gray-700 rounded-lg">Not Available</span>
                        @endif
                        @if ($user->is_admin || $user->is_mod)
                            <span class="px-4 py-2 mr-10 text-xl w-40 text-center text-white bg-gray-700 rounded-lg">Not Available</span>
                        @else
                            <form method="POST" action="{{ route('user.toggleBlock', ['id' => $user->id]) }}">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 mr-10 text-xl w-40 text-white bg-red-500 rounded-lg hover:bg-red-700"
                                >
                                    {{ $user->is_blocked ? 'Unblock User' : 'Block User' }}
                                </button>
                            </form>
                        @endif
                        <span class="px-4 py-2 text-xl w-40 text-center text-white bg-gray-700 rounded-lg">Not Available</span>
                    @endif
                </div>
            </div>
        </div>
    </section>
</section>

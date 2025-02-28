<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
        <div class="relative group w-24 h-24">
            @if (Auth::id() === $user->id) <!-- Check if the logged-in user is viewing their own profile -->
                <a href="{{ route('profile.edit') }}" class="relative block w-24 h-24">
                    <img 
                        src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="w-24 h-24 rounded-full shadow-lg"
                    />
                    <div 
                        class="absolute inset-0 flex items-center justify-center bg-black/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="h-6 w-6 text-white" 
                            viewBox="0 0 20 20" 
                            fill="currentColor"
                        >
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7.05 10.12a1 1 0 00-.263.474l-1.11 4.44a.5.5 0 00.607.607l4.44-1.11a1 1 0 00.474-.263l7.536-7.535a2 2 0 000-2.829l-1.414-1.414zm-2.121 1.414l1.414 1.414-7.536 7.535-1.414-1.414 7.536-7.535zM5 18a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                </a>
            @elseif (Auth::user()->is_admin) <!-- Check if the user is an admin -->
                <a href="{{ route('user.edit', $user->id) }}" class="relative block w-24 h-24">
                    <img 
                        src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="w-24 h-24 rounded-full shadow-lg"
                    />
                    <div 
                        class="absolute inset-0 flex items-center justify-center bg-black/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="h-6 w-6 text-white" 
                            viewBox="0 0 20 20" 
                            fill="currentColor"
                        >
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7.05 10.12a1 1 0 00-.263.474l-1.11 4.44a.5.5 0 00.607.607l4.44-1.11a1 1 0 00.474-.263l7.536-7.535a2 2 0 000-2.829l-1.414-1.414zm-2.121 1.414l1.414 1.414-7.536 7.535-1.414-1.414 7.536-7.535zM5 18a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                </a>
            @else

                <div class="relative block w-24 h-24">
                    <img 
                        src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="w-24 h-24 rounded-full shadow-lg"
                    />
                </div>
            @endif
        </div>
        <h2 class="text-lg font-bold text-center">{{ $user->name }}</h2>
        <p class="text-sm text-center">{{ $user->nickname }}</p>
        <p class="text-sm text-center">Aura: {{ $user->aura }}</p>
    </div>


    <!-- Links page section -->
    <div class="relative mt-2 pt-2">
        <div class="absolute top-2 left-0 h-full w-1 bg-[color:#C18A8A] rounded"></div>
        
        <h4 class="font-bold mb-4 text-[color:#C18A8A] pl-4">Sort Content:</h4>
        <ul class="space-y-2">
            <li><a href="#questions-section" class="pl-4 text-[color:#C18A8A] hover:underline">View Questions</a></li>
            <li><a href="#answers-section" class="pl-4 text-[color:#C18A8A] hover:underline">View Answers</a></li>
            <li><a href="#comments-section" class="pl-4 text-[color:#C18A8A] hover:underline">View Comments</a></li>
            <li><a href="#followed-question-section" class="pl-4 text-[color:#C18A8A] hover:underline">View Followed</a></li>
        </ul>
    </div>
</aside>

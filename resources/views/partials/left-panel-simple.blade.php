<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    @if (Auth::check())
        <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
            <div class="relative group w-24 h-24">
                <div class="relative block w-24 h-24">
                    <img 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="w-24 h-24 rounded-full shadow-lg"
                    />
                </div>
            </div>
            <h2 class="text-lg font-bold text-center">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-center">{{ Auth::user()->nickname }}</p>
            <p class="text-sm text-center">Aura: {{ Auth::user()->aura }}</p>
        </div>
    @else
    <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
        <a href="{{ route('login') }}" class="text-lg font-bold text-center">
        Login to See your Aura
        </a>
    </div>
    @endif
</aside>

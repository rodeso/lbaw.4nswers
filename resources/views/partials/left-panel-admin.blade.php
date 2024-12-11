<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center mb-8 bg-[color:#C18A8A] p-4 relative">
        <div class="relative group w-24 h-24">
            <div class="relative block w-24 h-24">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="w-24 h-24 rounded-full shadow-lg"
                />
            </div>
        </div>
        <h2 class="text-lg font-bold text-center">{{ $user->name }}</h2>
        <p class="text-sm text-center">{{ $user->nickname }}</p>
        <p class="text-sm text-center">Aura: {{ $user->aura }}</p>
    </div>


    <!-- Links page section -->
    <div class="relative mt-8">
        <div class="absolute top-0 left-0 h-full w-1 bg-[color:#C18A8A] rounded"></div>
        
        <h4 class="font-bold mb-4 text-[color:#C18A8A] pl-4">Jump to:</h4>
        <ul class="space-y-2">
            <li><a href="#" class="pl-4 text-[color:#C18A8A] hover:underline">Admins</a></li>
            <li><a href="#" class="pl-4 text-[color:#C18A8A] hover:underline">Moderators</a></li>
            <li><a href="#" class="pl-4 text-[color:#C18A8A] hover:underline">Blocked Users</a></li>
            <li><a href="#" class="pl-4 text-[color:#C18A8A] hover:underline">Other Users</a></li>
        </ul>
    </div>
</aside>

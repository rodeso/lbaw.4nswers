<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
        <div class="relative group w-24 h-24">
            <a class="relative block w-24 h-24">
                <img 
                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="User Avatar" 
                    class="w-24 h-24 rounded-full shadow-lg"
                />
            </a>
        </div>
        <h2 class="text-lg font-bold text-center">{{ $user->name }}</h2>
        <p class="text-sm text-center">{{ $user->nickname }}</p>
        <p class="text-sm text-center">Aura: {{ $user->aura }}</p>
    </div>

    <!-- Links page section -->
    <div class="relative mt-2 pt-2">
        <div class="absolute top-2 left-0 h-full w-1 bg-[color:#C18A8A] rounded"></div>
        
        <h4 class="font-bold mb-4 text-[color:#C18A8A] pl-4">Personal Hidden Information:</h4>
        <ul class="space-y-2">
            <li>
                <a class="block pl-4 text-[color:#C18A8A]">
                    Birth Date: 
                    <span class="block">{{ \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') }}</span>
                </a>
            </li>
            <li>
                <a class="block pl-4 text-[color:#C18A8A]">
                    Email: 
                    <span class="block">{{ formatEmail($user->email) }}</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Delete Account Button -->
    <div class="mt-4 pt-2">
        <button class="text-white bg-red-600 hover:bg-red-700 font-bold py-2 px-6 rounded shadow-lg w-full">
            Delete Account
        </button>
    </div>
</aside>


@php
    /**
     * Format an email address to display only the first two characters and mask the rest until the '@'.
     *
     * @param string $email
     * @return string
     */
    function formatEmail($email) {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];
        
        if (strlen($name) > 2) {
            $maskedName = substr($name, 0, 2) . str_repeat('*', strlen($name) - 2);
        } else {
            $maskedName = str_repeat('*', strlen($name)); // Mask the entire name if it's too short
        }

        return $maskedName . '@' . $domain;
    }
@endphp

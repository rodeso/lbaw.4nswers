<header class="fixed top-0 left-0 w-full bg-[color:#4E0F35] text-white px-8 py-2 flex justify-between items-center z-10">
    <div class="flex items-center space-x-4">
        <h1 class="text-2xl font-bold">4NSWERS</h1>
    </div>
    <!-- Scrolling Banner -->
    <div class="relative overflow-hidden bg-[color:#4B1414]">
        <div class="scrolling-text bg-[color:#4B1414] text-[color:#FF006E] py-2 px-4 whitespace-nowrap">
            ⚡ Urgent: Question about "X" is about to expire. View Hall of Fame 🎉 Join the Conversation Today!
        </div>
    </div>
    <!-- Right Side Buttons -->
    <div class="flex items-center space-x-2 "> 
        <button class="bg-[color:#444444] p-2 rounded-full squircle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11m4 0h1M5 6h14M5 14h14m-4 4h4m-6 0h-4m-6 0h-2m6-12h2m4 0h2m-6 8h4m-6 4h2m2-8h4" />
            </svg>
        </button>
        <button class="bg-[color:#444444] p-2 rounded-full squircle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.5V11a6 6 0 00-9.33-4.945M9 17h-.01" />
            </svg>
        </button>
        <button id="userButton" class="bg-[color:#444444] p-2 rounded-full squircle"
            data-logged-in="{{ Auth::check() ? 'true' : 'false' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zm0 1.5c-3.177 0-9 1.589-9 4.5v1.5h18v-1.5c0-2.911-5.823-4.5-9-4.5z" />
            </svg>
        </button>
    </div>
    <!-- Squircle decorations -->
    <div class="absolute inset-0 -z-10 squircle opacity-20"></div>
</header>
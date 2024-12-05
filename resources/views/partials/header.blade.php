<script>
    document.addEventListener("DOMContentLoaded", () => {
    const userButton = document.getElementById("userButton");
    const userNickname = "{{ Auth::user()->nickname ?? '' }}";

    userButton.addEventListener("click", () => {
        const isLoggedIn = userButton.getAttribute("data-logged-in") === "true";
        const drawer = document.querySelector(".drawer-menu");

        if (isLoggedIn) {
            if (drawer) {
                drawer.classList.add("translate-x-full");
                setTimeout(() => drawer.remove(), 300); // Wait for animation to complete before removing
            } else {
                // Otherwise, open the drawer
                openDrawerMenu(userNickname);
            }
        } else {
            window.location.href = "/login";
        }
    });

    const openDrawerMenu = (nickname) => {
        const drawer = document.createElement("div");
        drawer.className = "drawer-menu fixed top-0 right-0 h-full w-64 bg-[color:#4E0F35] text-white shadow-lg flex flex-col justify-between p-4 transform transition-transform translate-x-full";
        drawer.innerHTML = `
            <div>
                <button class="text-white mb-4" onclick="this.parentElement.parentElement.remove()">Close</button>
                <h2 class="text-xl font-bold">${nickname} Menu</h2>
                <ul class="mt-4">
                    <a href={{ route('user.profile', ['id' => Auth::id()]) }}><li class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">Profile</li></a>
                    @if (Auth::user()->is_admin)
                    <a href=""><li class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">Admin Dashboard</li></a>
                    @endif
                    <a href=""><li class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">Settings</li></a>

                    <a href="{{ route('hall-of-fame') }}"><li class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">Hall of Fame</li></a>
                    
                    <a href=""><li class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">About Us</li></a>
                    <a href="{{ route('terms-and-conditions') }}"><li class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">Terms & Conditions</li></a>
                </ul>
            </div>
            <div>
                <form id="logoutForm" method="GET" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="py-2 hover:bg-gray-700 hover:text-[color:#FF006E] px-4 rounded">Logout</button>
                </form>
            </div>
        `;
        document.body.appendChild(drawer);

        // Trigger the slide-in animation
        setTimeout(() => {
            drawer.classList.remove("translate-x-full");
        }, 10); // Small delay to ensure the class change triggers the animation
    };

});
</script>
<style>
    /* Custom scrollbar for the banner */
    .scroll-banner::-webkit-scrollbar {
        display: none;
    }
    .scroll-banner {
        scrollbar-width: none; /* Firefox */
    }
    /* Scrolling Text Animation */
    .scrolling-text {
        display: inline-block;
        animation: scroll 20s linear infinite; 
        will-change: transform;
    }

    @keyframes scroll {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    /* Stop animation on hover */
    .scrolling-text:hover {
        animation-play-state: paused;
    }
    .drawer-menu {
        transition: transform 0.3s ease-in-out;
    }

    .drawer-menu.translate-x-full {
        transform: translateX(100%);
    }

    .drawer-menu:not(.translate-x-full) {
        transform: translateX(0);
    }

</style>
<header class="fixed top-0 left-0 w-full bg-[color:#4E0F35] text-white py-2 flex justify-between items-center z-10">
    <div class="flex items-center space-x-4 mx-auto relative">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-[color:#FF006E]">4NSWERS</a>
    </div>
    <!-- Scrolling Banner -->
    <div class="relative overflow-hidden bg-[#4B1414] w-2/3 mx-auto rounded-xl">
        <div class="scrolling-text bg-[#4B1414] text-[#FF006E] py-2 px-6 whitespace-nowrap">
        @if($urgentQuestion)
        <a href="{{ route('question.show', ['id' => $urgentQuestion->id]) }}" class="text-[#FF006E]"> ⚡ Urgent: The Question "{{ $urgentQuestion->title }}" is about to expire.</a> <a href="{{ route('hall-of-fame') }}">View Hall of Fame 🎉</a> <a href ="{{ route('new-question') }}" >Join the Conversation Today!</a>
        @else
        <a href="{{ route('hall-of-fame') }}">View Hall of Fame 🎉</a> <a href ="{{ route('new-question') }}" >Join the Conversation Today!</a>
        @endif
        </div>
    </div>

    <!-- Right Side Buttons -->
    <div class="flex items-center space-x-6 mx-auto relative"> 
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
</header>

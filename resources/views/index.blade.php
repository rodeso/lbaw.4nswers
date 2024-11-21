<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar for the banner */
        .scroll-banner::-webkit-scrollbar {
            display: none;
        }
        .scroll-banner {
            scrollbar-width: none; /* Firefox */
        }
        /* Squircle styling */
        .squircle {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), transparent);
            clip-path: path("M20,2 Q38,2,38,20 Q38,38,20,38 Q2,38,2,20 Q2,2,20,2 Z");
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
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const userButton = document.getElementById("userButton");
        const userNickname = "{{ Auth::user()->nickname ?? '' }}";

        userButton.addEventListener("click", () => {
            const isLoggedIn = userButton.getAttribute("data-logged-in") === "true";
            const drawer = document.querySelector(".drawer-menu");

            if (isLoggedIn) {
                if (drawer) {
                    // If the drawer exists, remove it
                    drawer.remove();
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
            drawer.className = "drawer-menu fixed top-0 right-0 h-full w-64 bg-[color:#4E0F35] text-white shadow-lg flex flex-col justify-between p-4";
            drawer.innerHTML = `
                <div>
                    <button class="text-white mb-4" onclick="this.parentElement.parentElement.remove()">Close</button>
                    <h2 class="text-xl font-bold">${nickname} Menu</h2>
                    <ul class="mt-4">
                        <li class="py-2 hover:bg-gray-700 px-4 rounded">Profile</li>
                        <li class="py-2 hover:bg-gray-700 px-4 rounded">Settings</li>
                    </ul>
                </div>
                <div>
                    <form id="logoutForm" method="GET" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 px-4 hover:bg-[color:#FF006E] rounded">Logout</button>
                    </form>
                </div>
            `;
            document.body.appendChild(drawer);
        };
    });
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        @include('partials.header')

        <!-- Floating Side Panel (Left) -->
        @include('partials.left-panel')

        <!-- Floating Buttons (Right) -->
        @include('partials.right-buttons')
        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Posts Section -->
            <section class="w-3/5 space-y-8">
                @foreach ($questions as $question)
                    @include('partials.question')
                @endforeach
            </section>
        </main>


        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

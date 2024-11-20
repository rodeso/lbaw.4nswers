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
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="fixed top-0 left-0 w-full bg-gray-900 text-white px-8 py-2 flex justify-between items-center z-10">
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold">4NSWERS</h1>
            </div>
            <!-- Scrolling Banner -->
            <div class="relative overflow-hidden bg-gray-800">
                <div class="scrolling-text bg-gray-800 text-white py-2 px-4 whitespace-nowrap">
                    ⚡ Urgent: Question about "X" is about to expire. View Hall of Fame 🎉 Join the Conversation Today!
                </div>
            </div>
            <!-- Right Side Buttons -->
            <div class="flex items-center space-x-2 right-"> 
                <button class="bg-gray-800 p-2 rounded-full squircle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11m4 0h1M5 6h14M5 14h14m-4 4h4m-6 0h-4m-6 0h-2m6-12h2m4 0h2m-6 8h4m-6 4h2m2-8h4" />
                    </svg>
                </button>
                <button class="bg-gray-800 p-2 rounded-full squircle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.5V11a6 6 0 00-9.33-4.945M9 17h-.01" />
                    </svg>
                </button>
                <button id="userButton" class="bg-gray-800 p-2 rounded-full squircle"
                    data-logged-in="{{ Auth::check() ? 'true' : 'false' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.485 0 4.5-2.015 4.5-4.5S14.485 3 12 3 7.5 5.015 7.5 7.5 9.515 12 12 12zm0 1.5c-3.177 0-9 1.589-9 4.5v1.5h18v-1.5c0-2.911-5.823-4.5-9-4.5z" />
                    </svg>
                </button>
            </div>
            <!-- Squircle decorations -->
            <div class="absolute inset-0 -z-10 squircle opacity-20"></div>
        </header>


        <!-- Floating Side Panel (Left) -->
        <aside class="fixed top-20 left-5 w-[15%] bg-gray-200 p-6 rounded-lg shadow-lg">
            <nav>
                <ul class="space-y-4">
                    <li>
                        <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                            4U
                        </button>
                    </li>
                    <li>
                        <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                            New
                        </button>
                    </li>
                    <li>
                        <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                            Urgent
                        </button>
                    </li>
                    <li>
                        <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                            Popular
                        </button>
                    </li>
                </ul>
            </nav>
            <div class="mt-8">
                <h4 class="font-bold mb-4">Subscribed Tags</h4>
                <ul class="space-y-2">
                    @foreach ($tags as $tag)
                        <li>
                            <button class="bg-gray-300 hover:bg-gray-400 px-4 py-1 rounded">
                                {{ $tag->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Floating Buttons (Right) -->
        <div class="fixed top-24 right-10 space-y-4 w-[10%]">
            <button class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md w-full text-sm">Search</button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md w-full text-sm">Question</button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md w-full text-sm">4U</button>
        </div>

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Posts Section -->
            <section class="w-3/5 space-y-8">
                @foreach ($questions as $question)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <header class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                                <p class="text-sm text-gray-500">User: {{ $question->author_id }}</p>
                            </div>
                            <p class="text-sm text-gray-500">Time Left: {{ $question->time_end->diffForHumans() }}</p>
                        </header>
                        <h2 class="text-lg font-bold mt-4">{{ $question->title }}</h2>
                        <p class="text-gray-600 mt-2">{{ $question->post->body }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <div class="space-x-2">
                                @foreach ($question->tags as $tag)
                                    <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">## Yeahs!</button>
                        </div>
                    </div>
                @endforeach
            </section>
        </main>


        <!-- Footer -->
        <footer class="bg-gray-900 text-white text-center py-4">
            Copyright © 2024 4NSWERS
        </footer>
    </div>

</body>
</html>

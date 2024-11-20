<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $question->title }} - 4NSWERS</title>
    <style>
        .scroll-banner::-webkit-scrollbar {
            display: none;
        }
        .scroll-banner {
            scrollbar-width: none; /* Firefox */
        }
        .squircle {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), transparent);
            clip-path: path("M20,2 Q38,2,38,20 Q38,38,20,38 Q2,38,2,20 Q2,2,20,2 Z");
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="fixed top-0 left-0 w-full bg-gray-900 text-white px-8 py-2 flex justify-between items-center z-10">
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold">4NSWERS</a>
            </div>
            <!-- Scrolling Banner -->
            <div class="bg-gray-800 text-white py-2 px-4 overflow-x-auto whitespace-nowrap scroll-banner">
                <marquee>⚡ Urgent: Check out more questions on 4NSWERS 🎉 Dive into the conversation now!</marquee>
            </div>
            <!-- Squircle decorations -->
            <div class="absolute inset-0 -z-10 squircle opacity-20"></div>
        </header>

        <!-- Floating Side Panel (Left) -->
        <aside class="fixed top-20 left-5 w-[15%] bg-gray-200 p-6 rounded-lg shadow-lg">
            <h2 class="font-bold text-lg mb-4">Navigation</h2>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('home') }}" class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                            Home
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Floating Buttons (Right) -->
        <div class="fixed top-24 right-10 space-y-4 w-[10%]">
            <button class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md w-full text-sm">Search</button>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md w-full text-sm">Question</button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md w-full text-sm">4U</button>
        </div>

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Post Section -->
            <section class="w-3/5 bg-white rounded-lg shadow-md p-6 space-y-6">
                <header class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                        <p class="text-sm text-gray-500">Asked by User ID: {{ $question->author_id }}</p>
                    </div>
                    <p class="text-sm text-gray-500">Time Left: {{ $question->time_end->diffForHumans() }}</p>
                </header>

                <h1 class="text-2xl font-bold">{{ $question->title }}</h1>

                <p class="text-gray-600">{{ $question->post->body }}</p>

                <div class="space-x-2">
                    @foreach ($question->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">## Yeahs!</button>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white text-center py-4">
            Copyright © 2024 4NSWERS
        </footer>
    </div>

</body>
</html>

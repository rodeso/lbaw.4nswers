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
        @include('partials.header')

        <!-- Floating Side Panel (Left) -->
        @include('partials.left-panel')

        <!-- Floating Buttons (Right) -->
        @include('partials.right-buttons')

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Post Section -->
            <section class="w-3/5 bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-6">
                <header class="flex items-center justify-between bg-[color:#4B1414] p-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                        <p class="text-sm text-gray-500">Asked by User ID: {{ $question->author_id }}</p>
                    </div>
                    <p class="text-sm text-gray-500">Time Left: {{ $question->time_end->diffForHumans() }}</p>
                </header>

                <div class="flex items-center justify-between p-2">
                    <h1 class="text-lg font-bold mt-2">
                            {{ $question->title }}
                        
                    </h1>
                    <h2 class="text-white">## Yeahs!</h2>
                </div>

                <p class="text-gray-600">{{ $question->post->body }}</p>

                <div class="space-x-2">
                    @foreach ($question->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </section>
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

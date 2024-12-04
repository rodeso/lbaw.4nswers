<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - 4U</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <!-- Centered Posts Section -->
            <section class="w-3/5 space-y-8">
                @foreach ($questions as $question)
                    @php $count = 0; @endphp
                    @foreach ($question->tags as $tag)
                        @foreach ($user_tags as $user_tag)
                            @if ($tag->id == $user_tag->id)
                                @php $count++; @endphp
                            @endif
                        @endforeach
                    @endforeach
                    @if ($count > 0)
                        @include('partials.main-question')
                    @endif
                @endforeach
            </section>
        </main>


        <!-- Footer -->
        @include('partials.footer')
    </div>
</body>
</html>

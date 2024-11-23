<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        @include('partials.question')
                    @endif
                @endforeach
            </section>
        </main>


        <!-- Footer -->
        @include('partials.footer')
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <title>4NSWERS - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        @include('partials.header')

        <!-- Floating Side Panel (Left) -->
        @include('partials.left-panel-admin-posts')

        <!-- Floating Buttons (Right) -->
        @include('partials.right-buttons')

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Posts Section -->
            <section class="w-3/5 space-y-8">
                <h1 id="questions" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Reported Questions:</h1>
                @if($questions->isNotEmpty())
                    @foreach($questions as $question)
                        @include('partials.reported-question')
                    @endforeach
                @else
                    <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No reported questions yet!</p>
                @endif
                <h1 id="answers" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Reported Answers:</h1>
                @if($answers->isNotEmpty())
                    @foreach($answers as $answer)
                        @include('partials.reported-answer')
                    @endforeach
                @else
                    <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No reported answers yet!</p>
                @endif
                <h1 id="comments" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Reported Comments:</h1>
                @if($comments->isNotEmpty())
                    @foreach($comments as $comment)
                        @include('partials.reported-comment')
                    @endforeach
                @else
                    <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No reported comments yet!</p>
                @endif
            </section>
        </main>
        
        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

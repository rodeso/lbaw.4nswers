<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
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
        @include('partials.left-panel-profile')
        
        <!-- Floating Buttons (Right) -->
        @include('partials.right-buttons')

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Content Section -->
            <section class="w-3/5 space-y-8">
                <h1 id="questions-section" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Questions placed:</h1>
                    @if($questions->isNotEmpty())
                        @foreach ($questions as $question)
                            @include('partials.profile-question')
                        @endforeach
                    @else
                        <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No questions placed yet!</p>
                    @endif
                <h1 id="answers-section" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Answers given:</h1>
                    @if($answers->isNotEmpty())
                        @foreach ($answers as $answer)
                            @include('partials.profile-answer')
                        @endforeach
                    @else
                        <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No answers given yet!</p>
                    @endif
                <h1 id="comments-section" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Comments made:</h1>
                    @if($comments->isNotEmpty())
                        @foreach ($comments as $comment)
                            @include('partials.profile-comment')
                        @endforeach
                    @else
                        <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No comments made yet!</p>
                    @endif
                <h1 id="followed-question-section" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Followed questions:</h1>
                    @if($followedQuestions->isNotEmpty())
                        @foreach ($followedQuestions as $question)
                            @include('partials.profile-question')
                        @endforeach
                    @else
                        <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">No followed questions yet!</p>
                    @endif
            </section>
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>
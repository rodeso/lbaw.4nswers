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
            <section class="w-3/5 space-y-8 grid place-items-center h-full text-black">
                <h1 id="questions" class="text-2xl font-bold w-[800px] bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Reported Questions:</h1>
                @foreach($questions as $question)
                    <div class="card">
                        <div class="card-body">
                            <h3>{{ $question->title }}</h3>
                            <p>{{ $question->post_body }}</p>
                            <p><strong>Urgency:</strong> {{ $question->urgency }}</p>
                            <p><strong>End Time:</strong> {{ $question->time_end }}</p>
                            <p>Number of Reports: {{ $question->report_count }}</p>
                        </div>
                    </div>
                @endforeach
                <h1 id="answers" class="text-2xl font-bold w-[800px] mt-8 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Reported Answers:</h1>
                @foreach($answers as $answer)
                    <div class="card">
                        <div class="card-body">
                            <p>{{ $answer->post_body }}</p>
                            <p><strong>Related Question ID:</strong> {{ $answer->question_id }}</p>
                        </div>
                    </div>
                @endforeach
                <h1 id="comments" class="text-2xl font-bold w-[800px] mt-8 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Reported Comments:</h1>
                @foreach($comments as $comment)
                    <div class="card">
                        <div class="card-body">
                            <p>{{ $comment->post_body }}</p>
                            <p><strong>Related Answer ID:</strong> {{ $comment->answer_id }}</p>
                        </div>
                    </div>
                @endforeach
            </section>
        </main>
        
        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

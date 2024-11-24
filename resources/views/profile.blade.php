<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <h1 class="text-2xl font-bold text-gray-500 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Questions placed:</h1>
                    @foreach ($questions as $question)
                        @include('partials.profile-question')
                    @endforeach
                <h1 class="text-2xl font-bold text-gray-500 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Answers given:</h1>
                    @foreach ($answers as $answer)
                        @include('partials.profile-answer')
                    @endforeach
                <h1 class="text-2xl font-bold text-gray-500 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Comments made:</h1>
                    <h2>Comments</h2>
            </section>
        </main>


        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>
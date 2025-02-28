<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - {{ $tag->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        @include('partials.header')

        <!-- Floating Side Panel (Left) -->
        @include('partials.left-panel-tag')

        <!-- Floating Buttons (Right) -->
        @include('partials.right-buttons')

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Content Section -->
            <section class="w-3/5 space-y-8">
                <h1 id="questions-section" class="text-2xl font-bold text-white bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Top questions:</h1>
                    @if($questions->isNotEmpty())
                        @foreach ($questions as $question)
                            @include('partials.profile-question')
                        @endforeach
                    @else
                        <p class="text-lg font-bold text-[color:#4B1414] p-3 rounded-lg">There are currently no questions with this tag.</p>
                    @endif
            </section>
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollLinks = document.querySelectorAll('a[href^="#"]');
        
        scrollLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
</html>
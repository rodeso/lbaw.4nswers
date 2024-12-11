<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <title>4NSWERS - Home</title>
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
        <main class="flex-grow flex justify-center pt-16">
            <!-- Centered Posts Section -->
            <section class="w-3/5 space-y-8">
                @foreach ($questions as $question)
                    @include('partials.main-question')
                @endforeach
            </section>
        </main>
        
        <!-- Footer -->
        @include('partials.footer')

        <!-- Alert Message -->
        <div id="customAlert" class="hidden fixed inset-x-0 top-0 bg-opacity-50 flex justify-center z-50 py-8">
            <div class="bg-gray-100 rounded-lg shadow-lg p-4 max-w-sm w-full mt-4">
                <p class="text-gray-800 mb-2 text-lg font-bold">Alert!</p>
                <p id="alertMessage" class="text-gray-800 mb-2 text-base"></p>
                <div class="flex justify-end relative"> <!-- Centering parent container -->
                    <button id="closeAlert" 
                            class="text-white text-base py-2 px-3 bg-[color:#4B1414] hover:bg-[color:#4B1414] rounded-lg"
                            style="position: relative; transform: translate(-5px,-5px);">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    // Check for session alert and show the modal
    @if (session('alert'))
        document.addEventListener('DOMContentLoaded', () => {
            const alertMessage = "{{ session('alert') }}";
            const customAlert = document.getElementById('customAlert');
            const alertMessageElement = document.getElementById('alertMessage');
            const closeAlertButton = document.getElementById('closeAlert');

            // Set alert message and show the modal
            alertMessageElement.textContent = alertMessage;
            customAlert.classList.remove('hidden');

            // Close the modal on button click
            closeAlertButton.addEventListener('click', () => {
                customAlert.classList.add('hidden');
            });
        });
    @endif
</script>
</html>

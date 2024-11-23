<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4NSWERS - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for the close icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative flex flex-col min-h-screen justify-center items-center h-screen m-0">
    

    <div class="bg-[color:#C18A8A] p-5 rounded-lg shadow-lg w-full max-w-md">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold pt-2 pb-2">Login</h1>
            <!-- Close Button -->
            <a href="{{ route('home') }}" class="text-2xl text-gray-800 hover:text-[color:#FF006E]">
                <i class="fas fa-times"></i>
            </a>
        </div>
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-600 text-white p-3 rounded mb-4">
                <ul class="list-none m-0 p-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-2">
                <label for="email" class="block mb-1">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]">
            </div>

            <div class="mb-2">
                <label for="password" class="block mb-1">Password:</label>
                <input type="password" id="password" name="password" required
                    class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]">
            </div>

            <div>
                <button type="submit"
                    class="w-full p-2 bg-[color:#4E0F35] text-white rounded hover:bg-[color:#FF006E] transition">
                    Login
                </button>
            </div>
        </form>
        
        <div class="mt-2 text-center">
            <p>Don't have an account? <a href="{{ route('register') }}" class="text-[color:#FF006E] hover:underline">Sign Up</a></p>
        </div>
    </div>
</body>
</html>

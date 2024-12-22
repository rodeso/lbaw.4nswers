<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>4NSWERS - Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative flex flex-col min-h-screen">
    <!-- Header -->
    @include('partials.header')

    <!-- Floating Side Panel (Left) -->
    @include('partials.left-panel-edit-profile')

    <!-- Floating Buttons (Right) -->
    @include('partials.right-buttons')

    <!-- Main Page -->
    <div class="flex-grow flex justify-center pt-20">
        <div class="max-w-4xl mx-auto bg-[color:#C18A8A] p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold text-gray-500 mb-6 bg-[color:#4B1414] p-2 rounded-lg shadow-lg">Change Password</h1>

            <!-- Display any errors -->
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Edit Profile Form -->
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="w-[35rem]">

                    <!-- Email Section -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            class="border p-2 rounded w-full" 
                            required
                        />
                    </div>

                    <!-- Old Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-bold mb-2">Old Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="border p-2 rounded w-full" 
                            required
                        />
                    </div>

                    <!-- New Password -->
                    <div class="mb-6">
                        <label for="new_password" class="block text-gray-700 font-bold mb-2">New Password</label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="border p-2 rounded w-full" 
                            required
                        />
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-6">
                        <label for="new_password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            class="border p-2 rounded w-full" 
                            required
                        />
                    </div>

                    <!-- Save Changes Button -->
                    <div class="flex justify-end">
                        <button 
                            type="submit" 
                            class="bg-green-500 text-white py-2 px-6 rounded-full hover:bg-green-600"
                        >
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    @include('partials.footer')
</body>
</html>

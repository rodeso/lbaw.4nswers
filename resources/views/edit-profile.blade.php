<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="flex-grow flex justify-center pt-20">
        

        <div class="max-w-4xl mx-auto bg-[color:#C18A8A] p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold text-gray-500 mb-6 bg-[color:#4B1414] p-2 rounded-lg shadow-lg">Edit Profile</h1>

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
            <form action="{{ route('edit-profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- This method is used for PUT requests to update data -->
                
                <!-- Avatar Section -->
                <div class="flex items-center mb-6">
                    <label for="avatar" class="mr-4 block text-gray-700 font-bold">Profile Picture</label>
                    <input 
                        type="file" 
                        id="avatar" 
                        name="avatar" 
                        class="border p-2 rounded" 
                        accept="image/*" 
                    />
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Current Avatar" class="w-12 h-12 rounded-full ml-4">
                    @else
                        <img src="https://via.placeholder.com/100" alt="No Avatar" class="w-12 h-12 rounded-full ml-4">
                    @endif
                </div>

                <!-- Name Section -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', Auth::user()->name) }}" 
                        class="border p-2 rounded w-full" 
                        required
                    />
                </div>

                <!-- Nickname Section -->
                <div class="mb-6">
                    <label for="nickname" class="block text-gray-700 font-bold mb-2">Nickname</label>
                    <input 
                        type="text" 
                        id="nickname" 
                        name="nickname" 
                        value="{{ old('nickname', Auth::user()->nickname) }}" 
                        class="border p-2 rounded w-full" 
                        required
                    />
                </div>

                <!-- Birth Date Section -->
                <div class="mb-6">
                    <label for="birth_date" class="block text-gray-700 font-bold mb-2">Birth Date</label>
                    <input 
                        type="date" 
                        id="birth_date" 
                        name="birth_date" 
                        value="{{ old('birth_date', Auth::user()->birth_date) }}" 
                        class="border p-2 rounded w-full" 
                    />
                </div>

                <div class="flex justify-between">
                    <!-- Edit LogIn Credentials Button -->
                    <button 
                        type="button" 
                        class="bg-red-500 text-white py-2 px-6 rounded-full hover:bg-red-600"
                    >
                        Edit LogIn Credentials
                    </button>

                    <!-- Save Changes Button -->
                    <button 
                        type="submit" 
                        class="bg-green-500 text-white py-2 px-6 rounded-full hover:bg-green-600"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        

    </div>
    <!-- Footer -->
    @include('partials.footer')
</body>
</html>

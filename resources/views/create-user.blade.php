<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <title>4NSWERS - Create User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 relative">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        @include('partials.header')

        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-16">
            <section class="w-3/5 space-y-8">
                <section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-5">
                    <header class="flex items-center justify-between bg-[color:#4B1414]">
                        <div class="relative flex items-center space-x-16">
                            <div class="absolute w-14 h-14 bg-gray-300 rounded-2xl -left-1">
                                <img 
                                    src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/default.png') }}" 
                                    alt="Profile Picture" 
                                    class="absolute w-14 h-14 bg-gray-300 rounded-2xl"
                                />
                            </div>
                            <p class="text-lg text-white">
                                Creating User as {{ Auth::user()->nickname }}
                            </p>
                        </div>
                    </header>
                    <form 
                        action="{{ route('user.store') }}" 
                        method="POST" 
                        class="space-y-6"
                    >
                        @csrf
                        <!-- Nickname Field -->
                        <div class="mb-6">
                            <label for="nickname" class="block text-white text-sm font-bold mb-2">
                                Nickname
                            </label>
                            <input 
                                type="text" 
                                name="nickname" 
                                id="nickname" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the Nickname"
                                value="{{ old('nickname') }}" 
                                required
                            >
                            @error('nickname')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        <!-- Name Field -->
                        <div class="mb-6">
                            <label for="name" class="block text-white text-sm font-bold mb-2">
                                Name
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the Name"
                                value="{{ old('name') }}" 
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Email Field -->
                        <div class="mb-6">
                            <label for="email" class="block text-white text-sm font-bold mb-2">
                                Email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the Email"
                                value="{{ old('email') }}" 
                                required
                            >
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Password Field -->
                        <div class="mb-6">
                            <label for="password" class="block text-white text-sm font-bold mb-2">
                                Password
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the Password"
                                value="{{ old('password') }}" 
                                required
                            >
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Confirm Password Field -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-white text-sm font-bold mb-2">
                                Confirm Password
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Confirm the Password"
                                value="{{ old('password_confirmation') }}" 
                                required
                            >
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        <!-- Birthday Field -->
                        <div class="mb-6">
                            <label for="birth_date" class="block text-white text-sm font-bold mb-2">
                                Birthday
                            </label>
                            <input 
                                type="date" 
                                name="birth_date" 
                                id="birth_date" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the Birthday"
                                value="{{ old('birth_date') }}" 
                                required
                            >
                            @error('birth_date')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Aura Field -->
                        <div class="mb-6">
                            <label for="aura" class="block text-white text-sm font-bold mb-2">
                                Aura
                            </label>
                            <input 
                                type="number" 
                                name="aura" 
                                id="aura" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the Aura"
                                value="{{ old('aura') }}" 
                                required
                            >
                            @error('aura')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- is Mod Field -->
                        <div class="mb-6">
                            <label for="is_mod" class="block text-white text-sm font-bold mb-2">
                                is Mod
                            </label>
                            <input type="hidden" name="is_mod" value="0">
                            <input type="checkbox" name="is_mod" id="is_mod" value="1" {{ old('is_mod') ? 'checked' : '' }}>
                            @error('is_mod')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- is Blocked Field -->
                        <div class="mb-6">
                            <label for="is_blocked" class="block text-white text-sm font-bold mb-2">
                                is Blocked
                            </label>
                            <input type="hidden" name="is_blocked" value="0">
                            <input type="checkbox" name="is_blocked" id="is_blocked" value="1" {{ old('is_blocked') ? 'checked' : '' }}>
                            @error('is_blocked')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- is Admin Field -->
                        <div class="mb-6">
                            <label for="is_admin" class="block text-white text-sm font-bold mb-2">
                                is Admin
                            </label>
                            <input type="hidden" name="is_admin" value="0">
                            <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>

                            @error('is_admin')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Action Buttons -->
                        <div class="mb-6 flex justify-between">
                            <button 
                                type="submit" 
                                class="p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
                            >
                                Create User
                            </button>
                        </div>
                    </form>
                </section>
            </section>
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <title>4NSWERS - Report Form</title>
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
                                Reporting as {{ Auth::user()->nickname }}
                            </p>
                        </div>
                    </header>
                    <form 
                        action="{{ route('posts.report.submit', $post->id) }}" 
                        method="POST" 
                        class="space-y-6"
                    >
                        @csrf
                        <!-- Reason Field -->
                        <div class="mb-6">
                            <label for="reason" class="block text-white text-sm font-bold mb-2">
                                Reason for the Report
                            </label>
                            <input 
                                type="text" 
                                name="reason" 
                                id="reason" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Enter the reason for the Report"
                                value="{{ old('reason') }}" 
                                required
                            >
                            @error('reason')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notification Content Field -->
                        <div class="mb-6">
                            <label for="content" class="block text-white text-sm font-bold mb-2">
                                Notification Content
                            </label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="5" 
                                class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                                placeholder="Provide details for the notification..."
                                required
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="mb-6 flex justify-between">
                            <button 
                                type="submit" 
                                class="p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
                            >
                                Submit Report
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

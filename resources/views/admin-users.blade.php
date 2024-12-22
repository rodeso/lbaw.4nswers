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
        @include('partials.left-panel-admin-users')

        <!-- Floating Buttons (Right) -->
        @include('partials.right-buttons-admin')
        <!-- Main Layout -->
        <main class="flex-grow flex justify-center pt-20">
            <!-- Centered Posts Section -->
            <section class="w-3/5 space-y-8 grid place-items-center h-full text-white">
                <h1 id="admins" class="text-2xl font-bold w-[800px] bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Admins:</h1>
                @foreach ($users as $user)
                    @if ($user->is_admin)
                        @if ($user->id !== 0)
                            @include('partials.user-card-admin')
                        @endif
                    @endif
                @endforeach
                <h1 id="moderators" class="text-2xl font-bold w-[800px] mt-8 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Moderators:</h1>
                @foreach ($users as $user)
                    @if (!$user->is_admin && $user->is_mod)
                        @if ($user->id !== 0)
                            @include('partials.user-card-admin')
                        @endif
                    @endif
                @endforeach
                <h1 id="blocked" class="text-2xl font-bold w-[800px] mt-8 bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Blocked Users:</h1>
                @foreach ($users as $user)
                    @if (!$user->is_admin && !$user->is_mod && $user->is_blocked)
                        @if ($user->id !== 0)
                            @include('partials.user-card-admin')
                        @endif
                    @endif
                @endforeach
                <h1 id="others" class="text-2xl font-bold w-[800px] bg-[color:#4B1414] p-3 rounded-lg shadow-lg">Other Users:</h1>
                @foreach ($users as $user)
                    @if (!$user->is_admin && !$user->is_mod && !$user->is_blocked)
                        @if ($user->id !== 0)
                            @include('partials.user-card-admin')
                        @endif
                    @endif
                @endforeach
            </section>
        </main>
        
        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

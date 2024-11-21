<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4NSWERS - Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="nickname">Nickname:</label>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}">
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div>
                <label for="birth_date">Birth Date:</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
            </div>

            <div>
                <button type="submit">Register</button>
            </div>
        </form>
        <div>
            <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>
    </div>
</body>
</html>

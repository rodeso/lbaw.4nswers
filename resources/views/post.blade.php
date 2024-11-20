<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $question->title }} - 4NSWERS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <header>
            <a href="{{ route('home') }}">Back to Home</a>
            <h1>{{ $question->title }}</h1>
        </header>

        <section>
            <p><strong>Asked by User ID:</strong> {{ $question->author_id }}</p>
            <p><strong>Urgency:</strong> {{ $question->urgency }}</p>
            <p><strong>Time Left:</strong> {{ $question->time_end->diffForHumans() }}</p>
            <p><strong>Details:</strong></p>
            <p>{{ $question->post->body }}</p>
        </section>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4NSWERS - Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <main>
            <header>
                <h1>4NSWERS</h1>
                <input type="search" placeholder="Search...">
                <button>Ask a Question</button>
            </header>

            <aside>
                <ul>
                    <li><h3>4U</h3></li>
                    <li><h3>New</h3></li>
                    <li><h3>Urgent</h3></li>
                    <li><h3>Popular</h3></li>
                </ul>
            </aside>

            <section class="questions">
                @foreach ($questions as $question)
                    <div class="question-card">
                        <header>
                            <p>User ID: {{ $question->author_id }}</p>
                            <p>Urgency: {{ $question->urgency }}</p>
                            <p>Time Left: {{ $question->time_end->diffForHumans() }}</p>
                        </header>
                        <h2>{{ $question->title }}</h2>
                        <p>{{ $question->post->body }}</p>
                        <button>## Yeahs!</button>
                    </div>
                @endforeach
            </section>
        </main>
    </div>
</body>
</html>

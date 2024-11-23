<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ $question->title }} - 4NSWERS</title>
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
        <main class="flex-grow flex justify-center pt-20">

            <!-- Post's Feed -->
            <section class="w-3/5 space-y-8">

                <!-- Post's Question -->
                <section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-6">

                    <!-- Question Header -->
                    <header class="flex items-center justify-between bg-[color:#4B1414]">
                        <div class="relative flex items-center space-x-24">
                            <div class="absolute w-20 h-20 bg-gray-300 rounded-2xl"></div>
                            <p class="text-xl text-white">Asked by: {{ $question->author_id }}</p> <!-- To be changed to user's nickname -->
                        </div>
                        <div 
                            class="relative w-80 h-14 bg-white text-center flex items-end justify-end"
                            style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"
                        >
                            <p class="text-sm font-bold p-2"
                            style="color: 
                                @if($question->urgency === 'Red') red
                                @elseif($question->urgency === 'Orange') orange
                                @elseif($question->urgency === 'Yellow') yellow
                                @elseif($question->urgency === 'Green') green
                                @else black
                                @endif
                            ;">
                            Time Left: {{ $question->time_end->diffForHumans() }}
                            </p>
                        </div>
                    </header>
                    <!-- Question Title, Yeahs obtained & upvote/downvote buttons -->
                    <div class="flex justify-between items-center rounded-md">
                        <!-- Question Title with Border -->
                        <h1 class="text-2xl font-bold border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow">
                            {{ $question->title }}
                        </h1>
                        <div class="flex items-center space-x-2">
                            <!-- Upvote Button -->
                            <button 
                                class="w-10 h-10 bg-[color:#4B1414] hover:bg-green-600 text-white rounded-full flex items-center justify-center" 
                                aria-label="Upvote"
                                onclick="handleVote({{ $question->id }}, 'upvote')"
                            >
                                ▲
                            </button>
                            
                            <!-- Yeahs Count -->
                            <h2 class="text-lg font-bold">1000</h2>

                            <!-- Downvote Button -->
                            <button 
                                class="w-10 h-10 bg-[color:#4B1414] hover:bg-red-600 text-white rounded-full flex items-center justify-center" 
                                aria-label="Downvote"
                                onclick="handleVote({{ $question->id }}, 'downvote')"
                            >
                                ▼
                            </button>
                        </div>
                    </div>
                    <!-- Question Body -->                        
                    <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mt-4">
                        {{ $question->post->body }}
                    </p>
                    <!-- Time Posting & Question Tags -->
                    <div class="flex items-center space-x-4 mt-4">
                        <!-- Time of Posting -->
                        <p class="text-sm text-gray-700 font-semibold">
                            Asked {{ $question->post->time_stamp->diffForHumans() }}!
                        </p>
                        <!-- Question Tags -->
                        <div class="flex flex-wrap items-center space-x-2">
                            @foreach ($question->tags as $tag)
                                <span class="bg-[color:#FCF403] text-black-800 text-sm font-bold px-2 py-1 rounded">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>

                </section>

                <!-- Answers' Section -->
                <section class="w-full space-y-6 pl-12">

                    @foreach ($question->answers as $answer)
                        <section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-3">
                            <!-- Answer Header -->
                            <header class="flex items-center justify-between bg-[color:#4B1414]">
                                <div class="relative flex items-center space-x-16">
                                    <div class="absolute w-14 h-14 bg-gray-300 rounded-2xl -left-1"></div>
                                    <p class="text-lg text-white">Answered by: {{ $answer->author_id }}</p> <!-- To be changed to user's nickname -->
                                </div>
                                <div 
                                    class="relative w-80 h-12 bg-white text-center flex items-end justify-end text-[color:#4B1414]"
                                    style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"
                                >
                                    <p class="text-sm font-bold p-2">Aura: 16588753</p>
                                </div>
                            </header>
                            <!-- Answer Body and upvote/downvote -->
                            <div class="flex justify-between items-stretch rounded-md">
                                <!-- Answer Body -->
                                <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow">
                                    {{ $answer->post->body }}
                                </p>
                                <div class="flex flex-col items-center space-y-1">
                                    <!-- Upvote Button -->
                                    <button 
                                        class="w-10 h-10 bg-[color:#4B1414] hover:bg-green-600 text-white rounded-full flex items-center justify-center" 
                                        aria-label="Upvote"
                                        onclick="handleVote({{ $answer->id }}, 'upvote')"
                                    >
                                        ▲
                                    </button>

                                    <!-- Downvote Button -->
                                    <button 
                                        class="w-10 h-10 bg-[color:#4B1414] hover:bg-red-600 text-white rounded-full flex items-center justify-center" 
                                        aria-label="Downvote"
                                        onclick="handleVote({{ $answer->id }}, 'downvote')"
                                    >
                                        ▼
                                    </button>
                                </div>
                            </div>
                            <!-- Time Posting & Answer Tags -->
                            <div class="flex items-center space-x-4 mt-4">
                                <p class="text-sm text-gray-700 font-semibold">
                                    Asked {{ $answer->post->time_stamp->diffForHumans() }}!
                                </p>
                                <div class="flex flex-wrap items-center space-x-2">
                                    <!-- Not yet done because answers dont have tags yet -->
                                </div>
                            </div>
                        </section>
                    @endforeach

                </section>

            </section>
        </main>



        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

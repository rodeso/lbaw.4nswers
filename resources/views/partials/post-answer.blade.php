<!-- Answers' Section -->
<section class="w-full space-y-6 pl-12">

<!-- Display a Message if the Question is Closed -->
@if($question->closed)
<section class="w-full bg-[color:#FFEDED] rounded-lg shadow-md p-6 text-center">
    <p class="text-sm text-gray-700 font-semibold">
        This Question has been Closed, Thank You.
    </p>
</section>
@else
    <!-- Answer Form (Visible only to logged-in users) -->
    @auth
    <section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6">
        <header class="flex items-center justify-between bg-[color:#4B1414] p-3 rounded-t-lg">
            <div class="relative flex items-center space-x-4">
                <div class="relative w-14 h-14 bg-gray-300 rounded-2xl overflow-hidden">
                    <img 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="w-full h-full object-cover"
                    />
                </div>
                <p class="text-lg text-white">{{ Auth::user()->nickname }}, post your answer!</p>
            </div>
            <button 
                id="toggleAnswerButton"
                onclick="toggleAnswerForm()" 
                class="bg-white text-[color:#4B1414] px-4 py-2 rounded-lg hover:bg-[color:#C18A8A] transition font-semibold"
            >
                Click here to answer!
            </button>
        </header>
        <!-- Hidden Answer Form -->
        <div id="answerForm" class="hidden p-4 bg-white rounded-b-lg space-y-5">
            <form action="{{ route('answer.store') }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <textarea 
                    name="body" 
                    id="body" 
                    cols="30" 
                    rows="5" 
                    class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                    placeholder="Write your answer here..."
                ></textarea>
                <button 
                    type="submit" 
                    class="w-full p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
                >
                    Post Answer
                </button>
            </form>
        </div>
    </section>
    @endauth

    <!-- Message for Unauthenticated Users -->
    @guest
    <section class="w-full bg-[color:#FFEDED] rounded-lg shadow-md p-6 text-center">
        <p class="text-sm text-gray-700 font-semibold">
            Want to answer? <a href="{{ route('login') }}" class="text-blue-500">Log in</a> or 
            <a href="{{ route('register') }}" class="text-blue-500">Register</a> to post your answer.
        </p>
    </section>
    @endguest
@endif

<!-- Answers -->
@foreach ($question->answers as $answer)
    <section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-3">
        <!-- Answer Header -->
        <header class="flex items-center justify-between bg-[color:#4B1414]">
            <div class="relative flex items-center space-x-16">
                <div class="absolute w-14 h-14 bg-gray-300 rounded-2xl -left-1">
                    <img 
                        src="{{ $answer->author->profile_picture ? asset('storage/' . $answer->author->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="absolute w-14 h-14 bg-gray-300 rounded-2xl"
                    />
                </div>
                <p class="text-lg text-white">Answered by {{ $answer->author->nickname }}</p>
            </div>
            <div 
                class="relative w-80 h-12 bg-white text-center flex items-end justify-end text-[color:#4B1414]"
                style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"
            >
                <p class="text-sm font-bold p-2">{{ $answer->vote_difference }} aura</p>
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
                Answered {{ $answer->post->time_stamp->diffForHumans() }}!
            </p>
            <div class="flex flex-wrap items-center space-x-2">
                <!-- Not yet done because answers dont have tags yet -->
            </div>
        </div>
    </section>
@endforeach

</section>

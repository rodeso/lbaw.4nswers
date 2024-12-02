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

    <script>
        function toggleAnswerForm() {
            const form = document.getElementById('answerForm');
            const button = document.getElementById('toggleAnswerButton');
            
            // Toggle visibility of the form
            form.classList.toggle('hidden');
            
            // Update button text based on the form's state
            if (form.classList.contains('hidden')) {
                button.textContent = "Click here to answer!";
            } else {
                button.textContent = "Close Answer Form.";
            }
        }
    </script>

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
    <section 
        class="w-full rounded-lg shadow-md p-6 space-y-3 
        @if($answer->chosen) bg-green-200 border-4 border-green-600 @else bg-[color:#C18A8A] @endif">
        <!-- Answer Header -->
        <header class="flex items-center justify-between 
            @if($answer->chosen) bg-green-600 text-white @else bg-[color:#4B1414] @endif">
            <div class="relative flex items-center space-x-16">
                <div class="absolute w-14 h-14 bg-gray-300 rounded-2xl -left-1">
                    <img 
                        src="{{ $answer->author->profile_picture ? asset('storage/' . $answer->author->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                        alt="Profile Picture" 
                        class="absolute w-14 h-14 bg-gray-300 rounded-2xl"
                    />
                </div>
                <p class="text-lg 
                    @if($answer->chosen) text-white @else text-white @endif">
                    Answered by 
                    <a 
                        href="{{ Auth::id() === $answer->author->id ? route('profile') : route('user.profile', ['id' => $answer->author->id]) }}" 
                        class="hover:text-gray-500"
                    >
                        {{ $answer->author->nickname }}
                    </a>
                </p>
            </div>
            <div 
                class="relative w-80 h-12 bg-white text-center flex items-end justify-end text-[color:#4B1414]"
                style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"
            >
                <p id="aura-{{ $answer->id }}" class="text-sm font-bold p-2">Aura: {{ $answer->aura }}</p>
            </div>
        </header>
        <!-- Answer Body and upvote/downvote -->
        <div class="flex justify-between items-stretch rounded-md">
            <!-- Answer Body -->
            <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                {{ $answer->post->body }}
            </p>
            <div class="flex flex-col items-center space-y-1">
                <!-- Upvote Button -->
                <button 
                    class="w-10 h-10 bg-[color:#4B1414] hover:bg-green-600 text-white rounded-full flex items-center justify-center" 
                    aria-label="Upvote"
                    onclick="handleAuraVote({{ $answer->id }}, 'upvote')"
                >
                    ▲
                </button>

                <!-- Downvote Button -->
                <button 
                    class="w-10 h-10 bg-[color:#4B1414] hover:bg-red-600 text-white rounded-full flex items-center justify-center" 
                    aria-label="Downvote"
                    onclick="handleAuraVote({{ $answer->id }}, 'downvote')"
                >
                    ▼
                </button>
            </div>
        </div>
        <script>
            function handleAuraVote(answerId, voteType) {
                fetch(`/answer/${answerId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ vote: voteType }),
                })
                    .then(response => response.json())
                    .then(data => {
                        // Update the aura display
                        const auraElement = document.querySelector(`#aura-${answerId}`);
                        if (auraElement) {
                            auraElement.textContent = `Aura: ${data.totalAura}`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
        <!-- Time Posting & Moderator Tags -->
        <div class="flex items-center space-x-4 mt-4 justify-between">
            <div class="flex items-center space-x-4 mt-4">
                <p class="text-sm text-gray-700 font-semibold">
                    Answered {{ $answer->post->time_stamp->diffForHumans() }}!
                </p>
                <div class="flex flex-wrap items-center space-x-2">
                    @foreach ($answer->post->moderatorNotifications as $modNotification)
                        <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                            {{ $modNotification->reason }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <!-- Button to open the menu -->
                <button 
                    class="w-10 h-10 flex items-center justify-center text-white bg-[color:#4B1414] rounded-full hover:bg-gray-700 focus:outline-none"
                    aria-label="Options"
                    onclick="toggleAnswerOptionsMenu({{ $answer->id }})"
                >
                    ...
                </button>

                <!-- Options Menu -->
                <div 
                    id="answer-options-menu-{{ $answer->id }}" 
                    class="hidden fixed top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 bg-[color:#4E0F35] rounded-lg text-white shadow-lg p-6 z-50"
                >
                    <!-- Close Button -->
                    <button 
                        class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center text-lg font-bold bg-[color:#4B1414] hover:bg-gray-700 rounded-full focus:outline-none"
                        aria-label="Close Options"
                        onclick="toggleAnswerOptionsMenu({{ $answer->id }})"
                    >
                        ✕
                    </button>

                    <!-- Menu Content -->
                    <ul class="mt-8 space-y-4 text-base font-semibold">
                        @if (auth()->id() === $question->author->id)
                            <!-- Menu for the Author of the Question -->
                            @if (!$answer->chosen && !$question->closed)
                                <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                    <form action="{{ route('question.chooseAnswer', ['questionId' => $question->id, 'answerId' => $answer->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit">Choose this answer</button>
                                    </form>
                                </li>
                            @endif
                            <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                <a href="#">Report Answer</a>
                            </li>
                        @if (auth()->user()->is_mod)
                            <!-- Admin Option: Delete Answer -->
                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                <form action="{{ route('answer.delete', $answer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </li>
                        @endif
                        @elseif (auth()->id() === $answer->author->id)
                            <!-- Menu for the Author of the Answer -->
                            <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                <a href="{{ route('answer.edit', $answer->id) }}"> Edit </a>
                            </li>
                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                <form action="{{ route('answer.delete', $answer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </li>
                        @elseif (auth()->user()->is_moderator)
                            <!-- Menu for Moderators -->
                            <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                <form action="{{ route('answer.delete', $answer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </li>
                        @else
                            <!-- Menu for the General Public -->
                            <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                <a href="#">Report Answer</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- JavaScript to toggle the menu -->
            <script>
                function toggleAnswerOptionsMenu(answerId) {
                    const menu = document.getElementById(`answer-options-menu-${answerId}`);
                    menu.classList.toggle('hidden');
                }
            </script>

        </div>
        <!-- Highlight for chosen answer -->
        @if($answer->chosen)
            <div class="text-green-700 font-bold text-center mt-4">
                This answer was chosen by the questioner!
            </div>
        @endif
        <!-- Only show the "Show Comments" button if there are comments -->
        @if($answer->comments->isNotEmpty())
            <!-- Button to Toggle Comments -->
            <button 
                id="toggleCommentsButton-{{ $answer->id }}" 
                onclick="toggleCommentsVisibility({{ $answer->id }})" 
                class="bg-[color:#4B1414] text-sm text-white px-2 py-1 rounded-lg hover:bg-white hover:text-[color:#4B1414] transition font-semibold">
                Hide Comments
            </button>
        @endif
        <!-- Comment Form Section inside Answer Block -->
        @if(!$question->closed)
            @auth
            <button 
                id="toggleCommentButton-{{ $answer->id }}"
                onclick="toggleCommentForm({{ $answer->id }})" 
                class="bg-[color:#4B1414] text-sm text-white px-2 py-1 rounded-lg hover:bg-white hover:text-[color:#4B1414] transition font-semibold"
            >
                Comment here!
            </button>
            <div id="commentForm-{{ $answer->id }}" class="hidden rounded-b-lg space-y-5">
                <form action="{{ route('comments.store', ['answerId' => $answer->id]) }}" method="POST">
                    @csrf
                    <textarea 
                        name="body" 
                        id="body" 
                        cols="30" 
                        rows="3" 
                        class="w-full p-2 border-2 border-[color:#4B1414] rounded-md focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-[color:#C18A8A]"
                        placeholder="Write your comment here..."
                    ></textarea>
                    <button 
                        type="submit" 
                        class="w-full p-2 bg-[color:#4B1414] text-white rounded hover:bg-[color:#FF006E] transition"
                    >
                        Post Comment
                    </button>
                </form>
            </div>
            @endauth
        @endif
    </section>

    @include('partials.post-comment')

@endforeach



<!-- JavaScript to toggle the comment form visibility -->
<script>
    function toggleCommentForm(answerId) {
        const form = document.getElementById('commentForm-' + answerId);
        const button = document.getElementById('toggleCommentButton-' + answerId);
        
        // Toggle visibility of the form
        form.classList.toggle('hidden');
        
        // Update button text based on the form's state
        if (form.classList.contains('hidden')) {
            button.textContent = "Comment here!";
        } else {
            button.textContent = "Close Comment Form.";
        }
    }
</script>
<!-- JavaScript to Toggle Comments Visibility -->
<script>
    function toggleCommentsVisibility(answerId) {
        const commentsSection = document.getElementById('commentsSection-' + answerId);
        const toggleButton = document.getElementById('toggleCommentsButton-' + answerId);
        
        // Toggle visibility of the comments section
        commentsSection.classList.toggle('hidden');
        
        // Update button text based on the visibility of comments
        if (commentsSection.classList.contains('hidden')) {
            toggleButton.textContent = "Show Comments";
        } else {
            toggleButton.textContent = "Hide Comments";
        }
    }
</script>

</section>
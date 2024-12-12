<!-- Post's Question -->
<section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-6">

    <!-- Question Header -->
    <header class="flex items-center justify-between bg-[color:#4B1414]">
        <div class="relative flex items-center space-x-24">
            <div class="absolute w-20 h-20 bg-gray-300 rounded-2xl">
                <img 
                    src="{{ $question->author->profile_picture ? asset('storage/' . $question->author->profile_picture) : asset('profile_pictures/5P31c2m0XosLV5HWAl8gTDXUm0vVmNO6ht8llkev.png') }}" 
                    alt="Profile Picture" 
                    class="absolute w-20 h-20 bg-gray-300 rounded-2xl"
                />
            </div>
            <p class="text-xl text-white">
                Asked by 
                <a 
                    href="{{ Auth::id() === $question->author->id ? route('profile') : route('user.profile', ['id' => $question->author->id]) }}" 
                    class="hover:text-gray-500"
                >
                    {{ $question->author->nickname }}
                </a>
            </p>
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
            @if($question->closed)
                Closed: {{ $question->time_end->diffForHumans() }}
            @else
                Closes: {{ $question->time_end->diffForHumans() }}
            @endif
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
                id="upvote-button-{{ $question->id }}"
                class="w-10 h-10 rounded-full flex items-center justify-center text-white 
                    {{ $userVote === true ? 'bg-green-600' : 'bg-[color:#4B1414] hover:bg-green-600' }}" 
                aria-label="Upvote"
                onclick="handleVote({{ $question->id }}, 'upvote')"
            >
                ▲
            </button>
            
            @if ($question->popularityVotes->where('is_positive', true)->count() - $question->popularityVotes->where('is_positive', false)->count() >= 0)
                <!-- Yeahs Count -->
                <h2 id="yeahs-count-{{ $question->id }}" class="text-lg font-bold">
                    {{ $question->popularityVotes->where('is_positive', true)->count() - $question->popularityVotes->where('is_positive', false)->count() }} YEAHs
                </h2>
            @else
                <!-- Boos Count -->
                <h2 id="yeahs-count-{{ $question->id }}" class="text-lg font-bold">
                    {{ $question->popularityVotes->where('is_positive', false)->count() - $question->popularityVotes->where('is_positive', true)->count() }} BOOs
                </h2>
            @endif
            <!-- Downvote Button -->
            <button 
                id="downvote-button-{{ $question->id }}"
                class="w-10 h-10 rounded-full flex items-center justify-center text-white  
                    {{ $userVote === false ? 'bg-red-600' : 'bg-[color:#4B1414] hover:bg-red-600' }}" 
                aria-label="Downvote"
                onclick="handleVote({{ $question->id }}, 'downvote')"
            >
                ▼
            </button>
        </div>

        <!-- Vote Handling Script -->
        <script>
            async function handleVote(questionId, voteType) {
                try {
                    const response = await fetch(`/questions/${questionId}/vote`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ vote: voteType })
                    });

                    if (response.ok) {
                        const data = await response.json();

                        // Update the Yeahs Count
                        document.getElementById(`yeahs-count-${questionId}`).textContent = data.totalVotes;

                        // Get buttons
                        const upvoteButton = document.getElementById(`upvote-button-${questionId}`);
                        const downvoteButton = document.getElementById(`downvote-button-${questionId}`);

                        // Handle upvote action
                        if (voteType === 'upvote') {
                            upvoteButton.classList.add('bg-green-600');
                            upvoteButton.classList.remove('bg-[color:#4B1414]', 'hover:bg-green-600');
                            downvoteButton.classList.remove('bg-red-600');
                            downvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-red-600');
                        } 

                        // Handle downvote action
                        else if (voteType === 'downvote') {
                            downvoteButton.classList.add('bg-red-600');
                            downvoteButton.classList.remove('bg-[color:#4B1414]', 'hover:bg-red-600');
                            upvoteButton.classList.remove('bg-green-600');
                            upvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-green-600');
                        }

                        // If the vote was undone, reset both buttons to default state
                        if (data.voteUndone) {
                            upvoteButton.classList.remove('bg-green-600');
                            upvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-green-600');

                            downvoteButton.classList.remove('bg-red-600');
                            downvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-red-600');
                        }
                    } else {
                        console.error('Failed to vote');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        </script>

    </div>
    <!-- Question Body -->                        
    <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mt-4 break-words">
        {{ $question->post->body }}
    </p>

    <!-- Time Posting, Question Tags & Moderator Flags-->
    <div class="flex items-center space-x-4 mt-4 justify-between">
        <div class= "flex items-center space-x-4 mt-4">
            <!-- Time of Posting -->
            <p class="text-sm text-gray-700 font-semibold">
                Asked {{ $question->post->time_stamp->diffForHumans() }}!
            </p>
            <!-- Question Tags & Moderator Flags-->
            <div class="flex flex-wrap items-center space-x-2">
                @foreach ($question->tags as $tag)
                    <span class="bg-[color:#FCF403] text-black-800 text-sm font-bold px-2 py-1 rounded">{{ $tag->name }}</span>
                @endforeach
                @foreach ($question->post->moderatorNotifications as $questionModNotification)
                    <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                        {{ $questionModNotification->reason }}
                    </span>
                @endforeach
            </div>
        </div>
        @auth
            <div class="relative">
                <!-- Button to open the menu -->
                <button 
                    class="w-10 h-10 flex items-center justify-center text-white bg-[color:#4B1414] rounded-full hover:bg-gray-700 focus:outline-none"
                    aria-label="Options"
                    onclick="toggleQuestionOptionsMenu({{ $question->id }})"
                >
                    ...
                </button>

                <!-- Options Menu -->
                <div 
                    id="question-options-menu-{{ $question->id }}" 
                    class="hidden fixed top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 bg-[color:#4E0F35] rounded-lg text-white shadow-lg p-6 z-50"
                >
                    <!-- Close Button -->
                    <button 
                        class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center text-lg font-bold bg-[color:#4B1414] hover:bg-gray-700 rounded-full focus:outline-none"
                        aria-label="Close Options"
                        onclick="toggleQuestionOptionsMenu({{ $question->id }})"
                    >
                        ✕
                    </button>

                    <!-- Menu Content -->
                    <ul class="mt-8 space-y-4 text-base font-semibold">
                        @if (auth()->id() != $question->author->id)
                            <!-- Actions for Regular Users -->
                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                <form method="POST" id="followForm" action="{{ route('question.follow', $question->id) }}">
                                    @csrf
                                    <button>
                                        {{ $isFollowing ? 'Unfollow Question' : 'Follow Question' }}
                                    </button>
                                </form>
                            </li>
                        @endif
                        @if (auth()->id() === $question->author->id)
                            <!-- Actions for the Author of the Question -->
                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                <a href="{{ route('question.edit', $question->id) }}">Edit Question</a>
                            </li>
                            @if (!$question->closed)
                                <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                    <form action="{{ route('question.close', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this question?');">
                                        @csrf
                                        <button type="submit" class="text-left w-full">Close Question</button>
                                    </form>
                                </li>
                            @endif
                            @if (!auth()->user()->is_mod)
                                <!-- Delete button for authors who are not moderators -->
                                <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                    <form action="{{ route('question.delete', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete Question</button>
                                    </form>
                                </li>
                            @endif
                        @endif

                        
                        <!-- Actions for Moderators -->
                        @if (auth()->user()->is_mod)
                            @if (auth()->id() !== $question->author->id)
                                <!-- Flag Post -->
                                <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                    <a 
                                        href="{{ route('posts.flag', $question->post_id) }}" 
                                        class="block text-white"
                                        title="Flag this question for moderation"
                                    >
                                        Flag This Question
                                    </a>
                                </li>
                                <!-- Delete Flag -->
                                @if ($question->post->notifications->isNotEmpty())
                                    <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                        <form 
                                            action="{{ route('posts.flag.delete', $question->post->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Are you sure you want to delete this flag?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="block text-white w-full text-left"
                                            >
                                                Delete Flag
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            @endif
                            <!-- Delete button for moderators -->
                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                <form 
                                    action="{{ route('question.delete', $question->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this question?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="block text-white w-full text-left"
                                    >
                                        Delete Question
                                    </button>
                                </form>
                            </li>
                        @endif




                        @if (!auth()->user()->is_mod && auth()->id() !== $question->author->id)
                            <!-- Actions for Regular Users -->
                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                            <a 
                                href="{{ route('posts.report', $question->post_id) }}" 
                                class="block text-white"
                                title="Report this question for moderation"
                            >Report Question</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        @endauth
        <!-- JavaScript to toggle the menu -->
        <script>
            function toggleQuestionOptionsMenu(questionId) {
                const menu = document.getElementById(`question-options-menu-${questionId}`);
                menu.classList.toggle('hidden');
            }
        </script>

</section>
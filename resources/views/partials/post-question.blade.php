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
            <p class="text-xl text-white">Asked by {{ $question->author->nickname }}</p>
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
                id="upvote-button-{{ $question->id }}"
                class="w-10 h-10 bg-[color:#4B1414] hover:bg-green-600 text-white rounded-full flex items-center justify-center" 
                aria-label="Upvote"
                onclick="handleVote({{ $question->id }}, 'upvote')"
            >
                ▲
            </button>
            
            <!-- Yeahs Count -->
            <h2 id="yeahs-count-{{ $question->id }}" class="text-lg font-bold">
                {{ $question->popularityVotes->where('is_positive', true)->count() - $question->popularityVotes->where('is_positive', false)->count() }}
            </h2>

            <!-- Downvote Button -->
            <button 
                id="downvote-button-{{ $question->id }}"
                class="w-10 h-10 bg-[color:#4B1414] hover:bg-red-600 text-white rounded-full flex items-center justify-center" 
                aria-label="Downvote"
                onclick="handleVote({{ $question->id }}, 'downvote')"
            >
                ▼
            </button>
        </div>

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

                        // Update active button styles
                        const upvoteButton = document.getElementById(`upvote-button-${questionId}`);
                        const downvoteButton = document.getElementById(`downvote-button-${questionId}`);

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
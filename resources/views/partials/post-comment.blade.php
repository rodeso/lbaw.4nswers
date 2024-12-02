<!-- Comments Section for an Answer -->
<section class="w-full space-y-6 pl-20">

    <!-- Add Comment Form if question is not closed -->
    @if(!$question->closed)
    @auth
    <section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6">
        <header class="flex items-center justify-between bg-[color:#4B1414] p-3 rounded-t-lg">
            <div class="relative flex items-center space-x-4">
                <div class="relative w-14 h-14 bg-gray-300 rounded-2xl overflow-hidden">
                    <img 
                        src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('profile_pictures/default.png') }}" 
                        alt="Profile Picture" 
                        class="w-full h-full object-cover"
                    />
                </div>
                <p class="text-lg text-white">{{ Auth::user()->nickname }}, post a comment!</p>
            </div>
            <button 
                id="toggleCommentButton"
                onclick="toggleCommentForm()" 
                class="bg-white text-[color:#4B1414] px-4 py-2 rounded-lg hover:bg-[color:#C18A8A] transition font-semibold"
            >
                Click here to comment!
            </button>
        </header>
        <!-- Hidden Comment Form -->
        <div id="commentForm" class="hidden p-4 bg-white rounded-b-lg space-y-5">
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
    </section>
    @endauth

    <script>
        function toggleCommentForm() {
            const form = document.getElementById('commentForm');
            const button = document.getElementById('toggleCommentButton');
            
            // Toggle visibility of the form
            form.classList.toggle('hidden');
            
            // Update button text based on the form's state
            if (form.classList.contains('hidden')) {
                button.textContent = "Click here to comment!";
            } else {
                button.textContent = "Close Comment Form.";
            }
        }
    </script>


    <!-- Message for Unauthenticated Users -->
    @guest
    <section class="w-full bg-[color:#FFEDED] rounded-lg shadow-md p-6 text-center">
        <p class="text-sm text-gray-700 font-semibold">
            Want to comment? <a href="{{ route('login') }}" class="text-blue-500">Log in</a> or 
            <a href="{{ route('register') }}" class="text-blue-500">Register</a> to post your comment.
        </p>
    </section>
    @endguest
    @endif

    <!-- Comments -->
    @foreach ($answer->comments as $comment)
        <section class="w-full space-y-6 pl-20">
            <section class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
                <!-- Comment Header -->
                <header class="flex items-center justify-between bg-[color:#4B1414]">
                    <div class="relative flex items-center space-x-16 pl-2">
                        <p class="text-lg text-white">
                            Commented by {{ $comment->author->nickname }}
                        </p>
                    </div>
                </header>
                <!-- Comment Body and Metadata -->
                <div class="flex justify-between items-stretch rounded-md">
                    <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                        {{ $comment->post->body }}
                    </p>
                </div>
                <div class="flex items-center space-x-4 mt-4 justify-between">
                    <p class="text-sm text-gray-700 font-semibold">
                        Commented {{ $comment->post->time_stamp->diffForHumans() }}
                    </p>
                </div>
            </section>
        </section>
    @endforeach

</section>

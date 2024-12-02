<!-- Comments -->
<section id="commentsSection-{{ $answer->id }}" class="w-full rounded-lg space-y-3 pl-20">
    @foreach ($answer->comments as $comment)
        <section class="w-full space-y-6">
            <section class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
                <!-- Comment Header -->
                <header class="flex items-center justify-between bg-[color:#4B1414]">
                    <div class="relative flex items-center space-x-16 pl-2">
                        <p class="text-lg text-white">
                            Commented by 
                            <a 
                                href="{{ Auth::id() === $comment->author->id ? route('profile') : route('user.profile', ['id' => $comment->author->id]) }}" 
                                class="hover:text-gray-500"
                            >
                            {{ $comment->author->nickname }}
                            </a>
                        </p>
                    </div>

                    <!-- Action Menu -->
                    <div class="relative">
                        <button 
                            class="w-10 h-10 flex items-center justify-center text-white bg-[color:#4B1414] rounded-full hover:bg-gray-700 focus:outline-none"
                            aria-label="Options"
                            onclick="toggleCommentOptionsMenu({{ $comment->id }})"
                        >
                            ...
                        </button>

                        <!-- Options Menu -->
                        <div 
                            id="comment-options-menu-{{ $comment->id }}" 
                            class="hidden fixed top-1/3 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 bg-[color:#4E0F35] rounded-lg text-white shadow-lg p-6 z-50"
                        >
                            <!-- Close Button -->
                            <button 
                                class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center text-lg font-bold bg-[color:#4B1414] hover:bg-gray-700 rounded-full focus:outline-none"
                                aria-label="Close Options"
                                onclick="toggleCommentOptionsMenu({{ $comment->id }})"
                            >
                                ✕
                            </button>

                            <!-- Dynamic Menu Content -->
                            <ul class="mt-8 space-y-4 text-base font-semibold">
                                @if (auth()->id() === $comment->author->id)
                                    <!-- Actions for the comment author -->
                                    <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                        <a href=""> Edit </a>
                                    </li>
                                    <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Delete</button>
                                        </form>
                                    </li>
                                @endif

                                @if (auth()->user()->is_admin)
                                    <!-- Actions for admins and moderators -->
                                    <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                        <a href="{{ route('comment.moderate', $comment->id) }}"> Moderate </a>
                                    </li>
                                    <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Delete</button>
                                        </form>
                                    </li>
                                @elseif (!auth()->user()->is_admin && auth()->id() !== $comment->author->id)
                                    <!-- Actions for regular users -->
                                    <li class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                                        <a href=""> Report Comment</a>
                                    </li>
                                @endif

                            </ul>
                        </div>
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
                        Commented {{ $comment->post->time_stamp->diffForHumans() }}!
                    </p>
                </div>
            </section>
        </section>
    @endforeach
</section>

<!-- JavaScript to toggle the menu -->
<script>
    function toggleCommentOptionsMenu(commentId) {
        const menu = document.getElementById(`comment-options-menu-${commentId}`);
        menu.classList.toggle('hidden');
    }
</script>

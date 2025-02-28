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
                    @auth
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
                                        <!-- Actions for the Comment Author -->
                                        <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                            <form action="{{ route('comment.edit', $comment->id) }}" method="GET">
                                                <button type="submit" class="block w-full text-left">Edit Comment</button>
                                            </form>
                                        </li>
                                        @if (!auth()->user()->is_mod)
                                            <!-- Only non-moderators see this delete button -->
                                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                                <form action="{{ route('comment.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="block w-full text-left">Delete Comment</button>
                                                </form>
                                            </li>
                                        @endif
                                    @endif

                                    @if (auth()->user()->is_mod)
                                        <!-- Actions for Moderators (Not the Comment Author) -->
                                        @if (auth()->id() !== $comment->author->id)
                                            <!-- Flag Comment -->
                                            <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                                <form action="{{ route('posts.flag', $comment->post_id) }}" method="GET">
                                                    <button type="submit" class="block w-full text-left">Flag This Comment</button>
                                                </form>
                                            </li>
                                            <!-- Delete Flag Button -->
                                            @if ($comment->post->notifications->where('type', \App\Models\ModeratorNotification::class)->isNotEmpty())
                                                <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                                    <form action="{{ route('posts.flag.delete', $comment->post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this flag?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block text-white w-full text-left">Delete Flag</button>
                                                    </form>
                                                </li>
                                            @endif
                                        @endif
                                        <!-- Delete Comment -->
                                        <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                            <form action="{{ route('comment.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="block w-full text-left">Delete Comment</button>
                                            </form>
                                        </li>
                                    @endif

                                    @if (!auth()->user()->is_mod && auth()->id() !== $comment->author->id)
                                        <!-- Actions for Regular Users -->
                                        <li class="w-full text-left px-4 py-2 hover:bg-[color:#FF006E] rounded">
                                            <form action="{{ route('posts.report', $comment->post->id) }}" method="GET">
                                                <button type="submit" class="block w-full text-left">Report Comment</button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    @endauth
                </header>
                <!-- Comment Body and Metadata -->
                <div class="flex justify-between items-stretch rounded-md">
                    <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                        {{ $comment->post->body }}
                    </p>
                </div>
                <div class="flex items-center space-x-4 mt-4 justify-between">
                    <div>
                        <p class="text-sm text-gray-700 font-semibold">
                            Commented {{ $comment->post->time_stamp->diffForHumans() }}! &emsp;
                            @if ($comment->post->edit_time)
                                Edited {{ $comment->post->edit_time->diffForHumans() }}!
                             @endif
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center space-x-2">
                        @foreach ($comment->post->moderatorNotifications as $commentModNotification)
                            <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                                {{ $commentModNotification->reason }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </section>
        </section>
    @endforeach
</section>

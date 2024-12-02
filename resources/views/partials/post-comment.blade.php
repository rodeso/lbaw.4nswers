<!-- Comments -->
<section id="commentsSection-{{ $answer->id }}" class="w-full rounded-lg space-y-3 pl-20">
    @foreach ($answer->comments as $comment)
        <section class="w-full space-y-6">
            <section class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
                <!-- Comment Header -->
                <header class="flex items-center justify-between bg-[color:#4B1414]">
                    <div class="relative flex items-center space-x-16 pl-2">
                        <p class="text-lg 
                            @if($answer->chosen) text-white @else text-white @endif">
                            Commented by 
                            <a 
                                href="{{ Auth::id() === $comment->author->id ? route('profile') : route('user.profile', ['id' => $comment->author->id]) }}" 
                                class="hover:text-gray-500"
                            >
                            {{ $comment->author->nickname }}
                            </a>
                        </p>
                        <p class="text-lg text-white">
                             
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
                        Commented {{ $comment->post->time_stamp->diffForHumans() }}!
                    </p>
                </div>
            </section>
        </section>
    @endforeach
</section>


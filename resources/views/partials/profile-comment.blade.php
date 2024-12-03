<a href="{{ route('question.show', $comment->answer->question->id) }}">
    <section class="w-full space-y-6 pl-28" >
        <section class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
            <!-- Comment Header -->
            <header class="flex items-center justify-between bg-[color:#4B1414]">
                <p class="text-lg text-white">
                    Commented by 
                    <a>
                    {{ $comment->author->nickname }}
                    </a>
                </p>
            </header>
            <!-- Comment Body and Metadata -->
            <div class="flex justify-between items-stretch rounded-md">
                <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                    {{ $comment->post->body }}
                </p>
            </div>
            <div class="flex items-center space-x-4 mt-4 justify-between">
                <p class="text-sm text-gray-700 font-semibold break-words">
                    Commented to: {{ $comment->answer->post->body }}
                </p>
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
</a>

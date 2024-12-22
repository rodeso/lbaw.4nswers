<section class="w-full space-y-6 pl-28">
    <section class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
        <!-- Comment Header -->
        <header class="flex items-center justify-between bg-[color:#4B1414]">
            <p class="text-lg text-white pl-2">
                Commented by <a href="{{ route('user.profile', ['id' => $question->author->id]) }}" class=" hover:text-gray-500">{{ $comment->author->nickname }}</a>
            </p>
        </header>
        <!-- Comment Body and Metadata -->
        <div class="flex justify-between items-stretch rounded-md">
            <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                {{ $comment->post->body }}
            </p>
        </div>
        <div class="flex items-center space-x-4 mt-4 justify-between">
            <a href="{{ route('question.show', $comment->answer->question->id) }}" class="block no-underline">
                <p class="text-sm text-gray-700 font-semibold break-words hover:text-gray-500">
                    Commented to: {{ $comment->answer->post->body }}
                </p>
            </a>
            <div class="flex flex-wrap items-center space-x-2 w-full">
                @foreach ($comment->post->moderatorNotifications as $commentModNotification)
                    <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                        {{ $commentModNotification->reason }}
                    </span>
                @endforeach
                <span class="bg-green-400 text-black text-sm font-bold px-2 py-1 rounded ml-auto cursor-pointer"
                    onclick="toggleReports({{ $comment->post_id }})"
                    >
                    No. of Reports: {{ $comment->report_count }}
                </span>
            </div>
        </div>
    </section>
</section>

<!-- Hidden Reports Section -->
<div id="reports-{{ $comment->post_id }}" class="hidden transition-all duration-300 space-y-8 ease-in-out max-h-0-y-4 overflow-hidden opacity-0 pl-40">
    @foreach($reports as $report)
        @if ($report->post_id == $comment->post_id)
            <section class="w-full space-y-6 pl-28">
                <section class="w-full rounded-lg shadow-md p-6 space-y-4 bg-[color:#C18A8A]">
                    <!-- Report Header -->
                    <header class="flex items-center justify-between bg-[color:#4B1414]">
                        <p class="text-lg text-white pl-2">
                            Report Reason: 
                            <span>{{ $report->reason }}</span>
                        </p>
                    </header>
                    <!-- Report Details -->
                    <div class="flex justify-between items-stretch rounded-md">
                        <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                            Explanation: {{ $report->content }}
                        </p>
                    </div>
                </section>
            </section>
        @endif
    @endforeach
</div>
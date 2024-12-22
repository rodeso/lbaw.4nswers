<!-- Answers' Section -->
<section class="w-full space-y-6 pl-12">
    <!-- Answers -->
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
                <p class="text-lg text-white">Answered by <a href="{{ route('user.profile', ['id' => $question->author->id]) }}" class=" hover:text-gray-500">{{ $answer->author->nickname }}</a></p> <!-- To be changed to user's nickname -->
            </div>
            <div 
                class="relative w-80 h-12 bg-white text-center flex items-end justify-end text-[color:#4B1414]"
                style="clip-path: polygon(100% 0, 100% 100%, 0 100%);"
            >
                <p class="text-sm font-bold p-2">{{ $answer->vote_difference }} aura</p>
            </div>
        </header>
        <!-- Answer Body-->
        <div class="flex justify-between items-stretch rounded-md">
            <!-- Answer Body -->
            <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                {{ $answer->post->body }}
            </p>
        </div>
        <!-- Time Posting & Answer Tags -->
        <div class="flex items-center space-x-4 mt-4">
            <a href="{{ route('question.show', $answer->question->id) }}" class="hover:text-gray-500">
                <p class="text-sm text-gray-700 font-semibold break-words whitespace-nowrap">
                    Answered to: {{ $answer->question->title }}
                </p>
            </a>
            <div class="flex flex-wrap items-center space-x-2 w-full">
                @foreach ($answer->post->moderatorNotifications as $modNotification)
                    <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                        {{ $modNotification->reason }}
                    </span>
                @endforeach
                <span class="bg-green-400 text-black text-sm font-bold px-2 py-1 rounded ml-auto cursor-pointer"
                    onclick="toggleReports({{ $answer->post_id }})"
                    >
                    No. of Reports: {{ $answer->report_count }}
                </span>
            </div>
        </div>
    </section>
</section>


<!-- Hidden Reports Section -->
<div id="reports-{{ $answer->post_id }}" class="hidden transition-all duration-300 ease-in-out max-h-0 overflow-hidden opacity-0 pl-40">
    @foreach($reports as $report)
        @if ($report->post_id == $answer->post_id)
            <section class="w-full space-y-6 pl-28">
                <section class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
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
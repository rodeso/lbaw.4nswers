<!-- Post's Question -->
<section class="w-full bg-[color:#C18A8A] rounded-lg shadow-md p-6 space-y-6"
    onclick="handleClick('{{ route('question.show', $question->id) }}')">

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
            <p class="text-xl text-white">Asked by <a href="{{ route('user.profile', ['id' => $question->author->id]) }}" class="hover:text-gray-500">{{ $question->author->nickname }}</a></p>
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
    <!-- Question Title and Yeahs -->
    <div class="flex justify-between items-center rounded-md">
        <!-- Question Title with Border -->
        <h1 class="text-2xl font-bold border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow">
            <a href="{{ route('question.show', $question->id) }}" class="hover:text-gray-500" >{{ $question->title }}</a>
        </h1>
        <div class="flex items-center space-x-2">
            <!-- Yeahs Count -->
            @if ($question->vote_difference >= 0)
                <h2 class="text-lg font-bold"> {{ $question->vote_difference }} YEAHs</h2>
            @else
                <h2 class="text-lg font-bold"> {{ -$question->vote_difference }} BOOs</h2>
            @endif
        </div>
    </div>
    <!-- Question Body -->                        
    <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mt-4 break-words">
        {{ $question->post->body }}
    </p>
    <!-- Time Posting, Question Tags & Moderator Flags -->
    <div class="flex items-center space-x-4 mt-4">
        <!-- Time of Posting -->
        <p class="text-sm text-gray-700 font-semibold whitespace-nowrap">
            Asked {{ $question->post->time_stamp->diffForHumans() }}!
        </p>
        <!-- Question Tags & Moderator Flags -->
        <div class="flex flex-wrap items-center w-full">
            @foreach ($question->tags as $tag)
                <span class="bg-[color:#FCF403] text-black-800 text-sm font-bold px-2 py-1 rounded">{{ $tag->name }}</span>
            @endforeach
            @foreach ($question->post->moderatorNotifications as $questionModNotification)
                <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                    {{ $questionModNotification->reason }}
                </span>
            @endforeach
            <span class="bg-green-400 text-black text-sm font-bold px-2 py-1 rounded ml-auto cursor-pointer"
                    onclick="toggleReports({{ $question->post_id }})"
                >
                No. of Reports: {{ $question->report_count }}
            </span>
        </div>
    </div>
</section>
<!-- Hidden Reports Section -->

<div id="reports-{{ $question->post_id }}" class="hidden transition-all duration-300 ease-in-out max-h-0 overflow-hidden opacity-0 pl-40 space-y-6">
    @foreach($reports as $report)
        @if ($report->post_id == $question->post_id)
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
        @endif
    @endforeach
</div>
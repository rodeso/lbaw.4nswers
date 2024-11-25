<a href="{{ route('question.show', $answer->question->id) }}" class="p-6">
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
                    <p class="text-lg text-white">Answered by {{ $answer->author->nickname }}</p> <!-- To be changed to user's nickname -->
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
                <p class="text-sm text-gray-700 font-semibold">
                    Answered to: {{ $answer->question->title }}
                </p>
                <div class="flex flex-wrap items-center space-x-2">
                @foreach ($answer->post->moderatorNotifications as $modNotification)
                    <span class="bg-red-400 text-black text-sm font-bold px-2 py-1 rounded">
                        {{ $modNotification->reason }}
                    </span>
                @endforeach
            </div>
            </div>
        </section>
    </section>
</a>
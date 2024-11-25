<a href="{{ route('question.show', $question->id) }}" class="p-6">
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
        <!-- Question Title and Yeahs -->
        <div class="flex justify-between items-center rounded-md">
            <!-- Question Title with Border -->
            <h1 class="text-2xl font-bold border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow">
                {{ $question->title }}
            </h1>
            <div class="flex items-center space-x-2">
                <!-- Yeahs Count -->
                <h2 class="text-lg font-bold">1000 Yeahs</h2>
            </div>
        </div>
        <!-- Question Body -->                        
        <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mt-4 break-words">
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
</a>
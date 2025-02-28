<div class="bg-[color:#C18A8A] rounded-lg shadow-md p-4">
    <a href="{{ route('question.show', $question->id) }}">
        <header class="flex items-center justify-between bg-[color:#4B1414] p-2">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                <p class="text-sm text-gray-500">User: {{ $question->author_id }}</p>
            </div>
            <p class="text-sm text-gray-500">Time Left: {{ $question->time_end->diffForHumans() }}</p>
        </header>
        <div class="flex items-center justify-between p-2">
            <h2 class="text-lg font-bold mt-2">
                    {{ $question->title }}
                
            </h2>
            <h3 class="text-white">## Yeahs!</h3>
        </div>
        <p class="text-gray-600 mt-2">{{ $question->post->body }}</p>
        <div class="flex justify-between items-center mt-4">
            <div class="space-x-2">
                @foreach ($question->tags as $tag)
                    <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    </a>
</div>
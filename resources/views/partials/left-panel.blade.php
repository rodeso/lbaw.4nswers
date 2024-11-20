<aside class="fixed top-20 left-5 w-[15%] bg-gray-200 p-6 rounded-lg shadow-lg">
    <nav>
        <ul class="space-y-4">
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    4U
                </button>
            </li>
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    New
                </button>
            </li>
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    Urgent
                </button>
            </li>
            <li>
                <button class="text-lg font-bold w-full text-left px-4 py-2 rounded hover:bg-gray-300">
                    Popular
                </button>
            </li>
        </ul>
    </nav>
    <div class="mt-8">
        <h4 class="font-bold mb-4">Subscribed Tags</h4>
        <ul class="space-y-2">
            @foreach ($tags as $tag)
                <li>
                    <button class="bg-gray-300 hover:bg-gray-400 px-4 py-1 rounded">
                        {{ $tag->name }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
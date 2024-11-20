<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <nav>
        <ul class="space-y-4 bg-[color:#C18A8A]">
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
        <h4 class="font-bold mb-4 text-[color:#C18A8A]">Subscribed Tags</h4>
        <ul class="space-y-2">
            @foreach ($tags as $tag)
                <li>
                    <a class="text-[color:#C18A8A]">
                        {{ $tag->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
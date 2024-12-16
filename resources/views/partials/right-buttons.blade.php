
<script src="{{ asset('js/search.js') }}" defer></script>
<ul class="fixed top-24 right-10 space-y-4 w-[10%]">
    <li>
        <button
            id="search-button"
            class="bg-[color:#4B1414] hover:bg-[color:#4B1414] text-white px-4 py-2 rounded-md w-full text-sm">
            Search
        </button>
    </li>
    @auth
    <li>
        <button class="bg-[color:#4B1414] hover:bg-[color:#4B1414] text-white px-4 py-2 rounded-md w-full text-sm">
            <a href=" {{ route('new-question') }}">Post a Question</a>
        </button>
    </li>
    @endauth
    @guest
    <li>
        <button class="bg-[color:#4B1414] hover:bg-[color:#4B1414] text-white px-4 py-2 rounded-md w-full text-sm">
            <a href="/login">Login to Post</a>
        </button>
    </li>
    @endguest
</ul>

<!-- Floating Search Bar -->
<div id="search-container" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-white w-2/3 shadow-lg rounded-lg hidden z-50">
    <div class="flex items-center justify-between px-4 py-3">
        <input
            id="search-input"
            type="text"
            class="w-full p-2 border border-gray-300 rounded-md"
            placeholder="Search posts..."
        />
        <button id="search-close" class="ml-4 text-gray-500 hover:text-gray-800">
            ✖
        </button>
    </div>
    <div id="search-results" class="absolute bg-white w-full p-4 rounded-lg shadow-md hidden">
    <!-- Results will be dynamically added here -->
    </div>
</div>


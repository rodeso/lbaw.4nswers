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

<script>

 document.getElementById('search-button').addEventListener('click', () => {
    document.getElementById('search-container').classList.remove('hidden');
});

document.getElementById('search-close').addEventListener('click', () => {
    document.getElementById('search-container').classList.add('hidden');
});

//AJAX

document.getElementById('search-input').addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length < 3) {
        document.getElementById('search-results').classList.add('hidden');
        return;
    }

    fetch(`/api/search?query=${encodeURIComponent(query)}`) // Use the API endpoint
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch search results');
            }
            return response.json();
        })
        .then(data => {
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = ''; // Clear previous results

            if (data.length === 0) {
                resultsContainer.innerHTML = '<p class="text-gray-500">No results found.</p>';
            } else {
                data.forEach(question => {
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('p-2', 'border-b', 'border-gray-300');
                    resultItem.innerHTML = `
                        <a href="/questions/${question.id}" class="block hover:bg-gray-100 rounded-md p-2">
                            <p class="font-bold">${question.title}</p>
                            <p class="text-sm text-gray-500">
                                ${question.post.body.substring(0, 100)}...
                            </p>
                            <p class="text-xs text-gray-400">
                                Matched in: ${query.toLowerCase() === question.title.toLowerCase().substring(0, query.length) ? 'Title' : 'Body'}
                            </p>
                        </a>
                    `;
                    resultsContainer.appendChild(resultItem);
                });
            }

            resultsContainer.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching search results:', error);
        });
});




</script>
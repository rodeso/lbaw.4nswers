

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




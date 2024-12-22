document.addEventListener("DOMContentLoaded", async () => {
    const searchContainer = document.getElementById("search-container");
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");
    const searchResults = document.getElementById("search-results");
    const tagDropdownBtn = document.getElementById("tag-dropdown-btn");
    const tagDropdownMenu = document.getElementById("tag-dropdown-menu");
    const searchClose = document.getElementById("search-close");
    let selectedTagId = ""; // Default to no tag
    let debounceTimeout;

    // Function to fetch tags and populate the dropdown
    const fetchTags = async () => {
        try {
            const response = await fetch("/api/tags/fetch"); // Adjust endpoint
            if (!response.ok) throw new Error("Failed to fetch tags");

            const tags = await response.json();

            // Populate dropdown
            tagDropdownMenu.innerHTML = ""; // Clear existing options
            tags.forEach(tag => {
                const tagOption = document.createElement("div");
                tagOption.className = "p-2 cursor-pointer hover:bg-gray-100 rounded-md";
                tagOption.setAttribute("data-tag-id", tag.id);
                tagOption.textContent = tag.name;
                tagDropdownMenu.appendChild(tagOption);
            });

            // Add event listener for tag selection
            tagDropdownMenu.addEventListener("click", (e) => {
                const selectedTag = e.target;
                selectedTagId = selectedTag.getAttribute("data-tag-id");
                tagDropdownBtn.textContent = selectedTag.textContent;
                tagDropdownMenu.classList.add("hidden");
                // Trigger a search with the new tag
                if (searchInput.value.trim().length > 2) {
                    fetchSearchResults(searchInput.value.trim(), selectedTagId);
                }
            });
        } catch (error) {
            console.error("Error fetching tags:", error);
        }
    };

    // Function to fetch search results
    const fetchSearchResults = async (query, tagId) => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(async () => {
            try {
                const response = await fetch(`/api/search?query=${encodeURIComponent(query)}&tag=${encodeURIComponent(tagId)}`);
                if (!response.ok) throw new Error("Failed to fetch search results");

                const results = await response.json();

                // Clear previous results
                searchResults.innerHTML = "";

                if (results.length > 0) {
                    searchResults.classList.remove("hidden");

                    results.forEach(result => {
                        const resultItem = document.createElement("div");
                        resultItem.className = "py-2 border-b border-gray-300";
                        resultItem.innerHTML = `
                            <a href="/questions/${result.id}" class="block hover:bg-gray-100 rounded-md p-2">
                                <p class="font-bold">${result.title}</p>
                                <p class="text-sm text-gray-500">
                                    ${result.post.body.substring(0, 100)}...
                                </p>
                                <p class="text-sm text-gray-500">
                                    ${result.tags.map(tag => `#${tag.name}`).join(" ")}
                                </p>
                            </a>
                        `;
                        searchResults.appendChild(resultItem);
                    });
                } else {
                    // No results found, show "No results" message
                    searchResults.classList.remove("hidden");
                    searchResults.innerHTML = `<p class="py-4 text-center text-gray-500">No results found.</p>`;
                }
            } catch (error) {
                console.error("Error fetching search results:", error);
            }
        }, 300); // Debounce delay
    };


    // Fetch tags on page load
    await fetchTags();

    // Event Listener for Search Input
    searchInput.addEventListener("input", () => {
        const query = searchInput.value.trim();
        if (query.length > 2) {
            fetchSearchResults(query, selectedTagId);
        } else {
            searchResults.classList.add("hidden");
        }
    });

    // Toggle tag dropdown menu
    tagDropdownBtn.addEventListener("click", () => {
        tagDropdownMenu.classList.toggle("hidden");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!tagDropdownMenu.contains(e.target) && e.target !== tagDropdownBtn) {
            tagDropdownMenu.classList.add("hidden");
        }
    });

    // Close button to hide the search container
    searchClose.addEventListener("click", () => {
        searchInput.value = "";
        searchResults.innerHTML = "";
        selectedTagId = "";
        tagDropdownBtn.textContent = "All Tags";
    });

    // Event Listener for Search Button
    searchButton.addEventListener("click", () => {
        searchContainer.classList.toggle("hidden");
    });
    
});

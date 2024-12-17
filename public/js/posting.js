document.addEventListener('DOMContentLoaded', () => {
    const tagsContainer = document.getElementById('tags-container');
    const selectedTagsInput = document.getElementById('selected-tags');
    const newTagsInput = document.getElementById('new-tags');
    const newTagNameField = document.getElementById('new-tag-name');
    const newTagDescriptionField = document.getElementById('new-tag-description');
    const addNewTagButton = document.getElementById('add-new-tag');

    let selectedTags = []; // Array to store selected tag IDs
    let newTags = []; // Array to store new tags as objects with name and description

    // Toggle selection of existing tags
    tagsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('tag')) {
            const tag = e.target;
            const tagId = tag.getAttribute('data-id');

            if (selectedTags.includes(tagId)) {
                selectedTags = selectedTags.filter(id => id !== tagId);
                tag.classList.remove('bg-[color:#FCF403]');
                tag.classList.add('bg-gray-300');
            } else {
                selectedTags.push(tagId);
                tag.classList.remove('bg-gray-300');
                tag.classList.add('bg-[color:#FCF403]');
            }

            selectedTagsInput.value = selectedTags.join(',');
        }
    });

    // Add new tags dynamically
    addNewTagButton.addEventListener('click', () => {
        const newTagName = newTagNameField.value.trim();
        const newTagDescription = newTagDescriptionField.value.trim();

        if (newTagName && newTagDescription) {
            const newTagObj = { name: newTagName, description: newTagDescription };

            // Create a new span for the new tag
            const newTagSpan = document.createElement('span');
            newTagSpan.className = "tag bg-[color:#FCF403] text-black-800 text-sm font-bold px-2 py-1 rounded cursor-pointer";
            newTagSpan.textContent = newTagName;

            // Add a custom attribute to track its index in `newTags`
            const tagIndex = newTags.length;
            newTagSpan.setAttribute('data-index', tagIndex);

            // Add event listener to toggle selection for the new tag
            newTagSpan.addEventListener('click', () => {
                const index = parseInt(newTagSpan.getAttribute('data-index'));

                // Toggle selection
                if (newTagSpan.classList.contains('bg-[color:#FCF403]')) {
                    newTagSpan.classList.remove('bg-[color:#FCF403]');
                    newTagSpan.classList.add('bg-gray-300');
                    delete newTags[index]; // Remove from newTags
                } else {
                    newTagSpan.classList.remove('bg-gray-300');
                    newTagSpan.classList.add('bg-[color:#FCF403]');
                    newTags[index] = newTagObj; // Re-add to newTags
                }

                // Filter out any `undefined` values from newTags and update hidden input
                newTagsInput.value = JSON.stringify(newTags.filter(tag => tag));
            });

            // Append the new tag span and add it to the newTags array
            tagsContainer.appendChild(newTagSpan);
            newTags.push(newTagObj);

            // Clear the input fields
            newTagNameField.value = '';
            newTagDescriptionField.value = '';
            newTagsInput.value = JSON.stringify(newTags);
        } else {
            alert('Please provide both a name and a description for the new tag.');
        }
    });

});
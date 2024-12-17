// Options Menu on Questions

function toggleQuestionOptionsMenu(questionId) {
    const menu = document.getElementById(`question-options-menu-${questionId}`);
    menu.classList.toggle('hidden');
}

// Options Menu on Answers

function toggleAnswerOptionsMenu(answerId) {
    const menu = document.getElementById(`answer-options-menu-${answerId}`);
    menu.classList.toggle('hidden');
}

// Options Menu on Comments

function toggleCommentOptionsMenu(commentId) {
    const menu = document.getElementById(`comment-options-menu-${commentId}`);
    menu.classList.toggle('hidden');
}

// Votes on Questions

async function handleVote(questionId, voteType) {
    try {
        const response = await fetch(`/questions/${questionId}/vote`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ vote: voteType })
        });

        if (response.ok) {
            const data = await response.json();

            // Update the Yeahs Count
            document.getElementById(`yeahs-count-${questionId}`).textContent = data.totalVotes;

            // Get buttons
            const upvoteButton = document.getElementById(`upvote-button-${questionId}`);
            const downvoteButton = document.getElementById(`downvote-button-${questionId}`);

            // Handle upvote action
            if (voteType === 'upvote') {
                upvoteButton.classList.add('bg-green-600');
                upvoteButton.classList.remove('bg-[color:#4B1414]', 'hover:bg-green-600');
                downvoteButton.classList.remove('bg-red-600');
                downvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-red-600');
            } 

            // Handle downvote action
            else if (voteType === 'downvote') {
                downvoteButton.classList.add('bg-red-600');
                downvoteButton.classList.remove('bg-[color:#4B1414]', 'hover:bg-red-600');
                upvoteButton.classList.remove('bg-green-600');
                upvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-green-600');
            }

            // If the vote was undone, reset both buttons to default state
            if (data.voteUndone) {
                upvoteButton.classList.remove('bg-green-600');
                upvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-green-600');

                downvoteButton.classList.remove('bg-red-600');
                downvoteButton.classList.add('bg-[color:#4B1414]', 'hover:bg-red-600');
            }
        } else {
            console.error('Failed to vote');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Votes on Answers

function handleAuraVote(answerId, voteType) {
    fetch(`/answer/${answerId}/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ vote: voteType }),
    })
        .then(response => response.json())
        .then(data => {
            // Update the aura display
            const auraElement = document.querySelector(`#aura-${answerId}`);
            if (auraElement) {
                auraElement.textContent = `Aura: ${data.totalAura}`;
            }
        })
        .catch(error => console.error('Error:', error));
}


// Toggle Answer Form

function toggleAnswerForm() {
    const form = document.getElementById('answerForm');
    const button = document.getElementById('toggleAnswerButton');
    
    // Toggle visibility of the form
    form.classList.toggle('hidden');
    
    // Update button text based on the form's state
    if (form.classList.contains('hidden')) {
        button.textContent = "Click here to answer!";
    } else {
        button.textContent = "Close Answer Form.";
    }
}

// Toggle Comment Form
function toggleCommentForm(answerId) {
    const form = document.getElementById('commentForm-' + answerId);
    const button = document.getElementById('toggleCommentButton-' + answerId);
    
    // Toggle visibility of the form
    form.classList.toggle('hidden');
    
    // Update button text based on the form's state
    if (form.classList.contains('hidden')) {
        button.textContent = "Comment here!";
    } else {
        button.textContent = "Close Comment Form.";
    }
}

function toggleCommentsVisibility(answerId) {
    const commentsSection = document.getElementById('commentsSection-' + answerId);
    const toggleButton = document.getElementById('toggleCommentsButton-' + answerId);
    
    // Toggle visibility of the comments section
    commentsSection.classList.toggle('hidden');
    
    // Update button text based on the visibility of comments
    if (commentsSection.classList.contains('hidden')) {
        toggleButton.textContent = "Show Comments";
    } else {
        toggleButton.textContent = "Hide Comments";
    }
}
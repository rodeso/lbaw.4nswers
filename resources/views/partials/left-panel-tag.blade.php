<aside class="fixed top-20 left-5 w-[15%] bg-[color:#4E0F35] p-6 rounded-lg shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center bg-[color:#C18A8A] p-4 relative">
        
        <h2 class="text-lg font-bold text-center">{{ $tag->name }}</h2>
        <p class="text-sm text-center">{{ $tag->description }}</p>
        <p class="text-sm text-center">Followed by: {{ $tag->follower_count }}</p>
        <form method="POST" action="{{ route('tags.toggle-follow', $tag->id) }}">
            @csrf
            <button 
                id="follow-toggle" 
                class="px-4 py-2 text-l w-24 text-white bg-red-500 rounded-lg hover:bg-red-700"
                type="submit"
            >
                {{ $tag->is_following ? 'Unfollow' : 'Follow' }}
            </button>
        </form>
    </div>
</aside>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        const tagId = {{ $tag->id }};
        const button = $('#follow-toggle');

        button.on('click', function (e) {
            e.preventDefault(); // Prevent the default behavior

            const isFollowing = button.text().trim() === 'Unfollow';
            const url = `/tags/${tagId}/toggle-follow`;

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.status === 'followed') {
                        button.text('Unfollow');
                        button.removeClass('btn-primary').addClass('btn-danger');
                    } else if (response.status === 'unfollowed') {
                        button.text('Follow');
                        button.removeClass('btn-danger').addClass('btn-primary');
                    }
                },
                error: function () {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>

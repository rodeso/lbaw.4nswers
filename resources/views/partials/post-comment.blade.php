<!-- Comment Section -->
<section class="w-full space-y-6 pl-20">
    <section 
        class="w-full rounded-lg shadow-md p-6 space-y-3 bg-[color:#C18A8A]">
        <!-- Comment Header -->
        <header class="flex items-center justify-between bg-[color:#4B1414]">
            <div class="relative flex items-center space-x-16 pl-2">
                <p class="text-lg text-white">
                    Commented by {{ $answer->author->nickname }}
                </p>
            </div>
        </header>
        <!-- Comment Body and upvote/downvote -->
        <div class="flex justify-between items-stretch rounded-md">
            <!-- Comment Body -->
            <p class="text-gray-600 border-2 border-[color:#4B1414] rounded-md p-2 mr-3 flex-grow break-words">
                Example of a random comment! This is a test comment to see how it looks like on the website.
            </p>
        </div>
        <!-- Time Posting & Moderator Tags -->
        <div class="flex items-center space-x-4 mt-4 justify-between">
            <div class="flex items-center space-x-4">
                <p class="text-sm text-gray-700 font-semibold">
                    Commented {{ $answer->post->time_stamp->diffForHumans() }}!
                </p>
            </div>
        </div>
    </section>
</section>
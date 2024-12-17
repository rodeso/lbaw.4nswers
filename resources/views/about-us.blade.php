<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <title>4NSWERS - About Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">

        <!-- Header -->
        @include('partials.header')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col p-6 bg-white shadow-md rounded-lg mx-auto w-3/5 mt-20">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-[color:#4E0F35]">About Us</h1>
            </div>

            <!-- About Content -->
            <div class="space-y-6">
                <p class="text-gray-700">
                    Our project aims to redefine what it means to be online and have questions. Our goal is to ensure that every user feels comfortable asking questions and confident that they will receive fast and constructive answers in a friendly environment. 
                </p>
                <h2 class="text-xl font-semibold text-[color:#4E0F35]">4NSWERS</h2>
                <p class="text-gray-700">
                    As learners, we often have questions that need answers as fast as possible. So we decided to create a collaborative Q&A content-rated forum website adapted for those situations.
                </p>
                <p class="text-gray-700">
                    On this website, users can post their questions or doubts about a certain topic, marking the post with appropriate tags. Other users can respond with what they think is the best answer to the current problem. Guests can view questions and responses but must create an account to participate.
                </p>
                <p class="text-gray-700">
                    As various answers stack up on a post, they are voted on by users. Positive and negative votes affect the answers' order, with the most publicly supported answers appearing at the top.
                </p>
                <h2 class="text-xl font-semibold text-[color:#4E0F35]">Gamification</h2>
                <p class="text-gray-700">
                    The website incorporates a points system to encourage participation. Responders with the top 4 answers on a post receive reward points, as does the responder whose answer is marked as USEFUL by the poster. Posters also earn points based on their question's popularity.
                </p>
                <p class="text-gray-700">
                    The top 16 users with the most points are featured in a special "Hall of Fame" ranking on the website.
                </p>
                <h2 class="text-xl font-semibold text-[color:#4E0F35]">How It Works</h2>
                <p class="text-gray-700">
                    Questions are open for a predetermined amount of time (up to 48 hours) selected by the poster. The question closes when time runs out or when the poster declares an answer as USEFUL. After closure, the post remains accessible but locked for new contributions and votes.
                </p>
                <p class="text-gray-700">
                    Moderators may review flagged posts and provide an analysis of answers, alerting the community to incorrect answers. Posts with higher interaction or significant reports are more likely to receive moderation. Moderators can issue alerts and adjust points for flagged content.
                </p>
                <h2 class="text-xl font-semibold text-[color:#4E0F35]">Becoming a Moderator</h2>
                <p class="text-gray-700">
                    Users can become moderators for a tag by earning points and providing accurate answers to posts associated with that tag.
                </p>
                <h2 class="text-xl font-semibold text-[color:#4E0F35]">Our Mission</h2>
                <p class="text-gray-700">
                    Our central motivation is to reduce the frustration of not having someone to ask about important or urgent questions. By engaging a community of users, we aim to deliver the best possible answers quickly and effectively.
                </p>
            </div>
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

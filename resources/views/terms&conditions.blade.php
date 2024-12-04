<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('rose.ico') }}?v=1.0">
    <title>4NSWERS - Terms & Conditions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .scroll-banner::-webkit-scrollbar {
            display: none;
        }
        .scroll-banner {
            scrollbar-width: none; /* Firefox */
        }
        .squircle {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), transparent);
            clip-path: path("M20,2 Q38,2,38,20 Q38,38,20,38 Q2,38,2,20 Q2,2,20,2 Z");
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <!-- Main Page Wrapper -->
    <div class="flex flex-col min-h-screen">

        <!-- Header -->
        @include('partials.header')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col p-6 bg-white shadow-md rounded-lg mx-auto w-3/5 mt-20">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-[color:#4E0F35]">Terms & Conditions</h1>
                <p class="text-gray-600">Effective Date: 28/11/2024</p>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto max-h-[calc(100vh-320px)] border-t border-b border-gray-300 p-6 space-y-6">
                <h2 class="text-xl font-semibold text-[color:#4E0F35]">A. Acceptance of Terms</h2>
                <p class="text-gray-700">By accessing or using 4NSWERS, you agree to abide by these Terms and Conditions and our Privacy Policy. If you do not agree, please refrain from using the platform. Continued usage constitutes acceptance.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">B. User Eligibility</h2>
                <p class="text-gray-700">You must be at least 13 years of age to use 4NSWERS. By creating an account, you affirm that you meet the age requirement and are legally permitted to use this service.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">C. Account Responsibilities</h2>
                <p class="text-gray-700">Users must provide accurate information when creating accounts. Each user is responsible for safeguarding their account credentials and all activities under their account. Unauthorized access to another user's account is strictly prohibited.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">D. Posting Content</h2>
                <p class="text-gray-700">Users are responsible for all content they post, including questions, answers, and comments. By posting, you grant 4NSWERS a non-exclusive, royalty-free license to display, distribute, and modify the content for the platform's operation.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">E. Content Guidelines</h2>
                <p class="text-gray-700">Users are prohibited from posting:
                    <ol class="list-decimal pl-6 text-gray-700">
                        <li>Offensive, illegal, or harmful content.</li>
                        <li>Spam, promotions, or irrelevant materials.</li>
                        <li>Misleading or false answers that disrupt the platform's purpose.</li>
                    </ol>
                </p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">F. Voting System</h2>
                <p class="text-gray-700">Users can upvote or downvote answers based on quality and relevance. This voting impacts answer visibility and contributes to gamification points.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">G. Gamification and Rewards</h2>
                <p class="text-gray-700">1. Points are earned for engagement, including posting popular questions, receiving votes, and providing USEFUL answers.<br>2. Points can be reduced for flagged or moderated content violations.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">H. Hall of Fame</h2>
                <p class="text-gray-700">The top 16 users based on points are featured in the Hall of Fame. This list is updated regularly to reflect the most active and helpful contributors.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">I. Moderation</h2>
                <p class="text-gray-700">Moderators review flagged posts and randomly patrol all questions and feeds. They can issue alerts, remove content, or adjust point balances for violations. Users may become moderators by achieving specific performance metrics.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">J. Time-Limited Questions</h2>
                <p class="text-gray-700">All questions are open for a maximum of 48 hours (decision up to the question's poster) or until a USEFUL answer is selected. After closure, the post remains accessible but locked for further contributions and votes.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">K. Prohibited Activities</h2>
                <p class="text-gray-700">
                    <ol class="list-decimal pl-6 text-gray-700">
                        <li>Circumventing rules to gain points unfairly.</li>
                        <li>Harassment, impersonation, or fraudulent activity.</li>
                        <li>Using bots or scraping data without permission.</li>
                    </ol>
                </p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">L. Disclaimers and Liabilities</h2>
                <p class="text-gray-700">4NSWERS is not responsible for incorrect information or damages arising from platform use. Users are encouraged to verify critical information independently.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">M. Privacy and Data Use</h2>
                <p class="text-gray-700">Please review our Privacy Policy for detailed information on how user data is collected, used, and stored. By using the platform, you consent to these practices.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">N. Termination of Accounts</h2>
                <p class="text-gray-700">4NSWERS reserves the right to suspend or terminate accounts for policy violations or misuse. Suspended users forfeit any accumulated points or rewards.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">O. Amendments</h2>
                <p class="text-gray-700">These Terms and Conditions may be updated periodically. Continued use of the platform after changes indicates your acceptance of the revised terms.</p>

                <h2 class="text-xl font-semibold text-[color:#4E0F35]">P. Contact</h2>
                <p class="text-gray-700">For questions or concerns, please contact support@4nswers.com .</p>
            </div>
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

</body>
</html>

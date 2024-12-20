<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForYouController;
use App\Http\Controllers\HallOfFameController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TagPageController;

use App\Http\Controllers\SearchController;


// Home
Route::get('/', [IndexController::class, 'index'])->name('home');

// Authentication - Login & Register & Logout
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// ForYou
Route::get('/foryou', [ForYouController::class, 'index'])->name('foryou');

// Hall of Fame
Route::get('/hall-of-fame', [HallOfFameController::class, 'index'])->name('hall-of-fame');

// Admin Dashboard
Route::get('/admin-dashboard/users', [AdminDashboardController::class, 'users'])->name('admin-dashboard.users');
Route::get('/admin-dashboard/tags', [AdminDashboardController::class, 'tags'])->name('admin-dashboard.tags');
Route::get('/admin-dashboard/posts', [AdminDashboardController::class, 'posts'])->name('admin-dashboard.posts');

Route::post('/user/{id}/toggle-mod', [UserController::class, 'toggleMod'])->name('user.toggleMod');
Route::post('/user/{id}/toggle-block', [UserController::class, 'toggleBlock'])->name('user.toggleBlock');

Route::delete('/tags/{id}', [AdminDashboardController::class, 'deleteTag'])->name('admin-dashboard.deleteTag');

// Terms & Conditions
Route::get('/terms', [TermsConditionsController::class, 'index'])->name('terms-and-conditions');

// About Us
Route::get('/about', [AboutUsController::class, 'about'])->name('about.us');

// Popular, Urgent, New
Route::get('/popular', [IndexController::class, 'reorderByPopularity'])->name('popular');

Route::get('/urgent', [IndexController::class, 'reorderByUrgent'])->name('urgent');

Route::get('/new', [IndexController::class, 'reorderByNew'])->name('new');

// Question
Route::get('/questions/{id}', [PostController::class, 'show'])->name('question.show');

// Edit Question
Route::get('/questions/{id}/edit', [PostController::class, 'showEditQuestion'])->name('question.edit');
Route::put('/questions/{id}/update', [PostController::class, 'updateQuestion'])->name('question.update');
Route::delete('/questions/{id}/delete', [PostController::class, 'deleteQuestion'])->name('question.delete');
Route::post('/questions/{id}/close', [PostController::class, 'closeQuestion'])->name('question.close');

// Edit Question Tags
Route::get('/questions/{id}/edit-tags', [PostController::class, 'showEditTags'])->name('question.edit-tags');
Route::put('/questions/{id}/update-tags', [PostController::class, 'updateTags'])->name('question.update-tags');

// Follow Question
Route::post('/questions/{id}/follow', [PostController::class, 'followQuestion'])->name('question.follow');

// Report
Route::get('/posts/{id}/report', [NotificationController::class, 'showReportForm'])->name('posts.report');
Route::post('/posts/{id}/report', [NotificationController::class, 'reportPost'])->name('posts.report.submit');

// Flags
Route::get('/posts/{id}/flag', [NotificationController::class, 'showFlagForm'])->name('posts.flag');
Route::post('/posts/{id}/flag', [NotificationController::class, 'flagPost'])->name('posts.flag.submit');
Route::delete('/posts/{id}/flag', [NotificationController::class, 'deleteFlag'])->name('posts.flag.delete');

// Notifications
Route::get('/notifications', [NotificationController::class, 'getVoteNotifications'])->name('notifications.index');

//Choose Best Answer
Route::post('/questions/{questionId}/choose-answer/{answerId}', [PostController::class, 'chooseAnswer'])->name('question.chooseAnswer');

// Post Answer
Route::post('/answers', [PostController::class, 'storeAnswer'])->name('answer.store');

// Post Comment
Route::post('/answers/{answerId}/comments', [PostController::class, 'storeComment'])->name('comments.store');

// Edit Answer
Route::get('/answers/{id}/edit', [PostController::class, 'showEditAnswer'])->name('answer.edit');
Route::put('/answers/{id}/update', [PostController::class, 'updateAnswer'])->name('answer.update');
Route::delete('/answers/{id}/delete', [PostController::class, 'deleteAnswer'])->name('answer.delete');

// Edit Comment
Route::get('/comments/{id}/edit', [PostController::class, 'showEditComment'])->name('comment.edit');
Route::delete('/comments/{id}/delete', [PostController::class, 'deleteComment'])->name('comment.delete');
Route::put('/comments/{id}/update', [PostController::class, 'updateComment'])->name('comment.update');

// Posting Question
Route::post('/questions', [PostController::class, 'storeQuestion'])->name('question.store');
Route::get('/new-question', [PostController::class, 'showNewQuestion'])->name('new-question');

// Yeah Vote
Route::post('/questions/{id}/vote', [PostController::class, 'vote'])->name('question.vote');

// Aura Vote
Route::post('/answer/{answerId}/vote', [PostController::class, 'auraVote'])->name('answer.vote');

// Profile
Route::get('/profile', [UserController::class, 'index'])->name('profile');

// User Profiles
Route::get('/users/{id}', [UserController::class, 'show'])->name('user.profile');

// Delete User
Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('user.delete');

// Follow User
// Tag Page
Route::get('/tags/{id}', [TagPageController::class, 'index'])->name('tag');
Route::post('/tags/{id}/toggle-follow', [TagPageController::class, 'toggleFollow'])->name('tags.toggle-follow');
Route::get('/tags/{id}/is-following', [TagPageController::class, 'isFollowing']);

//Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Edit Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [UserController::class, 'update'])->name('profile.update');
});

// Edit Credentials Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit/password', [UserController::class, 'editpassword'])->name('password.edit');
    Route::put('/profile/edit/password', [UserController::class, 'updatepassword'])->name('password.update');
});



?>
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

// Terms & Conditions
Route::get('/terms-and-conditions', [TermsConditionsController::class, 'index'])->name('terms-and-conditions');

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

// Post Answer
Route::post('/answers', [PostController::class, 'storeAnswer'])->name('answer.store');

// Post Comment
Route::post('/answers/{answerId}/comments', [PostController::class, 'storeComment'])->name('comments.store');

// Edit Answer
Route::get('/answers/{id}/edit', [PostController::class, 'showEditAnswer'])->name('answer.edit');
Route::put('/answers/{id}/update', [PostController::class, 'updateAnswer'])->name('answer.update');
Route::delete('/answers/{id}/delete', [PostController::class, 'deleteAnswer'])->name('answer.delete');

// Posting Question
Route::post('/new-question', [PostController::class, 'storeQuestion'])->name('question.store');
Route::get('/new-question', [PostController::class, 'showNewQuestion'])->name('new-question');

// Yeah Vote
Route::post('/questions/{id}/vote', [PostController::class, 'vote'])->name('question.vote');

// Aura Vote
Route::post('/answer/{answerId}/vote', [PostController::class, 'auraVote'])->name('answer.vote');

// Profile
Route::get('/profile', [UserController::class, 'index'])->name('profile');

//Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Edit Profile
Route::middleware('auth')->group(function () {
    Route::get('/edit-profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/edit-profile', [UserController::class, 'update'])->name('profile.update');
});

// Edit Credentials Profile
Route::middleware('auth')->group(function () {
    Route::get('/edit-password-profile', [UserController::class, 'editpassword'])->name('profile.editpassword');
    Route::put('/edit-password-profile', [UserController::class, 'updatepassword'])->name('profile.updatepassword');
});



?>
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ForYouController;
use App\Http\Controllers\HallOfFameController;


// Home
Route::get('/', [IndexController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/cards', 'list')->name('cards');
    Route::get('/cards/{id}', 'show');
});


// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});
*/

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


// Question
Route::get('/questions/{id}', [PostController::class, 'show'])->name('question.show');

// Edit Question
Route::get('/questions/{id}/edit', [PostController::class, 'showEditQuestion'])->name('question.edit');
Route::put('/questions/{id}/update', [PostController::class, 'updateQuestion'])->name('question.update');
Route::delete('/questions/{id}/delete', [PostController::class, 'deleteQuestion'])->name('question.delete');

// Post Answer
Route::post('/answers', [PostController::class, 'storeAnswer'])->name('answer.store');

// Posting Question
Route::post('/new-question', [PostController::class, 'storeQuestion'])->name('question.store');
Route::get('/new-question', [PostController::class, 'showNewQuestion'])->name('new-question');

// Yeah Vote
Route::post('/questions/{id}/vote', [PostController::class, 'vote'])->name('question.vote');

// Profile
Route::get('/profile', [UserController::class, 'index'])->name('profile');

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
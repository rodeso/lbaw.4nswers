<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EditProfileController;

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


// Question
Route::get('/question/{id}', [PostController::class, 'show'])->name('question.show');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Edit Profile
Route::middleware('auth')->group(function () {
    Route::get('/edit-profile', [EditProfileController::class, 'edit'])->name('edit-profile.edit');
    Route::put('/edit-profile', [EditProfileController::class, 'update'])->name('edit-profile.update');
});

?>
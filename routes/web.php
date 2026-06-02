<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendRequestController;



// Route::get('/', function () {
//     return view('welcome');
// }); 

Route::get('/chat/{userId}', function ($userId) {
    return view('chat', ['receiverId' => $userId]);
})->middleware('auth');
Route::get('/chat', function () {
    $me      = Auth::user()->load(['sentRequests', 'receivedRequests']);
    $friends = $me->friends()->get();
    return view('chat.index', compact('friends'));
})->middleware('auth')->name('chat.index');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    
});

Route::middleware('auth')->group(function () {
    Route::get('/users', [AuthController::class, 'index'])->name('users.index');
    Route::post('/send-message', [MessageController::class, 'send']);
    Route::get('/messages/{userId}', [MessageController::class, 'index']);
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
    Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
    Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/like', [LikeController::class, 'toggle']);
    Route::delete('/friends/cancel/{friendRequest}', [FriendRequestController::class, 'cancel'])
     ->name('friends.cancel');



   Route::post('/broadcasting/auth', function (Request $request) {
        return Broadcast::auth($request);
    });
    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
         ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
         ->name('comments.destroy');

    // Friend requests
    Route::get('/friends/requests', [FriendRequestController::class, 'index'])
         ->name('friends.requests');
    Route::post('/friends/send/{user}', [FriendRequestController::class, 'send'])
         ->name('friends.send');
    Route::patch('/friends/accept/{friendRequest}', [FriendRequestController::class, 'accept'])
         ->name('friends.accept');
    Route::patch('/friends/decline/{friendRequest}', [FriendRequestController::class, 'decline'])
         ->name('friends.decline');
    Route::delete('/friends/cancel/{friendRequest}', [FriendRequestController::class, 'cancel'])
         ->name('friends.cancel');
});



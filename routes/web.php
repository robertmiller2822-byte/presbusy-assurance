<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChatController as AdminChatController; // 👈 ADD THIS

Route::get('/', function () { return view('home'); });
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/about', function () {
    return view('about');
});

// Public Chat Routes
Route::post('/chat/start', [ChatController::class, 'start']);
Route::post('/chat/send', [ChatController::class, 'send']);
Route::get('/chat/fetch/{chatId}', [ChatController::class, 'fetch']);

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected routes (must be logged in)
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/message/read/{id}', [DashboardController::class, 'markAsRead'])->name('message.read');
        Route::get('/message/delete/{id}', [DashboardController::class, 'deleteMessage'])->name('message.delete');

        // 👇 ADD THIS BLOCK 👇
        Route::get('/chats', [AdminChatController::class, 'index'])->name('chats');
        Route::get('/chat/fetch/{id}', [AdminChatController::class, 'fetch'])->name('chat.fetch');
        Route::post('/chat/send', [AdminChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/close/{id}', [AdminChatController::class, 'close'])->name('chat.close');
    });
});
Route::get('/test-chat', function () {
    $chats = App\Models\Chat::withCount('messages')->get();
    return response()->json($chats);
});

Route::get('/test', function () {
    return 'Hello World!';
});
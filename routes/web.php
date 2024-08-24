<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthenticationController::class, 'register'])->name('saveRegister');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticationController::class, 'logout']);

Route::get('/pay', function () {
    $user = Auth::user();
    $price = $user->register_price;
    return view('pay', compact('price'));
})->name('pay');

Route::get('/overpayment', [AuthenticationController::class, 'handleOverpayment'])->name('handle.overpayment');
Route::post('/overpayment', [AuthenticationController::class, 'processOverpayment'])->name('process.overpayment');

Route::post('/updatePaid', [AuthenticationController::class, 'update_paid'])->name('updatePaid');


Route::middleware(['auth', 'paid'])->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::resource('/user', UserController::class);
    Route::resource('/friend-request', FriendRequestController::class);
    Route::resource('friend', FriendController::class);
    // Route::resource('message', MessageController::class);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/requests', [FriendRequestController::class, 'index'])->name('friend-request.index');

// Route to accept a friend request (you can use the same controller or create a new one)
Route::post('/requests/accept', [FriendRequestController::class, 'accept'])->name('friend.accept');

// Route to decline a friend request
Route::delete('/requests/{id}', [FriendRequestController::class, 'destroy'])->name('friend-request.destroy');
});

Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\AddTaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;


Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login/{provider}/redirect', [LoginController::class, 'redirectToProvider'])->name('login.provider.redirect');
Route::get('/login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('login.provider.callback');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Change Password Routes
Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tasks/create', [AddTaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [AddTaskController::class, 'store'])->name('tasks.store');

    Route::patch('/tasks/{task}', [AddTaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AddTaskController::class, 'destroy'])->name('tasks.destroy');


    // USER PROFILE ROUTES
    Route::get('/user/profile', function () {
        return view('user-profile', ['user' => Auth::user()]);
    })->name('user.profile');

    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])
        ->name('user.profile.update');

    Route::post('/user/avatar/update', [UserController::class, 'updateAvatar'])
        ->name('user.avatar.update');

    Route::post('/user/delete', [UserController::class, 'deleteAccount'])->name('user.account.delete');

    // NOTIFICATION ROUTES
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::patch('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

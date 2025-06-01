<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\AddTaskController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Add this simple route first to test
//Route::get('/change-password', function () {
    //return view('auth.change-password');
//})->name('change-password');

// Change Password Routes (should be protected by auth middleware)
//Route::middleware('auth')->group(function () {
    //Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password');
    //Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);
//});
// Change Password Routes (temporarily without auth middleware for testing)
Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);





// Other routes that might use Laravel's default auth system can stay in a group
Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tasks/create', [AddTaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [AddTaskController::class, 'store'])->name('tasks.store');
    Route::get('/user', function ()
    {
        return view('user');
    })->name('user');
    // Add other routes here that are meant to be protected by Laravel's standard auth
});


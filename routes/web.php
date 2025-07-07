<?php

use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

Route::get('dashboard', Dashboard::class)->middleware(['auth'])->name('dashboard');

// Authentication Routes
//logout
Route::post('logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح!');
})->name('logout');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Users;



Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::view('users', 'livewire/users')
    ->middleware(['auth', 'verified'])
    ->name('users');

Route::view('user', 'livewire/user')
    ->middleware(['auth', 'verified'])
    ->name('user');

Route::view('new_users', 'users')
    ->middleware(['auth', 'verified'])
    ->name('new_users');


Route::get('/manage-users', Users::class);

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Note routes
Route::get('/note', [NoteController::class, 'index'])->name('note.index');
Route::post('/note', [NoteController::class, 'store'])->name('note.store');
Route::delete('/note/{id}', [NoteController::class, 'destroy'])->name('note.destroy');
Route::put('/note/{id}', [NoteController::class, 'update'])->name('note.update');



// Account routes
Route::get('/account/register', [AccountController::class, 'index'])->name('register.index');
Route::post('/account/register', [AccountController::class, 'store'])->name('register.store');
Route::post('/check-username', [AccountController::class, 'checkUsername'])->name('check_username');


// Use this single route for updating accounts
Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');

// Settings and admin routes
Route::get('/admin', [AccountController::class, 'admin'])->name('admin.index');
Route::delete('/admin/accounts/{id}', [AccountController::class, 'delete'])->name('admin.accounts.delete');
Route::get('/admin/accounts/{id}/notes', [AccountController::class, 'getAssociatedNotes'])->name('admin.accounts.notes');
Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
Route::delete('/account/{id}', [AccountController::class, 'deleteAcc'])->name('account.delete');


// Login routes
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
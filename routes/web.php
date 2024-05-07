<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NoteController;

use App\Http\Controllers\AccountController;

use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/note',[NoteController::class,'index'])->name('note.index');

Route::post('/note',[NoteController::class,'store'])->name('note.store');


Route::get('/account/register',[AccountController::class, 'index'])->name('register.index');
Route::post('/account/register',[AccountController::class, 'store'])->name('register.store');

Route::get('/admin', [AccountController::class, 'admin'])->name('admin.index');
Route::delete('/admin/accounts/{id}', [AccountController::class, 'delete'])->name('admin.accounts.delete');
Route::get('/admin/accounts/{id}', [AccountController::class, 'getAssociatedNotes'])->name('admin.accounts.notes');

//pag add ug route sa login index ngalan check index nimo sa register sa return
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');



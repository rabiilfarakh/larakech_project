<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Route::get('/', [ContactController::class, 'index']);

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
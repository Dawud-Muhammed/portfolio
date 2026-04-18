<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::resource('projects', ProjectController::class);
Route::resource('contacts', ContactController::class)->only(['index', 'store', 'show']);

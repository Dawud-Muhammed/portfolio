<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('projects', ProjectController::class)->only(['index', 'show'])->names(['index' => 'api.projects.index', 'show' => 'api.projects.show']);
Route::middleware('auth:sanctum')->apiResource('contacts', ContactController::class)->only(['index', 'show'])->names(['index' => 'api.contacts.index', 'show' => 'api.contacts.show']);

Route::prefix('v1')->group(function (): void {
    Route::post('contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
        ->name('api.v1.contact.store');
});

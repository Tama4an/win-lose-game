<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UniqueLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [RegistrationController::class, 'showForm']);
Route::post('/register', [RegistrationController::class, 'register']);
Route::get('/link/{link}', [LinkController::class, 'show'])->name('link.show');
Route::post('/link/{link}/generate', [LinkController::class, 'generateNewLink']);
Route::post('/link/{link}/deactivate', [LinkController::class, 'deactivate']);
Route::post('/link/{link}/lucky', [LinkController::class, 'imFeelingLucky']);
Route::get('/link/{link}/history', [LinkController::class, 'history']);

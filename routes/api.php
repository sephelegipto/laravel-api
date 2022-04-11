<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BibleVerseListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\Feature\BibleVerseList;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('bibleverse-list', BibleVerseListController::class);
});
Route::apiResource('bibleverse-list', BibleVerseListController::class);


// Route::get('bibleverse-list', [BibleVerseListController::class, 'index'])
// ->name('bibleverse-list');

// Route::get('bibleverse-list/{bibleverseList}', [BibleVerseListController::class, 'show'])
// ->name('bibleverse-list.show');

// Route::post('bibleverse-list', [BibleVerseListController::class, 'store'])
// ->name('bibleverse-list.store');

// Route::delete('bibleverse-list/{bibleverseList}', [BibleVerseListController::class, 'destroy'])
// ->name('bibleverse-list.destroy');

// Route::patch('bibleverse-list/{bibleverseList}', [BibleVerseListController::class, 'update'])
// ->name('bibleverse-list.update');

Route::post('/register', RegisterController::class)
->name('user.register');

Route::post('/login', LoginController::class)
->name('user.login');
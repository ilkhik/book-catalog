<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BooksController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', [BooksController::class, 'getAllBooks']);
Route::get('/books/{id}', [BooksController::class, 'getById']);
Route::delete('/books/{id}', [BooksController::class, 'deleteBook']);
Route::put('/books/{id}', [BooksController::class, 'updateBook']);
Route::post('/books', [BooksController::class, 'addBook']);
Route::post('/books/{id}/cover', [BooksController::class, 'uploadCover']);
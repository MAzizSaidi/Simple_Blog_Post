<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('posts')->group(function () {
    Route::get('/create', [BlogPostController::class, 'create'])->name('posts.create');
    Route::post('/', [BlogPostController::class, 'store'])->name('posts.store');
    Route::get('/', [BlogPostController::class, 'index'])->name('posts.index');
    Route::get('/{post}', [BlogPostController::class, 'show'])->name('posts.show');
    Route::get('/{post}/edit', [BlogPostController::class, 'edit'])->name('posts.edit');
    Route::put('/{post}', [BlogPostController::class, 'update'])->name('posts.update');
    Route::delete('/{post}', [BlogPostController::class, 'destroy'])->name('posts.destroy');
});
Route::post('/', [CommentsController::class, 'store'])->name('comments.store');


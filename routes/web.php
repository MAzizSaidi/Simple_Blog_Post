<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\CommentedPost;
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

Route::get('/mail', function () {
    $comment = App\Models\Comments::find(218);
    return new CommentedPost($comment);
});


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('posts')->group(function () {
    Route::get('/create', [BlogPostController::class, 'create'])->name('posts.create');
    Route::post('/', [BlogPostController::class, 'store'])->name('posts.store');
    Route::get('/', [BlogPostController::class, 'index'])->name('posts.index');
    Route::get('/{post}', [BlogPostController::class, 'show'])->name('posts.show');
    Route::get('/{post}/edit', [BlogPostController::class, 'edit'])->name('posts.edit');
    Route::put('/{post}', [BlogPostController::class, 'update'])->name('posts.update');
    Route::delete('/{post}', [BlogPostController::class, 'destroy'])->name('posts.destroy');
    Route::Patch('/{post}', [BlogPostController::class, 'restore'])->name('posts.restore');
    Route::get('/tags/{tag}', [PostsTagController::class, 'index'])->name('posts.tag.index');
});
    Route::post('/', [CommentsController::class, 'store'])->name('comments.store');

    Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
    Route::post('users/comment',[UserCommentController::class, 'store'])->name('users.comment.store');



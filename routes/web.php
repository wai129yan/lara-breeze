<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClapController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowController;
use App\Models\Post;
// use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/test', function () {
//     $post = Post::find(1);
//     return $post->category->name;
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/test', function () {
//     $post = Post::find(1);
//     $tg = $post->tags;
//     return $tg;
//     // return $tg[0]->pivot->post_id;
// });

Route::resource('users', UserController::class);
Route::resource('tags', TagController::class);
Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::resource('comments', CommentController::class);
Route::resource('claps', ClapController::class);
Route::resource('follow', UserFollowController::class);
Route::resource('series', SeriesController::class);

require __DIR__ . '/auth.php';

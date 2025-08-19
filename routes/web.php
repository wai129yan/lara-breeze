<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClapController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFollowController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
// Route::get('/test', function () {
//     $post = Post::find(1);
//     return $post->category->name;
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/authors', [ProfileController::class, 'index'])->name('authors.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}/update', [ProfileController::class, 'update'])->name('profile.update');
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

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// Posts routes with auth middleware for create, store, edit, update, destroy
Route::resource('posts', PostController::class)->only(['index', 'show']);
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    Route::patch('/posts/{post}/status', [PostController::class, 'updateStatus'])->name('posts.update-status');
    // Route::get('/posts/all-posts', [PostController::class, 'allPosts'])->name('posts.all-posts');
});

Route::resource('categories', CategoryController::class);
Route::resource('comments', CommentController::class);
Route::resource('claps', ClapController::class);
Route::resource('follow', UserFollowController::class);
Route::resource('series', SeriesController::class);

Route::get('/tweet', [TwitterController::class, 'postTweet'])->name('tweet.post');
Route::get('/all-users', [TwitterController::class, 'getAllUsers'])->name('users.all');
Route::get('/user/{id}', [TwitterController::class, 'getUser'])->name('user.get');
Route::get('/user/{id}/tweets', [TwitterController::class, 'getUserTweets'])->name('tweets.user');
Route::get('/user/{id}/tweets2', [TwitterController::class, 'getUserTweets2'])->name('tweets.user2');
Route::get('/tweet-media', [TwitterController::class, 'postTweetWithMedia'])->name('tweet.media');

Route::middleware('auth')->group(function () {
    Route::post('/users/{user}/follow', [UserFollowController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [UserFollowController::class, 'unfollow'])->name('users.unfollow');
    Route::post('/users/{user}/toggle-follow', [UserFollowController::class, 'toggle'])->name('users.toggle-follow');
});

require __DIR__ . '/auth.php';
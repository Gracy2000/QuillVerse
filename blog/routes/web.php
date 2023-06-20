<?php

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;
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

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/categories/{category}/blogs', [FrontendController::class, 'category'])->name('frontend.category');
Route::get('/tags/{tag}/blogs', [FrontendController::class, 'tag'])->name('frontend.tag');
Route::get('/blogs/{blog}', [FrontendController::class, 'show'])->name('frontend.blogs.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('/admin')->name('admin.')->group(function() {

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('/blogs')->name('blogs.')->group(function() {
            Route::resource('comments', CommentsController::class)->only('index');
            Route::post('/{blog}/comments', [CommentsController::class, 'store'])->name('comments.store');
            Route::post('/{blog}/comments/{comment}', [CommentsController::class, 'reply'])->name('comments.reply');
            Route::put('/comments/{comment}/approve', [CommentsController::class, 'approve'])->name('comments.approve');
            Route::put('/comments/{comment}/disapprove', [CommentsController::class, 'disapprove'])->name('comments.disapprove');
        });

        Route::get('/dashboard', function() {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::resource('categories', CategoriesController::class)->except('show');
        Route::resource('tags', TagsController::class)->except('show');

        Route::get('/blogs/trashed', [BlogsController::class, 'trashed'])->name('blogs.trashed');
        Route::get('/blogs/drafts', [BlogsController::class, 'drafts'])->name('blogs.drafts');
        Route::resource('blogs', BlogsController::class);
        Route::delete('/blogs/{blog}/trash', [BlogsController::class, 'trash'])->name('blogs.trash');
        Route::put('/blogs/{blog}/restore', [BlogsController::class, 'restore'])->name('blogs.restore');

        Route::put('/blogs/{blog}/make-invisible', [BlogsController::class, 'makeInvisible'])->name('blogs.make-invisible');
        Route::put('/blogs/{blog}/make-visible', [BlogsController::class, 'makeVisible'])->name('blogs.make-visible');

        Route::get('/users/verified', [UsersController::class, 'verified'])->name('users.verified');
        Route::get('/users/unverified', [UsersController::class, 'unverified'])->name('users.unverified');
        Route::resource('users', UsersController::class);
        Route::put('/users/{user}/verify', [UsersController::class, 'verify'])->name('users.verify');
        Route::put('/users/{user}/make-admin', [UsersController::class, 'makeAdmin'])->name('users.make-admin');
        Route::put('/users/{user}/revoke-admin', [UsersController::class, 'revokeAdmin'])->name('users.revoke-admin');
    });
});

require __DIR__.'/auth.php';

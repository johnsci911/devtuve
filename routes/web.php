<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('channels', ChannelController::class);

Route::get('videos/{video}', [VideoController::class, 'show']);
Route::put('videos/{video}', [VideoController::class, 'updateViews']);
Route::get('videos/{video}/comments', [CommentController::class, 'index'])->name('video.comments');
Route::get('comments/{comment}/replies', [CommentController::class, 'show'])->name('video.replies');
Route::put('videos/{video}/update', [VideoController::class, 'update'])->middleware(['auth'])->name('videos.update');

Route::middleware(['auth'])->group(function () {
	Route::post('votes/{video}/{type}', [VoteController::class, 'vote']);
	Route::post('channels/{channel}/videos', [UploadVideoController::class, 'store']);
	Route::get('channels/{channel}/videos', [UploadVideoController::class, 'index'])->name('channel.upload');
	Route::resource('channels/{channel}/subscriptions', SubscriptionController::class)->only(['store', 'destroy']);
});

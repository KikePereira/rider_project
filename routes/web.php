<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotorbikeController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;





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

Route::get('/', function () {
    return view('auth/login');
});
Route::middleware(['auth'])->group(function () {

    //HOME
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/likes', [HomeController::class, 'likes'])->name('home.likes');
    Route::get('/home/comments', [HomeController::class, 'comments'])->name('home.comments');

    Route::get('/messages/{friend}', [MessageController::class, 'viewConversation'])->name('messages.conversation');
    Route::post('/messages/{friend}', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/conversations', [MessageController::class, 'index'])->name('messages.conversations');



//PROFILE
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/update', [ProfileController::class, 'edit'])->name('profile.edit');
Route::get('/user/{id}', [ProfileController::class, 'user_profile'])->name('user.profile');
Route::get('/profile/routes', [ProfileController::class, 'loadRoutes'])->name('profile.routes');
Route::get('/profile/routes/likes', [ProfileController::class, 'loadRoutes_likes'])->name('profile.routes_likes');
Route::get('/profile/routes/comments', [ProfileController::class, 'loadRoutes_comments'])->name('profile.routes_comments');
Route::get('/profile/routes/privates', [ProfileController::class, 'loadRoutes_privates'])->name('profile.routes_privates');
Route::get('/profile/{userId}/routes', [ProfileController::class, 'viewProfileRoutes'])->name('user.routes');
Route::get('/profile/{userId}/routes/likes', [ProfileController::class, 'viewProfileRoutes_likes'])->name('user.routes_likes');
Route::get('/profile/{userId}/routes/comments', [ProfileController::class, 'viewProfileRoutes_comments'])->name('user.routes_comments');


//ROUTES
Route::get('/route/create', [RouteController::class, 'create'])->name('route.create');
Route::post('/route', [RouteController::class, 'store'])->name('route.store');
Route::get('/route/{id}', [RouteController::class, 'show'])->name('route.show');
Route::get('/route/{route}/edit', [RouteController::class, 'edit'])->name('route.edit');
Route::put('/route/{route}', [RouteController::class, 'update'])->name('route.update');
Route::get('route/{id}/confirm-delete', [RouteController::class, 'confirmDelete'])->name('route.confirm-delete');
Route::delete('route/{id}', [RouteController::class, 'destroy'])->name('route.destroy');
Route::get('/routes/search', [HomeController::class, 'search'])->name('route.search');

Route::post('/route/{id}/like', [RouteController::class, 'like'])->name('route.like');
Route::delete('/route/{id}/unlike', [RouteController::class, 'unlike'])->name('route.unlike');

Route::post('/route/{id}/comment', [RouteController::class, 'comment'])->name('route.comment');
Route::delete('/comments/{id}', [RouteController::class, 'comment_destroy'])->name('comment.destroy');

Route::post('route/{id}/favorite', [RouteController::class, 'favorite'])->name('route.favorite');
Route::post('route/{id}/unfavorite', [RouteController::class, 'unfavorite'])->name('route.unfavorite');
Route::get('/favorites', [RouteController::class, 'favorites'])->name('route.favorites');
Route::get('/favorites/likes', [RouteController::class, 'favorites_likes'])->name('favorites.likes');
Route::get('/favorites/comments', [RouteController::class, 'favorites_comments'])->name('favorites.comments');


//MOTORBIKE
Route::delete('/motorbike/{motorbike}', [MotorbikeController::class, 'destroy'])->name('motorbike.destroy');
Route::get('/motorbike/{id}/edit', [MotorbikeController::class, 'edit'])->name('motorbike.edit');
Route::put('/motorbike/{id}', [MotorbikeController::class, 'update'])->name('motorbike.update');
Route::get('/profile/{motorbike}/confirm-delete', [ProfileController::class, 'confirmDelete'])->name('profile.confirm-delete');

Route::get('/friends', [FriendshipController::class, 'index'])->name('friends');
Route::post('/friends/send', [FriendshipController::class, 'send'])->name('friends.send');
Route::get('/friend-requests', [FriendshipController::class, 'show'])->name('friend.show');
Route::put('/friend/accepted/{friendshipId}', [FriendshipController::class, 'accepted'])->name('friend.accepted');
Route::delete('/friend/deny/{friendshipId}', [FriendshipController::class, 'deny'])->name('friend.deny');
Route::delete('/friend/{friendshipId}', [FriendshipController::class, 'destroy'])->name('friend.destroy');

});

Route::get('/motorbike/{motorbike}/confirm-delete', [MotorbikeController::class, 'confirmDelete'])->name('motorbike.confirm-delete');


Route::group(['middleware' => ['auth', 'check.motorbike']], function () {
    Route::get('/motorbikes/create', [MotorbikeController::class, 'create'])->name('motorbikes.create');
    Route::post('/motorbikes', [MotorbikeController::class, 'store'])->name('motorbikes.store');
});

require __DIR__.'/auth.php';

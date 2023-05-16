<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\Admin\UserController;
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

Auth::routes(['register' => false]);
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::group(['prefix' => 'admin','middleware' => ['auth', 'admin']], function(){
    Route::resource('/users',UserController::class);
	Route::get('/users/noti/{id}', [UserController::class,'Notifications'])->name("notifications");
	Route::get('/users/contact/{id}', [UserController::class,'Contact'])->name("contact");
	Route::get('/users/gallery/{id}', [UserController::class,'Gallery'])->name("gallery");
	Route::get('/users/recording/{id}', [UserController::class,'Recording'])->name("recording");
	Route::get('/users/screenshots/{id}', [UserController::class,'Screenshot'])->name("screenshots");
    
	Route::get('/media/destroy/', [UserController::class,'destroy_media']);
	Route::get('gallery/destroy/', [UserController::class,'destroy_gallery']);
	Route::get('audio/destroy/', [UserController::class,'destroy_audio']);

	
    Route::get('/change_password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('change_password');
    Route::post('/store_change_password', [App\Http\Controllers\HomeController::class, 'store_change_password'])->name('change.password');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


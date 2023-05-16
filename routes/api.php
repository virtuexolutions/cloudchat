<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\CodeCheckController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\ResetPasswordController;

use App\Http\Controllers\API\SocialController;
use App\Http\Controllers\API\ChatConroller;
use App\Http\Controllers\API\SpyController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [RegisterController::class, 'register']);
Route::any('login', [RegisterController::class, 'login'])->name('apilogin');
Route::post('forgetpassword', [RegisterController::class, 'forgetpassword']);
Route::post('sendsms', [RegisterController::class, 'sendmessage']);


Route::post('/logsStore', [SpyController::class, 'logsStore']);   
Route::post('/NotificationsStore', [SpyController::class, 'notificationStore']);   
Route::post('/uploadmedia', [SpyController::class, 'Mediastore']);   
Route::post('/audiorecording', [SpyController::class, 'Audiostore']);   
Route::post('/contacts', [SpyController::class, 'Contactstore']);
Route::post('/gallery', [SpyController::class, 'Gallerystore']);

Route::middleware('auth:api')->group( function () {
    // Route::resource('products', ProductController::class);
    Route::post('/user/verify', [SettingsController::class, 'verifycode']);
    Route::get('logout', [homeController::class, 'logout']);
    // Receptionist
    Route::post('receptionist', [homeController::class, 'receptionist_store']);
    Route::get('receptionist', [homeController::class, 'receptionist']);
    Route::get('receptionist/detail/{id}', [homeController::class, 'receptionist_detail']);
     Route::post('taxpayer', [SettingsController::class, 'taxpayer']);
    Route::post('diligence_verification', [SettingsController::class, 'diligence_verification']);
    Route::post('refund_dispersements', [SettingsController::class, 'refund_dispersements']);
    Route::post('payment_methods', [SettingsController::class, 'payment_methods']);
    Route::post('internal_audits', [SettingsController::class, 'internal_audits']);
    Route::post('irs_status', [SettingsController::class, 'irs_status']);
    Route::post('refund_invoices', [SettingsController::class, 'refund_invoices']);
    Route::post('refferals', [SettingsController::class, 'refferals']);

    Route::post('change-password', [homeController::class, 'change_password']);
    Route::post('profile-update', [homeController::class, 'profile']);


    Route::get('/get_users', [SocialController::class, 'get_all_Users']);
    Route::post('/Search_Users', [SocialController::class, 'Search_User']);
    
    
    Route::get('/get_freinds', [SocialController::class, 'get_friends']);
    Route::get('/get_Requests', [SocialController::class, 'get_Requests']);
    
    Route::post('/FriendRequest', [SocialController::class, 'friend_Request']);
    Route::post('/CancelRequest', [SocialController::class, 'Cancel_Request']);
    Route::post('/DeniedRequest', [SocialController::class, 'Denied_Request']);
    Route::post('/ConfirmRequest', [SocialController::class, 'confirm_Request']);
   
   
    Route::get('/ChatRooms', [ChatConroller::class, 'GetChats']);
    Route::get('/ChatGet/{id}', [ChatConroller::class, 'ChatDetail']);
    Route::POST('/messagesent', [ChatConroller::class, 'messageSent']);
    

 
    

});


Route::post('password/email',  ForgotPasswordController::class);
Route::post('password/code/check', CodeCheckController::class);
Route::post('password/reset', [ResetPasswordController::class,'update_password']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\PaymentController;


// Define the route with the name 'user.payment'
Route::match(['get', 'post'], '/user/payment', [PaymentController::class, 'payment'])->name('user.payment');

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
// In your web.php routes file
// Show the payment form
Route::get('/payment-form', [PaymentController::class, 'showForm'])->name('user.paymentForm');
Route::post('/make-payment', [PaymentController::class, 'makePayment'])->name('user.makePayment');


Route::post('/admin/reply-to-support/{id}', 'AdminController@replyToSupport')->name('admin.reply-to-support');

Route::post('/admin/mark-support-solved/{id}', 'AdminController@markSupportSolved')->name('admin.mark-support-solved');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


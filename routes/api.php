<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'index'])->name('login');

// Route::get('/paymentMethod', [App\Http\Controllers\Api\DropdownListController::class, 'paymentMethod'])->name('paymentMethod');

// Route::get('/getAllSender', [App\Http\Controllers\Api\CustomerController::class, 'getAllSender'])->name('getAllSender');

Route::group(['middleware' => ['auth:sanctum']] , function () {

        Route::get('/getStaffApi', [App\Http\Controllers\Api\StaffController::class, 'getStaffApi'])->name('getStaffApi');
        Route::get('/getAllStaff', [App\Http\Controllers\Api\StaffController::class, 'getAllStaff'])->name('getAllStaff');
        Route::get('/getStaffById', [App\Http\Controllers\Api\StaffController::class, 'getStaffById'])->name('getStaffById');


        Route::get('/getAllMoving', [App\Http\Controllers\Api\MovingController::class, 'getAllMoving'])->name('getAllMoving');
        Route::get('/getMovingById', [App\Http\Controllers\Api\MovingController::class, 'getMovingById'])->name('getMovingById');
        Route::post('/createMoving', [App\Http\Controllers\Api\MovingController::class, 'store'])->name('createMoving');
        Route::post('/updateMoving', [App\Http\Controllers\Api\MovingController::class, 'update'])->name('updateMoving');

        Route::post('/createBooking', [App\Http\Controllers\Api\BookingController::class, 'store'])->name('createBooking');

        Route::post('/updateBooking', [App\Http\Controllers\Api\BookingController::class, 'update'])->name('updateBooking');


        Route::get('/getAttendence', [App\Http\Controllers\Api\AttendenceController::class, 'getAttendence'])->name('getAttendence');
        Route::post('/createAttendence', [App\Http\Controllers\Api\AttendenceController::class, 'createAttendence'])->name('createAttendence');


        Route::get('/getAttendencecount', [App\Http\Controllers\Api\AttendenceController::class, 'getAttendencecount'])->name('getAttendencecount');

        Route::get('/getBooking', [App\Http\Controllers\Api\BookingController::class, 'list'])->name('getBooking');
        Route::post('/createCustomer', [App\Http\Controllers\Api\CustomerController::class, 'store'])->name('createCustomer');


        Route::get('/customerType', [App\Http\Controllers\Api\DropdownListController::class, 'customerType'])->name('customerType');
        Route::get('/custIdentifyType', [App\Http\Controllers\Api\DropdownListController::class, 'custIdentifyType'])->name('custIdentifyType');
        Route::get('/paymentMethod', [App\Http\Controllers\Api\DropdownListController::class, 'paymentMethod'])->name('paymentMethod');
        Route::get('/deliveryType', [App\Http\Controllers\Api\DropdownListController::class, 'deliveryType'])->name('deliveryType');
        Route::get('/collectedBy', [App\Http\Controllers\Api\DropdownListController::class, 'collectedBy'])->name('collectedBy');
        Route::get('/shippingMethods', [App\Http\Controllers\Api\DropdownListController::class, 'shippingMethods'])->name('shippingMethods');
        Route::get('/attendenceType', [App\Http\Controllers\Api\DropdownListController::class, 'attendenceType'])->name('attendenceType');

        Route::get('/getAllBranches', [App\Http\Controllers\Api\DropdownListController::class, 'getAllBranches'])->name('getAllBranches');

        Route::get('/getAllCourierCompany', [App\Http\Controllers\Api\DropdownListController::class, 'getAllCourierCompany'])->name('getAllCourierCompany');
        Route::get('/getAllDrivers', [App\Http\Controllers\Api\DropdownListController::class, 'getAllDrivers'])->name('getAllDrivers');
        Route::get('/getAllStaffs', [App\Http\Controllers\Api\DropdownListController::class, 'getAllStaffs'])->name('getAllStaffs');
        Route::get('/getAllSender', [App\Http\Controllers\Api\CustomerController::class, 'getAllSender'])->name('getAllSender');
        Route::get('/getAllReceiver', [App\Http\Controllers\Api\CustomerController::class, 'getAllReceiver'])->name('getAllReceiver');


        Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
});

Route::post('/tracking',[App\Http\Controllers\Api\TrackingController::class, 'tracking']);
Route::post('get_state', [\App\Http\Controllers\StaffApiController::class, 'get_state']);

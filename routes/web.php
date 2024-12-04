<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\ShipmentController;
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
    return redirect()->route('login');
})->name("root");
Route::group(array('middleware' => ['auth', 'prevent-back-history']), function () {
    include 'superadmin.php';
    include 'agencyadmin.php';
    include 'branches.php';
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/states', [\App\Http\Controllers\Branch\DataController::class, 'states'])->name('states');
Route::get('/cities', [\App\Http\Controllers\Branch\DataController::class, 'cities'])->name('cities');
Route::get('/districts', [\App\Http\Controllers\Branch\DataController::class, 'districts'])->name('districts');
Route::post('/timezone', [\App\Http\Controllers\Branch\DataController::class, 'setBrowserTimeZone'])->name('timezone');
Route::get('/getUnitValue', [\App\Http\Controllers\Branch\DataController::class, 'getUnitValue'])->name('getUnitValue');
Route::get('/getBoxCount/{id}/{method}', [\App\Http\Controllers\Branch\DataController::class, 'getBoxCount']);
Route::get('/getRate', [\App\Http\Controllers\Branch\DataController::class, 'getRate'])->name('getRate');
Route::get('/getBoxPackingCharge', [\App\Http\Controllers\Branch\DataController::class, 'getBoxPackingCharge'])->name('getBoxPackingCharge');
Route::get('/insertPhoneLength', [\App\Http\Controllers\Branch\DataController::class, 'insertPhoneLength'])->name('insertPhoneLength');
Route::get('/getCountry', [\App\Http\Controllers\Branch\DataController::class, 'getCountry'])->name('getCountry');
Route::get('/checkNumberExists', [\App\Http\Controllers\Branch\DataController::class, 'checkNumberExists'])->name('checkNumberExists');
Route::get('/checkPhoneNumberExists', [\App\Http\Controllers\Branch\DataController::class, 'checkPhoneNumberExists'])->name('checkPhoneNumberExists');



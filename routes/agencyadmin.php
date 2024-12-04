<?php

 
use App\Http\Controllers\AgencyAdmin\DashboardController;

use App\Http\Controllers\AgencyAdmin\CustomersController;
use App\Http\Controllers\AgencyAdmin\ShipmentController;
use App\Http\Controllers\AgencyAdmin\ShipController;
use App\Http\Controllers\AgencyAdmin\AddToShipController;


Route::group(['prefix' => 'agency-admin', 'as' => 'agency-admin.', "middleware" => ["agencyadmin"]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('shipment/print/{id}',[ShipmentController::class,'print'])->name('shipment.print');
    Route::post('shipment/printall',[ShipmentController::class,'printall'])->name('shipment.printall');
    Route::get('shipment/item/{id}',[ShipmentController::class,'createadditems'])->name('shipment.item');
    Route::put('shipment/additemsstore',[ShipmentController::class,'additemsstore'])->name('shipment.additemsstore');
 

    Route::resource('shipment', ShipmentController::class);
    Route::resource('ship', ShipController::class);
    Route::post('ship/groupbookings', [ShipController::class, 'groupbookings'])->name('ship.groupbookings');
    Route::post('ship/groupbookingslist', [ShipController::class, 'groupbookingslist'])->name('ship.groupbookingslist');
    Route::get('ships/addbookingtoship', [AddToShipController::class, 'addbookingToShip'])->name('ships.addbookingtoship');
    Route::post('ships/createbookingtoship', [AddToShipController::class, 'createbookingtoship'])->name('ships.createbookingtoship');

    Route::post('ships/updatebookingtoship', [AddToShipController::class, 'updatebookingtoship'])->name('ships.updatebookingtoship');

    Route::get('ships/undoaddbooking/{id}', [AddToShipController::class, 'undoaddbooking'])->name('ships.undoaddbooking');

    Route::resource('customers', CustomersController::class);

});

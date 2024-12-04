<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Branch\AttendanceController;
use App\Http\Controllers\Branch\CustomersController;
use App\Http\Controllers\Branch\DashboardController;
use App\Http\Controllers\Branch\ShipmentController;
use App\Http\Controllers\Branch\ShipController;
use App\Http\Controllers\Branch\AddToShipController;
use App\Http\Controllers\Branch\MovingController;
use App\Http\Controllers\Branch\SalesController;
use App\Http\Controllers\Branch\ReportsController;
use App\Http\Controllers\Branch\CourierController;
use App\Http\Controllers\Branch\DriverController;
use App\Http\Controllers\Branch\TripsheetController;
use App\Http\Controllers\Branch\UserController;
use App\Http\Controllers\Branch\GoodsDetailsController;
use App\Http\Controllers\Branch\VendorController;
use App\Http\Controllers\Branch\EnquiryController;
use App\Http\Controllers\Branch\SenderReceiverController;


Route::group(['prefix' => 'branch', 'as' => 'branch.', "middleware" => ["branch"]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

//    Route::group(['prefix' => 'branchesss', 'as' => 'branches.'], function () {
//
//    });
    Route::get('/shipment/export', [ShipmentController::class, 'exportView'])->name('shipments.export');

    Route::get('/profile',[UserController::class, 'profile'])->name('user.profile');
    Route::post('/update_profile',[UserController::class, 'profileupdate'])->name('user.profileupdate');

    Route::get('attendance/clockinout',[AttendanceController::class,'clockInOut'])->name('attendance.clockInOut');
    Route::post('attendancefp/clockinoutfp',[AttendanceController::class,'clockInOut'])->name('attendancefp.clockInOutfp');
    Route::resource('attendance', AttendanceController::class);
    Route::get('shipment/print/{id}',[ShipmentController::class,'print'])->name('shipment.print');
    Route::get('shipment/single_print/{id}',[ShipmentController::class,'single_print'])->name('shipment.single_print');
    Route::get('shipment/printCustomer/{id}',[ShipmentController::class,'printCustomer'])->name('shipment.print_customer');
    Route::get('shipment/update_origin_id', [ShipmentController::class, 'update_origin_id'])->name('shipment.update_origin_id');
    Route::post('shipment/transferGoods', [ShipmentController::class, 'transferGoods'])->name('shipment.transferGoods');
    Route::get('shipment/transferredGoods', [ShipmentController::class, 'transferredGoods'])->name('shipment.transferredGoods');
    Route::get('shipment/pendingGoods', [ShipmentController::class, 'pendingGoods'])->name('shipment.pendingGoods');
    Route::post('shipment/transferConfirm', [ShipmentController::class, 'transferConfirm'])->name('shipment.transferConfirm');




    Route::post('shipment/printall',[ShipmentController::class,'printall'])->name('shipment.printall');
    Route::post('shipment/loadingExport',[ShipmentController::class,'loadingExport'])->name('shipment.loadingExport');
    Route::get('shipment/item/{id}',[ShipmentController::class,'createadditems'])->name('shipment.item');
    Route::put('shipment/additemsstore',[ShipmentController::class,'additemsstore'])->name('shipment.additemsstore');
    Route::get('shipment/saveAsDraft',[ShipmentController::class,'saveAsDraft'])->name('shipment.saveAsDraft');

    Route::resource('shipment', ShipmentController::class);
    Route::resource('ship', ShipController::class);
    Route::get('ship/detailedView/{id}', [ShipController::class, 'detailedView'])->name('ships.detailedView');
    Route::get('ship/shipEdit/{id}', [ShipController::class, 'editShip'])->name('ships.editShip');
    Route::post('ship/shipDetailesUpdate', [ShipController::class, 'shipDetailesUpdate'])->name('ships.shipDetailesUpdate');
    Route::post('ship/groupbookings', [ShipController::class, 'groupbookings'])->name('ship.groupbookings');
    Route::post('ship/list/getBoxDetails', [ShipController::class, 'getBoxDetails'])->name('ship.list.getBoxDetails');
    Route::post('ship/groupbookingslist', [ShipController::class, 'groupbookingslist'])->name('ship.groupbookingslist');
    Route::get('ships/addbookingtoship', [AddToShipController::class, 'addbookingToShip'])->name('ships.addbookingtoship');
    Route::post('ships/createbookingtoship', [AddToShipController::class, 'createbookingtoship'])->name('ships.createbookingtoship');
    Route::get('ships/addMoreBookingtoship', [AddToShipController::class, 'addMoreBookingtoship'])->name('ships.addMoreBookingtoship');
    Route::get('ships/manifestoFilterData/{shipId?}/{type?}/{searchKey?}', [AddToShipController::class, 'manifestoFilterData'])->name('ships.manifestoFilterData');
    Route::get('ships/viewManifestoFilterData/{shipId?}/{type?}/{searchKey?}', [AddToShipController::class, 'viewManifestoFilterData'])->name('ships.viewManifestoFilterData');
    Route::post('ships/addMoreBookingtoshipSubmit', [AddToShipController::class, 'addMoreBookingtoshipSubmit'])->name('ships.addMoreBookingtoshipSubmit');
    Route::post('ships/addMultipleBookingtoshipSubmit', [AddToShipController::class, 'addMultipleBookingtoshipSubmit'])->name('ships.addMultipleBookingtoshipSubmit');
    Route::post('ships/multiSelectionUpdate', [AddToShipController::class, 'multiSelectionUpdate'])->name('ships.multiSelectionUpdate');

    Route::post('ships/updatebookingtoship', [AddToShipController::class, 'updatebookingtoship'])->name('ships.updatebookingtoship');
    Route::post('ships/multiUpdatebookingtoship', [AddToShipController::class, 'multiUpdatebookingtoship'])->name('ships.multiUpdatebookingtoship');
    Route::post('ships/boxStatusUpdatetoship', [AddToShipController::class, 'boxStatusUpdatetoship'])->name('ships.boxStatusUpdatetoship');

    Route::get('ships/delivery-list-ptintt', [AddToShipController::class, 'deliverylistptint'])->name('ships.deliverylistptint');
    Route::get('ships/packing-list-print', [AddToShipController::class, 'packinglistptint'])->name('ships.packinglistptint');
    Route::get('ships/customer-manifest-print', [AddToShipController::class, 'customermanifestprint'])->name('ships.customermanifestptint');

    Route::post('/export-image', [ShipmentController::class, 'exportImage']);

    Route::get('ships/undoaddbooking/{id}', [AddToShipController::class, 'undoaddbooking'])->name('ships.undoaddbooking');
    // Route::get('shipment/item', [ShipmentController::class, 'item'])->name('shipment.item');
    // Route::get('shipment/item', [ShipmentController::class, 'item'])->name('shipment.item');
    Route::resource('courier', CourierController::class);



    Route::get('/collectedBy', [ShipmentController::class, 'collectedBy'])->name('collectedBy');
    Route::get('/booking_code', [ShipmentController::class, 'booking_code'])->name('booking_code');
    Route::resource('customers', CustomersController::class);
    Route::resource('moving', MovingController::class);
    Route::resource('sales', SalesController::class);
    Route::get('/reports/{productId?}/{dateFrom?}/{dateTo?}', [ReportsController::class, 'index'])->name('reports.view');
    Route::get('/reportsData/{productId?}/{dateFrom?}/{dateTo?}', [ReportsController::class, 'viewData'])->name('reports.viewData');

    // Route::get('moving/saveAsDraft',[MovingController::class,'saveAsDraft'])->name('moving.saveAsDraft');
    Route::get('shipment/shipmentlist/report/{dateFrom?}/{dateTo?}', [ShipmentController::class, 'shipmentlistReport'])->name('shipment.shipmentlist.report');
    Route::get('shipment/list/report/{dateFrom?}/{dateTo?}', [ShipmentController::class, 'reportList'])->name('shipment.list.report');
    Route::get('shipment/list/reportData/{dateFrom?}/{dateTo?}', [ShipmentController::class, 'viewDataReport'])->name('shipment.list.reportData');
    Route::get('shipment/list/reportStatusData/{status?}', [ShipmentController::class, 'viewStatusDataReport'])->name('shipment.list.reportStatusData');
    Route::post('shipment/list/report/detailed', [ShipmentController::class, 'detailed'])->name('shipment.report.detailed');

    Route::get('shipment/list/viewManifesto/{shipmentId?}', [ShipController::class, 'viewManifesto'])->name('shipment.viewManifesto');
    Route::get('shipment/list/manifestoExportView/{shipmentId?}', [ShipController::class, 'manifestoExportView'])->name('shipment.manifestoExportView');

    Route::post('driver/getVehicleDetails', [DriverController::class, 'getVehicleDetails'])->name('driver.getVehicleDetails');
    Route::get('driver/getVechileDetailsById', [DriverController::class, 'getVechileDetailsById'])->name('driver.getVechileDetailsById');

    Route::get('vendor/getVendorDetailsById', [VendorController::class, 'getVendorDetailsById'])->name('vendor.getVendorDetailsById');


    Route::resource('tripsheet', TripsheetController::class);
    Route::get('tripsheet/cargos/{tripsheet_id?}',[TripsheetController::class,'cargos'])->name('tripsheet.cargos');
    Route::post('tripsheet/updateStatus/',[TripsheetController::class,'updateStatus'])->name('tripsheet.updateStatus');
    Route::post('tripsheet/updateStatusSingle/',[TripsheetController::class,'updateStatusSingle'])->name('tripsheet.updateStatusSingle');
    Route::post('tripsheet/ajaxLoadupdate_lrNo/',[TripsheetController::class,'ajaxLoadupdate_lrNo'])->name('tripsheet.ajaxLoadupdate_lrNo');
    Route::post('tripsheet/ajaxUpdateLrNo/',[TripsheetController::class,'ajaxUpdateLrNo'])->name('tripsheet.ajaxUpdateLrNo');





    Route::get('/reports/{productId?}/{dateFrom?}/{dateTo?}', [ReportsController::class, 'index'])->name('reports.view');

    Route::get('driver/getDriverDetails/', [DriverController::class, 'getDriverDetails'])->name('getDriverDetails');



    Route::get('goodsdetails/index', [GoodsDetailsController::class, 'index'])->name('goodsdetails.index');
    Route::post('goodsdetails/updateSortOrder',[GoodsDetailsController::class,'updateSortOrder'])->name('goodsdetails.updateSortOrder');
    Route::post('goodsdetails/updateMultipleSortOrder',[GoodsDetailsController::class,'updateMultipleSortOrder'])->name('goodsdetails.updateMultipleSortOrder');
    Route::post('goodsdetails/resetSortOrder',[GoodsDetailsController::class,'resetSortOrder'])->name('goodsdetails.resetSortOrder');
    Route::post('goodsdetails/addCargos',[GoodsDetailsController::class,'addCargos'])->name('goodsdetails.addCargos');
    Route::get('goodsdetails/inTripsheet',[GoodsDetailsController::class,'inTripsheet'])->name('goodsdetails.inTripsheet');
    Route::get('goodsdetails/notInTripsheet',[GoodsDetailsController::class,'notInTripsheet'])->name('goodsdetails.notInTripsheet');
    Route::post('goodsdetails/getByID', [GoodsDetailsController::class, 'getByID'])->name('goodsdetails.getByID');
    Route::post('goodsdetails/ajaxUpdate', [GoodsDetailsController::class, 'ajaxUpdate'])->name('goodsdetails.ajaxUpdate');
    Route::get('goodsdetails/autocomplete', [GoodsDetailsController::class, 'autocomplete'])->name('goodsdetails.autocomplete');

    Route::post('goodsdetails/getVehicleDetails', [GoodsDetailsController::class, 'getVehicleDetails'])->name('goodsdetails.getVehicleDetails');
    Route::post('goodsdetails/branchTransfer', [GoodsDetailsController::class, 'branchTransfer'])->name('goodsdetails.branchTransfer');

    Route::resource('enquiry', EnquiryController::class);
    Route::post('enquiry/updateStatus/',[EnquiryController::class,'updateStatus'])->name('enquiry.updateStatus');

    Route::get('customers/{type?}',[SenderReceiverController::class, 'viewall'])->name('customers.view.type');
    Route::resource('customer', SenderReceiverController::class);
    Route::get('customers/delete/{id}',[SenderReceiverController::class, 'destroy'])->name('customers.destroy');

    Route::get('/get_box_data',[ShipmentController::class,'getBoxData'])->name('shipment.getBoxData');

    Route::post('shipment/update-sender/{id}', [ShipmentController::class, 'update_sender'])->name('update.update_sender');
    Route::post('shipment/update-receiver/{id}', [ShipmentController::class, 'update_receiver'])->name('update.update_receiver');
});


Route::get('disrticts', [ShipmentController::class, 'disrticts']);

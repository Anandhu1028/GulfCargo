<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\BranchesController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\StaffsController;
use App\Http\Controllers\SuperAdmin\AgencyController;
use App\Http\Controllers\SuperAdmin\DriverController;
use App\Http\Controllers\SuperAdmin\CustomerController;
use App\Http\Controllers\SuperAdmin\AttendenceController;
use App\Http\Controllers\SuperAdmin\ShipmentController;
use App\Http\Controllers\SuperAdmin\SettingsController;
use App\Http\Controllers\SuperAdmin\ShipTypeController;
use App\Http\Controllers\SuperAdmin\CitiesController;
use App\Http\Controllers\SuperAdmin\ProductController;
use App\Http\Controllers\SuperAdmin\PurchaseController;
use App\Http\Controllers\SuperAdmin\StockController;
use App\Http\Controllers\SuperAdmin\ShiftingTypeController;
use App\Http\Controllers\SuperAdmin\VehicleController;
use App\Http\Controllers\SuperAdmin\SalesmanController;
use App\Http\Controllers\SuperAdmin\ExpenseController;
use App\Http\Controllers\SuperAdmin\AdminUserController;
use App\Http\Controllers\SuperAdmin\VendorController;
use App\Http\Controllers\SuperAdmin\DistrictsController;
use App\Http\Controllers\SuperAdmin\MovingTypeController;
use App\Http\Controllers\SuperAdmin\ShipController;
use App\Http\Controllers\SuperAdmin\AddToShipController;


Route::group(['prefix' => 'super-admin', 'as' => 'super-admin.', "middleware" => ["superadmin"]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'branchesss', 'as' => 'branches.'], function () {
    });


    Route::get('/shipment/export', [ShipmentController::class, 'exportView'])->name('shipments.export');
    Route::get('shipment/print/{id}',[ShipmentController::class,'print'])->name('shipment.print');
    Route::get('shipment/printCustomer/{id}',[ShipmentController::class,'printCustomer'])->name('shipment.print_customer');


    Route::get('/profile',[AdminUserController::class, 'profile'])->name('user.profile');
    Route::post('/update_profile',[AdminUserController::class, 'profileupdate'])->name('user.profileupdate');

    Route::resource('branches', BranchesController::class);
    Route::resource('staffs', StaffsController::class);
    Route::post('staff_by_branch_id',[StaffsController::class, 'staff_by_branch_id'])->name('staff.bybranch');
    Route::get('staff_attendence_export/{id}',[StaffsController::class, 'get_staff_attaendence_data'])->name('staffattendence.export');

    Route::resource('attendence', AttendenceController::class);
    Route::get('attendenceReport',[ AttendenceController::class, 'attendenceReport'])->name('attendence.report');
    Route::get('attendenceReportPdf',[ AttendenceController::class, 'listdata'])->name('attendence.listdata');
    Route::get('attendenceReportSalary/{staffId?}/{partial?}/{present?}/{absent?}/{dated?}',[ AttendenceController::class, 'attendenceReportSalary'])->name('attendence.report.salary');
    Route::get('attendencecount',[ AttendenceController::class, 'attendencecount'])->name('attendence.count');
    Route::get('markAttendence',[ AttendenceController::class, 'markAttendence'])->name('attendence.markAttendence');
    Route::post('markPresent',[ AttendenceController::class, 'markPresent'])->name('attendence.markPresent');
    Route::post('markAbsent',[ AttendenceController::class, 'markAbsent'])->name('attendence.markAbsent');




    Route::get('time',[SettingsController::class, 'time'])->name('attendence.time');
    Route::post('storetime',[SettingsController::class, 'storetime'])->name('attendence.storetime');

    Route::get('boxdimensionList/{id}',[SettingsController::class, 'boxdimensionEdit']);
    Route::get('boxdimensionList',[SettingsController::class, 'boxdimensionlist'])->name('boxdimension.list');
    Route::post('boxdimensionDestroy',[SettingsController::class, 'boxdimensionDestroy'])->name('boxdimension.del');
    Route::get('boxdimension',[SettingsController::class, 'boxdimension'])->name('boxdimension.create');
    Route::post('storeboxdimension',[SettingsController::class, 'storeboxdimension'])->name('boxdimension.store');
    Route::put('updtaeboxdimension',[SettingsController::class, 'updateboxdimension'])->name('boxdimension.update');


    Route::get('discount',[SettingsController::class, 'discount'])->name('booking.discount');
    Route::post('storediscount',[SettingsController::class, 'storediscount'])->name('booking.storediscount');

    Route::get('weight',[SettingsController::class, 'weight'])->name('booking.weight');
    Route::post('storeweight',[SettingsController::class, 'storeweight'])->name('booking.storeweight');


    Route::resource('shiptype', ShipTypeController::class);
    Route::resource('shiftingtype', ShiftingTypeController::class);
    // Route::post('shiftingtype/destroy', [ShiftingTypeController::class, 'destroy'])->name('shiftingtype.destroy');




    Route::resource('shipment', ShipmentController::class);
    Route::resource('city', CitiesController::class);
    Route::get('city/getcities',[ CitiesController::class], 'getcities')->name('getcities');
    Route::resource('district', DistrictsController::class);



    Route::resource('roles', RoleController::class);
    Route::resource('agency', AgencyController::class);
    Route::resource('driver', DriverController::class);
    Route::get('customers/{type?}',[CustomerController::class, 'viewall'])->name('customers.view.type');
    Route::resource('customer', CustomerController::class);
    Route::post('agency-getdata', [AgencyController::class, 'agencyGetdata'])->name('agency-getdata');

    Route::resource('product', ProductController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('stock', StockController::class);

    Route::get('bookingStatus',[SettingsController::class, 'bookingStatus'])->name('booking.status');
    Route::get('bookingStatusCreate',[SettingsController::class, 'bookingStatusCreate'])->name('bookingStatus.create');
    Route::post('bookingStatusStore',[SettingsController::class, 'bookingStatusStore'])->name('bookingStatus.store');
    Route::get('bookingStatusEdit/{id}',[SettingsController::class, 'bookingStatusEdit'])->name('bookingStatus.edit');
    Route::post('bookingStatusUpdate',[SettingsController::class, 'bookingStatusUpdate'])->name('bookingStatus.update');
    Route::post('bookingStatusDelete',[SettingsController::class, 'bookingStatusDelete'])->name('bookingStatus.delete');

    Route::get('movingStatus',[SettingsController::class, 'movingStatus'])->name('moving.status');
    Route::get('movingStatusCreate',[SettingsController::class, 'movingStatusCreate'])->name('movingStatus.create');
    Route::post('movingStatusStore',[SettingsController::class, 'movingStatusStore'])->name('movingStatus.store');
    Route::get('movingStatusEdit/{id}',[SettingsController::class, 'movingStatusEdit'])->name('movingStatus.edit');
    Route::post('movingStatusUpdate',[SettingsController::class, 'movingStatusUpdate'])->name('movingStatus.update');
    Route::post('movingStatusDelete',[SettingsController::class, 'movingStatusDelete'])->name('movingStatus.delete');

    Route::get('visaType',[SettingsController::class, 'visaType'])->name('visa.type');
    Route::get('visaTypeCreate',[SettingsController::class, 'visaTypeCreate'])->name('visaType.create');
    Route::post('visaTypeStore',[SettingsController::class, 'visaTypeStore'])->name('visaType.store');
    Route::get('visaTypeEdit/{id}',[SettingsController::class, 'visaTypeEdit'])->name('visaType.edit');
    Route::post('visaTypeUpdate',[SettingsController::class, 'visaTypeUpdate'])->name('visaType.update');
    Route::post('visaTypeDelete',[SettingsController::class, 'visaTypeDelete'])->name('visaType.delete');


    Route::get('documentType',[SettingsController::class, 'documentType'])->name('document.type');
    Route::get('documentTypeCreate',[SettingsController::class, 'documentTypeCreate'])->name('documentType.create');
    Route::post('documentTypeStore',[SettingsController::class, 'documentTypeStore'])->name('documentType.store');
    Route::get('documentTypeEdit/{id}',[SettingsController::class, 'documentTypeEdit'])->name('documentType.edit');
    Route::post('documentTypeUpdate',[SettingsController::class, 'documentTypeUpdate'])->name('documentType.update');
    Route::post('documentTypeDelete',[SettingsController::class, 'documentTypeDelete'])->name('documentType.delete');



    Route::get('shipmentType',[SettingsController::class, 'shipmentType'])->name('shipment.type');
    Route::get('shipmentTypeCreate',[SettingsController::class, 'shipmentTypeCreate'])->name('shipmentType.create');
    Route::post('shipmentTypeStore',[SettingsController::class, 'shipmentTypeStore'])->name('shipmentType.store');
    Route::get('shipmentTypeEdit/{id}',[SettingsController::class, 'shipmentTypeEdit'])->name('shipmentType.edit');
    Route::post('shipmentTypeUpdate',[SettingsController::class, 'shipmentTypeUpdate'])->name('shipmentType.update');
    Route::post('shipmentTypeDelete',[SettingsController::class, 'shipmentTypeDelete'])->name('shipmentType.delete');

    Route::get('clearingAgent',[SettingsController::class, 'clearingAgent'])->name('clearing.agent');
    Route::get('clearingAgentCreate',[SettingsController::class, 'clearingAgentCreate'])->name('clearingAgent.create');
    Route::post('clearingAgentStore',[SettingsController::class, 'clearingAgentStore'])->name('clearingAgent.store');
    Route::get('clearingAgentEdit/{id}',[SettingsController::class, 'clearingAgentEdit'])->name('clearingAgent.edit');
    Route::post('clearingAgentUpdate',[SettingsController::class, 'clearingAgentUpdate'])->name('clearingAgent.update');
    Route::post('clearingAgentDelete',[SettingsController::class, 'clearingAgentDelete'])->name('clearingAgent.delete');

    Route::get('portOfOrigin',[SettingsController::class, 'portOfOrigin'])->name('port.origin');
    Route::get('portOfOriginCreate',[SettingsController::class, 'portOfOriginCreate'])->name('portOfOrigin.create');
    Route::post('portOfOriginStore',[SettingsController::class, 'portOfOriginStore'])->name('portOfOrigin.store');
    Route::get('portOfOriginEdit/{id}',[SettingsController::class, 'portOfOriginEdit'])->name('portOfOrigin.edit');
    Route::post('portOfOriginUpdate',[SettingsController::class, 'portOfOriginUpdate'])->name('portOfOrigin.update');
    Route::post('portOfOriginDelete',[SettingsController::class, 'portOfOriginDelete'])->name('portOfOrigin.delete');

    Route::resource('vehicle', VehicleController::class);
    Route::resource('salesman', SalesmanController::class);
    Route::resource('expense', ExpenseController::class);

    Route::get('shipment/list/report/{type?}/{search?}', [ShipmentController::class, 'reportList'])->name('shipment.report');
    Route::get('shipment/list/reportData/{dateFrom?}/{dateTo?}', [ShipmentController::class, 'viewDataReport'])->name('shipment.report.reportData');
    Route::get('shipment/list/reportStatusData/{status?}', [ShipmentController::class, 'viewStatusDataReport'])->name('shipment.report.reportStatusData');
    Route::get('shipment/list/report/getData', [ShipmentController::class, 'getData'])->name('shipment.report.getData');
    Route::post('shipment/list/report/detailed', [ShipmentController::class, 'detailed'])->name('shipment.report.detailed');


    Route::get('shipment/delete/{id}', [ShipmentController::class, 'destroy_invoice'])->name('shipment.destroy_invoice');

    Route::get('shipment/delete/{id}', [ShipmentController::class, 'destroy_invoice'])->name('shipment.destroy_invoice');


    Route::resource('vendors', VendorController::class);

    Route::resource('movingTypes', MovingTypeController::class);



    Route::resource('ship', ShipController::class);
    Route::get('ship/detailedView/{id}', [ShipController::class, 'detailedView'])->name('ships.detailedView');
    Route::get('ship/shipEdit/{id}', [ShipController::class, 'editShip'])->name('ships.editShip');
    Route::post('ship/shipDetailesUpdate', [ShipController::class, 'shipDetailesUpdate'])->name('ships.shipDetailesUpdate');
    Route::post('ship/groupbookings', [ShipController::class, 'groupbookings'])->name('ship.groupbookings');
    Route::post('ship/list/getBoxDetails', [ShipController::class, 'getBoxDetails'])->name('ship.list.getBoxDetails');
    Route::post('ship/groupbookingslist', [ShipController::class, 'groupbookingslist'])->name('ship.groupbookingslist');
    Route::get('shipment/list/viewManifesto/{shipmentId?}', [ShipController::class, 'viewManifesto'])->name('shipment.viewManifesto');
    Route::get('shipment/list/manifestoExportView/{shipmentId?}', [ShipController::class, 'manifestoExportView'])->name('shipment.manifestoExportView');
    Route::get('ships/addbookingtoship', [AddToShipController::class, 'addbookingToShip'])->name('ships.addbookingtoship');
    Route::post('ships/multiUpdatebookingtoship', [AddToShipController::class, 'multiUpdatebookingtoship'])->name('ships.multiUpdatebookingtoship');

    Route::post('shipment/loadingExport',[ShipmentController::class,'loadingExport'])->name('shipment.loadingExport');
    Route::post('shipment/printall',[ShipmentController::class,'printall'])->name('shipment.printall');
    Route::get('ships/customer-manifest-print', [AddToShipController::class, 'customermanifestprint'])->name('ships.customermanifestptint');
    Route::get('ships/packing-list-print', [AddToShipController::class, 'packinglistptint'])->name('ships.packinglistptint');
    Route::get('ships/delivery-list-ptintt', [AddToShipController::class, 'deliverylistptint'])->name('ships.deliverylistptint');

});

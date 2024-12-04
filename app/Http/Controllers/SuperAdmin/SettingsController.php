<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Branches;
use App\Models\Attendence;
use App\Models\AttendenceTimes;
use App\Models\Discount;
use App\Models\Weight;
use App\Models\BoxDimensions;
use App\Models\Staffs;
use App\Models\Statuses;
use App\Models\MovingStatuses;
use App\Models\VisaTypes;
use App\Models\DocumentTypes;
use App\Models\ShipmentTypes;
use App\Models\ClearingAgents;
use App\Models\PortOfOrigins;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class SettingsController extends BaseController
{
    
    public function time()
    { 
        $attendence = AttendenceTimes::first(); 
        return view('superadmin.settings.time',compact( 'attendence' ) ); 
    } 

    public function storetime(Request $request)
    { 
        if( $request->id == null) {
        $attendence_time = new AttendenceTimes();
        $attendence_time->checkin_from = $request->checkin_from;
        $attendence_time->checkin_to = $request->checkin_to;
        $attendence_time->checkout_from = $request->checkout_from;
        $attendence_time->checkout_to = $request->checkout_to; 
 
        $attendence_time->save();
        }
        else {
            $id = $request->id;
            $attendence_time = AttendenceTimes::find($id);  
            $attendence_time->checkin_from = $request->checkin_from;
            $attendence_time->checkin_to = $request->checkin_to;
            $attendence_time->checkout_from = $request->checkout_from;
            $attendence_time->checkout_to = $request->checkout_to; 
     
            $attendence_time->save();
        }

        toastr()->success(section_title() . ' Attencdence Time Updated Successfully');
        return redirect()->back();
        // return redirect()->to(index_url()); 
    }

    public function boxdimensionlist() {

        $boxdimensions = BoxDimensions::all();
        return view('superadmin.settings.boxlist', compact('boxdimensions')); 
    }

    public function boxdimensionEdit($id) {
        $boxDimension = BoxDimensions::find($id);  
        return view('superadmin.settings.boxedit', compact('boxDimension')); 

    }
    
    

    public function boxdimension() {

        return view('superadmin.settings.boxcreate'); 
    }

    public function storeboxdimension(Request $request) { 
       
        $boxdimension = new BoxDimensions();
        $boxdimension->length = $request->length;
        $boxdimension->width  = $request->width;
        $boxdimension->height = $request->height;
        $boxdimension->value  = $request->value;
        $boxdimension->cargo_packing  = $request->cargo_packing;
        $boxdimension->save();

        toastr()->success(section_title() . ' Box dimensions created Successfully'); 
        return redirect()->route('super-admin.boxdimension.list');
 

    }

    public function updateboxdimension(Request $request) { 
        $id = $request->id;
        $boxdimension = BoxDimensions::find($id);   
        $boxdimension->length = $request->length;
        $boxdimension->width  = $request->width;
        $boxdimension->height = $request->height;
        $boxdimension->value  = $request->value;
        $boxdimension->cargo_packing  = $request->cargo_packing;
        $boxdimension->save();

        toastr()->success(section_title() . ' Box dimensions updated Successfully');
        return redirect()->route('super-admin.boxdimension.list');

    }

    public function boxdimensionDestroy(Request $request)
    { 
        $id = $request->id;
        DB::table("box_dimensions")->where('id', $id)->delete();
        toastr()->success(section_title() . ' Deleted Successfully');
        return redirect()->route('super-admin.boxdimension.list');
    }


    public function discount()
    { 
        $discount = Discount::first(); 
        return view('superadmin.settings.discount',compact( 'discount' ) ); 
    } 

    public function storediscount(Request $request)
    { 
        if( $request->id == null) {
        $discount = new Discount();
        $discount->discount = $request->discount; 
        $discount->save();
        }
        else {
            $id = $request->id;
            $discount = Discount::find($id);   
            $discount->discount = $request->discount; 
            $discount->save();
        }

        toastr()->success(section_title() . 'Discount Updated Successfully');
        return redirect()->back();
    }


    public function weight()
    { 
        $weight = Weight::first(); 
        return view('superadmin.settings.weight',compact( 'weight' ) ); 
    } 

    public function storeweight(Request $request)
    { 
        if( $request->id == null) {
        $weight = new Weight();
        $weight->weight = $request->weight; 
        $weight->electronics_weight = $request->electronics_weight;         
        $weight->save();
        }
        else {
            $id = $request->id;
            $weight = Weight::find($id);   
            $weight->weight = $request->weight; 
            $weight->electronics_weight = $request->electronics_weight;
            $weight->save();
        }

        toastr()->success(section_title() . 'Weight Updated Successfully');
        return redirect()->back();
    }

    public function bookingStatus(){
        $statuses = status_list(); //Statuses::get();
        return view('superadmin.settings.bookingStatus', compact('statuses'));
    }

    public function bookingStatusCreate() {
        return view('superadmin.settings.bookingStatusCreate');
    }

    public function bookingStatusStore(Request $request) {
        $status = new Statuses();
        $slug = mb_strtolower($request->name);
        $slugName = str_replace(' ', '_', $slug);

        $status->name = $request->name;
        $status->status = $request->status;
        $status->view = $request->view;
        $status->slug = $slugName;
        $status->save();
        toastr()->success('Booking Status Added Successfully');
        return redirect()->route('super-admin.booking.status');
    }

    public function bookingStatusEdit($id) {
        $status = Statuses::find($id);
        return view('superadmin.settings.bookingStatusEdit', compact('status'));
    }

    public function bookingStatusUpdate(Request $request) {
        $id = $request->hidId;
        $status = Statuses::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->view = $request->view;
        $slug = mb_strtolower($request->name);
        $slugName = str_replace(' ', '_', $slug);
        $status->slug = $slugName;
        $status->save();
        toastr()->success('Booking Status Updated Successfully');
        return redirect()->route('super-admin.booking.status');
    }

    public function bookingStatusDelete(Request $request) {
        $id = $request->statusId;
        $status = Statuses::find($id);
        $status->delete();
        toastr()->success('Booking Status Deleted Successfully');
        return redirect()->route('super-admin.booking.status');
    }
    
    public function movingStatus(){
        $statuses = MovingStatuses::get();
        return view('superadmin.settings.movingStatus', compact('statuses'));
    }

    public function movingStatusCreate() {
        return view('superadmin.settings.movingStatusCreate');
    }

    public function movingStatusStore(Request $request) {
        $status = new MovingStatuses();
        $slug = mb_strtolower($request->name);
        $slugName = str_replace(' ', '_', $slug);

        $status->name = $request->name;
        $status->status = $request->status;
        $status->slug = $slugName;
        $status->save();
        toastr()->success('Moving Status Added Successfully');
        return redirect()->route('super-admin.moving.status');
    }

    public function movingStatusEdit($id) {
        $status = MovingStatuses::find($id);
        return view('superadmin.settings.movingStatusEdit', compact('status'));
    }

    public function movingStatusUpdate(Request $request) {
        $id = $request->hidId;
        $status = MovingStatuses::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $slug = mb_strtolower($request->name);
        $slugName = str_replace(' ', '_', $slug);
        $status->slug = $slugName;
        $status->save();
        toastr()->success('Moving Status Updated Successfully');
        return redirect()->route('super-admin.moving.status');
    }

    public function movingStatusDelete(Request $request) {
        $id = $request->statusId;
        $status = MovingStatuses::find($id);
        $status->delete();
        toastr()->success('Moving Status Deleted Successfully');
        return redirect()->route('super-admin.moving.status');
    }

    public function visaType(){
        $types = VisaTypes::get();
        return view('superadmin.settings.visaType', compact('types'));
    }

    public function visaTypeCreate() {
        return view('superadmin.settings.visaTypeCreate');
    }

    public function visaTypeStore(Request $request) {
        $type = new VisaTypes();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        toastr()->success('Visa Type Added Successfully');
        return redirect()->route('super-admin.visa.type');
    }

    public function visaTypeEdit($id) {
        $type = VisaTypes::find($id);
        return view('superadmin.settings.visaTypeEdit', compact('type'));
    }

    public function visaTypeUpdate(Request $request) {
        $id = $request->hidId;
        $status = VisaTypes::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->save();
        toastr()->success('Visa Type Updated Successfully');
        return redirect()->route('super-admin.visa.type');
    }

    public function visaTypeDelete(Request $request) {
        $id = $request->typeId;
        $status = VisaTypes::find($id);
        $status->delete();
        toastr()->success('Visa Type Deleted Successfully');
        return redirect()->route('super-admin.visa.type');
    }


    public function documentType(){
        $types = DocumentTypes::get();
        return view('superadmin.settings.documentType', compact('types'));
    }

    public function documentTypeCreate() {
        return view('superadmin.settings.documentTypeCreate');
    }

    public function documentTypeStore(Request $request) {
        $type = new DocumentTypes();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        toastr()->success('Document Type Added Successfully');
        return redirect()->route('super-admin.document.type');
    }

    public function documentTypeEdit($id) {
        $type = DocumentTypes::find($id);
        return view('superadmin.settings.documentTypeEdit', compact('type'));
    }

    public function documentTypeUpdate(Request $request) {
        $id = $request->hidId;
        $status = DocumentTypes::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->save();
        toastr()->success('Document Type Updated Successfully');
        return redirect()->route('super-admin.document.type');
    }

    public function documentTypeDelete(Request $request) {
        $id = $request->typeId;
        $status = DocumentTypes::find($id);
        $status->delete();
        toastr()->success('Document Type Deleted Successfully');
        return redirect()->route('super-admin.document.type');
    }


    public function shipmentType(){
        $types = ShipmentTypes::get();
        return view('superadmin.settings.shipmentType', compact('types'));
    }

    public function shipmentTypeCreate() {
        return view('superadmin.settings.shipmentTypeCreate');
    }

    public function shipmentTypeStore(Request $request) {
        $type = new ShipmentTypes();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        toastr()->success('Shipment Type Added Successfully');
        return redirect()->route('super-admin.shipment.type');
    }

    public function shipmentTypeEdit($id) {
        $type = ShipmentTypes::find($id);
        return view('superadmin.settings.shipmentTypeEdit', compact('type'));
    }

    public function shipmentTypeUpdate(Request $request) {
        $id = $request->hidId;
        $status = ShipmentTypes::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->save();
        toastr()->success('Shipment Type Updated Successfully');
        return redirect()->route('super-admin.shipment.type');
    }

    public function shipmentTypeDelete(Request $request) {
        $id = $request->typeId;
        $status = ShipmentTypes::find($id);
        $status->delete();
        toastr()->success('Shipment Type Deleted Successfully');
        return redirect()->route('super-admin.shipment.type');
    }

    public function clearingAgent() {
        $agents = ClearingAgents::get();
        return view('superadmin.settings.clearingAgent', compact('agents'));
    }

    public function clearingAgentCreate() {
        return view('superadmin.settings.clearingAgentCreate');
    }

    public function clearingAgentStore(Request $request) {
        $type = new ClearingAgents();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        toastr()->success('Clearing Agent Added Successfully');
        return redirect()->route('super-admin.clearing.agent');
    }

    public function clearingAgentEdit($id) {
        $type = ClearingAgents::find($id);
        return view('superadmin.settings.clearingAgentEdit', compact('type'));
    }

    public function clearingAgentUpdate(Request $request) {
        $id = $request->hidId;
        $status = ClearingAgents::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->save();
        toastr()->success('Clearing Agent Updated Successfully');
        return redirect()->route('super-admin.clearing.agent');
    }

    public function clearingAgentDelete(Request $request) {
        $id = $request->typeId;
        $status = ClearingAgents::find($id);
        $status->delete();
        toastr()->success('Clearing Agent Deleted Successfully');
        return redirect()->route('super-admin.clearing.agent');
    }

    public function portOfOrigin() {
        $origins = PortOfOrigins::get();
        return view('superadmin.settings.portOfOrigin', compact('origins'));
    }

    public function portOfOriginCreate() {
        return view('superadmin.settings.portOfOriginCreate');
    }

    public function portOfOriginStore(Request $request) {
        $type = new PortOfOrigins();
        $type->name = $request->name;
        $type->status = $request->status;
        $type->save();
        toastr()->success('Port of Origin Added Successfully');
        return redirect()->route('super-admin.port.origin');
    }

    public function portOfOriginEdit($id) {
        $type = PortOfOrigins::find($id);
        return view('superadmin.settings.portOfOriginEdit', compact('type'));
    }

    public function portOfOriginUpdate(Request $request) {
        $id = $request->hidId;
        $status = PortOfOrigins::find($id);
        $status->name = $request->name;
        $status->status = $request->status;
        $status->save();
        toastr()->success('Port of Origin Updated Successfully');
        return redirect()->route('super-admin.port.origin');
    }

    public function portOfOriginDelete(Request $request) {
        $id = $request->typeId;
        $status = PortOfOrigins::find($id);
        $status->delete();
        toastr()->success('Port of Origin Deleted Successfully');
        return redirect()->route('super-admin.port.origin');
    }
    
}

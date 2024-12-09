@extends('layouts.app')

@section('content')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
@endsection
<style>
.boxContainer{
    border:1px solid black;
    padding:5px;
    margin-top:5px;
}


*{padding:0;margin:0;}

body{
	font-family:Verdana, Geneva, sans-serif;
	font-size:18px;
}

.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:220px;
	/* left:320px;*/
	right:20px;
	background-color:#0C9;
	color:#FFF;
	/* border-radius:50px; */
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:22px;
}

.save{
    position:fixed;
	width:60px;
	height:60px;
	bottom:300px;
	/* left:320px; */
	right:20px;
	background-color:#cc5100;
	color:#FFF;
	/* border-radius:50px; */
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-save{
	margin-top:22px;
}
.box_details .form-group{
        margin-bottom: 0rem;
}
/* Increase the height of the dropdown */
.select2-results__options {
            max-height: 200px; /* Adjust this value as needed */
        }

        /* Increase the height of the select box */
        .select2-container--default .select2-selection--single {
            height: 40px; /* Adjust this value as needed */
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px; /* Adjust this value as needed */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px; /* Adjust this value as needed */
        }
</style>
    <div class="content-page" id="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                {!! breadcrumbs() !!}
                            </div>
                            <h4 class="page-title">{{page_title()}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

<a href="javascript:void();" class="float" id="addBox" title="Add Box">
<i class="fa fa-plus my-float"></i>
</a>

<a href="javascript:void();" class="save" id="saveDraft" title="Save as Draft">
<i class="fa fa-save my-save"></i>
</a>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                        <form action="{{update_url($shipment->id)}}" id="edititemsstore" method="post" enctype="multipart/form-data" >
                                @method('PUT')
                                @csrf
                                <div class="col-md-12">  <!--  col-12- start-->
                                    <div class="header">
                                        <h4>Basic Info</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" id="bookingNumberSection">
                                            <div class="form-group">
                                                <label>Booking No.</label>
                                                <input type="text" name="booking_number"
                                                       value="{{ $shipment->booking_number }}" class="form-control"
                                                       required readonly
                                                       id="booking_no_uniq"
                                                       style="readonly !important; }}">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Branch List</label>
                                                <select autofocus name="branch_id" id="branch_id"
                                                        class="form-control">
                                                        @foreach ($branches as $branch)
                                                        <option
                                                            {{   ($shipment->branch_id==$branch->id ) ? 'selected' : "" }} value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <h4>Sender Info</h4>
                                            <div class="row">
                                                <div class="form-group col-md-10">
                                                    <label>Sender/Customer</label>
                                                    <select name="sender_id" id="sender_id" class="form-control select2" required>
                                                        <option value='' selected="selected">Select</option>
                                                        @foreach (get_customers('sender')->where('branch_id', branch()->id) as $sender)
                                                        <option value="{{ $sender->id }}"
                                                        {{ ($shipment->sender_id== $sender->id) ? 'selected' : "" }}
                                                        data-identification_type="{{$sender->identification_type ?? ''}}"
                                                        data-identification_number="{{$sender->identification_number ?? ''}}"
                                                        data-name="{{$sender->name ?? ''}}"
                                                        data-email="{{$sender->email ?? ''}}"
                                                        data-phone="{{$sender->phone ?? ''}}"
                                                         data-post="{{$sender->post ?? ''}}"
                                                          data-address="{{$sender->address->address ?? ''}}"
                                                         data-whatsapp_number="{{$sender->whatsapp_number ?? ''}}"
                                                        data-country_code_phone="{{$sender->country_code_phone ?? ''}}"
                                                        data-country_code_whatsapp="{{$sender->country_code_whatsapp ?? ''}}" 
                                                        data-country_id="{{$sender->address->country_id ?? ''}}"
                                                        data-state_id="{{$sender->address->state_id ?? ''}}"
                                                        data-district_id="{{$sender->address->district_id ?? ''}}"
                                                        data-city_id="{{$sender->address->city_id ?? ''}}"
                                                        data-zip_code="{{$sender->address->zip_code ?? ''}}">
                                                    {{ strtoupper($sender->name) }} - {{ $sender->phone }}
                                                </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sender_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>


                                                <div class="col-md-2">
                                                    <button type="button" id="AddSender" class="btn btn-primary mt-sm-4"><i
                                                            class="fa fa-plus"></i></button>
                                                            <button type="button" id="EditSender" class="btn btn-primary mt-sm-4"><i
                                                            class="fa fa-pen"></i></button>
                                                </div>

                                            </div>
                                            <div class="row form-group col-md-12">
                                                <label>Sender Address</label>
                                                <input readonly type="text" id="sender_address" value="{{$shipment->sender->address->address??""}}" class="form-control">
                                            </div>

                                            <div class="row form-group col-md-12">
                                                <label>Sender Phone</label>
                                                <input readonly type="text" id="sender_phone" value="{{$shipment->sender->phone??""}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="header">
                                                <h4>Receiver Info</h4>
                                            </div>
                                            <div class=" row">
                                                <div class="form-group col-md-10">
                                                    <label>Receiver/Customer</label>
                                                    <select name="receiver_id" id="receiver_id" class="form-control select2" required>
                                                    <option value='' selected="selected">Select</option>
                                                    @foreach (get_customers('receiver')->where('branch_id', branch()->id) as $receiver)
                                                    <option value="{{ $receiver->id }}"
                                                    {{ ($shipment->receiver_id== $receiver->id) ? 'selected' : "" }}
                                                        data-identification_type="{{$receiver->identification_type ?? ''}}"
                                                        data-identification_number="{{$receiver->identification_number ?? ''}}"
                                                        data-name="{{$receiver->name ?? ''}}"
                                                        data-email="{{$receiver->email ?? ''}}"
                                                        data-phone="{{$receiver->phone ?? ''}}"
                                                          data-post="{{$receiver->post ?? ''}}"
                                                          data-address="{{$receiver->address->address ?? ''}}"
                                                         data-whatsapp_number="{{$receiver->whatsapp_number ?? ''}}"
                                                        data-country_code_phone="{{$receiver->country_code_phone ?? ''}}"
                                                        data-country_code_whatsapp="{{$receiver->country_code_whatsapp ?? ''}}" 
                                                        data-country_id="{{$receiver->address->country_id ?? ''}}"
                                                        data-state_id="{{$receiver->address->state_id ?? ''}}"
                                                        data-district_id="{{$receiver->address->district_id ?? ''}}"
                                                        data-city_id="{{$receiver->address->city_id ?? ''}}"
                                                        data-zip_code="{{$receiver->address->zip_code ?? ''}}">
                                                    {{ strtoupper($receiver->name) }} - {{ $receiver->phone }}
                                                </option>
                                                    @endforeach
                                                </select>
                                                    @error('receiver_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="AddReceiver" class="btn btn-primary mt-4"><i
                                                            class="fa fa-plus"></i></button>
                                                            <button type="button" id="EditReceiver" class="btn btn-primary mt-4"><i
                                                            class="fa fa-pen"></i></button>   
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12">
                                                <label>Receiver Address</label>
                                                <input readonly type="text"  value="{{$shipment->receiver->address->address??""}}" id="receiver_address" class="form-control">
                                            </div>

                                            <div class="row form-group col-md-12">
                                                <label>Receiver Phone</label>
                                                <input readonly type="text"  value="{{$shipment->receiver->phone??""}}" id="receiver_phone" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="header">
                                            <h4>Shipping Info</h4>
                                        </div>
                                        <div class="body">
                                            <div class="row">
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Receipt Number</label>
                                                        <input type="text"   class="form-control"
                                                            name="receipt_number" value="{{$shipment->receipt_number}}">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Packaging Type</label>
                                                        <input type="text"   name="packing_type"
                                                            class="form-control" value="{{$shipment->packing_type}}">
                                                    </div>
                                                </div> -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Courier Company</label>
                                                        <select name="agency_id"  class="form-control">
                                                        @foreach ($agencies as $agency)
                                                        <option
                                                            {{   ($shipment->agency_id==$agency->id ) ? 'selected' : "" }} value="{{ $agency->id }}">{{ $agency->name }}</option>
                                                        @endforeach
                                                        <!-- <option value="Best Express"> Best Express</option> -->
                                                    </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Shipping Methods</label>
                                                        <select name="shiping_method" class="form-control" id="shiping_method"  onchange="getVolume(this);" required>
                                                        <option value="" data-shipTypeId=""> Select </option>
                                                            @foreach( $ship_types as $key => $shipping_type )
                                                            <option {{ ($shipment->shipping_method_id==$shipping_type->id ) ? 'selected' : "" }}  value="{{$shipping_type->id}}" data-shipTypeId="{{$shipping_type->id}}">{{$shipping_type->name}}</option>
                                                            @endforeach
                                                        </select>

                                                        <input type="hidden" name="shipping_method_id" value=""  id="shipping_method_id"/>

                                                           <?php /*

                                                            {{ ($shipment->shiping_method== $shipping_type->value) ? 'selected' : "" }}

                                                            <option
                                                                {{ ($shipping_type->shiping_method=='Air') ? 'selected' : "" }} value="Air">
                                                                Air
                                                            </option>
                                                            <option
                                                                {{ ($shipping_type->shiping_method=='Sea') ? 'selected' : "" }} value="Sea">
                                                                Sea
                                                            </option>
                                                            <option
                                                                {{ ($shipping_type->shiping_method=='Road') ? 'selected' : "" }} value="Road">
                                                                Road
                                                            </option>
                                                            */?>



                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Payment Method</label>
                                                        <select name="payment_method" class="form-control" id="">
                                                            <option
                                                                {{ ($shipment->payment_method=='cash_payment') ? 'selected' : "" }} value="cash_payment">
                                                                Cash Payment
                                                            </option>
                                                            <option
                                                                {{ ($shipment->payment_method=='credit') ? 'selected' : "" }} value="credit">
                                                                Credit
                                                            </option>
                                                            <option
                                                                {{ ($shipment->payment_method=='bank') ? 'selected' : "" }} value="bank">
                                                                Bank
                                                            </option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select name="status_id" class="form-control" id="" required>
                                                        <option value="">--- Select Status ---</option>
                                                            @foreach ( status_list_admin() as $item)
                                                                <option
                                                                    {{ ($shipment->status_id==$item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('status_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">



                                                <div class="col-md-3">
                                                <div class="form-group">
                                                <label>Date</label>
                                                        <input type="date" value="{{ isset($shipment->created_date) ? date('Y-m-d', strtotime($shipment->created_date)) : ''}}" max=""
                                                            class="form-control" id="propertyname" name="created_date"
                                                            placeholder="Enter title">
                                                </div>
                                               </div>


                                               <div class="col-md-3">
                                                <div class="form-group">
                                                    <label   for="collected_by"  >Collected By</label>
                                                    <select class="form-control" name="collected_by" id="collected_by" required  onchange="getRate(this);">
                                                        <option value>Select</option>
                                                            <option value="driver"  {{ ($shipment->collected_by== 'driver') ? 'selected' : "" }} >Driver</option>
                                                            <option value="staff"  {{ ($shipment->collected_by== 'staff') ? 'selected' : "" }}>Office</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" id="driver_or_staff">
                                            @if($shipment->collected_by== 'driver')
                                                    <div class="form-group">
                                                        <label>Driver Name</label>
                                                        <select class="form-control" name="driver_id" required>
                                                            <option value="">Selct Driver</option>
                                                            @foreach($drivers as $driver)
                                                                <option value="{{$driver->id}}" {{ ($shipment->driver_id== $driver->id) ? 'selected' : "" }} >{{$driver->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            @else
                                                     <div class="form-group">
                                                        <label>Staff Name</label>
                                                        <select class="form-control" name="staff_id"  required>
                                                            <option value="">Selct Driver</option>
                                                            @foreach($staffs as $staff)
                                                                <option value="{{$staff->id}}" {{ ($shipment->staff_id== $staff->id) ? 'selected' : "" }} >{{$staff->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                            @endif
                                            </div>


                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>LRL Tracking Code</label>
                                                        <input type="text" name="lrl_tracking_code" value="{{$shipment->lrl_tracking_code}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Delivery Type</label>
                                                        <select class="form-control" name="delivery_type" id="delivery_type" required>
                                                            <option value>Select</option>
                                                                <option value="door_to_door" {{ ($shipment->delivery_type== 'door_to_door') ? 'selected' : "" }} >Door To Door</option>
                                                                <option value="door_to_port" {{ ($shipment->delivery_type==  'door_to_port') ? 'selected' : "" }}>Door To Port</option>

                                                        </select>


                                                    </div>
                                                </div>


                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="propertyname">Time</label>
                                                        <input type="time" name="time" value="{{!empty($shipment)?$shipment->time:'' }}" class=" form-control"
                                                            id="propertyname1" required
                                                            placeholder="Select Time" autocomplete="off" id="setTimeExample">
                                                    </div>


                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="propertyname">Value of Goods</label>
                                                        <input type="text" name="value_of_goods"  class="  form-control"
                                                            id="propertyname1"
                                                            placeholder="Value of Goods"
                                                            value="{{$shipment->value_of_goods}}"
                                                            >
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="propertyname">Special remarks</label>
                                                        <textarea type="text" name="special_remarks"  class="  form-control"
                                                            id="propertyname1"
                                                            style="height: 38px;"
                                                            maxlength="400"
                                                            placeholder="Special remarks"
                                                            >{{$shipment->special_remarks}}</textarea>
                                                    </div>
                                                </div>

                                            </div>




                                            <div class="row mb-5">
                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>LRL Tracking Code</label>
                                                        <input type="text" name="lrl_tracking_code" value="{{$shipment->lrl_tracking_code}}"
                                                            class="form-control">
                                                    </div>
                                                </div>  -->
                                            </div>

                                            {{-- <div id="Container"> </div> --}}

                                            <!-- <button type="button" id="addBox" class="btn btn-success">Add Box
                                                        </button>  -->


                                                <?php
                                                    $grand_total_qty = 0;
                                                    $grand_total_amount =0;
                                                    $box_total_value = 0;
                                                    $ik = count($boxes);
                                                ?>
                                                @foreach($boxes as $i => $box)
                                                <?php
                                                        $total_qty = 0;
                                                        $total_amount =0;
                                                        $box_total_value = $box->total_value;

                                                ?>

                                                <div id="newBoxContainer{{$i+1}}" class="boxcount">
                                                <div class="package col-md-12"  id="package_ID" >
                                                    <div class="header row">
                                                        <div class="col-md-6"  style="float:left">
                                                        <h5 class="packageinfo-head"  data-myattri="{{$i+1}}">Box - {{$box->box_name}}</h5>
                                                        <input type="hidden" name="box_name{{$i+1}}"   data-myattri="{{$i+1}}" class="box_name" value="{{$box->box_name}}" />
                                                        </div>
                                                        <div class="col-md-6 text-right pb-2" style="float:left">
                                                        <button type="button" id="addpackage{{$i+1}}" data-myattri="{{$i+1}}"  class="btn btn-success addpackage">Add Items</button>
                                                        <button type="button" id="removeBox{{$i+1}}" data-myattri="{{$i+1}}"  class="btn btn-danger removeBox">Delete Box</button>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Weight</label>
                                                                <input type="text" name="weight{{$i+1}}" value="{{ $box->weight }}" class="form-control weight">
                                                                {{-- <input type="text" name="weight" value="{{$weight->weight?$weight->weight:''}}" class="form-control box-weight1"> --}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                         
                                            <div class="row">
                                                <div class="form-group col-md-10">
                                                    <label>Sender/Customer</label>
                                                    <select name="box_sender_id{{$i+1}}" id="box_sender_id{{$i+1}}" class="form-control select2">
                                                        @foreach (get_customers('sender') as $sender)
                                                            <option value="{{ $sender->id }}"
                                                            {{ ($shipment->sender_id== $sender->id) ? 'selected' : "" }} 
                                                            data-identification_type="{{$sender->identification_type ?? ''}}"
                                                        data-identification_number="{{$sender->identification_number ?? ''}}"
                                                        data-name="{{$sender->name ?? ''}}"
                                                        data-email="{{$sender->email ?? ''}}"
                                                        data-phone="{{$sender->phone ?? ''}}"
                                                          data-address="{{$sender->address->address ?? ''}}"
                                                         data-whatsapp_number="{{$sender->whatsapp_number ?? ''}}"
                                                        data-country_code_phone="{{$sender->country_code_phone ?? ''}}"
                                                        data-country_code_whatsapp="{{$sender->country_code_whatsapp ?? ''}}" 
                                                        data-country_id="{{$sender->address->country_id ?? ''}}"
                                                        data-state_id="{{$sender->address->state_id ?? ''}}"
                                                        data-district_id="{{$sender->address->district_id ?? ''}}"
                                                        data-city_id="{{$sender->address->city_id ?? ''}}"
                                                        data-zip_code="{{$sender->address->zip_code ?? ''}}">
                                                    {{ strtoupper($sender->name) }} - {{ $sender->phone }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sender_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                                <div class="col-md-2">
                                                <button type="button" id="AddSender{{$i+1}}" class="btn btn-primary mt-sm-4"><i
                                                class="fa fa-plus"></i></button>
                                                            <button type="button" id="EditSender{{$i+1}}" class="btn btn-primary mt-sm-4"><i
                                                            class="fa fa-pen"></i></button>
                                                </div>

                                            </div>
                                            <div class="row form-group col-md-12">
                                                
                                                <input readonly type="hidden" id="sender_address" value="{{$shipment->sender->address->address??""}}" class="form-control">
                                            </div>

                                            <div class="row form-group col-md-12">
                                               
                                                <input readonly type="hidden" id="sender_phone" value="{{$shipment->sender->phone??""}}" class="form-control">
                                            </div>
                                            
                 
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            
                                            <div class=" row">
                                                <div class="form-group col-md-10">
                                                    <label>Receiver/Customer</label>
                                                    <select name="box_receiver_id{{$i+1}}" id="box_receiver_id{{$i+1}}"
                                                            class="form-control select2">
                                                        @foreach (get_customers('receiver') as $receiver)
                                                            <option value="{{ $receiver->id }}"
                                                            {{ ($shipment->receiver_id== $receiver->id) ? 'selected' : "" }}
                                                            data-identification_type="{{$receiver->identification_type ?? ''}}"
                                                        data-identification_number="{{$receiver->identification_number ?? ''}}"
                                                        data-name="{{$receiver->name ?? ''}}"
                                                        data-email="{{$receiver->email ?? ''}}"
                                                        data-phone="{{$receiver->phone ?? ''}}"
                                                          data-address="{{$receiver->address->address ?? ''}}"
                                                         data-whatsapp_number="{{$receiver->whatsapp_number ?? ''}}"
                                                        data-country_code_phone="{{$receiver->country_code_phone ?? ''}}"
                                                        data-country_code_whatsapp="{{$receiver->country_code_whatsapp ?? ''}}" 
                                                        data-country_id="{{$receiver->address->country_id ?? ''}}"
                                                        data-state_id="{{$receiver->address->state_id ?? ''}}"
                                                        data-district_id="{{$receiver->address->district_id ?? ''}}"
                                                        data-city_id="{{$receiver->address->city_id ?? ''}}"
                                                        data-zip_code="{{$receiver->address->zip_code ?? ''}}">
                                                    {{ strtoupper($receiver->name) }} - {{ $receiver->phone }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('receiver_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="AddReceiver{{$i+1}}" class="btn btn-primary mt-4"><i
                                                            class="fa fa-plus"></i></button>
                                                            <button type="button" id="EditReceiver{{$i+1}}" class="btn btn-primary mt-4"><i
                                                            class="fa fa-pen"></i></button>
                                                </div>
                                            </div>
                                            <div class="row form-group col-md-12">
                                              
                                                <input type="hidden" id="receiver_address" value="{{$shipment->receiver->address->address??""}}" class="form-control">
                                            </div>
                                            
                                            <div class="row form-group col-md-12">
                                               
                                                <input type="hidden" id="receiver_phone" value="{{$shipment->receiver->phone??""}}" class="form-control">
                                            </div>
                                            
                                            
                                        </div>
                                    </div> 
                                                    <div class="body box_und_calc" id="packageinfo{{$i+1}}" >
                                                        <table class="table table-bordered packageinfo{{$i+1}}">
                                                            @foreach($box->packages as $j => $package)

                                                            <tr>
                                                            <td width="2%">
                                                              <span class="form-control border-0">{{$j+1}}</span>
                                                            </td>
                                                                <td width="40%">
                                                                    <input type="text" placeholder="Enter description"
                                                                        name="description{{$i+1}}[]" value="{{$package->description}}"
                                                                        class="form-control descriptions" >
                                                                </td>
                                                                <td>
                                                                    <input type="number" placeholder="Enter quantity"
                                                                        name="qty{{$i+1}}[]" value="{{$package->quantity}}"
                                                                        class="form-control qty">


                                                                </td>
                                                                <td>
                                                                    <input type="number" placeholder="Enter unit price"
                                                                        name="unit{{$i+1}}[]" value="{{$package->unit_price}}"
                                                                        class="form-control unit" data-myattri="{{$i+1}}" step="0.01">

                                                                </td>
                                                                <td>
                                                                    <input type="text" name="subtotal{{$i+1}}[]" readonly
                                                                        class="form-control value pkg-subtotal"  value="{{$package->subtotal}}">
                                                                </td>

                                                                <td><button type="button"  class="remove btn btn-danger" data-remove="{{$i+1}}" data-myAttri="{{$i+1}}" >X</button></td>

                                                            </tr>
                                                            <?php
                                                            $total_qty += $package->quantity;
                                                            $total_amount += $package->subtotal;

                                                            $grand_total_qty  += $package->quantity;
                                                            $grand_total_amount += $package->subtotal;
                                                            ?>
                                                            @endforeach
                                                        </table>
                                                    </div>

                                                    <div class="body">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td width="20%"> </td>
                                                                <td width="20%"><h6>Total Quantity: </h6></td>
                                                                <td width="20%"><h6><span id="totalqty{{$i+1}}" class="rtotqty">{{$total_qty }}</span></h6></td>

                                                                <td width="20%"><h6>Total Value : </h6></td>
                                                                <td width="20%"><h6><span id="totalAmt{{$i+1}}" class="package-total-amount  rtotamt">{{ $total_amount }}</span></h6></td>

                                                            </tr>
                                                        </table>
                                                    </div>


                                                    <div class="body" id="boxDimension">
                                                    <div class="row">
                                                        <div class="col-md-2 box-title">
                                                            <h5></h5>
                                                        </div>
                                                        </div>
                                                        <div class="row" style="display: none;">
                                                            <input type="hidden" name="box_id{{$i+1}}" value="{{$box->id}}" />

                                                            <div class="col-md-2" >
                                                                <div class="form-group">
                                                                    <label>Length x Width x Height</label>
                                                                    <select name='dimension{{$i+1}}' data-no='{{$i+1}}' class='form-control box-dimension' required   onchange="getval(this);">
                                                                        <option value=''>select</option>
                                                                        <option value='2' selected>45 x 45 x 45</option>
                                                                        {{-- @foreach($dimensions as $dimension)
                                                                        <option value='{{$dimension->id}}'
                                                                        {{ ($box->box_dimension_id== $dimension->id) ? 'selected' : "" }}
                                                                        data-id='{{$dimension->id}}'>{{$dimension->length}} x {{$dimension->width}} x {{$dimension->height}}</option>
                                                                        @endforeach --}}
                                                                        <option {{ ($box->box_dimension_id == 0 ) ? 'selected' : "" }} value='0'>Other</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Start other -->
                                                                <div class="col-md-1 {{ ($box->box_dimension_id == 0)? '' : 'd-none' }}" id="other_length{{$i+1}}">
                                                                <div class="form-group">
                                                                    <label>Length</label>
                                                                    <input type="text" name="other_length{{$i+1}}" data-no="{{$i+1}}" value="{{$box->other_length}}" class="form-control other_length"   onkeyup="getValOther(this);">
                                                                </div>
                                                                </div>
                                                                <div class="col-md-1 {{ ($box->box_dimension_id == 0)? '' : 'd-none' }}" id="other_width{{$i+1}}">
                                                                <div class="form-group">
                                                                    <label>Width</label>
                                                                    <input type="text" name="other_width{{$i+1}}" data-no="{{$i+1}}" value="{{$box->other_width}}" class="form-control other_width"   onkeyup="getValOther(this);">
                                                                </div>
                                                                </div>
                                                                <div class="col-md-1 {{ ($box->box_dimension_id == 0)? '' : 'd-none' }}" id="other_height{{$i+1}}">
                                                                <div class="form-group">
                                                                    <label>Height</label>
                                                                    <input type="text" name="other_height{{$i+1}}"  data-no="{{$i+1}}" value="{{$box->other_height}}" class="form-control other_height"   onkeyup="getValOther(this);">
                                                                </div>
                                                                </div>

                                                                <div class="col-md-1 {{ ($box->box_dimension_id == 0)? '' : 'd-none' }}" id="other_select{{$i+1}}">
                                                                <div class="form-group">
                                                                    <label>Select</label>
                                                                    <input type="text" name="other_select{{$i+1}}"  data-no="{{$i+1}}" value="{{$box->other_select}}" class="form-control other_select"   onkeyup="getValOther(this);">
                                                                </div>
                                                                </div>   `
                                                            <!-- End other -->

                                                            <div class="col-md-2 {{ ($box->box_dimension_id == 0)? 'd-none' : '' }} " id="packing{{$i+1}}">
                                                                <div class="form-group">
                                                                    <label>Packing</label>
                                                                    <select name='packing{{$i+1}}' data-no='{{$i+1}}' class='form-control box-packing' onchange="getBoxPackingVal(this);">
                                                                      
                                                                        <option value='2' selected >Cargo Packing</option>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-1 {{ ($box->box_dimension_id == 0)? 'd-none' : '' }}" id="selectVolume{{$i+1}}">
                                                                <div class="form-group">
                                                                    <label>Select</label>
                                                                        <select name='volume{{$i+1}}' data-no='{{$i+1}}' class='form-control ' required   onchange="getval(this);">
                                                                            <option value='6000' selected >6000</option>
                                                                            {{-- <option value='5000'   {{ ($shipment->shiping_method== '5000') ? 'selected' : "" }}>5000</option>
                                                                            <option value='6000'  {{ ($shipment->shiping_method== '6000') ? 'selected' : "" }}>6000</option>
                                                                            <option value='1000000' {{ ($shipment->shiping_method== '1000000') ? 'selected' : "" }}>1000000</option> --}}
                                                                        </select>
                                                                </div>
                                                            </div>

                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <label>Volume</label>                                                              
                                                                <input type="text" name="unit_value{{$i+1}}" value="15.19" class="form-control box-unit-value" data-unit-value="{{$i+1}}">

                                                            </div>
                                                        </div>
                                                      
                                                        <div class="col-md-1">
                                                            <div class="form-group">
                                                                <label>Rate</label>
                                                                {{-- <input type="text" name="rate{{$i+1}}" value="{{$box->rate}}" class="form-control box-rate"  data-rate="{{$i+1}}"> --}}
                                                                <input type="text" name="rate{{$i+1}}" value="20" class="form-control box-rate"  data-rate="{{$i+1}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Total Amount</label>
                                                                <input type="text" name="total_value{{$i+1}}" value="{{$box->total_value}}" class="form-control box-total-value total" readonly>
                                                                <!-- <input type="hidden" name="box_name{{$i+1}}" value="{{$box->box_name}}" class="form-control box_name"> -->
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2" id="box_packing_charge{{$i+1}}">
                                                        <div class="form-group">
                                                            <label>Packing charge</label>
                                                            {{-- <input type="text" name="box_packing_charge{{$i+1}}" value="{{$box->box_packing_charge}}"  data-no='{{$i+1}}' class='form-control box_packing_charge'/> --}}
                                                            <input type="text" name="box_packing_charge{{$i+1}}" value="20"  data-no='{{$i+1}}' class='form-control box_packing_charge'/>

                                                        </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                </div>
                                                </div>
                                                <?php $ik = $ik -1; ?>
                                                @endforeach

                                                <div id="Container"> </div>
                                            <hr>
                                            <div class="col-md-8"  id="TotalDiv" style="display:none;">
                                                <div class="body">
                                                    <table class="table " >
                                                        <tr>
                                                            <td style="border:none;">

                                                            <div class="row pt-2">
                                                                    <div class="col-md-6"  >

                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <label>Quantity</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <label>Unit Rate</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <label>Amount</label>
                                                                    </div>
                                                                </div>

                                                                <div class="row pt-2">

                                                                    <?php
                                                                     $normal_weight = $shipment->normal_weight - ( ($shipment->msic_weight) + ($shipment->electronics_weight) + ($shipment->other_weight));
                                                                    ?>

                                                                    <div class="col-md-6" style="text-align:right;" >
                                                                        <label>Total Weight</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            {{-- <input type="text" name="normal_weight" value="{{$shipment->normal_weight}}" class="form-control "> --}}
                                                                            <input type="text" name="grand_total_weight" value="{{ $shipment->grand_total_weight }}" class="form-control " >

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_normal_weight" value="{{$shipment->rate_normal_weight}}" class="form-control rate_normal_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_normal_weight" value="{{$shipment->amount_normal_weight}}" class="form-control tot_amt" >
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row pt-2">
                                                                        <div class="col-md-6"  style="text-align:right;">
                                                                            <label>Duty</label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="electronics_weight"
                                                                                value="{{$shipment->electronics_weight}}" class="form-control electronics_weight tot_wgt">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="rate_electronics_weight" value="{{$shipment->rate_electronics_weight}}" class="form-control rate_electronics_weight tot_rate">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_electronics_weight" value="{{$shipment->amount_electronics_weight}}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row  pt-2">
                                                                        <div class="col-md-6"  style="text-align:right;">
                                                                            <label>Packing charge</label>
                                                                        </div>
                                                                        <div class="col-md-2"">
                                                                            <div class="">
                                                                                <input type="text" name="msic_weight"
                                                                                value="{{$shipment->msic_weight}}" class="form-control msic_weight tot_wgt">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="rate_msic_weight" value="{{$shipment->rate_msic_weight}}" class="form-control rate_msic_weight tot_rate">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_msic_weight" value="{{$shipment->amount_msic_weight}}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Additional Packing charge</label>
                                                                    </div>
                                                                    <div class="col-md-2"">
                                                                        <div class="">
                                                                            <input type="text" name="add_pack_charge"
                                                                            value="{{$shipment->add_pack_charge}}" class="form-control add_pack_charge tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_add_pack_charge" value="{{$shipment->rate_add_pack_charge}}" class="form-control rate_add_pack_charge tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <div class="">
                                                                        <input type="text" name="amount_add_pack_charge" value="{{$shipment->amount_add_pack_charge}}" class="form-control tot_amt">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Insurance </label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="insurance"
                                                                            value="{{$shipment->insurance}}" class="form-control insurance_weight tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_insurance" value="{{$shipment->rate_insurance}}" class="form-control rate_insurance_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_insurance" value="{{$shipment->amount_insurance}}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>AWB Fee</label>
                                                                    </div>
                                                                    <div class="col-md-2"">
                                                                        <div class="">
                                                                            <input type="text" name="awbfee"
                                                                            value="{{$shipment->awbfee}}" class="form-control awbfee tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_awbfee" value="{{$shipment->rate_awbfee}}" class="form-control rate_awbfee tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_awbfee" value="{{$shipment->amount_awbfee}}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>VAT Amount</label>
                                                                    </div>
                                                                    <div class="col-md-2"">
                                                                        <div class="">
                                                                            <input type="text" name="vat_amount"
                                                                            value="{{$shipment->vat_amount}}" class="form-control vat_amount tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_vat_amount" value="{{$shipment->rate_vat_amount}}" class="form-control rate_vat_amount tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_vat_amount" value="{{$shipment->amount_vat_amount}}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Volume weight</label>
                                                                    </div>
                                                                    <div class="col-md-2"">
                                                                        <div class="">
                                                                            <input type="text" name="volume_weight"
                                                                            value="{{$shipment->volume_weight}}" class="form-control volume_weight tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_volume_weight" value="{{$shipment->rate_volume_weight}}" class="form-control rate_volume_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_volume_weight" value="{{$shipment->amount_volume_weight}}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Discount</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="discount_weight"
                                                                            value="{{$shipment->discount_weight}}" class="form-control discount_weight tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_discount_weight" value="{{$shipment->rate_discount_weight}}" class="form-control rate_discount_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_discount_weight" value="{{$shipment->amount_discount_weight}}" class="form-control ">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            

                                                                <div class="row">

                                                                        <div class="col-md-6 pt-2"  style="text-align:right;font-size:18px;font-weight:bold;">

                                                                        </div>
                                                                        <div class="col-md-2 pt-2" style="border-top:1px solid;">
                                                                            <div class="">  <!-- <input type="text" name="grand_total_weight" value="{{ $normal_weight }}" class="form-control" readonly> -->
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-2 pt-2"  style="border-top:1px solid;">
                                                                            <div class="">
                                                                                <!-- <input type="text" name="rate_grand_total" value="{{$shipment->rate_grand_total}}" class="form-control"> -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 pt-2"  style="border-top:1px solid;">
                                                                        <div class="">
                                                                            <input type="text" name="amount_grand_total" value="{{$shipment->amount_grand_total}}" class="form-control">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row  pt-2">

                                                                     <div class="col-md-6"  style="text-align:right;">
                                                                            <label>No.of Pcs</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="">
                                                                                <input value="{{ $shipment->number_of_pcs?$shipment->number_of_pcs:0 }}" type="text" name="number_of_pcs"
                                                                                class="form-control" id="number_of_pcs">

                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <div class="row mt-5">
                                                                        <div class="col-md-12"  style="text-align:left;">
                                                                            <!-- <h3>Declared value = Total Weight x 20 </h3> -->
                                                                        </div>
                                                                </div>

                                                            </td>
                                                         

                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>


                                        </div> <!-- body -->
                                    </div>


                                    <div class="text-center" style="display:block;">
                                    <input type="hidden" name="id" value="{{$shipment->id}}" />
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                        </button>
                                        <a href="{{index_url()}}" type="button"
                                        class="btn btn-danger waves-effect waves-light">Cancel
                                        </a>
                                    </div>

                                </div>  <!--  col-12- end-->
                        </form>


                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->


                <!----------------------- div for add more ------------------------>


                <div style="display:none;" >
                                        <div id="newBoxContainer" class="boxcount">


                                            <div class="package col-md-12"  id="package_ID" >
                                                <div class="header">
                                                    <div class="col-md-6"  style="float:left">
                                                        <h5 class="packageinfo-head1">Package Info </h5>
                                                        <input type="hidden" name="box_name_1" value="" class="box_name1" />
                                                    </div>
                                                    <div class="col-md-6 text-right pb-2" style="float:left">
                                                        <button type="button" id="addpackage" class="btn btn-success addpackage">Add Items</button>
                                                        <button type="button" id="removeBox" class="btn btn-danger removeBox">Delete Box</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Weight</label>
                                                            <input type="text" name="weight[]" value="" class="form-control box-weight1 weight">
                                                            {{-- <input type="text" name="weight" value="{{$weight->weight?$weight->weight:''}}" class="form-control box-weight1"> --}}
                                                        </div>
                                                    </div>
                                                <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                         
                                            <div class="row">
                                                <div class="form-group col-md-10">
                                                    <label>Sender/Customer</label>
                                                    <select name="sender_id[]" id="sender_id[]" class="form-control select2">
                                                        @foreach (get_customers('sender') as $sender)
                                                            <option value="{{ $sender->id }}"
                                                            {{ ($shipment->sender_id== $sender->id) ? 'selected' : "" }} 
                                                            data-identification_type="{{$sender->identification_type ?? ''}}"
                                                        data-identification_number="{{$sender->identification_number ?? ''}}"
                                                        data-name="{{$sender->name ?? ''}}"
                                                        data-email="{{$sender->email ?? ''}}"
                                                        data-phone="{{$sender->phone ?? ''}}"
                                                          data-address="{{$sender->address->address ?? ''}}"
                                                         data-whatsapp_number="{{$sender->whatsapp_number ?? ''}}"
                                                        data-country_code_phone="{{$sender->country_code_phone ?? ''}}"
                                                        data-country_code_whatsapp="{{$sender->country_code_whatsapp ?? ''}}" 
                                                        data-country_id="{{$sender->address->country_id ?? ''}}"
                                                        data-state_id="{{$sender->address->state_id ?? ''}}"
                                                        data-district_id="{{$sender->address->district_id ?? ''}}"
                                                        data-city_id="{{$sender->address->city_id ?? ''}}"
                                                        data-zip_code="{{$sender->address->zip_code ?? ''}}">
                                                    {{ strtoupper($sender->name) }} - {{ $sender->phone }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('sender_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                                <div class="col-md-2">
                                                <button type="button" id="AddSender[]" class="btn btn-primary mt-sm-4"><i
                                                class="fa fa-plus"></i></button>
                                                            <button type="button" id="EditSender[]" class="btn btn-primary mt-sm-4"><i
                                                            class="fa fa-pen"></i></button>
                                                </div>

                                            </div>
                 
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            
                                            <div class=" row">
                                                <div class="form-group col-md-10">
                                                    <label>Receiver/Customer</label>
                                                    <select name="receiver_id[]" id="receiver_id[]"
                                                            class="form-control select2">
                                                        @foreach (get_customers('receiver') as $receiver)
                                                            <option value="{{ $receiver->id }}"
                                                            {{ ($shipment->receiver_id== $receiver->id) ? 'selected' : "" }}
                                                            data-identification_type="{{$receiver->identification_type ?? ''}}"
                                                        data-identification_number="{{$receiver->identification_number ?? ''}}"
                                                        data-name="{{$receiver->name ?? ''}}"
                                                        data-email="{{$receiver->email ?? ''}}"
                                                        data-phone="{{$receiver->phone ?? ''}}"
                                                          data-address="{{$receiver->address->address ?? ''}}"
                                                         data-whatsapp_number="{{$receiver->whatsapp_number ?? ''}}"
                                                        data-country_code_phone="{{$receiver->country_code_phone ?? ''}}"
                                                        data-country_code_whatsapp="{{$receiver->country_code_whatsapp ?? ''}}" 
                                                        data-country_id="{{$receiver->address->country_id ?? ''}}"
                                                        data-state_id="{{$receiver->address->state_id ?? ''}}"
                                                        data-district_id="{{$receiver->address->district_id ?? ''}}"
                                                        data-city_id="{{$receiver->address->city_id ?? ''}}"
                                                        data-zip_code="{{$receiver->address->zip_code ?? ''}}">
                                                    {{ strtoupper($receiver->name) }} - {{ $receiver->phone }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('receiver_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="AddReceiver[]" class="btn btn-primary mt-4"><i
                                                            class="fa fa-plus"></i></button>
                                                            <button type="button" id="EditReceiver[]" class="btn btn-primary mt-4"><i
                                                            class="fa fa-pen"></i></button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div> 
                                              
                                                <div class="body box_und_calc" id="packageinfo">

                                                    <table class="table table-bordered packageinfo">
                                                        <tr>
                                                        <td width="2%">
                                                              <span class="form-control border-0">1</span>
                                                            </td>

                                                            <td width="40%">
                                                                <input type="text" placeholder="Enter description"
                                                                    name="description[]"
                                                                    class="form-control descriptions">
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Enter quantity"
                                                                    name="qty[]"
                                                                    class="form-control qty">
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Enter unit price"
                                                                    name="unit[]"
                                                                    class="form-control unit" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="subtotal[]" readonly
                                                                    class="form-control value pkg-subtotal">
                                                            </td>
                                                            <td>
                                                                <button type="button"  name="remove[]" class="remove btn btn-danger" data-remove="">X</button>
                                                            </td>

                                                        </tr>
                                                    </table>

                                                </div>

                                                <div class="body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="20%"> </td>
                                                            <td width="20%"><h6>Total Quantity: </h6></td>
                                                            <td width="20%"><h6><span id="totalqty"></span></h6></td>
                                                            <td width="20%"><h6>Total Value: </h6></td>
                                                            <td width="20%"><h6><span id="totalAmt" class="package-total-amount"></span></h6></td>
                                                        </tr>
                                                    </table>

                                                </div>


                                                <div class="body" id="boxDimension">
                                                <div class="row">
                                                    <div class="col-md-2 box-title">
                                                        <!-- <h6>Box</h6> -->
                                                    </div>
                                                    </div>
                                                    <div class="row" style="display: none;">
                                                    <!-- <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Length</label>
                                                            <input type="text" name="length" value="" class="form-control box-length">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Width</label>
                                                            <input type="text" name="width" value="" class="form-control box-width">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Height</label>
                                                            <input type="text" name="height" value="" class="form-control box-height">
                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Length x Width x Height</label>
                                                            <select name='dimension' data-no='' class='form-control box-dimension' required   onchange="getval(this);">
                                                                <option value=''>select</option>
                                                                <option value='2' selected>45 x 45 x 45</option>
                                                                {{-- @foreach($dimensions as $dimension)
                                                                <option value='{{$dimension->id}}' data-id='{{$dimension->id}}'>{{$dimension->length}} x {{$dimension->width}} x {{$dimension->height}}</option>
                                                                @endforeach --}}
                                                                <option value='0'>Other</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 d-none" id="other_length">
                                                        <div class="form-group">
                                                            <label>Length</label>
                                                            <input type="text" name="other_length" value="" class="form-control other_length"   onkeyup="getValOther(this);">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 d-none" id="other_width">
                                                        <div class="form-group">
                                                            <label>Width</label>
                                                            <input type="text" name="other_width" value="" class="form-control other_width"   onkeyup="getValOther(this);">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 d-none" id="other_height">
                                                        <div class="form-group">
                                                            <label>Height</label>
                                                            <input type="text" name="other_height" value="" class="form-control other_height"   onkeyup="getValOther(this);">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 d-none" id="other_select">
                                                        <div class="form-group">
                                                            <label>Select</label>
                                                            <input type="text" name="other_select" value="" class="form-control other_select"   onkeyup="getValOther(this);">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2" id="packing">
                                                        <div class="form-group">
                                                            <label>Packing</label>
                                                            <select name='packing' data-no='' class='form-control box-packing' onchange="getBoxPackingVal(this);">
                                                                <option value=''>Select</option>
                                                                <option value='2' selected >Cargo Packing</option>
                                                                {{-- <option value='1'>Customer Packing</option>
                                                                <option value='2'>Cargo Packing</option> --}}
                                                            </select>
                                                        </div>
                                                        <!-- <input type="hidden" name="box_packing_charge"  data-no='' class='form-control box_packing_charge'/> -->
                                                    </div>

                                                     <div class="col-md-2" id="selectVolume">
                                                        <div class="form-group">
                                                            <label>Select </label>
                                                            <select name='volume' data-no='' class='form-control ' required   onchange="getval(this);">
                                                                <option selected value='6000'  >6000</option>
                                                                {{-- <option value='5000'>5000</option>
                                                                <option value='6000' >6000</option>
                                                                <option value='1000000' >1000000</option> --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Volume</label>
                                                            <input type="text" name="unit_value" value="15.19" class="form-control box-unit-value">
                                                        </div>
                                                    </div>





                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label>Rate</label>
                                                            <input type="text" name="rate" value="20" class="form-control box-rate1">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Total Amount</label>
                                                            <input type="text" name="total_value" value="602.00" class="form-control box-total-value total1" readonly>
                                                            <!-- <input type="hidden" name="box_name" value="" class="form-control box_name"> -->
                                                        </div>
                                                    </div>
                                                    <?php /*

                                                    <div class="col-md-2 d-none" id="other_dimension">
                                                        <div class="form-group">
                                                            <label>Other</label>
                                                            <input type="text" name="other_dimension" value="" class="form-control other_dimension">
                                                        </div>
                                                    </div>
                                                    */?>




                                                        <div class="col-md-2" id="box_packing_charge">
                                                        <div class="form-group">
                                                            <label>Packing charge</label>
                                                            <input type="text" name="box_packing_charge" value="20"  data-no='' class='form-control box_packing_charge'/>
                                                        </div>
                                                        </div>


                                                </div>
                                            </div>


                                            </div>
                                        </div>
                                    </div>

                <!----------------------- div for add more ------------------------>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->
</div>

@include('branches.modals.add_client')
@endsection
@section('styles')
@include('layouts.datatables_style')
@endsection
@section('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
<script>


    $(window).on('load', function() {
        $('.id_img').each(function() {
            var img = $(this);
            img.attr('src', img.data('src'));
        });
    });

    $(document).ready(function() {
    // Check if "driver" is already selected initially
    if ($('#collected_by').val() === 'driver') {
        // toggleBookingNumberInput(false);
    }

    // Bind change event handler
    $('#collected_by').change(function() {
        if ($(this).val() === 'driver') {
            // toggleBookingNumberInput(true);
        } else {
            toggleBookingNumberInput(false);
        }
    });

    // Function to toggle input readonly property
    function toggleBookingNumberInput(enable) {
        $('#bookingNumberSection input[name="booking_number"]').prop('readonly', !enable);
    }

    $("#whatsapp_same").change(function() {
        var phone = document.querySelector('input[name="phone"]');
        var whatsapp_number = document.querySelector('input[name="whatsapp_number"]');
        var wp_no = whatsapp_number.value;

        if (this.checked) {
            phone.value = wp_no;
        } else { // Changed elseif to else
            phone.value = ''; // Setting phone value to an empty string instead of null
        }
    });



});

document.addEventListener('DOMContentLoaded', function() {

    $(document).on('change', '.sender_id_type', function() {
        $('.sender_id_no').trigger('input');
    });

    $(document).on('input', '.sender_id_no', function() {
        var dataIndex = $(this).attr('data-index');
        var selectValue = $(`select[name="sender_id_type${dataIndex}"]`).val();
        console.log(dataIndex);

        // Select the <p> tag that follows the current input
        var $existingP = $(this).next('p');

        // Determine the new content for the <p> tag and validation message
        var newContent = '';
        var isValid = true; // Flag to check if the input is valid
        var inputValue = $(this).val(); // Get the current input value

        if (selectValue == 'Passport Number') {
            if (inputValue.length > 0 && inputValue.length !== 8) {
                newContent = 'Passport Number should be 8 characters. Please enter exactly 8 characters.';
                isValid = false;
            } else if (inputValue.length === 8) {
                newContent = selectValue + ' is Correct';
            } else {
                newContent = 'Passport Number should be 8 characters.';
            }
        } else if (selectValue == 'Aadhaar Number' || selectValue == 'Aadhar') {
            if (inputValue.length > 0 && inputValue.length !== 12) {
                newContent = 'Aadhaar Number should be 12 digits. Please enter exactly 12 digits.';
                isValid = false;
            } else if (inputValue.length === 12) {
                newContent = selectValue + ' is Correct';
            } else {
                newContent = 'Aadhaar Number should be 12 digits.';
            }
        }

        // Set the color based on validity
        var color = isValid ? 'green' : 'red';

        // Update the existing <p> tag or add a new one if it doesn't exist
        if ($existingP.length) {
            $existingP.text(newContent).css('color', color);
        } else {
            $(this).after(`<p style="color: ${color};">${newContent}</p>`);
        }
    });


    $(document).on('change', '.receiver_id_type', function() {
        $('.receiver_id_no').trigger('input');
    });

    $(document).on('input', '.receiver_id_no', function() {
        var dataIndex = $(this).attr('data-index');
        var selectValue = $(`select[name="receiver_id_type${dataIndex}"]`).val();
        console.log(dataIndex);

        // Select the <p> tag that follows the current input
        var $existingP = $(this).next('p');

        // Determine the new content for the <p> tag and validation message
        var newContent = '';
        var isValid = true; // Flag to check if the input is valid
        var inputValue = $(this).val(); // Get the current input value

        if (selectValue == 'Passport Number') {
            if (inputValue.length > 0 && inputValue.length !== 8) {
                newContent = 'Passport Number should be 8 characters. Please enter exactly 8 characters.';
                isValid = false;
            } else if (inputValue.length === 8) {
                newContent = selectValue + ' is Correct';
            } else {
                newContent = 'Passport Number should be 8 characters.';
            }
        } else if (selectValue == 'Aadhaar Number' || selectValue == 'Aadhar') {
            if (inputValue.length > 0 && inputValue.length !== 12) {
                newContent = 'Aadhaar Number should be 12 digits. Please enter exactly 12 digits.';
                isValid = false;
            } else if (inputValue.length === 12) {
                newContent = selectValue + ' is Correct';
            } else {
                newContent = 'Aadhaar Number should be 12 digits.';
            }
        }

        // Set the color based on validity
        var color = isValid ? 'green' : 'red';

        // Update the existing <p> tag or add a new one if it doesn't exist
        if ($existingP.length) {
            $existingP.text(newContent).css('color', color);
        } else {
            $(this).after(`<p style="color: ${color};">${newContent}</p>`);
        }
    });




$(document).ready(function () {
    // Loop through all Add and Edit buttons dynamically and attach event listeners
    $('.btn-primary').each(function () {
        let index = $(this).attr('id').match(/(\d+)$/); // Dynamically extract index number
        if (index) {
            let i = index[0];

            // Handle "Add Receiver" click for each index
            $(`#AddReceiver${i}`).click(function () {
                openReceiverModal("add", i);
            });

            // Handle "Edit Receiver" click for each index
            $(`#EditReceiver${i}`).click(function () {
                openReceiverModal("edit", i);
            });
        }
    });

    function openReceiverModal(mode, index) {
        if (mode === "add") {
            $('#AddClient h4.modal-title').text("Add Receiver");
            $('#AddClient #clientType').val("receiver");
            $('#AddClient').modal('show');
        }

        if (mode === "edit") {
            let selectedOption = $(`#box_receiver_id${index}`).find('option:selected');
            let receiverId = selectedOption.val();

            if (receiverId) {
                $('#AddClient .modal-title').text("Edit Receiver");
                $('#receiver_id_input').val(receiverId); 
                $('#save_data_user').hide();
                $('#update_data_receiver').show();
                $('#update_data_user').hide();
                populateFieldsForEditReceiver(selectedOption);
                $('#AddClient').modal('show');
            } else {
                alert('Please select a receiver to edit.');
            }
        }
    }

    function populateFieldsForEditReceiver(option) {
        $('#receiver_address').val(option.data('address'));
        $('#receiver_phone').val(option.data('phone'));
        $('#country_code_whatsapp').val(option.data('country_code_whatsapp'));
        $('#country_code_phone').val(option.data('country_code_phone'));
        $('#client_identification_type').val(option.data('identification_type'));
        $('#client_identification_number').val(option.data('identification_number'));
        $('#zip_code').val(option.data('zip_code'));
        $('#state_id').val(option.data('state_id')).trigger('change');
        $('#city_id').val(option.data('city_id')).trigger('change');
    }

    $('#update_data_receiver').click(function () {
        let selectedOption = $('#receiver_id').find('option:selected');
        let receiverId = selectedOption.val();
        let formData = new FormData($('#add_client_shipments')[0]);

        $.ajax({
            url: `/branch/shipment/update-receiver/${receiverId}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#AddClient').modal('hide');
                    $(`#box_receiver_id${response.index} option[value="${receiverId}"]`).remove();
                    $(`#box_receiver_id${response.index}`).append(
                        `<option value="${receiverId}" 
                            data-identification_type="${response.data.identification_type}"
                            data-identification_number="${response.data.identification_number}"
                            data-name="${response.data.name}"
                            data-email="${response.data.email}"
                            data-phone="${response.data.phone}"
                            data-address="${response.data.address}"
                            data-whatsapp_number="${response.data.whatsapp_number}"
                            data-country_code_phone="${response.data.country_code_phone}"
                            data-country_code_whatsapp="${response.data.country_code_whatsapp}"> 
                            ${response.data.name.toUpperCase()} - ${response.data.phone}</option>`
                    );
                    $(`#box_receiver_id${response.index}`).val(receiverId);
                } else {
                    alert('Failed to update receiver details.');
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });
});


$(document).ready(function () {
    // Loop through all Add and Edit buttons dynamically and attach event listeners
    $('.btn-primary').each(function () {
        let index = $(this).attr('id').match(/(\d+)$/); // Dynamically extract index number
        if (index) {
            let i = index[0];

            // Handle "Add Sender" click for each index
            $(`#AddSender${i}`).click(function () {
                openReceiverModal("add", i);
            });

            // Handle "Edit Sender" click for each index
            $(`#EditSender${i}`).click(function () {
                openReceiverModal("edit", i);
            });
        }
    });

    function openReceiverModal(mode, index) {
        if (mode === "add") {
            $('#AddClient h4.modal-title').text("Add Sender");
            $('#AddClient #clientType').val("sender");
            $('#AddClient').modal('show');
        }

        if (mode === "edit") {
            let selectedOption = $(`#box_sender_id${index}`).find('option:selected');
            let receiverId = selectedOption.val();

            if (receiverId) {
                $('#AddClient .modal-title').text("Edit Sender");
                $('#receiver_id_input').val(receiverId); 
                $('#save_data_user').hide();
                $('#update_data_sender').show();
                $('#update_data_user').hide();
                populateFieldsForEditReceiver(selectedOption);
                $('#AddClient').modal('show');
            } else {
                alert('Please select a sender to edit.');
            }
        }
    }

    function populateFieldsForEditReceiver(option) {
        $('#sender_address').val(option.data('address'));
        $('#sender_phone').val(option.data('phone'));
        $('#country_code_whatsapp').val(option.data('country_code_whatsapp'));
        $('#country_code_phone').val(option.data('country_code_phone'));
        $('#client_identification_type').val(option.data('identification_type'));
        $('#client_identification_number').val(option.data('identification_number'));
        $('#zip_code').val(option.data('zip_code'));
        $('#state_id').val(option.data('state_id')).trigger('change');
        $('#city_id').val(option.data('city_id')).trigger('change');
    }

    $('#update_data_sender').click(function () {
        let selectedOption = $('#sender_id').find('option:selected');
        let receiverId = selectedOption.val();
        let formData = new FormData($('#add_client_shipments')[0]);

        $.ajax({
            url: `/branch/shipment/update-sender/${senderId}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#AddClient').modal('hide');
                    $(`#box_sender_id${response.index} option[value="${senderId}"]`).remove();
                    $(`#box_sender_id${response.index}`).append(
                        `<option value="${senderId}" 
                            data-identification_type="${response.data.identification_type}"
                            data-identification_number="${response.data.identification_number}"
                            data-name="${response.data.name}"
                            data-email="${response.data.email}"
                            data-phone="${response.data.phone}"
                            data-address="${response.data.address}"
                            data-whatsapp_number="${response.data.whatsapp_number}"
                            data-country_code_phone="${response.data.country_code_phone}"
                            data-country_code_whatsapp="${response.data.country_code_whatsapp}"> 
                            ${response.data.name.toUpperCase()} - ${response.data.phone}</option>`
                    );
                    $(`#box_sender_id${sender.index}`).val(senderId);
                } else {
                    alert('Failed to update sender details.');
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });
});







        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Check if the term matches the 'data-phone' or 'data-whatsapp' attributes
            if (data.element) {
                var phone = $(data.element).data('phone') ? $(data.element).data('phone').toString().toLowerCase() : '';
                var whatsapp = $(data.element).data('whatsapp') ? $(data.element).data('whatsapp').toString().toLowerCase() : '';

                var term = params.term.toLowerCase();

                if (phone.indexOf(term) > -1 || whatsapp.indexOf(term) > -1) {
                    return data;
                }
            }

            // Check if the term matches the text
            if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                return data;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $('#sender_id').select2({
            placeholder: "Select a sender",
            allowClear: true,
            matcher: matchCustom
        });

        $('#receiver_id').select2({
            placeholder: "Select a sender",
            allowClear: true,
            matcher: matchCustom
        });


        $(document).ready(function() {
        // Initialize select2 for Sender
        $('#box_sender_id{{$i+1}}').select2({
            placeholder: "Select a sender", // Placeholder text
            allowClear: true,  // Allow clearing of selection
            matcher: matchCustom  // Custom matching function (ensure it's defined elsewhere)
        });

        // Initialize select2 for Receiver
        $('#box_receiver_id{{$i+1}}').select2({
            placeholder: "Select a receiver",  // Change placeholder to reflect 'receiver'
            allowClear: true,  // Allow clearing of selection
            matcher: matchCustom  // Custom matching function (ensure it's defined elsewhere)
        });
    });
    




    $(document).ready(function () {
    $('#AddReceiver').click(function () {
        $('#AddClient .modal-title').text("Add Receiver");
        $('#clientType').val("receiver");
        $('.id_no label').text("Receiver ID");
        $('.id_type label').text("Receiver Identification Type");

        $('#state_id').html('');
        <?php foreach ($previous_receiver_state as $key => $value) { ?>
            $('#state_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
        <?php } ?>

        $('#city_id').html('');
        <?php foreach ($previous_receiver_city as $key => $value) { ?>
            $('#city_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
        <?php } ?>

        $("#phone").attr("maxlength", <?=$prev_receiver_phon_length->phone_no_length?>);
        $("#whatsapp_number").attr("maxlength", <?=$prev_receiver_phon_length->phone_no_length?>);

        $('#AddClient').modal('show');
    });

    $('#EditReceiver').click(function () {
        const selectedOption = $('#receiver_id').find('option:selected');
        const receiverId = selectedOption.val();

        if (receiverId) {
            $('#AddClient .modal-title').text("Edit Receiver");
            $('#receiverId').val(receiverId);
            $('#save_data_user').hide();
            $('#update_data_receiver').show();

            // Populate fields for editing (replace with your logic)
            populateFieldsForEditReceiver(selectedOption);

            $('#AddClient').modal('show');
        } else {
            alert('Please select a receiver to edit.');
        }
    });
});

function populateFieldsForEditReceiver(selectedOption) {
    // Replace this with logic to populate fields with data from the selected receiver
    console.log("Populating fields for editing receiver:", selectedOption);
}







    const grand_total = document.querySelector('input[name="grand_total_weight"]');
    const rate_normal_weight = document.querySelector('input[name="rate_normal_weight"]');
    const amount_normal_weight = document.querySelector('input[name="amount_normal_weight"]');

    const rate_electronics_weight = document.querySelector('input[name="rate_electronics_weight"]');
    const amount_electronics_weight = document.querySelector('input[name="amount_electronics_weight"]');

    const msic = document.querySelector('input[name="msic_weight"]');
    const rate_msic_weight = document.querySelector('input[name="rate_msic_weight"]');
    const amount_msic_weight = document.querySelector('input[name="amount_msic_weight"]');

    const add_pack_charge = document.querySelector('input[name="add_pack_charge"]');
    const rate_add_pack_charge = document.querySelector('input[name="rate_add_pack_charge"]');
    const amount_add_pack_charge = document.querySelector('input[name="amount_add_pack_charge"]');

    const insurance = document.querySelector('input[name="insurance"]');
    const rate_insurance = document.querySelector('input[name="rate_insurance"]');
    const amount_insurance = document.querySelector('input[name="amount_insurance"]');

    const awbfee = document.querySelector('input[name="awbfee"]');
    const rate_awbfee = document.querySelector('input[name="rate_awbfee"]');
    const amount_awbfee = document.querySelector('input[name="amount_awbfee"]');

    const vat_amount = document.querySelector('input[name="vat_amount"]');
    const rate_vat_amount = document.querySelector('input[name="rate_vat_amount"]');
    const amount_vat_amount = document.querySelector('input[name="amount_vat_amount"]');

    const volume_weight = document.querySelector('input[name="volume_weight"]');
    const rate_volume_weight = document.querySelector('input[name="rate_volume_weight"]');
    const amount_volume_weight = document.querySelector('input[name="amount_volume_weight"]');

    const discount_weight = document.querySelector('input[name="discount_weight"]');
    const rate_discount_weight = document.querySelector('input[name="rate_discount_weight"]');
    const amount_discount_weight = document.querySelector('input[name="amount_discount_weight"]');

    const normal_weight = document.querySelector('input[name="normal_weight"]');

    const grand_total_weight = document.querySelector('input[name="grand_total_weight"]');
    const electronics_weight = document.querySelector('input[name="electronics_weight"]');
    const msic_weight = document.querySelector('input[name="msic_weight"]');

    const amount_grand_total = document.querySelector('input[name="amount_grand_total"]');



    function multiplyAddPackCharge() {
        const val1 = parseFloat(add_pack_charge.value);
        const val2 = parseFloat(rate_add_pack_charge.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_add_pack_charge.value =result.toFixed(0);
            }
            else{
                amount_add_pack_charge.value =result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyInsurance() {
        const val1 = parseFloat(insurance.value);
        const val2 = parseFloat(rate_insurance.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_insurance.value =result.toFixed(0);
            }
            else{
                amount_insurance.value =result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyVolume() {
        const val1 = parseFloat(volume_weight.value);
        const val2 = parseFloat(rate_volume_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_volume_weight.value =result.toFixed(0);
            }
            else{
                amount_volume_weight.value =result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyAwbFee() {
        const val1 = parseFloat(awbfee.value);
        const val2 = parseFloat(rate_awbfee.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_awbfee.value =result.toFixed(0);
            }
            else{
                amount_awbfee.value = result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyVatAmount() {
        const val1 = parseFloat(vat_amount.value);
        const val2 = parseFloat(rate_vat_amount.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_vat_amount.value =result.toFixed(0);
            }
            else{
                amount_vat_amount.value =result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyDiscount() {
        const val1 = parseFloat(discount_weight.value);
        const val2 = parseFloat(rate_discount_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_discount_weight.value =result.toFixed(0);
            }
            else{
                amount_discount_weight.value = result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyDuty() {
        const val1 = parseFloat(electronics_weight.value);
        const val2 = parseFloat(rate_electronics_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_electronics_weight.value =result.toFixed(0);
            }
            else{
                amount_electronics_weight.value = result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }

    function multiplyPackingCharge() {
        const val1 = parseFloat(msic_weight.value);
        const val2 = parseFloat(rate_msic_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_msic_weight.value =result.toFixed(0);
            }
            else{
                amount_msic_weight.value = result.toFixed(2);
            }
        } else {
            result.value = '';
        }
    }
    function totalQuantity() {
        // const val1 = parseFloat(amount_normal_weight.value) || 0;
        // const val2 = parseFloat(amount_electronics_weight.value) || 0;
        // const val3 = parseFloat(amount_msic_weight.value) || 0;


        // const val1 = parseFloat(insurance.value) || 0;
        // const val2 = parseFloat(volume_weight.value) || 0;
        // const val3 = parseFloat(awbfee.value) || 0;
        // const val4 = parseFloat(vat_amount.value) || 0;
        // const val5 = parseFloat(grand_total_weight.value) || 0;
        // const val6 = parseFloat(electronics_weight.value) || 0;
        // const val7 = parseFloat(msic_weight.value) || 0;
        // const val8 = parseFloat(amount_discount_weight.value) || 0;
        // const val9 = parseFloat(amount_add_pack_charge.value) || 0;


        // if ([val1, val2, val3, val4, val5, val6, val7,val9 ].every(val => !isNaN(val))) {
        //     var result = val1 + val2 + val3 + val4 + val5 + val6 + val7 + val9;
        //     var grant_tot = result - val8;
        //     console.log(result);
        //     console.log(grant_tot);
        //     amount_grand_total.value = grant_tot.toFixed(2);
        // }



        const val1 = parseFloat(amount_normal_weight.value) || 0;
        const val2 = parseFloat(amount_electronics_weight.value) || 0;
        const val3 = parseFloat(amount_msic_weight.value) || 0;
        const val4 = parseFloat(amount_insurance.value) || 0;
        const val5 = parseFloat(amount_awbfee.value) || 0;
        const val6 = parseFloat(amount_vat_amount.value) || 0;
        const val7 = parseFloat(amount_volume_weight.value) || 0;
        const val8 = parseFloat(amount_discount_weight.value) || 0;
        const val9 = parseFloat(amount_add_pack_charge.value) || 0;


        if ([val1, val2, val3, val4, val5, val6, val7,val9].every(val => !isNaN(val))) {
            var result = val1 + val2 + val3 + val4 + val5 + val6 + val7 + val9;
            var grant_tot = result - val8;
            amount_grand_total.value = grant_tot.toFixed(2);
        }

    }

    // function totalQuantityss() {
    //     const val1 = parseFloat(amount_normal_weight.value) || 0;
    //     const val2 = parseFloat(amount_electronics_weight.value) || 0;
    //     const val3 = parseFloat(amount_msic_weight.value) || 0;an serve

    //     const val4 = parseFloat(amount_insurance.value) || 0;
    //     const val5 = parseFloat(amount_awbfee.value) || 0;
    //     const val6 = parseFloat(amount_vat_amount.value) || 0;
    //     const val7 = parseFloat(amount_volume_weight.value) || 0;
    //     const val8 = parseFloat(amount_discount_weight.value) || 0;


    //     if ([val1, val2, val3, val4, val5, val6, val7].every(val => !isNaN(val))) {
    //         var result = val1 + val2 + val3 + val4 + val5 + val6 + val7;
    //         var grant_tot = result - val8;
    //         amount_grand_total.value = grant_tot.toFixed(2);
    //     }
    // }

    // function discountQuantity() {
    //     totalQuantityss()
    //     const val1 = parseFloat(amount_discount_weight.value) || 0;
    //     const total = parseFloat(amount_grand_total.value) || 0;
    //     if (!isNaN(val1)) {
    //         var result = total - val1;
    //         // amount_grand_total.value = result.toFixed(2);
    //     }
    // }
    electronics_weight.addEventListener('input', multiplyDuty);
    rate_electronics_weight.addEventListener('input', multiplyDuty);

    msic_weight.addEventListener('input', multiplyPackingCharge);
    rate_msic_weight.addEventListener('input', multiplyPackingCharge);

    insurance.addEventListener('input', multiplyInsurance);
    rate_insurance.addEventListener('input', multiplyInsurance);

    volume_weight.addEventListener('input', multiplyVolume);
    rate_volume_weight.addEventListener('input', multiplyVolume);

    awbfee.addEventListener('input', multiplyAwbFee);
    rate_awbfee.addEventListener('input', multiplyAwbFee);

    vat_amount.addEventListener('input', multiplyVatAmount);
    rate_vat_amount.addEventListener('input', multiplyVatAmount);

    discount_weight.addEventListener('input', multiplyDiscount);
    rate_discount_weight.addEventListener('input', multiplyDiscount);

    add_pack_charge.addEventListener('input', multiplyAddPackCharge);
    rate_add_pack_charge.addEventListener('input', multiplyAddPackCharge);

    insurance.addEventListener('input', totalQuantity);
    volume_weight.addEventListener('input', totalQuantity);
    awbfee.addEventListener('input', totalQuantity);
    vat_amount.addEventListener('input', totalQuantity);
    grand_total_weight.addEventListener('input', totalQuantity);
    electronics_weight.addEventListener('input', totalQuantity);
    msic_weight.addEventListener('input', totalQuantity);
    add_pack_charge.addEventListener('input', totalQuantity);



    amount_normal_weight.addEventListener('input', totalQuantity);
    amount_electronics_weight.addEventListener('input', totalQuantity);
    amount_msic_weight.addEventListener('input', totalQuantity);
    amount_insurance.addEventListener('input', totalQuantity);
    amount_awbfee.addEventListener('input', totalQuantity);
    amount_vat_amount.addEventListener('input', totalQuantity);
    amount_volume_weight.addEventListener('input', totalQuantity);
    amount_add_pack_charge.addEventListener('input', totalQuantity);

    rate_normal_weight.addEventListener('input', totalQuantity);
    rate_electronics_weight.addEventListener('input', totalQuantity);
    rate_msic_weight.addEventListener('input', totalQuantity);
    rate_insurance.addEventListener('input', totalQuantity);
    rate_volume_weight.addEventListener('input', totalQuantity);
    rate_awbfee.addEventListener('input', totalQuantity);
    rate_vat_amount.addEventListener('input', totalQuantity);
    rate_add_pack_charge.addEventListener('input', totalQuantity);

    discount_weight.addEventListener('input', totalQuantity);
    rate_discount_weight.addEventListener('input', totalQuantity);
    amount_discount_weight.addEventListener('input', totalQuantity);

    $(document).ready(function() {
        totalQuantity();
        $('#edititemsstore').on('submit', function(event) {
            totalQuantity();
        });
    });

});


$(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });

    $('input.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 1,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });



});



$("#saveDraft").on('click',function(e){
    e.preventDefault();

        $.ajax({
                url: `{{ route('branch.shipment.saveAsDraft') }}`,
                type: "GET",
                data:  $("#edititemsstore").serialize(),
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                        toastr.success( result );
                    },
                error:function(error){
                        console.log(error)
                        alert("not send");
                    }
        });

});







        $(function () {
                var no_of_pcs = $('#number_of_pcs').val();
                if(no_of_pcs == 0){
                    count = 0;
                } else {
                    count = parseInt(no_of_pcs);
                    $("#total-package").css({'display':'block'});
                    $("#TotalDiv").css({'display':'block'});
                }

                addItems(count);
                getValOther();

                document.getElementById("edititemsstore").onkeypress = function(e) {
                    alert('hello');
                    var key = e.charCode || e.keyCode || 0;
                    if (key == 13) {

                        e.preventDefault();
                    }
                    else {
                        addItems(count);
                    }
                }

                $(document).ready(function () {
                    $('.select2').select2();
                        addremoveClass();
                    })


            });




            $('#addBox').on('click', function () {
                var no_of_box = parseInt($('#number_of_pcs').val());
                if( no_of_box == 0 ){
                    count = 0;
                    $('#total-package').css({'display':'block'});

                    // $("input[name='msic_weight']").val('');
                    $("input[name='normal_weight']").val('');
                    // $("input[name='grand_total_weight']").val('');
                    $("input[name='grand_total_box_value']").val('');
                    $("input[name='total_freight']").val('');
                    $("input[name='misc_freight']").val('');
                    $("input[name='packing_charge']").val('');
                    $("input[name='grand_total']").val('');

                }

                count = no_of_box + 1;
                var number_of_pcs =count;
                 $('#number_of_pcs').val(count);

                for (i = 0; i <1; i++) {

                       var myClone =  $('#newBoxContainer').clone().attr('id', 'newBoxContainer'+ count);

                        var k =  count;
                        var j =  count;

                        myClone.find('#newBoxContainer').attr('id','newBoxContainer'+k);
                        myClone.find('.box-length').attr('name','length'+k);
                        myClone.find('.box-height').attr('name','height'+k);
                        myClone.find('.box-width').attr('name','width'+k);
                        myClone.find('.box-dimension').attr('name','dimension'+k);
                        myClone.find('.box-dimension').attr('data-no',k);
                        myClone.find('.box-unit-value').attr('name','unit_value'+k);
                        myClone.find('.box-weight1').attr('data-weight', k);
                        myClone.find('.box-weight1').attr('name','weight'+ k);
                        myClone.find('.box-weight1').attr('class', 'form-control box-weight');

                        myClone.find('.receiver_name_1').attr('name','receiver_name'+ k);
                        myClone.find('.receiver_address_1').attr('name','receiver_address'+ k);
                        myClone.find('.receiver_mob_1').attr('name','receiver_mob'+ k);
                        myClone.find('.receiver_id_no_1').attr('name','receiver_id_no'+ k);
                        myClone.find('.receiver_id_type').attr('name','receiver_id_type'+ k);
                        myClone.find('.sender_id_type').attr('name','sender_id_type'+ k);
                        myClone.find('.sender_pin_1').attr('name','sender_pin'+ k);
                        myClone.find('.receiver_pin_1').attr('name','receiver_pin'+ k);

                        myClone.find('.sender_id_img_1').attr('name','sender_id_image'+ k + '[]');
                        myClone.find('.receiver_id_img_1').attr('name','receiver_id_image'+ k + '[]');

                        myClone.find('.sender_name_1').attr('name','sender_name'+ k);
                        myClone.find('.sender_address_1').attr('name','sender_address'+ k);
                        myClone.find('.sender_mob_1').attr('name','sender_mob'+ k);
                        myClone.find('.sender_id_no_1').attr('name','sender_id_no'+ k);
                        myClone.find('.sender_id_type').attr('name','sender_id_type'+ k);

                        myClone.find('.oldBoxNo').attr('class','form-control col-3 oldBoxNo'+ k);
                        myClone.find('#noBoxFound').attr('id','noBoxFound'+ k);
                        myClone.find('.oldBoxFill').attr('data-boxId', k);
                        myClone.find('.oldBoxFill').attr('class','btn btn-primary fillAdress col-1 ml-2 oldBoxFill'+ k);

                        myClone.find('#box_sender_id').attr('name','box_sender_id'+ k);
                        myClone.find('#box_receiver_id').attr('name','box_receiver_id'+ k);

                        myClone.find('.box-rate1').attr('data-rate', k);
                        myClone.find('.box-rate1').attr('name','rate'+ k);
                        myClone.find('.box-rate1').attr('class', 'form-control box-rate');

                        myClone.find('.box-packing').attr('data-packing', k);
                        myClone.find('.box-packing').attr('data-no', k);
                        myClone.find('.box-packing').attr('name','packing'+ k);
                        myClone.find('.box-packing').attr('class', 'form-control box-packing');
                        myClone.find('#packing').attr('id', 'packing'+k);


                        myClone.find('#selectVolume').attr('id', 'selectVolume'+k);

                        myClone.find('#box_packing_charge').attr('id', 'box_packing_charge'+k);
                        myClone.find('.box_packing_charge').attr('data-no', k);
                        myClone.find('.box_packing_charge').attr('name','box_packing_charge'+ k);
                        myClone.find('.box_packing_charge').attr('class', 'form-control box_packing_charge');


                        myClone.find('.box-unit-value').attr('data-unit-value', k);
                        myClone.find('.box-total-value').attr('name','total_value'+k);
                        // myClone.find('.volume').attr('data-volume', k);
                        myClone.find('.volume').attr('name','volume'+ k);
                        myClone.find('.volume').attr('data-no',k);

                        myClone.find('#other_length').attr('id', 'other_length'+k);
                        myClone.find('.other_length').attr('name','other_length'+ k);
                        myClone.find('.other_length').attr('data-no',k);


                        myClone.find('#other_width').attr('id', 'other_width'+k);
                        myClone.find('.other_width').attr('name','other_width'+ k);
                        myClone.find('.other_width').attr('data-no',k);

                        myClone.find('#other_height').attr('id', 'other_height'+k);
                        myClone.find('.other_height').attr('name','other_height'+ k);
                        myClone.find('.other_height').attr('data-no',k);

                        myClone.find('#other_select').attr('id', 'other_select'+k);
                        myClone.find('.other_select').attr('name','other_select'+ k);
                        myClone.find('.other_select').attr('data-no',k);

                        var myName = $(this).text();
                        const booking_number = document.querySelector('input[name="booking_number"]');
                        myClone.find('.packageinfo-head1').text('Box - '+j+ booking_number.value );
                        myClone.find('.packageinfo-head1').attr('data-myattri', j);
                        myClone.find('.packageinfo-head1').attr('class', 'packageinfo-head');

                        myClone.find('.box_name1').val(j+ booking_number.value );
                        myClone.find('.box_name1').attr('data-myattri', j);
                        myClone.find('.box_name1').attr('name', 'box_name'+k);
                        myClone.find('.box_name1').attr('class', 'box_name');



                        myClone.find('#addpackage').attr('data-myattri', j);
                        myClone.find('#addpackage').attr('id', 'addpackage'+j);
                        console.log(j);
                        console.log(k);
                        myClone.find('#removeBox').attr('data-myattri', j);
                        myClone.find('#removeBox').attr('id', 'removeBox'+j);
                        myClone.find('#additems').attr('id', 'additems'+j);
                        myClone.find('#packageinfo').attr('id', 'packageinfo'+j);
                        myClone.find('.packageinfo').attr('class', 'table table-bordered packageinfo'+j);
                        myClone.find('input[name="description[]"]').attr('name', 'description'+j+'[]');
                        myClone.find('input[name="qty[]"]').attr('name', 'qty'+j+'[]');
                        myClone.find('input[name="unit[]"]').attr('name', 'unit'+j+'[]');
                        myClone.find('input[name="unit'+j+'[]"]').attr('data-myAttri', j);
                        myClone.find('input[name="subtotal[]"]').attr('name', 'subtotal'+j+'[]');
                        myClone.find('button[name="remove[]"]').attr('data-remove', j);
                        myClone.find('button[name="remove[]"]').attr('data-myAttri', j);
                        myClone.find('#totalAmt').attr('id', 'totalAmt'+j);
                        myClone.find('#totalqty').attr('id', 'totalqty'+j);
                        // myClone.find('.box_name').attr('value', '<?=branch()->branch_code?branch()->branch_code:''?>' + j+<?=$bookingNum?>);

                        myClone.clone().appendTo("#Container");
                        // myClone.clone().prependTo("#Container");
                        // myClone.clone().prependTo("#Container").find('input:visible:enabled:first').focus();
                        updateBoxName(j, <?=$bookingNum?>);
                }

                    $("#shiping_method").trigger("change");


                if(number_of_pcs > 0) {
                    $("#TotalDiv").css({'display':'block'});
                    $("#total-package").css({'display':'block'});
                    addItems( count);
                    // inputChange();
                    addremoveClass();

                }

                $(".tot_wgt, .tot_rate, .tot_amt").trigger("input");




            });



            function updateBoxName(count, bookingNumber ){

                const booking_number = document.querySelector('input[name="booking_number"]');

                // $(".box_name"+i+1).each(function (boxnum) {

                //     var boxnum= boxnum+1;
                //     console.log(''+ boxnum + booking_number.value);
                //     $(this).val(''+ boxnum + booking_number.value);

                // });


                // $(".packageinfo-head").each(function (index) {
                //     var index =  $(".packageinfo-head").length -index;
                //     // var index= index-1;
                //     $(this).text('Box - '+ index + booking_number.value );


                // });

                $(".box_name").each(function (boxnum) {
                    var no_of_box = parseInt($('#number_of_pcs').val());
                    var boxnum= boxnum+1;
                   
                  //  $(this).val(''+ boxnum + booking_number.value);
                  $(this).val(''+ booking_number.value+'-'+ boxnum +'/'+no_of_box);
                    $(this).attr('name', `box_name${boxnum}`);


                });

                $(".packageinfo-head").each(function (index) {
                    var no_of_box = parseInt($('#number_of_pcs').val());
                    var index= index+1;
                    $(this).text('Box - '+ booking_number.value +' - '  + index +'/'+ no_of_box );
                });


                $(".sender_name").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_name${index}`);
                });

                $(".sender_address").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_address${index}`);
                });

                $(".sender_pin").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_pin${index}`);
                });

                $(".sender_mob").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_mob${index}`);
                });

                $(".sender_id_no").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_id_no${index}`);
                    $(this).attr('data-index', `${index}`);
                });

                $(".sender_id_image_value").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_id_image_value${index}`);
                });

                $(".sender_id_image").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_id_image${index}`);
                });






                $(".receiver_name").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_name${index}`);
                });

                $(".receiver_address").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_address${index}`);
                });

                $(".receiver_pin").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_pin${index}`);
                });

                $(".receiver_mob").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_mob${index}`);
                });

                $(".receiver_id_no").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_id_no${index}`);
                    $(this).attr('data-index', `${index}`)
                });

                $(".sender_id_type").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `sender_id_type${index}`);
                });

                $(".receiver_id_image_value").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_id_image_value${index}`);
                });

                $(".receiver_id_image").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `receiver_id_image${index}`);
                });

                $(".weight").each(function (index) {
                    var index= index+1;
                    $(this).attr('name', `weight${index}`);
                });




                $(".boxcount").each(function (index) {
                    var index= index+1;

                    $(this).find(".descriptions").each(function() {
                         $(this).attr("name", `description${index}[]`);
                    });

                    $(this).find(".qty").each(function() {
                         $(this).attr("name", `qty${index}[]`);
                    });

                    $(this).find(".unit").each(function() {
                         $(this).attr("name", `unit${index}[]`);
                    });

                    $(this).find(".pkg-subtotal").each(function() {
                         $(this).attr("name", `subtotal${index}[]`);
                    });
                });

            }



            $('#sender_id').on('change', function () {
                var address = $(this).find(":selected").data('address');
                var phone = $(this).find(":selected").data('phone');
                $("#sender_address").val(address);
                $("#sender_phone").val(phone);
     
            });
            $('#receiver_id').on('change', function () {
                var address = $(this).find(":selected").data('address');
                var phone = $(this).find(":selected").data('phone');
                $("#receiver_address").val(address);
                $("#receiver_phone").val(phone);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            $(document).ready(function() {
    // Event listener for change on box_sender_id dropdown
    $('#box_sender_id{{$i+1}}').on('change', function () {
        var selectedSenderId = $(this).val();  // Get the selected sender ID

        if (!selectedSenderId) {
            return; // If no sender is selected, exit early
        }

        // Log the selected sender ID for debugging
        console.log("Selected Sender ID: " + selectedSenderId);

        $.ajax({
            url: '/sender-details',  // Make sure this matches your route in web.php
            method: 'GET',
            data: { sender_id: selectedSenderId },
            success: function(response) {
                console.log(response);  // Debug the response
                if (response.status === 'success') {
                    // Update address and phone input fields with the data from the response
                    $("#sender_address").val(response.data.address);
                    $("#sender_phone").val(response.data.phone);

                    // Optionally, change background color to indicate the change
                    $("#sender_address").css('background-color', '#FFFFE0');
                    $("#sender_phone").css('background-color', '#FFFFE0');
                } else {
                    alert('Sender data not found!');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + ", " + error);
                alert('An error occurred while fetching the sender data.');
            }
        });
    });
});

         



       
             $('#AddSender').click(function () {

                $('#AddClient h4.modal-title').text("Add Sender");
                $('#AddClient #clientType').val("sender");
                $('.id_no label').text("Sender Id");
                $('.id_type label').text("Sender Identification Type");
                // $("select[name='client_identification_type']").val('<?=$previous_sender->identification_type?>');
                $("select[name='country_id']").val(<?=$previous_sender->address->country_id?>);
                console.log(<?=$previous_sender->address->country_id?>);
                $('#state_id').html('');
                <?php foreach ($previous_sender_state as $key => $value) { ?>
                      $('#state_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
                <?php } ?>

                $('#city_id').html('');
                <?php foreach ($previous_sender_city as $key => $value) { ?>
                      $('#city_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
                <?php } ?>


                $("#phone").attr("maxlength", <?=$prev_sender_phon_length->phone_no_length?>);
                $("#whatsapp_number").attr("maxlength", <?=$prev_sender_phon_length->phone_no_length?>);

                $("#phone").attr("placeholder", "Enter "+<?=$prev_sender_phon_length->phone_no_length?$prev_sender_phon_length->phone_no_length:'-'?>+" digits");
                $("#whatsapp_number").attr("placeholder", "Enter "+<?=$prev_sender_phon_length->phone_no_length?$prev_sender_phon_length->phone_no_length:'-'?>+" digits");

                $("select[name='state_id']").val(<?=$previous_sender->address->state_id?>);
                $("select[name='city_id']").val(<?=$previous_sender->address->city_id?>);
                $("select[name='country_code_whatsapp']").val(<?=$previous_sender->country_code_whatsapp?>);
                $("select[name='country_code_phone']").val(<?=$previous_sender->country_code_phone?>);

                $('#mobile2').text("Whatsapp");

                $('#AddClient').modal('show');

            });
            $('#EditSender').click(function () {
        var selectedOption = $('#sender_id').find('option:selected');
        var senderId = selectedOption.val();
        isEditMode = true;
       // alert(senderId);
        if (senderId) {
            $('#AddClient .modal-title').text("Edit Sender");
            $('#sender_id_input').val(senderId); // Set ID field for editing
            $('#AddClient').modal('show');
            $('#save_data_user').hide();
            $('#update_data_receiver').hide();
            $('#update_data_user').show();
           
            // Populate fields with selected receiver data
            populateFieldsForEdit(selectedOption);
        } else {
            alert('Please select a sender to edit.');
        }


                    // JavaScript code to dynamically enable/disable the forward button
            document.addEventListener('DOMContentLoaded', () => {
                const forwardButton = document.getElementById('forwardButton');

                // Check initial history length and update button state
                updateForwardButtonState();

                // Listen for history changes and update button state accordingly
                window.addEventListener('popstate', () => {
                    updateForwardButtonState();
                });
            });

            function updateForwardButtonState() {
                const forwardButton = document.getElementById('forwardButton');
                forwardButton.disabled = history.length <= 1;
            }
    });
      // Function to populate fields for Edit
      function populateFieldsForEdit(option) {
        $('#name').val(option.data('name'));
        $('#email').val(option.data('email'));
        $('#phone').val(option.data('phone'));
        $('#address').val(option.data('address'));
        $('#whatsapp_number').val(option.data('whatsapp_number'));
       // $('#country_id').val(option.data('country_id'));
        //$('#state_id').val(option.data('state_id'));
        //$('#district_id').val(option.data('district_id'));
        $('#cities').val(option.data('cities'));
        $('#post').val(option.data('post'));
        $('#zip_code').val(option.data('zip_code'));
        $('#country_code_phone').val(option.data('country_code_phone'));
        $('#country_code_whatsapp').val(option.data('country_code_whatsapp'));
        $('#client_identification_type').val(option.data('identification_type'));
        $('#client_identification_number').val(option.data('identification_number'));
     $('#country_id').val(option.data('country_id')).trigger('change'); // Trigger change to load states
     $('#state_id').val(option.data('state_id')).trigger('change'); 
     $('#district_id').val(option.data('district_id')).trigger('change');
   
            }
            $('#update_data_user').click(function () {
    var selectedOption = $('#sender_id').find('option:selected');
    var senderId = selectedOption.val();
    var formData = new FormData($('#add_client_shipments')[0]); // Collect form data

    $.ajax({
        url: '/branch/shipment/update-sender/' + senderId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token header
        },
        success: function(response) {
            if (response.success) {
                // Hide the modal
                $('#AddClient').modal('hide');

                // Log the response to see if data is coming as expected
                console.log(response.data);

                // Remove the existing option and add a new one
                $('#sender_id option[value="' + senderId + '"]').remove();
                $('#sender_id').append(
                    '<option value="' + senderId + '" ' +
                    'data-identification_type="' + response.data.identification_type + '" ' +
                    'data-identification_number="' + response.data.identification_number + '" ' +
                    'data-name="' + response.data.name + '" ' +
                    'data-email="' + response.data.email + '" ' +
                    'data-phone="' + response.data.phone + '" ' +
                    'data-address="' + response.data.address + '" ' +
                    'data-whatsapp_number="' + response.data.whatsapp_number + '" ' +
                    'data-country_code_phone="' + response.data.country_code_phone + '" ' +
                    'data-country_code_whatsapp="' + response.data.country_code_whatsapp + '" ' +
                    'data-country_id="' + response.data.country_id + '" ' +
                    'data-state_id="' + response.data.state_id + '" ' +
                    'data-district_id="' + response.data.district_id + '" ' +
                    'data-city_id="' + response.data.city_id + '" ' +
                    'data-zip_code="' + response.data.zip_code + '">' +
                    response.data.name.toUpperCase() + ' - ' + response.data.phone +
                    '</option>'
                );

                // Set the updated option as selected
                $('#sender_id').val(senderId);
                 // Update the readonly fields with the new data
                 $('#sender_address').val(response.data.address);
                $('#sender_phone').val(response.data.phone);
            } else {
                alert('Failed to update sender details.');
            }
        },
        error: function(xhr) {
            alert('Failed to update sender details.');
        }
    });
});

            $('#AddReceiver').click(function () {
                $('#AddClient h4.modal-title').text("Add Receiver <?=$previous_receiver->address->state_id?>");
                $('#AddClient #clientType').val("receiver");
                $('.id_no label').text("Receiver Id");
                $('.id_type label').text("Receiver Identification Type");
                // $("select[name='client_identification_type']").val('<?=$previous_receiver->identification_type?>');
                $("select[name='country_id']").val(<?=$previous_receiver->address->country_id?>);
                $('#state_id').html('');
                <?php foreach ($previous_receiver_state as $key => $value) { ?>
                      $('#state_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
                <?php } ?>

                $('#city_id').html('');
                <?php foreach ($previous_receiver_city as $key => $value) { ?>
                      $('#city_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
                <?php } ?>


                $("#phone").attr("maxlength", <?=$prev_receiver_phon_length->phone_no_length?>);
                $("#whatsapp_number").attr("maxlength", <?=$prev_receiver_phon_length->phone_no_length?>);

                $("#phone").attr("placeholder", "Enter "+<?=$prev_receiver_phon_length->phone_no_length?$prev_receiver_phon_length->phone_no_length:'-'?>+" digits");
                $("#whatsapp_number").attr("placeholder", "Enter "+<?=$prev_receiver_phon_length->phone_no_length?$prev_receiver_phon_length->phone_no_length:'-'?>+" digits");

                $("select[name='state_id']").val(<?=$previous_receiver->address->state_id?>);
                $("select[name='city_id']").val(<?=$previous_receiver->address->city_id?>);
                $("select[name='country_code_whatsapp']").val(<?=$previous_receiver->country_code_whatsapp?>);
                $("select[name='country_code_phone']").val(<?=$previous_receiver->country_code_phone?>);


                $('#AddClient').modal('show');

                 $('#mobile2').text("Mobile 2");

                $('#AddClient').modal('show');
                $('#country_id').trigger('change');
            });

      // Update receiver
      $('#EditReceiver').click(function () {
        var selectedOption = $('#receiver_id').find('option:selected');
        var receiverId = selectedOption.val();
        isEditMode = true;
       // alert(senderId);
        if (receiverId) {
            $('#AddClient .modal-title').text("Edit Receiver");
            $('#sender_id_input').val(receiverId); // Set ID field for editing
            $('#AddClient').modal('show');
            $('#save_data_user').hide();
            $('#update_data_receiver').show();
            $('#update_data_user').hide();
           
            // Populate fields with selected receiver data
            populateFieldsForEditReceiver(selectedOption);
        } else {
            alert('Please select a receiver to edit.');
        }
    });
    function populateFieldsForEditReceiver(option) {
        $('#name').val(option.data('name'));
        $('#email').val(option.data('email'));
        $('#phone').val(option.data('phone'));
        $('#address').val(option.data('address'));
        $('#whatsapp_number').val(option.data('whatsapp_number'));
        $('#country_id').val(option.data('country_id'));
        $('#state_id').val(option.data('state_id'));
        $('#district_id').val(option.data('district_id'));
        $('#cities').val(option.data('cities'));
        $('#post').val(option.data('post'));
        $('#zip_code').val(option.data('zip_code'));
        $('#country_code_phone').val(option.data('country_code_phone'));
        $('#country_code_whatsapp').val(option.data('country_code_whatsapp'));
        $('#client_identification_type').val(option.data('identification_type'));
        $('#client_identification_number').val(option.data('identification_number'));
    }
    $('#update_data_receiver').click(function () {
    var selectedOption = $('#receiver_id').find('option:selected');
    var receiverId = selectedOption.val();
    var formData = new FormData($('#add_client_shipments')[0]); // Collect form data

    $.ajax({
        url: '/branch/shipment/update-receiver/' + receiverId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token header
        },
        success: function(response) {
            if (response.success) {
                // Hide the modal
                $('#AddClient').modal('hide');

                // Log the response to see if data is coming as expected
                console.log(response.data);

                // Remove the existing option and add a new one
                $('#receiver_id option[value="' + receiverId + '"]').remove();
                $('#receiver_id').append(
                    '<option value="' + receiverId + '" ' +
                    'data-identification_type="' + response.data.identification_type + '" ' +
                    'data-identification_number="' + response.data.identification_number + '" ' +
                    'data-name="' + response.data.name + '" ' +
                    'data-email="' + response.data.email + '" ' +
                    'data-phone="' + response.data.phone + '" ' +
                    'data-address="' + response.data.address + '" ' +
                    'data-whatsapp_number="' + response.data.whatsapp_number + '" ' +
                    'data-country_code_phone="' + response.data.country_code_phone + '" ' +
                    'data-country_code_whatsapp="' + response.data.country_code_whatsapp + '" ' +
                    'data-country_id="' + response.data.country_id + '" ' +
                    'data-state_id="' + response.data.state_id + '" ' +
                    'data-district_id="' + response.data.district_id + '" ' +
                    'data-city_id="' + response.data.city_id + '" ' +
                    'data-zip_code="' + response.data.zip_code + '">' +
                    response.data.name.toUpperCase() + ' - ' + response.data.phone +
                    '</option>'
                );

                // Set the updated option as selected
                $('#receiver_id').val(receiverId);
                 // Update the readonly fields with the new data
                 $('#receiver_address').val(response.data.address);
                $('#receiver_phone').val(response.data.phone);
            } else {
                alert('Failed to update receiver details.');
            }
        },
        error: function(xhr) {
            alert('Failed to update receiver details.');
        }
    });
});


            $('.modal').on('hidden.bs.modal', function (e) {
                $(this).find("input,textarea,select").val('').end()
                .find("input[type=checkbox], input[type=file], input[type=radio]")
                .prop("checked", "")
                .end();
            })


            var index = 1;

            function addItems(number_of_pcs) {
                for( let i = 1; i <= number_of_pcs; i++) {
                    $(document).on("input", ".unit", function () {
                        $("input[name='unit"+i+"[]']").each(function () {
                            var qty = $(this).parent('td').prev('td').find('input').val()
                            var unit = $(this).val();
                            $(this).parent('td').next('td').find('input').val((qty * unit).toFixed(2));
                            console.log((qty * unit).toFixed(2));
                        });

                        var sum = 0;
                        $("input[name='subtotal"+i+"[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt"+i).text(sum);
                        $("#inp_totalAmt"+i).text(sum);
                    })


                    $(document).on("input", ".qty", function () {
                        var sum = 0;
                        $("input[name='qty"+i+"[]']").each(function () {
                            var qty = $(this).val();
                            var unit = $(this).parent('td').next('td').find('input').val();
                            $(this).closest('tr').find('td:nth-child(5) input').val((qty * unit).toFixed(2));
                            sum += +$(this).val();
                        });
                        $("#totalqty"+i).text(sum);
                        var sum = 0;
                        $("input[name='subtotal"+i+"[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt"+i).text(sum);
                    })
                }

            }


                $(document).on("input", ".box-weight", function () {
                        var sum_value = 0;
                        $('.box-weight').each(function(){
                            sum_value += +$(this).val();
                            $("input[name='normal_weight']").val(sum_value);
                            $("input[name='normal_weight_temp']").val(sum_value);
                            // $("input[name='grand_total_weight']").val(sum_value);
                        })
                        $("input[name='rate_normal_weight']").trigger("keyup");
                        var wgt = $(this).attr("data-weight");
                        var total_weight = parseFloat($("input[name='weight"+wgt+"']").val());
                        var rate = parseFloat($("input[name='rate"+wgt+"']").val());
                        $("input[name='total_value"+wgt+"']").val( (total_weight * rate).toFixed(2));
                        $("input[name='electronics_weight']").trigger("keyup");
                })

                $(document).on("input", ".box-rate", function () {
                        var wgt = $(this).attr("data-rate");
                        var total_weight = parseFloat($("input[name='weight"+wgt+"']").val());
                        var rate = parseFloat($("input[name='rate"+wgt+"']").val());
                        $("input[name='total_value"+wgt+"']").val((total_weight * rate).toFixed(2));
                        $("input[name='electronics_weight']").trigger("keyup");
                })

                $(document).on("input", ".box-unit-value", function () {
                        var wgt = $(this).attr("data-unit-value");
                        var total_weight = parseFloat($("input[name='weight"+wgt+"']").val());
                        var total_unit_value = parseFloat($("input[name='unit_value"+wgt+"']").val());
                })


                $(document).on("input", ".box_packing_charge", function () {
                    var sum_value = 0;
                        $('.box_packing_charge').each(function(){
                            sum_value += +$(this).val();
                            $("input[name='packing_charge']").val(sum_value);
                        })

                        $(".gtotal").trigger("input");
                })



            $(document).on("input", ".gtotal", function () {
                var sum_value = 0;
                $('.gtotal').each(function(){

                    sum_value += +$(this).val();
                    if($("#discount").val() != '') {
                        var discount =  parseFloat($("#discount").val());
                    } else {
                        var discount = 0;
                    }
                    $("input[name='grand_total']").val(parseFloat(sum_value) - discount );

                })
            })


            $(document).on("input", "#discount", function () {
                $(".discount").val( $('#discount').val());
                var sum_value = 0;
                $('.gtotal').each(function(){
                    sum_value += +$(this).val();
                    if($("#discount").val() != '') {
                        var discount =  parseFloat($("#discount").val());
                    } else {
                        var discount = 0;
                    }
                    $("input[name='grand_total']").val(parseFloat(sum_value) - discount );
                });
            })

            $(".grand_total_weight, .rate_normal_weight ").keyup(function(){
                var wgt = $(this).attr("data-unit-value");
                var total_weight = parseFloat($("input[name='grand_total_weight']").val());
                var total_rate_value = parseFloat($("input[name='rate_normal_weight']").val());
                $("input[name='amount_normal_weight']").val( (total_weight * total_rate_value).toFixed(2));
                $(".tot_amt").trigger("keyup");
                $(".gtotal").trigger("input");
            })


            //     $(".electronics_weight, .rate_electronics_weight ").keyup(function(){
            //         var wgt = $(this).attr("data-unit-value");
            //         var total_weight = parseFloat($("input[name='electronics_weight']").val());
            //         var total_rate_value = parseFloat($("input[name='rate_electronics_weight']").val());
            //         $("input[name='amount_electronics_weight']").val( total_weight * total_rate_value);

            //         var normal_weight = 0;
            //         var msic_weight = 0;
            //         var other_weight = 0;
            //         var electronics_weight = 0;
            //         var amount_other_weight =0;
            //         // var insurance = 0;
            //         // var awbfee = 0;
            //         // var vat_amount = 0;
            //         // var volume_weight = 0;


            //         normal_weight = isNaN(parseFloat($("input[name='normal_weight_temp']").val())) ? 0 : parseFloat($("input[name='normal_weight_temp']").val());
            //         msic_weight = isNaN(parseFloat($("input[name='msic_weight']").val())) ? 0 : parseFloat($("input[name='msic_weight']").val());
            //         electronics_weight = isNaN(parseFloat($("input[name='electronics_weight']").val()))? 0: parseFloat($("input[name='electronics_weight']").val());
            //         other_weight = isNaN(parseFloat($("input[name='other_weight']").val()))? 0: parseFloat($("input[name='other_weight']").val());
            //         // insurance = isNaN(parseFloat($("input[name='insurance']").val())) ? 0 : parseFloat($("input[name='insurance']").val());
            //         // awbfee = isNaN(parseFloat($("input[name='awbfee']").val())) ? 0 : parseFloat($("input[name='awbfee']").val());
            //         // vat_amount = isNaN(parseFloat($("input[name='vat_amount']").val())) ? 0 : parseFloat($("input[name='vat_amount']").val());
            //         // volume_weight = isNaN(parseFloat($("input[name='volume_weight']").val())) ? 0 : parseFloat($("input[name='volume_weight']").val());


            //         rate_normal_weight = isNaN(parseFloat($("input[name='rate_normal_weight']").val())) ? 0 : parseFloat($("input[name='rate_normal_weight']").val());
            //         rate_msic_weight = isNaN(parseFloat($("input[name='rate_msic_weight']").val())) ? 0 : parseFloat($("input[name='rate_msic_weight']").val());
            //         rate_electronics_weight = isNaN(parseFloat($("input[name='rate_electronics_weight']").val())) ? 0 : parseFloat($("input[name='rate_electronics_weight']").val());
            //         rate_other_weight = isNaN(parseFloat($("input[name='rate_other_weight']").val())) ? 0 : parseFloat($("input[name='rate_other_weight']").val());
            //         // rate_insurance = isNaN(parseFloat($("input[name='rate_insurance']").val())) ? 0 : parseFloat($("input[name='rate_insurance']").val());
            //         // rate_awbfee = isNaN(parseFloat($("input[name='rate_awbfee']").val())) ? 0 : parseFloat($("input[name='rate_awbfee']").val());
            //         // rate_vat_amount = isNaN(parseFloat($("input[name='rate_vat_amount']").val())) ? 0 : parseFloat($("input[name='rate_vat_amount']").val());
            //         // rate_volume_weight = isNaN(parseFloat($("input[name='rate_volume_weight']").val())) ? 0 : parseFloat($("input[name='rate_volume_weight']").val());


            //         amount_normal_weight =  isNaN(normal_weight * rate_normal_weight) ? 0 : normal_weight * rate_normal_weight;
            //         amount_msic_weight =  isNaN(msic_weight * rate_msic_weight) ? 0 : msic_weight * rate_msic_weight;
            //         amount_electronics_weight =  isNaN(electronics_weight * rate_electronics_weight)? 0 : electronics_weight * rate_electronics_weight;
            //         amount_other_weight =  isNaN(other_weight * rate_other_weight)? 0 : other_weight * rate_other_weight;
            //         // amount_insurance =  isNaN(insurance * rate_insurance) ? 0 : insurance * rate_insurance;
            //         // amount_awbfee =  isNaN(awbfee * rate_awbfee) ? 0 : awbfee * rate_awbfee;
            //         // amount_vat_amount =  isNaN(vat_amount * rate_vat_amount) ? 0 : vat_amount * rate_vat_amount;
            //         // amount_volume_weight =  isNaN(volume_weight * rate_volume_weight) ? 0 : volume_weight * rate_volume_weight;
            //         // var elec_mis_oth_wgt =  parseFloat(msic_weight)   + parseFloat(electronics_weight);

            //         $("input[name='amount_msic_weight']").val(amount_msic_weight);
            //         $("input[name='amount_electronics_weight']").val(amount_electronics_weight);

            //         // $("input[name='amount_insurance']").val(amount_insurance);
            //         // $("input[name='amount_awbfee']").val(amount_awbfee);
            //         // $("input[name='amount_vat_amount']").val(amount_vat_amount);
            //         // $("input[name='amount_volume_weight']").val(amount_volume_weight);

            //         //$("input[name='amount_grand_total']").val( amount_normal_weight + amount_msic_weight + amount_other_weight + amount_electronics_weight);
            //         $("input[name='total_freight']").val( amount_normal_weight + amount_msic_weight + amount_other_weight + amount_electronics_weight);
            //         console.log(amount_normal_weight + amount_msic_weight + amount_other_weight + amount_electronics_weight, 'sdfbfjhbsdljh');

            //         $(".grand_total_weight").trigger("keyup");
            //         $(".rate_electronics_weight").trigger("input");

            // })


            // $(" .msic_weight, .rate_msic_weight ").keyup(function(){
            //     var wgt = $(this).attr("data-unit-value");
            //     var total_weight = parseFloat($("input[name='msic_weight']").val());
            //     var total_rate_value = parseFloat($("input[name='rate_msic_weight']").val());

            //     $("input[name='amount_msic_weight']").val( total_weight * total_rate_value);


            //     var normal_weight = 0;
            //     var msic_weight = 0;
            //     var other_weight = 0;
            //     var electronics_weight = 0;
            //     var amount_other_weight =0;
            //     // var insurance = 0;
            //     // var awbfee = 0;
            //     // var vat_amount = 0;
            //     // var volume_weight = 0;

            //     normal_weight =  isNaN(parseFloat($("input[name='normal_weight']").val()))? 0 : parseFloat($("input[name='normal_weight']").val());
            //     msic_weight = isNaN(parseFloat($("input[name='msic_weight']").val())) ? 0 : parseFloat($("input[name='msic_weight']").val());
            //     electronics_weight = isNaN(parseFloat($("input[name='electronics_weight']").val()))? 0: parseFloat($("input[name='electronics_weight']").val());
            //     other_weight = isNaN(parseFloat($("input[name='other_weight']").val()))? 0: parseFloat($("input[name='other_weight']").val());
            //     // insurance = isNaN(parseFloat($("input[name='insurance']").val())) ? 0 : parseFloat($("input[name='insurance']").val());
            //     // awbfee = isNaN(parseFloat($("input[name='awbfee']").val())) ? 0 : parseFloat($("input[name='awbfee']").val());
            //     // vat_amount = isNaN(parseFloat($("input[name='vat_amount']").val())) ? 0 : parseFloat($("input[name='vat_amount']").val());
            //     // volume_weight = isNaN(parseFloat($("input[name='volume_weight']").val())) ? 0 : parseFloat($("input[name='volume_weight']").val());


            //     rate_normal_weight = isNaN(parseFloat($("input[name='rate_normal_weight']").val())) ? 0 : parseFloat($("input[name='rate_normal_weight']").val());
            //     rate_msic_weight = isNaN(parseFloat($("input[name='rate_msic_weight']").val())) ? 0 : parseFloat($("input[name='rate_msic_weight']").val());
            //     rate_electronics_weight = isNaN(parseFloat($("input[name='rate_electronics_weight']").val())) ? 0 : parseFloat($("input[name='rate_electronics_weight']").val());
            //     rate_other_weight = isNaN(parseFloat($("input[name='rate_other_weight']").val())) ? 0 : parseFloat($("input[name='rate_other_weight']").val());
            //     // rate_insurance = isNaN(parseFloat($("input[name='rate_insurance']").val())) ? 0 : parseFloat($("input[name='rate_insurance']").val());
            //     // rate_awbfee = isNaN(parseFloat($("input[name='rate_awbfee']").val())) ? 0 : parseFloat($("input[name='rate_awbfee']").val());
            //     // rate_vat_amount = isNaN(parseFloat($("input[name='rate_vat_amount']").val())) ? 0 : parseFloat($("input[name='rate_vat_amount']").val());
            //     // rate_volume_weight = isNaN(parseFloat($("input[name='rate_volume_weight']").val())) ? 0 : parseFloat($("input[name='rate_volume_weight']").val());

            //     amount_normal_weight =  isNaN(normal_weight * rate_normal_weight) ? 0 : normal_weight * rate_normal_weight;
            //     amount_msic_weight =  isNaN(msic_weight * rate_msic_weight) ? 0 : msic_weight * rate_msic_weight;
            //     amount_electronics_weight =  isNaN(electronics_weight * rate_electronics_weight)? 0 : electronics_weight * rate_electronics_weight;
            //     amount_other_weight =  isNaN(other_weight * rate_other_weight)? 0 : other_weight * rate_other_weight;
            //     // amount_insurance =  isNaN(insurance * rate_insurance) ? 0 : insurance * rate_insurance;
            //     // amount_awbfee =  isNaN(awbfee * rate_awbfee) ? 0 : awbfee * rate_awbfee;
            //     // amount_vat_amount =  isNaN(vat_amount * rate_vat_amount) ? 0 : vat_amount * rate_vat_amount;
            //     // amount_volume_weight =  isNaN(volume_weight * rate_volume_weight) ? 0 : volume_weight * rate_volume_weight;


            //     var elec_mis_oth_wgt =  parseFloat(msic_weight)  + parseFloat(electronics_weight)

            //     $("input[name='amount_msic_weight']").val(amount_msic_weight);
            //     $("input[name='amount_electronics_weight']").val(amount_electronics_weight);
            //     // $("input[name='amount_insurance']").val(amount_insurance);
            //     // $("input[name='amount_awbfee']").val(amount_awbfee);
            //     // $("input[name='amount_vat_amount']").val(amount_vat_amount);
            //     // $("input[name='amount_volume_weight']").val(amount_volume_weight);
            //     // $("input[name='grand_total_weight']").val( parseFloat(normal_weight) - parseFloat(elec_mis_oth_wgt));


            //     $("input[name='amount_grand_total']").val( amount_normal_weight + amount_msic_weight + amount_other_weight + amount_electronics_weight);
            //     $("input[name='total_freight']").val( amount_normal_weight + amount_msic_weight + amount_other_weight + amount_electronics_weight);

            //     $(".grand_total_weight").trigger("keyup");
            //     $(".tot_amt").trigger("keyup");
            //      $(".gtotal").trigger("input");


            //     })



                $(".other_weight, .rate_other_weight").keyup(function(){

                var total_weight = isNaN(parseFloat($("input[name='other_weight']").val())) ? 0 : parseFloat($("input[name='other_weight']").val());
                var total_rate_value = isNaN(parseFloat($("input[name='rate_other_weight']").val())) ? 0 : parseFloat($("input[name='rate_other_weight']").val());

                var normal_weight = isNaN(parseFloat($("input[name='normal_weight_temp']").val())) ? 0 : parseFloat($("input[name='normal_weight_temp']").val());
                $("input[name='normal_weight']").val(normal_weight +total_weight );

                $("input[name='amount_other_weight']").val( total_weight * total_rate_value);
                $(".tot_amt").trigger("keyup");
                $(".gtotal").trigger("input");
            });





            $(".tot_amt").keyup(function(){
                var sum_value = 0;
                $('.tot_amt').each(function(){
                    sum_value += +$(this).val();
                    $("input[name='amount_grand_total']").val( sum_value);
                    $("input[name='total_freight']").val( sum_value );
                })
            })


            $(document).on("click", ".fillAdress", function (event) {
                var boxId = $(this).attr('data-boxid');
                var boxName = $('.oldBoxNo' + boxId).val();

                $.ajax({
                    url: '/branch/get_box_data',
                    type: 'GET',
                    data: { box_name: boxName },
                    success: function(response) {
                        if (response.success) {
                            console.log(response.data);
                            $('#noBoxFound' + boxId).html(response.message);

                            var data = response.data;
                            $('input[name="sender_name' + boxId + '"]').val(data.sender_name);
                            $('textarea[name="sender_address' + boxId + '"]').val(data.sender_address);
                            $('input[name="sender_pin' + boxId + '"]').val(data.sender_pin);
                            $('input[name="sender_mob' + boxId + '"]').val(data.sender_mob);
                            $('select[name="sender_id_type' + boxId + '"]').val(data.sender_id_type);
                            $('input[name="sender_id_no' + boxId + '"]').val(data.sender_id_no);
                            // $('input[name="sender_id_image' + boxId + '"]').val(data.sender_id_image);
                            $('input[name="receiver_name' + boxId + '"]').val(data.receiver_name);
                            $('input[name="receiver_id_no' + boxId + '"]').val(data.receiver_id_no);
                            $('textarea[name="receiver_address' + boxId + '"]').val(data.receiver_address);
                            $('input[name="receiver_pin' + boxId + '"]').val(data.receiver_pin);
                            $('input[name="receiver_mob' + boxId + '"]').val(data.receiver_mob);
                            $('select[name="receiver_id_type' + boxId + '"]').val(data.receiver_id_type);
                            // $('input[name="receiver_id_image' + boxId + '"]').val(data.receiver_id_image);
                        } else {
                            $('#noBoxFound' + boxId).html(response.message);
                            console.log(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' ' + error);
                    }
                });
            });



            $(document).on("click", ".addpackage", function (event) {
                var i = $(this).attr("data-myattri");
                var si = parseInt($(':input[name="description'+i+'[]"]').length)+1;
                var tr = $('#tr').html();
                        var html = `<tr>
                                    <td style="padding:10px" width="2%"><span class="form-control border-0">`+si+`</span></td>
                                    <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description`+i+`[]" class="form-control descriptions"></td>
                                        <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty`+i+`[]"  class="form-control qty"></td>
                                        <td style="padding:10px"><input type="number"  data-myAttri="`+i+`" placeholder="Enter unit price" name="unit`+i+`[]" class="form-control unit" step="0.01"></td>
                                        <td style="padding:10px"><input type="text" readonly name="subtotal`+i+`[]" class="form-control value pkg-subtotal"></td>
                                        <td>
                                        <button type="button"  name="remove`+i+`[]" class="remove btn btn-danger" data-remove="`+i+`">X</button>
                                        </td>
                                    </tr>`;
                        $('#packageinfo'+i+' table').append(html);
                        addremoveClass();
                        $("input[name='description"+i+"[]']").focus();

            });


            $(document).on("click", ".removeBox", function (event) {
                    var boxNo = $(this).attr("data-myattri");
                    var boxCount = $('#number_of_pcs').val();
                    boxCount = boxCount -1;


                    $('#number_of_pcs').val(boxCount);
                    $('#number_of_pcs').val(boxCount);
                    $("#newBoxContainer"+boxNo).remove();
                        if( boxCount == 0){
                            $("#TotalDiv").css({'display':'none'});
                            $("#total-package").css({'display':'none'});
                        }

                        $(".box-weight").trigger("input");
                        $(".box-unit-value").trigger("input");
                        // $(".msic_weight").trigger("input");
                        $(".gtotal").trigger("input");
                        $("#discount").trigger("input");
                        $(".qty").trigger("keyup");
                        $(".unit").trigger("keyup");

                        // addItems(boxCount);
                        $(".tot_wgt, .tot_rate, .tot_amt").trigger("input");


                        updateBoxName(boxCount, boxNo );
            });



            $(document).on("keyup", ".qty", function (event) {

                var box_total = 0;
                $('.pkg-subtotal').each(function(){
                    box_total += +$(this).val();
                    $("#totalPackageAmt").html(box_total);
                    $("input[name='package_total_amount']").val(box_total );
                });

                var box_qty_total = 0;
                $('.qty').each(function(){
                    box_qty_total += +$(this).val();
                    $("#totalPackageqty").html(box_qty_total);
                    $("input[name='package_total_quantity']").val( box_qty_total );
                });


                var box_total = 0;
                $('.pkg-subtotal').each(function(){
                    box_total += +$(this).val();
                    $("#totalPackageAmt").html(box_total);
                    $("input[name='package_total_amount']").val(box_total  );

                });


            });

            $(document).on("keyup", ".unit", function (event) {
                var keyPressed = event.keyCode || event.which;
                if (keyPressed == 13) {
                    var packageNo = $(this).attr("data-myAttri");
                    $("#addpackage"+packageNo).click();
                    event.preventDefault();
                    return false;
                }

                var box_total = 0;
                $('.pkg-subtotal').each(function(){
                    box_total += +$(this).val();
                    $("#totalPackageAmt").html(box_total);
                    $("input[name='package_total_amount']").val(box_total  );
                });
            });



            function addremoveClass() {

                $('.remove').click(function(){

                    var no_of_box = $('.body .boxcount').length;

                    var boxNo = $(this).attr("data-myAttri");
                    var totalRowCount = $(".packageinfo"+boxNo+" tr").length;

                    if(no_of_box == 1 ){
                        $('#total-package').css({'display':'none'});
                    }


                    $(this).closest("tr").remove();
                    var rm_id = $(this).attr("data-remove");
                        var sum = 0;
                        $("input[name='subtotal"+rm_id+"[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt"+rm_id+"").text(sum);

                        var qtysum = 0;
                        $("input[name='qty"+rm_id+"[]']").each(function () {
                            qtysum += +$(this).val();
                        });
                        $("#totalqty"+rm_id+"").text(qtysum);

                        var rtotamtsum =0;
                        $(".rtotamt").each(function () {
                            rtotamtsum += parseFloat($(this).text());

                        });

                        $("#totalPackageAmt").text(rtotamtsum);
                        $("input[name='package_total_amount']").val(rtotamtsum);

                        var rtotqtysum = 0;
                        $(".rtotqty").each(function () {
                            rtotqtysum += parseFloat($(this).text());
                        });
                        $("#totalPackageqty").text(rtotqtysum);
                        $("input[name='package_total_quantity']").val(rtotqtysum);

                    });
            }

            $('#country_id').change(function () {
                var country_id = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('states')}}?country_id=" + country_id;
                // console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        // console.log(result);
                        $('#loader').addClass('d-none');
                        let option = ``;
                        $('#state_id').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                        $('.country_code').val(result.phonecode);
                        if(result.phone_no_length!= null)
                        {
                            $("#phone").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#whatsapp_number").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#phone").attr("maxlength", result.phone_no_length);
                            $("#whatsapp_number").attr("maxlength", result.phone_no_length);
                        } else {
                            $("#phone").attr("placeholder", "Enter phone");
                            $("#whatsapp_number").attr("placeholder", "Enter phone");
                        }

                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
            })

            $("#country_code_whatsapp").change(function () {
                 var country_code = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('getCountry')}}?country_code=" + country_code;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull

                        $('#loader').addClass('d-none');
                        if(result.phone_no_length!= null)
                        {
                            $("#whatsapp_number").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#whatsapp_number").attr("maxlength", result.phone_no_length);
                        } else {
                            $("#whatsapp_number").attr("placeholder", "Enter phone");
                        }

                    }, error: function (er) {
                        console.log(er);
                    }
                }); // ajax call closing
            });



            $("#country_code_phone").change(function () {

                var country_code = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('getCountry')}}?country_code=" + country_code;
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        console.log(result);
                        // return false;
                        $('#loader').addClass('d-none');

                        if(result.phone_no_length!= null)
                        {
                            $("#phone").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#phone").attr("maxlength", result.phone_no_length);
                        } else {
                            $("#phone").attr("placeholder", "Enter phone");

                        }

                    }, error: function (er) {
                        console.log(er);
                    }
                }); // ajax call closing


            });



            $('#state_id').change(function () {
                var state_id = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('cities')}}?state_id=" + state_id;
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        console.log(result);
                        $('#loader').addClass('d-none');
                        let option = ``;
                        $('#city_id').html('<option value="">Select City</option>');
                        $.each(result, function (key, value) {
                            $("#city_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
            })


            $('#state_id').change(function () {
                var state_id = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('districts')}}?state_id=" + state_id;
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        console.log(result);
                        $('#loader').addClass('d-none');
                        let option = ``;
                        $('#district_id').html('<option value="">Select District</option>');
                        $.each(result, function (key, value) {
                            $("#district_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
            })



            $('#collected_by').change(function () {
                var collected = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('branch.collectedBy')}}?collected=" + collected;
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        $('#loader').addClass('d-none');

                        $('#driver_or_staff').html(result.res);

                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
            })


            function calculateTotal() {
                let weight = $('#weight').val()
                let rate = $('#rate').val();
                let packing_charge = $('#packing_charge').val();
                let other_charges = $('#other_charges').val();
                let discount = $('#discount').val();
                console.log(weight * rate);
                if (typeof weight === "undefined" || weight == null) {
                    weight = 0;
                }
                if (typeof rate === "undefined" || rate == null) {
                    rate = 0;
                }
                if (typeof packing_charge === "undefined" || packing_charge == null) {
                    packing_charge = 0;
                }
                if (typeof other_charges === "undefined" || other_charges == null) {
                    other_charges = 0;
                }
                if (typeof discount === "undefined" || discount == null) {
                    discount = 0;
                }
                let am = (weight * rate);
                let grossTotal = am + parseFloat(packing_charge) + parseFloat(other_charges)
                let total = grossTotal - discount;
                $('#total_amount').val(total);
            }

            $("#add_client_shipments").submit(function (e) {
                e.preventDefault();
                $('.valid-err').hide()
                $('#loader').removeClass('d-none');
                var formData = new FormData(this);
                for (var p of formData) {
                    let name = p[0];
                    let value = p[1];

                    console.log(name, value)
                }
                $.ajax({
                    url: `{{ route('branch.customers.store') }}`,
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        // when call is sucessfull
                        if (result.success === true) {
                            clearForm()
                            $('#loader').addClass('d-none');
                            var message = `<span class="alert alert-success">` + result.message + `</span>`;
                            console.log(result);
                            $('#msg').html(message)
                            $('#' + result.data.type + '_id').append(`<option value="` + result.data.id + `" selected>` + result.data.name + `<option>`);
                            toastr.info(result.data.address.address);
                            $('#' + result.data.type + '_address').val(result.data.address.address)
                            setTimeout(() => {
                                $('.modal').modal('hide');
                                $('.alert').hide();
                            }, 2000);
                        } else {
                            toastr.error(result.message);
                        }

                    },
                    error: function (err) {
                        // check the err for error details
                        console.log(err);
                        $('#loader').addClass('d-none');
                        $.each(err.responseJSON.errors, function (key, item) {
                            $('#' + key).after('<label class="valid-err text-danger">' + item + '</label>')
                        });
                    }
                }); // ajax call closing

            });



        function clearForm() {
            $('#name').val("");
            $('#email').val("");
            $('#phone').val("");
            $('#zip_code').val("");
            $('#address').val("");
            $('#client_identification_number').val("");
        }


        $('.btnAction').click(function () {

            $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $(this).attr('disabled', true);
            $('#basic-form').submit();
        });


function getval(event)
{


    var boxNo =event.dataset.no;
    var weight = $("input[name='weight"+boxNo+"']").val();
    var volume = $("select[name='volume"+boxNo+"']").val();
    var packing = $("select[name='packing"+boxNo+"']").val();
    var dataid = $("select[name='dimension"+boxNo+"']").val();
    // var dataid = event.options[event.selectedIndex].dataset.id;
        if( dataid == 0 ){

            $("#other_height"+boxNo).removeClass("d-none");
            $("#other_length"+boxNo).removeClass("d-none");
            $("#other_width"+boxNo).removeClass("d-none");
            $("#other_select"+boxNo).removeClass("d-none");
            $("input[name='box_packing_charge"+boxNo+"']").val('');

            $("#packing"+boxNo).addClass("d-none");
            $("#selectVolume"+boxNo).addClass("d-none");

            $("input[name='weight"+boxNo+"']").trigger("input");
            $("select[name='packing"+boxNo+"']").trigger("change");


        } else {

            $("#other_height"+boxNo).addClass("d-none");
            $("#other_length"+boxNo).addClass("d-none");
            $("#other_width"+boxNo).addClass("d-none");
            $("#other_select"+boxNo).addClass("d-none");

            $("#packing"+boxNo).removeClass("d-none");
            $("#selectVolume"+boxNo).removeClass("d-none");

                $('#loader').removeClass('d-none');
                const url = "{{route('getUnitValue')}}?id=" + dataid+"&boxNo="+boxNo+"&volume="+volume+"&packing="+packing;
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        $('#loader').addClass('d-none');

                        $("input[name='unit_value"+result.boxno+"']").val((result.value).toFixed(2));
                        $("input[name='weight"+result.boxno+"']").trigger("input");
                        $("select[name='packing"+result.boxno+"']").trigger("change");

                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
        }

}


function getValOther(event) {
    var boxNo =event.dataset.no;


    var height = parseFloat($("input[name='other_height"+boxNo+"']").val());
    var length = parseFloat($("input[name='other_length"+boxNo+"']").val());
    var width = parseFloat($("input[name='other_width"+boxNo+"']").val());
    var select = parseFloat($("input[name='other_select"+boxNo+"']").val());

    var volume = (height * length * width )/ select;

    var select = $("input[name='unit_value"+boxNo+"']").val(volume.toFixed(2));


}


function getVolume(event){
    var selected_volume  =   event.value;
    $('.volume').val(selected_volume);

    var shiping_method =  $("#shiping_method option:selected").attr('data-shiptypeid');
    var collected_by = $("#collected_by").val();

    $("#shipping_method_id").val(shiping_method);

        $('#loader').removeClass('d-none');
        const url = "{{route('getRate')}}?collected_by=" + collected_by+"&shiping_method="+shiping_method;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function (result) {
                // when call is sucessfull
                $(".box-rate").val( result.rate);
                // $("input[name='rate_normal_weight']").val(result.rate);

                $(".box-rate").trigger("input");
                // $("input[name='rate_normal_weight']").trigger("keyup");



            }, error: function (er) {
                console.log(er);
            }

        }); // ajax call closing

}


function getRate(event){

    var shiping_method =  $("#shiping_method option:selected").attr('data-shiptypeid');
    var collected_by = $("#collected_by").val();

        $('#loader').removeClass('d-none');
        const url = "{{route('getRate')}}?collected_by=" + collected_by+"&shiping_method="+shiping_method;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function (result) {
                // when call is sucessfull
                $(".box-rate").val( result.rate);
                $("input[name='rate_normal_weight']").val(result.rate);

                $(".box-rate").trigger("input");
                $("input[name='rate_normal_weight']").trigger("keyup");



            }, error: function (er) {
                console.log(er);
            }

        }); // ajax call closing

}

function getBoxPackingVal(event) {

    var pack_charge = isNaN(parseFloat($("#packing_charge").val()))? 0 : parseFloat($("#packing_charge").val());

    var boxNo = event.dataset.no;

    var dimension_id = parseFloat($("select[name='dimension"+boxNo+"']").val());
    var packing_id = parseFloat($("select[name='packing"+boxNo+"']").val());

     $('#loader').removeClass('d-none');
        const url = "{{route('getBoxPackingCharge')}}?dimension_id=" + dimension_id+"&packing_id="+packing_id;
        console.log(url);
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function (result) {
                // when call is sucessfull
                console.log(result, result.packing_rate);
                console.log( pack_charge + parseFloat(result.packing_rate) );

                $("input[name='box_packing_charge"+boxNo+"']").val(result.packing_rate);
                $(".box_packing_charge").trigger("input");

            }, error: function (er) {
                console.log(er);
            }

        }); // ajax call closing



}


</script>

@endsection

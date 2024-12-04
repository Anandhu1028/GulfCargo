@extends('layouts.app')

@section('content')
<style>
.boxContainer{
    border:1px solid black;
    padding:5px;
    margin-top:5px;
}
body{
	font-family:Verdana, Geneva, sans-serif;
	font-size:18px;
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form action="{{store_url()}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Basic Info</h4>
                                    </div>

                                    <div class="row">

                                    {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking code .</label>
                                                <input type="text" name="booking_code"  id="booking_code"
                                                       value="" class="form-control"  >
                                                @error('booking_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> --}}


                                        <div class="col-md-6" id="bookingNumberSection">
                                            <div class="form-group">
                                                <label>Booking No.</label>
                                                <input type="text" name="booking_number"
                                                       value="{{ $nextBookingNumber }}" class="form-control"
                                                       required  >
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <input type="hidden" name="new_book_no" value="{{ $nextBookingNumber }}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Branch List</label>
                                                <select autofocus name="branch_id" id="branch_id"
                                                        class="form-control">
                                                    @foreach ($branches as $branch)
                                                        <option
                                                            {{ (branch()->id==$branch->id) ? 'selected' : "" }} value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                                <button type="button" id="AddSender" class="btn btn-primary mt-sm-4"><i
                                                        class="fa fa-plus"></i></button>
                                                        <button type="button" id="EditSender" class="btn btn-primary mt-sm-4"><i
                                                        class="fa fa-pen"></i></button>
                                            </div>

                                        </div>
                                        <div class="row form-group col-md-12">
                                            <label>Sender Address</label>
                                            <input readonly type="text" id="sender_address" class="form-control">
                                        </div>
                                        <div class="row form-group col-md-12">
                                            <label>Sender Phone</label>
                                            <input readonly type="text" id="sender_phone" class="form-control">
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
                                                <button type="button" id="AddReceiver" class="btn btn-primary mt-4"><i
                                                        class="fa fa-plus"></i></button>
                                                        <button type="button" id="EditReceiver" class="btn btn-primary mt-4"><i
                                                        class="fa fa-pen"></i></button>      
                                            </div>
                                        </div>
                                        <div class="row form-group col-md-12">
                                            <label>Receiver Address</label>
                                            <input readonly type="text" id="receiver_address" class="form-control">
                                        </div>
                                        <div class="row form-group col-md-12">
                                            <label>Receiver Phone</label>
                                            <input readonly type="text" id="receiver_phone" class="form-control">
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
                                                    <input type="text" value="{{ old('receipt_number') }}"
                                                           class="form-control"
                                                           name="receipt_number">
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Packaging Type</label>
                                                    <input type="text" value="{{ old('packing_type') }}"
                                                           name="packing_type"
                                                           class="form-control">
                                                </div>
                                            </div> -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Courier Company</label>
                                                    <select name="agency_id" class="form-control">
                                                        <!-- <option value="Best Express"> Best Express</option> -->
                                                        @foreach ($agencies as $agency)
                                                        <option value="{{ $agency->id }}" {{$agency->id == 5? 'selected':''}}>{{ $agency->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- <input type="text" value="{{ old('agency_id') }}"
                                                           name="agency_id" class="form-control"> -->
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Shipping Methods</label>

                                                    <select name="shiping_method" class="form-control" id="shiping_method"  onchange="getVolume(this);" required>
                                                        <option value="" data-shipTypeId=""> Select </option>
                                                            @foreach( $ship_types as $key => $shipping_type )
                                                            <option value="{{$shipping_type->value}}" data-shipTypeId="{{$shipping_type->id}}">{{$shipping_type->name}}</option>
                                                            @endforeach
                                                        </select>

                                                        <input type="hidden" name="shipping_method_id" value=""  id="shipping_method_id"/>

                                                        <?php /*
                                                        <option
                                                            {{ (old('shiping_method')=='Air') ? 'selected' : "" }} value="Air">
                                                            Air
                                                        </option>
                                                        <option
                                                            {{ (old('shiping_method')=='Sea') ? 'selected' : "" }} value="Sea">
                                                            Sea
                                                        </option>
                                                        <option
                                                            {{ (old('shiping_method')=='Raoad') ? 'selected' : "" }} value="Road">
                                                            Road
                                                        </option> */ ?>


                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Payment Method</label>
                                                    <select name="payment_method" class="form-control" id="">
                                                        <option
                                                           value="cash_payment">
                                                            Cash Payment
                                                        </option>
                                                        <option
                                                             value="credit">
                                                            Credit
                                                        </option>
                                                        <option
                                                             value="bank">
                                                            Bank
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status_id" class="form-control" id="" disabled>
                                                    <option value="">--- Select Status ---</option>
                                                        @foreach (status_list_admin() as $item)
                                                            <option
                                                                {{ $item->id == 15 ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="status_id" value="15">
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
                                                        <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : date('Y-m-d')}}" max=""
                                                            class="form-control" id="propertyname" name="created_date"
                                                            placeholder="Enter title">
                                                </div>
                                            </div>
                                             <!-- <div class="col-md-3">
                                                <div class="form-group">

                                            </div>
                                            </div>   -->

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label  for="collected_by" >Collected By</label>
                                                    <select class="form-control" name="collected_by" id="collected_by" required>
                                                            <option value="" selected>Select</option>
                                                            <option value="driver">Driver</option>
                                                            <option value="staff">Office</option>
                                                    </select>
                                                </div>
                                            </div>




                                            <div class="col-md-3" id="driver_or_staff">
                                                <div class="form-group">
                                                {{-- @if(!empty($previous_booking->collected_by) == "driver")
                                                    <label>Driver Name</label>
                                                    <select class="form-control" name="driver_id">
                                                        <option value>Select Driver</option>
                                                        @foreach($drivers as $driver)
                                                            <option  {{ (!empty($previous_booking->driver_id) == $driver->id ) ? 'selected' : "" }} value="{{$driver->id}}">{{$driver->name}}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif(!empty($previous_booking->collected_by) == "staff")
                                                    <label>Staff Name</label>
                                                        <select class="form-control" name="staff_id">
                                                            <option value>Select Staff</option>
                                                            @foreach($staffs as $staff)
                                                                <option  {{ (!empty($previous_booking->staff_id) == $staff->id ) ? 'selected' : "" }} value="{{$staff->id}}">{{$staff->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                @else --}}
                                                    <label>Select Name</label>
                                                    <select class="form-control" name="">
                                                        <option value>Select </option>
                                                    </select>
                                                {{-- @endif --}}

                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>LRL Tracking Code</label>
                                                    <input type="text" name="lrl_tracking_code"
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
                                                            <option   value="door_to_door" selected>Door To Door</option>
                                                            <option  value="door_to_port">Door To Port</option>

                                                    </select>


                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="propertyname">Time</label>
                                                        <input type="time" name="time" value="{{!empty($shipment)?$shipment->time:date('H:i')}}" class="  form-control"
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
                                                        ></textarea>
                                                </div>
                                            </div>

                                        </div>


                                        </div>

                                    <div class="row">


                                    </div>
                                    <div style="display:none;" >
                                        <div id="boxContainer">


                                            <div class="package col-md-12"  id="package_ID" >
                                                <div class="header">
                                                    <div class="col-md-6"  style="float:left">
                                                    <h6 class="packageinfo-head">Package Info</h6>
                                                    </div>
                                                    <div class="col-md-6 text-right pb-2" style="float:left">
                                                    <button type="button" id="addpackage" class="btn btn-success">Add
                                                            Items
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="body" id="packageinfo">

                                                    <table class="table table-bordered packageinfo">
                                                        <tr>
                                                            <td width="40%">
                                                                <input type="text" placeholder="Enter description"
                                                                    name="description[]"
                                                                    class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Enter quantity"
                                                                    name="qty[]"
                                                                    class="form-control qty">
                                                            </td>
                                                            <td>
                                                                <input type="number" placeholder="Enter unit price"
                                                                    name="unit[]"
                                                                    class="form-control unit">
                                                            </td>
                                                            <td>
                                                                <input type="number" name="subtotal[]" readonly
                                                                    class="form-control value pkg-subtotal">
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </div>

                                                <div class="body" id="boxDimension">
                                                <div class="row">
                                                    <div class="col-md-2 box-title">
                                                        <h6>Box</h6>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-2">
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
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Weight</label>
                                                            <input type="number" name="weight" value="" class="form-control box-weight">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Unit Value</label>
                                                            <input type="number" name="unit_value" value="" class="form-control box-unit-value">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Total Value</label>
                                                            <input type="number" name="total_value" value="" class="form-control box-total-value total" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                                <div class="body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td width="25%"><h4>Amount : </h4></td>
                                                            <td width="25%"><h4><span id="totalAmt" class="package-total-amount"></span></h4></td>
                                                            <td width="25%"><h4>Quantity: </h4></td>
                                                            <td width="25%"><h4><span id="totalqty"></span></h4></td>
                                                        </tr>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="boxContainer1"> </div>

                                    {{-- <div id="Container">

                                    </div> --}}


                                </div>

                                <div class="col-md-12" style="display:none;">
                                    <div class="body" id="boxDimension1">
                                        <div class="row">
                                            <div class="col-md-2 box-title">
                                                <h6>Box</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
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
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Weight</label>
                                                    <input type="number" name="weight" value="" class="form-control box-weight">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Unit Value</label>
                                                    <input type="number" name="unit_value" value="" class="form-control box-unit-value">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Total Value</label>
                                                    <input type="number" name="total_value" value="" class="form-control box-total-value total" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="row" id="total-package" style="display:none;">

                                    <table class="table table-bordered">
                                                        <tbody><tr>
                                                            <td width="25%"><h4>Total Amount : </h4></td>
                                                            <td width="25%"><h4>
                                                                <span id="totalPackageAmt" class="package-total-amount"></span>
                                                            </h4>
                                                            <input type="hidden" name="package_total_amount" value="" >


                                                            </td>
                                                            <td width="25%"><h4>Total Quantity: </h4></td>
                                                            <td width="25%">
                                                                <h4><span id="totalPackageqty"></span></h4>
                                                                <input type="hidden" name="package_total_quantity" value="" >
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                    </table>
                                <div>

                                </div>
                                </div>
                                        <hr>
                                            <div class="col-md-8"  id="TotalDiv" >
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
                                                                    <div class="col-md-6" style="text-align:right;" >
                                                                        <label>Total Weight</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            {{-- <input type="text" name="normal_weight" value="{{$shipment->normal_weight}}" class="form-control "> --}}
                                                                            <input type="text" name="grand_total_weight" value="" class="form-control " >

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_normal_weight" value="" class="form-control rate_normal_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_normal_weight" value="" class="form-control tot_amt">
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
                                                                                value="" class="form-control electronics_weight tot_wgt">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="rate_electronics_weight" value="" class="form-control rate_electronics_weight tot_rate">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_electronics_weight" value="" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row  pt-2">
                                                                        <div class="col-md-6"  style="text-align:right;">
                                                                            <label>Packing charge</label>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="msic_weight"
                                                                                value="" class="form-control msic_weight tot_wgt">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="rate_msic_weight" value="" class="form-control rate_msic_weight tot_rate">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_msic_weight" value="" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Additional Packing charge</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="add_pack_charge"
                                                                            value="" class="form-control add_pack_charge tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_add_pack_charge" value="" class="form-control rate_add_pack_charge tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                    <div class="">
                                                                        <input type="text" name="amount_add_pack_charge" value="" class="form-control tot_amt">
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
                                                                            value="" class="form-control insurance_weight tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_insurance" value="" class="form-control rate_insurance_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_insurance" value="" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>AWB Fee</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="awbfee"
                                                                            value="" class="form-control awbfee tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_awbfee" value="" class="form-control rate_awbfee tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_awbfee" value="" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>VAT Amount</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="vat_amount"
                                                                            value="" class="form-control vat_amount tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_vat_amount" value="" class="form-control rate_vat_amount tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_vat_amount" value="" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row  pt-2">
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Volume weight</label>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="volume_weight"
                                                                            value="" class="form-control volume_weight tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_volume_weight" value="" class="form-control rate_volume_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_volume_weight" value="" class="form-control tot_amt">
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
                                                                            value="" class="form-control discount_weight tot_wgt">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="rate_discount_weight" value="" class="form-control rate_discount_weight tot_rate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_discount_weight" value="" class="form-control ">
                                                                        </div>
                                                                    </div>

                                                                </div>








                                                                {{-- <div class="row pt-2">
                                                                        <div class="col-md-6"  style="text-align:right;">
                                                                            <label>Other weight</label>
                                                                        </div>
                                                                        <div class="col-md-2" >
                                                                            <div class="">
                                                                                <input type="text" name="other_weight"
                                                                                value="{{$shipment->other_weight}}" class="form-control other_weight tot_wgt">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <div class="">
                                                                                <input type="text" name="rate_other_weight" value="{{$shipment->rate_other_weight}}" class="form-control rate_other_weight tot_rate">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                        <div class="">
                                                                            <input type="text" name="amount_other_weight" value="{{ $shipment->amount_other_weight }}" class="form-control tot_amt">
                                                                        </div>
                                                                    </div>

                                                                </div> --}}

                                                                <div class="row">


                                                                        <div class="col-md-6 pt-2"  style="text-align:right;font-size:18px;font-weight:bold;">

                                                                        </div>
                                                                        <div class="col-md-2 pt-2" style="border-top:1px solid;">
                                                                            <div class="">
                                                                            {{-- <input type="text" name="normal_weight" value="{{$shipment->normal_weight}}" class="form-control tot_wgt1"> --}}

                                                                            <!-- THIS VALUE IS USED FOR CALCULATION  normal_weight_temp-->
                                                                            {{-- <input type="hidden" name="normal_weight_temp" value="{{$shipment->normal_weight}}" class="form-control tot_wgt1" readonly> --}}

                                                                                <!-- <input type="text" name="grand_total_weight" value="" class="form-control" readonly> -->
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-2 pt-2"  style="border-top:1px solid;">
                                                                            <div class="">
                                                                                <!-- <input type="text" name="rate_grand_total" value="" class="form-control"> -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 pt-2"  style="border-top:1px solid;">
                                                                        <div class="">
                                                                            <input type="text" name="amount_grand_total" value="" class="form-control">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row  pt-2">

                                                                     <div class="col-md-6"  style="text-align:right;">
                                                                            <label>No.of Pcs</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="">
                                                                                <input value="" type="text" name="number_of_pcs"
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
                                                            {{-- <td width="40%">
                                                                <div class="row">


                                                                    <div class="col-md-6 "  style="text-align:right;">
                                                                        <label>Total Freight</label>
                                                                    </div>
                                                                    <div class="col-md-6 ">
                                                                        <div class="">
                                                                            <input type="text" name="total_freight"
                                                                            value="{{$shipment->total_freight}}" class="form-control gtotal">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Box Packing Charge</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="">
                                                                            <input type="text" name="packing_charge" value="{{ $shipment->packing_charge}}"  id="packing_charge" class="form-control gtotal">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Other Packing Charge</label>
                                                                    </div>
                                                                    <div class="col-md-6 ">
                                                                        <div class="">
                                                                            <input type="text" name="other_charges" value="{{ $discount->other_packing_charge? $discount->other_packing_charge:0}}" class="form-control gtotal">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Document Charge</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="">
                                                                            <input type="text" name="document_charge" value="{{ $discount->document_charge? $discount->document_charge:0}}" class="form-control  gtotal" step="any">

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Discount</label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="">
                                                                        <input type="text" value="{{ $discount->discount? $discount->discount:0}}"
                                                                        id="discount" name="discount" class="form-control discount">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6"  style="text-align:right;">
                                                                        <label>Grand Total  {{ $shipment->grand_total}} </label>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="">
                                                                            <input type="text" name="grand_total" value="{{ $shipment->grand_total}}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td> --}}

                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                <div class="text-center" style="display:block;">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>
                                </div>
                            </form>
                            <!-- end form -->

                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->



    </div>
    @include('branches.modals.add_client')
@endsection
@section('styles')
    @include('layouts.datatables_style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>


        $(document).ready(function() {
            $('#collected_by').change(function() {
                if ($(this).val() === 'driver') {
                    $('#bookingNumberSection input[name="booking_number"]').prop('readonly', false);
                } else {
                    $('#bookingNumberSection input[name="booking_number"]').prop('readonly', true);
                }
            });

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

        $(function () {
            // validation needs name of the element
            // initialize after multiselect

            $(document).ready(function () {

                // addItems();

                $('input.timepicker').timepicker({
                    timeFormat: 'h:mm p',
                    interval: 1,
                    dynamic: false,
                    dropdown: true,
                    scrollbar: true
                });

            });


            $('#number_of_pcs').on('change', function () {
                var number_of_pcs = $(this).val();
                $('#Container').html('');
                for (i = 0; i < $(this).val(); i++) {
                    var j = i+1;
                       var myClone =  $('#boxContainer').clone();

                        var k = i+1;
                        // var boxDimension =  $('#boxDimension').clone();
                        myClone.find('.box-title').html('<h6>Box ' + k+'</h6>' );
                        myClone.find('.box-length').attr('name','length'+k);
                        myClone.find('.box-height').attr('name','height'+k);
                        myClone.find('.box-width').attr('name','width'+k);
                        myClone.find('.box-unit-value').attr('name','unit_value'+k);
                        myClone.find('.box-weight').attr('data-weight', k);
                        myClone.find('.box-unit-value').attr('data-unit-value', k);
                        myClone.find('.box-total-value').attr('name','total_value'+k);
                        // myClone.clone().appendTo("#Container");

                         var myName = $(this).text();
                        myClone.find('.packageinfo-head').text( 'Package Info ' + j );
                        myClone.find('#addpackage').attr('id', 'addpackage'+j);
                        myClone.find('#additems').attr('id', 'additems'+j);
                        myClone.find('#packageinfo').attr('id', 'packageinfo'+j);
                        myClone.find('.packageinfo').attr('class', 'table table-bordered packageinfo'+j);
                        myClone.find('input[name="description[]"]').attr('name', 'description'+j+'[]');
                        myClone.find('input[name="qty[]"]').attr('name', 'qty'+j+'[]');
                        myClone.find('input[name="unit[]"]').attr('name', 'unit'+j+'[]');
                        myClone.find('input[name="unit'+j+'[]"]').attr('data-myAttri', j);
                        myClone.find('input[name="subtotal[]"]').attr('name', 'subtotal'+j+'[]');
                        myClone.find('#totalAmt').attr('id', 'totalAmt'+j);
                        myClone.find('#totalqty').attr('id', 'totalqty'+j);
                        myClone.clone().appendTo("#Container");



                }

                // $('#boxContainer').html('');
                // for (i = 0; i < $(this).val(); i++) {
                //     var k = i+1;
                //     var boxDimension =  $('#boxDimension').clone();
                //     boxDimension.find('.box-title').html('<h6>Box ' + k+'</h6>' );
                //     boxDimension.find('.box-length').attr('name','length'+k);
                //     boxDimension.find('.box-height').attr('name','height'+k);
                //     boxDimension.find('.box-weight').attr('name','weight'+k);
                //     boxDimension.find('.box-unit-value').attr('name','unit_value'+k);
                //     boxDimension.find('.box-weight').attr('data-weight', k);
                //     boxDimension.find('.box-unit-value').attr('data-unit-value', k);
                //     boxDimension.find('.box-total-value').attr('name','total_value'+k);
                //     boxDimension.clone().appendTo("#boxContainer");
                // }
                // $("#TotalDiv").css({'display':'block'});
                // $("#total-package").css({'display':'block'});

                addItems();
            });


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


            $('#AddSender').click(function () {
                $('#AddClient h4.modal-title').text("Add Sender");
                $('#AddClient #clientType').val("sender");
                $('.id_no label').text("Sender Id");
                $('.id_type label').text("Sender Identification Type");

                $("select[name='country_id']").val(<?=$previous_sender->address->country_id?>);
                $("select[name='state_id']").val(<?=$previous_sender->address->state_id?>);
                $("select[name='district_id']").val(<?=$previous_sender->address->district_id?>);
                <?php foreach ($previous_sender_state as $key => $value) { ?>
                      $('#state_id').append("<option value='<?=$value->id?>' '<?=$value->id==3396?' selected ':''  ?>'><?=$value->name?></option>");
                <?php } ?>
                <?php foreach ($previous_sender_district as $key => $value) { ?>
                      $('#district_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
                <?php } ?>
                var selectedOption = $('#country_id').find('option:selected');
                var phonecode = selectedOption.data('phonecode');

                $("#country_code_phone").val(phonecode);
                $("select[name='country_code_whatsapp']").val(phonecode);


                $('#AddClient').modal('show');

                $('#mobile2').text("Whatsapp");

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
                $('#AddClient h4.modal-title').text("Add Receiver");
                $('#AddClient #clientType').val("receiver");
                $('.id_no label').text("Receiver Id");
                $('.id_type label').text("Receiver Identification Type");
                $('#AddClient').modal('show');
                // console.log(<?=$previous_receiver->address->country_id?>);
                $("select[name='country_id']").val(<?=$previous_receiver->address->country_id?>);
                <?php foreach ($previous_receiver_state as $key => $value) { ?>
                      $('#state_id').append("<option value='<?=$value->id?>' '<?=$value->id== $previous_receiver->address->state_id?' selected ':''  ?>'><?=$value->name?></option>");
                <?php } ?>
                <?php foreach ($previous_receiver_district as $key => $value) { ?>
                      $('#district_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");
                <?php } ?>

                var selectedOption = $('#country_id').find('option:selected');
                var phonecode = selectedOption.data('phonecode');

                $("#country_code_phone").val(phonecode);
                $("select[name='country_code_whatsapp']").val(phonecode);



 $('#mobile2').text("Mobile 2");






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

            function addItems() {
                $('#addpackage1').click(function () {
                    var tr = $('#tr').html();
                    var html = `<tr>
                                <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description1[]" class="form-control"></td>
                                    <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty1[]"  class="form-control qty"></td>
                                    <td style="padding:10px"><input type="number"  data-myAttri="1" placeholder="Enter unit price" name="unit1[]" class="form-control unit"></td>
                                    <td style="padding:10px"><input type="number" readonly name="subtotal1[]" class="form-control value pkg-subtotal"></td>

                                </tr>`;
                    $('#packageinfo1 table').append(html)
                })


                $('#addpackage2').click(function () {
                    var tr = $('#tr').html();
                    var html = `<tr>
                                <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description2[]" class="form-control"></td>
                                    <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty2[]"  class="form-control qty"></td>
                                    <td style="padding:10px"><input type="number"  data-myAttri="2" placeholder="Enter unit price" name="unit2[]" class="form-control unit"></td>
                                    <td style="padding:10px"><input type="number" readonly name="subtotal2[]" class="form-control value pkg-subtotal"></td>

                                </tr>`;
                    $('#packageinfo2 table').append(html)
                })


                $('#addpackage3').click(function () {
                    var tr = $('#tr').html();
                    var html = `<tr>
                                <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description3[]" class="form-control"></td>
                                    <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty3[]"  class="form-control qty"></td>
                                    <td style="padding:10px"><input type="number"  data-myAttri="3" placeholder="Enter unit price" name="unit3[]" class="form-control unit"></td>
                                    <td style="padding:10px"><input type="number" readonly name="subtotal3[]" class="form-control value pkg-subtotal"></td>

                                </tr>`;
                    $('#packageinfo3 table').append(html)
                })


                $('#addpackage4').click(function () {
                    var tr = $('#tr').html();
                    var html = `<tr>
                                <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description4[]" class="form-control"></td>
                                    <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty4[]"  class="form-control qty"></td>
                                    <td style="padding:10px"><input type="number"  data-myAttri="4" placeholder="Enter unit price" name="unit4[]" class="form-control unit"></td>
                                    <td style="padding:10px"><input type="number" readonly name="subtotal4[]" class="form-control value pkg-subtotal"></td>
                                </tr>`;
                    $('#packageinfo4 table').append(html)
                })

                $('#addpackage5').click(function () {
                    var tr = $('#tr').html();
                    var html = `<tr>
                                <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description5[]" class="form-control"></td>
                                    <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty5[]"  class="form-control qty"></td>
                                    <td style="padding:10px"><input type="number"  data-myAttri="5" placeholder="Enter unit price" name="unit5[]" class="form-control unit"></td>
                                    <td style="padding:10px"><input type="number" readonly name="subtotal5[]" class="form-control value pkg-subtotal"></td>
                                </tr>`;
                    $('#packageinfo5 table').append(html)
                })


                    $(document).on("input", ".box-weight", function () {
                        var sum_value = 0;
                        $('.box-weight').each(function(){
                            sum_value += +$(this).val();
                            $("input[name='total_weight']").val(sum_value);
                        })

                        var wgt = $(this).attr("data-weight");
                        var total_weight = parseFloat($("input[name='weight"+wgt+"']").val());
                        var total_unit_value = parseFloat($("input[name='unit_value"+wgt+"']").val());
                        $("input[name='total_value"+wgt+"']").val( total_weight * total_unit_value);

                        var box_total = 0;
                        $('.box-total-value').each(function(){
                            box_total += +$(this).val();
                            $("input[name='grand_total_box_value']").val(box_total);
                        })

                    })


                    $(document).on("input", ".box-unit-value", function () {
                        var wgt = $(this).attr("data-unit-value");
                        var total_weight = parseFloat($("input[name='weight"+wgt+"']").val());
                        var total_unit_value = parseFloat($("input[name='unit_value"+wgt+"']").val());
                        $("input[name='total_value"+wgt+"']").val( total_weight * total_unit_value);

                        var box_total = 0;
                        $('.box-total-value').each(function(){
                            box_total += +$(this).val();
                            $("input[name='grand_total_box_value']").val(box_total);
                        })

                    })

                    $(document).on("input", ".msic_weight", function () {
                        var total_weight = parseFloat($("input[name='total_weight']").val());
                        var msic_weight = parseFloat($("input[name='msic_weight']").val());
                        $("input[name='grand_total_weight']").val( total_weight + msic_weight);
                    })

                    // $(document).on("input", ".box-total-value", function () {
                    //     var sum_value = 0;
                    //     $('.box-total-value').each(function(){
                    //         sum_value += +$(this).val();
                    //         $("input[name='grand_total_box_value']").val(sum_value);
                    //     })
                    // })

                    $(document).on("input", ".total", function () {
                        var sum_value = 0;
                        $('.total').each(function(){
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
                        $('.total').each(function(){
                            sum_value += +$(this).val();
                            if($("#discount").val() != '') {
                                var discount =  parseFloat($("#discount").val());
                            } else {
                                var discount = 0;
                            }
                            $("input[name='grand_total']").val(parseFloat(sum_value) - discount );
                        });

                        // var sum_grand_total = parseFloat($("input[name='grand_total']").val());
                        // var sum_discount = parseFloat($("#discount").val());

                        // if( sum_grand_total != '' && sum_grand_total > 0){
                        //     if( sum_discount > 0) {
                        //         $("input[name='grand_total']").val( sum_grand_total - sum_discount );
                        //     } else {
                        //         $("input[name='grand_total']").val( sum_grand_total);
                        //     }
                        // }
                    })

                    $(document).on("input", ".form-control", function () {
                        $("input[name='unit1[]']").each(function () {
                            var qty = $(this).parent('td').prev('td').find('input').val()
                            var unit = $(this).val();
                            $(this).parent('td').next('td').find('input').val(qty * unit);
                        });
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='subtotal1[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt1").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='qty1[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalqty1").text(sum);
                    })


                    $(document).on("input", ".form-control", function () {
                        $("input[name='unit2[]']").each(function () {
                            var qty = $(this).parent('td').prev('td').find('input').val()
                            var unit = $(this).val();
                            $(this).parent('td').next('td').find('input').val(qty * unit);
                        });
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='subtotal2[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt2").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='qty2[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalqty2").text(sum);
                    })


                    $(document).on("input", ".form-control", function () {
                        $("input[name='unit3[]']").each(function () {
                            var qty = $(this).parent('td').prev('td').find('input').val()
                            var unit = $(this).val();
                            $(this).parent('td').next('td').find('input').val(qty * unit);
                        });
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='subtotal3[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt3").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='qty3[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalqty3").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        $("input[name='unit4[]']").each(function () {
                            var qty = $(this).parent('td').prev('td').find('input').val()
                            var unit = $(this).val();
                            $(this).parent('td').next('td').find('input').val(qty * unit);
                        });
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='subtotal4[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt4").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='qty4[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalqty4").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        $("input[name='unit5[]']").each(function () {
                            var qty = $(this).parent('td').prev('td').find('input').val()
                            var unit = $(this).val();
                            $(this).parent('td').next('td').find('input').val(qty * unit);
                        });
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='subtotal5[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalAmt5").text(sum);
                    })

                    $(document).on("input", ".form-control", function () {
                        var sum = 0;
                        $("input[name='qty5[]']").each(function () {
                            sum += +$(this).val();
                        });
                        $("#totalqty5").text(sum);
                    })


                     $(document).on("keyup", ".unit", function (event) {
                        var keyPressed = event.keyCode || event.which;
                        if (keyPressed == 16) {
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

                    });
            }


            $('#country_id').change(function () {
                var country_id = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('states')}}?country_id=" + country_id;
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
                        $('#state_id').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                         
                        $('.country_code').val(result.phonecode);

                        if(result.phone_no_length!= null){
                            $("#phone").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#whatsapp_number").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#whatsapp_number").attr("maxlength", result.phone_no_length);

                        }
                        else {
                            $("#phone").attr("placeholder", "Enter phone");
                            $("#whatsapp_number").attr("placeholder", "Enter phone");
                        }


                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
            })


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
                        console.log(result);
                        // return false;
                        $('#loader').addClass('d-none');
                        console.log(result.phone_no_length);
                        if(result.phone_no_length!= null)
                        {
                            // $("#phone").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            $("#whatsapp_number").attr("placeholder", "Enter "+result.phone_no_length+" digits");
                            // $("#phone").attr("max", result.phone_no_length);
                            $("#whatsapp_number").attr("max", result.phone_no_length);
                        } else {
                            // $("#phone").attr("placeholder", "Enter phone");
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
                            $("#phone").attr("max", result.phone_no_length);
                            $("#phone").attr("maxlength", result.phone_no_length);
                        } else {
                            $("#phone").attr("placeholder", "Enter phone");

                        }

                    }, error: function (er) {
                        console.log(er);
                    }
                }); // ajax call closing


            });


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
                        console.log(result);
                        $('#loader').addClass('d-none');

                        $('#driver_or_staff').html(result.res);
                        // let option = ``;
                        // $('#city_id').html('<option value="">Select City</option>');
                        // $.each(result, function (key, value) {
                        //     $("#city_id").append('<option value="' + value
                        //         .id + '">' + value.name + '</option>');
                        // });

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

            // $('#weight, #rate, #packing_charge, #other_charges, #discount').on('blur', function () {
            //     calculateTotal();
            // })


            $("#add_client_shipments").submit(function (e) {
                e.preventDefault();
                $('.valid-err').hide()
                $('#loader').removeClass('d-none');
                //var data = $('#add_client_shipments').serialize();
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
                            //$("#err").append("<li class='alert alert-danger'>"+item+"</li>")

                            $('#' + key).after('<label class="valid-err text-danger">' + item + '</label>')
                        });
                    }
                }); // ajax call closing

            });

        });


        function clearForm() {
            $('#name').val("");
            $('#email').val("");
            $('#phone').val("");
            $('#zip_code').val("");
            $('#address').val("");
            $('#client_identification_number').val("");
        }

        function getVolume(event){
            var selected_volume  =   event.value;
            $('.volume').val(selected_volume);
            var shiping_method =  $("#shiping_method option:selected").attr('data-shiptypeid');
            $("#shipping_method_id").val(shiping_method);

        }


        $('.btnAction').click(function () {

            $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $(this).attr('disabled', true);
            $('#basic-form').submit();
        });


        $('#booking_code').keyup(function () {
            var booking_code = $(this).val();
            $('#loader').removeClass('d-none');
            const url = "{{route('branch.booking_code')}}?booking_code=" + booking_code;  //collectedBy

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (result) {
                    // when call is sucessfull
                    console.log(result);
                    $('#loader').addClass('d-none');

                    $("#sender_id").val(result);
                    $("#sender_id").trigger("change");

            // });

            //         $('#sender_id').on('change', function () {
            //     var address = $(this).find(":selected").data('address');
            //     var phone = $(this).find(":selected").data('phone');
            //     $("#sender_address").val(address);
            //     $("#sender_phone").val(phone);
            // });

                    // $('#driver_or_staff').html(result.res);
                    // let option = ``;
                    // $('#city_id').html('<option value="">Select City</option>');
                    // $.each(result, function (key, value) {
                    //     $("#city_id").append('<option value="' + value
                    //         .id + '">' + value.name + '</option>');
                    // });

                }, error: function (er) {
                    console.log(er);
                }

            }); // ajax call closing
        })



document.addEventListener('DOMContentLoaded', function() {

    function matchCustom(params, data) {
        console.log('Searching for:', params.term);

        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            return data;
        }

        if (data.element) {
            var phone = $(data.element).data('phone') ? $(data.element).data('phone').toString().toLowerCase() : '';
            var whatsapp = $(data.element).data('whatsapp') ? $(data.element).data('whatsapp').toString().toLowerCase() : '';

            var term = params.term.toLowerCase();

            console.log('Phone:', phone);
            console.log('WhatsApp:', whatsapp);
            console.log('Term:', term);

            // Check if term matches 'data-phone' or 'data-whatsapp'
            if (phone.indexOf(term) > -1 || whatsapp.indexOf(term) > -1) {
                console.log('Match found');
                return data;
            }
        }

        // Check if the term matches the text of the option
        if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
            console.log('Text match found');
            return data;
        }

        // Return `null` if the term should not be displayed
        return null;
    }



        $('#sender_id').select2({
            placeholder: "Select a Sender",
            allowClear: true,
            matcher: matchCustom
        });

        $('#receiver_id').select2({
            placeholder: "Select a Receiver",
            allowClear: true,
            matcher: matchCustom
        });



    const grand_total = document.querySelector('input[name="grand_total_weight"]');
    const rate_normal_weight = document.querySelector('input[name="rate_normal_weight"]');
    const amount_normal_weight = document.querySelector('input[name="amount_normal_weight"]');

    const electronics = document.querySelector('input[name="electronics_weight"]');
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

    const normal_weight = document.querySelector('input[name="normal_weight"]');

    const grand_total_weight = document.querySelector('input[name="grand_total_weight"]');
    const electronics_weight = document.querySelector('input[name="electronics_weight"]');
    const msic_weight = document.querySelector('input[name="msic_weight"]');

    const discount_weight = document.querySelector('input[name="discount_weight"]');
    const rate_discount_weight = document.querySelector('input[name="rate_discount_weight"]');
    const amount_discount_weight = document.querySelector('input[name="amount_discount_weight"]');

    const amount_grand_total = document.querySelector('input[name="amount_grand_total"]');



    function multiplyTotal() {
        const val1 = parseFloat(grand_total.value);
        const val2 = parseFloat(rate_normal_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_normal_weight.value =result.toFixed(0);
            }
            else{
                amount_normal_weight.value =result.toFixed(2);
            }
        }
        else {
            var result = 0;
        }
    }
    function multiplyDuty() {
        const val1 = parseFloat(electronics.value);
        const val2 = parseFloat(rate_electronics_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_electronics_weight.value =result.toFixed(0);
            }
            else{
                amount_electronics_weight.value =result.toFixed(2);
            }
        } else {
            var result = 0;
        }
    }
    function multiplyPacking() {
        const val1 = parseFloat(msic.value);
        const val2 = parseFloat(rate_msic_weight.value);
        if (!isNaN(val1) && !isNaN(val2)) {
            var result = (val1 * val2);
            if (Number.isInteger(result)){
                amount_msic_weight.value =result.toFixed(0);
            }
            else{
                amount_msic_weight.value =result.toFixed(2);
            }
        } else {
            var result = 0;
        }
    }


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
            var result = 0;
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
            var result = 0;
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
            var result = 0;
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
                amount_awbfee.value =result.toFixed(2);
            }
        } else {
            var result = 0;
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
            var result = 0;
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
            var result = 0;
        }
    }

    function totalQuantity() {
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

    function discountQuantity() {
        totalQuantity()
        const val1 = parseFloat(amount_discount_weight.value) || 0;
        const total = parseFloat(amount_grand_total.value) || 0;
        if (!isNaN(val1)) {
            var result = total - val1;
            // amount_grand_total.value = result.toFixed(2);
        }


    }


    grand_total.addEventListener('input', multiplyTotal);
    rate_normal_weight.addEventListener('input', multiplyTotal);

    electronics.addEventListener('input', multiplyDuty);
    rate_electronics_weight.addEventListener('input', multiplyDuty);

    msic.addEventListener('input', multiplyPacking);
    rate_msic_weight.addEventListener('input', multiplyPacking);

    add_pack_charge.addEventListener('input', multiplyAddPackCharge);
    rate_add_pack_charge.addEventListener('input', multiplyAddPackCharge);

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

    insurance.addEventListener('input', totalQuantity);
    volume_weight.addEventListener('input', totalQuantity);
    awbfee.addEventListener('input', totalQuantity);
    vat_amount.addEventListener('input', totalQuantity);
    grand_total_weight.addEventListener('input', totalQuantity);
    electronics_weight.addEventListener('input', totalQuantity);
    msic_weight.addEventListener('input', totalQuantity);
    add_pack_charge.addEventListener('input', totalQuantity);

    rate_normal_weight.addEventListener('input', totalQuantity);
    rate_electronics_weight.addEventListener('input', totalQuantity);
    rate_msic_weight.addEventListener('input', totalQuantity);
    rate_insurance.addEventListener('input', totalQuantity);
    rate_volume_weight.addEventListener('input', totalQuantity);
    rate_awbfee.addEventListener('input', totalQuantity);
    rate_vat_amount.addEventListener('input', totalQuantity);
    rate_add_pack_charge.addEventListener('input', totalQuantity);


    amount_normal_weight.addEventListener('input', totalQuantity);
    amount_electronics_weight.addEventListener('input', totalQuantity);
    amount_msic_weight.addEventListener('input', totalQuantity);
    amount_insurance.addEventListener('input', totalQuantity);
    amount_awbfee.addEventListener('input', totalQuantity);
    amount_vat_amount.addEventListener('input', totalQuantity);
    amount_volume_weight.addEventListener('input', totalQuantity);
    amount_add_pack_charge.addEventListener('input', totalQuantity);

    rate_discount_weight.addEventListener('input', discountQuantity);
    amount_discount_weight.addEventListener('input', discountQuantity);


});





    </script>

@endsection

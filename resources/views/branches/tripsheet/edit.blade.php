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
 
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
 
                            <form action="{{update_url($tripsheet->id)}}" id="editTripsheet" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                                <div class="col-md-12"> 

                                    
                                <div class="row"> 
                                        <div class="col-md-6  "> 
                                                <h4>Trip Details</h4>  
                                        </div> 
                                        <div class="col-md-6">
                                            <a href="{{index_url()}}" type="button"
                                            class="btn btn-primary waves-effect waves-light" style="float:right;">Back
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Trip Date</label>
                                                <input type="date"  class="form-control" id="trip_date" value="{{ $tripsheet->trip_date}}" name="trip_date"   placeholder="Trip date">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Trip Time</label>
                                                <input type="time"  class="form-control" id="trip_time" value="{{ $tripsheet->trip_time}}" name="trip_time"   placeholder="Trip time">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estimated Arrival Date</label>
                                                <input type="date"  class="form-control" id="estimate_arrival_date" value="{{ $tripsheet->estimate_arrival_date}}" name="estimate_arrival_date"   placeholder="Estimated Arrival Date">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Header</label>
                                                <select name="agency_id" id="agency_id" class="form-control">
                                                @foreach($agencies as $agency) 
                                                <option value="{{$agency->id}}">{{ Str::title($agency->name)}} </option>
                                                @endforeach
                                                </select>
                                                @error('agency_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Vehicle / Vendor</label>
                                                <select name="type" id="type" class="form-control">
                                                <option value="">-- Select Type -- </option>                                               
                                                <option value="vehicle"  {{ ($tripsheet->type== 'vehicle') ? 'selected' : "" }}>Vehicle</option>
                                                <option value="vendor"  {{ ($tripsheet->type== 'vendor') ? 'selected' : "" }}>Vendor</option>                                               
                                                </select> 
                                                @error('type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-4 vehicle">
                                            <div class="form-group">
                                                <label>Vehicle Number</label>
                                                <select name="vehicle_id" id="vehicle_id" class="form-control">
                                                <option value="">-- Select Vechicle -- </option>    
                                                @foreach($vehicles as $vehicle) 
                                                <option value="{{$vehicle->id}}"  {{ ($tripsheet->vehicle_id== $vehicle->id) ? 'selected' : "" }}>{{ $vehicle->vehicle_no}} </option>
                                                @endforeach
                                                </select> 
                                                @error('vehicle_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 vehicle">
                                            <div class="form-group">
                                                <label>Driver Name</label>
                                                <input type="text"  class="form-control" id="driver_name" value="{{ $tripsheet->driver_name}}" name="driver_name"   placeholder="Driver name">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                    
                                        <div class="col-md-4 vehicle">
                                            <div class="form-group">
                                                <label>Driver Mobile</label>
                                                <input type="text"  class="form-control" id="driver_mobile" value="{{ $tripsheet->driver_mobile}}" name="driver_mobile"   placeholder="driver_mobile">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-4 vendor">
                                            <div class="form-group">
                                                <label>Vendor Name</label> 
                                                <select name="vendor_id" id="vendor_id" class="form-control">
                                                <option value="">-- Select Vendor -- </option>    
                                                @foreach($vendors as $vendor) 
                                                <option value="{{$vendor->id}}"  {{ ($tripsheet->vendor_id== $vendor->id) ? 'selected' : "" }}>{{ $vendor->name}} </option>
                                                @endforeach
                                                </select> 
                                                @error('vendor_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 vendor">
                                            <div class="form-group">
                                                <label>Authorized Person</label>
                                                <input type="text"  class="form-control" id="authorized_person" name="authorized_person"   placeholder="Authorized person" value="{{$tripsheet->authorized_person}}">
                                                @error('authorized_person')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4 vendor">
                                            <div class="form-group">
                                                <label>Mobile Number</label>
                                                <input type="text"  class="form-control" id="mobile_number" name="mobile_number"  value="{{$tripsheet->mobile_number}}"  placeholder="Mobile Number">
                                                @error('mobile_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Helper</label>
                                                <input type="text"  class="form-control" id="hepler_name" value="{{ $tripsheet->hepler_name}}" name="hepler_name"   placeholder="hepler_name">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Helper Mobile</label>
                                                <input type="text"  class="form-control" id="helper_mobile" value="{{ $tripsheet->helper_mobile}}" name="helper_mobile"   placeholder="Helper mobile">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Start K.M</label>
                                                <input type="text"  class="form-control kmCalculate"  id="start_km" value="{{ $tripsheet->start_km}}" name="start_km"   placeholder="Start K.M">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Stop K.M</label>
                                                <input type="text"  class="form-control kmCalculate" id="stop_km" value="{{ $tripsheet->stop_km}}" name="stop_km"   placeholder="Stop K.M">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Total K.M</label>
                                                <input type="text"  class="form-control kmCalculate" id="total_km" value="{{ $tripsheet->total_km}}" name="total_km"   placeholder="Total km">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>  
                                   
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Total Rent</label>
                                                <input type="text"  class="form-control cal" id="total_rent" value="{{ $tripsheet->total_rent}}" name="total_rent"   placeholder="Total rent">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Destination</label> 
                                                <select name="destination" class="form-control"  id="destination" required>
                                                    <option value="">--- Select Destination ---</option>                                                             
                                                            <option {{ ($tripsheet->destination=='state') ? 'selected' : "" }}  value="state">State</option>
                                                            <option {{ ($tripsheet->destination=='vendor') ? 'selected' : "" }} value="vendor">Vendor</option> 
                                                    </select>
                                                    @error('destination')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror  
                                            </div>
                                        </div> 
                                        
                                    </div>

                                    <div class="header mt-5 mb-5">
                                        <h5>Expense Details</h5>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Diesel Amt</label>
                                                <input type="text"  class="form-control cal" id="diesel_amt" value="{{ $tripsheet->diesel_amt}}" name="diesel_amt"   placeholder="Diesel amt">
                                                @error('diesel_amt')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Batha Amt</label>
                                                <input type="text"  class="form-control cal" id="batha_amt" value="{{ $tripsheet->batha_amt}}" name="batha_amt"   placeholder="Batha Amt">
                                                @error('batha_amt')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Phone Exp</label>
                                                <input type="text"  class="form-control cal" id="phone_exp" value="{{ $tripsheet->phone_exp}}" name="phone_exp"   placeholder="Phone exp">
                                                @error('phone_exp')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Toll Expense</label>
                                                <input type="text"  class="form-control cal" id="toll_expense" value="{{ $tripsheet->toll_expense}}" name="toll_expense"   placeholder="Toll Expense">
                                                @error('toll_expense')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Food Amt</label>
                                                <input type="text"  class="form-control" id="food_amt cal" value="{{ $tripsheet->food_amt}}" name="food_amt"   placeholder="Food Amt">
                                                @error('food_amt')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Other Exp</label>
                                                <input type="text"  class="form-control" id="other_exp cal" value="{{ $tripsheet->other_exp}}" name="other_exp"   placeholder="Other Exp">
                                                @error('other_exp')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Expense Total</label>
                                                <input type="text"  class="form-control cal" id="expense_total" value="{{ $tripsheet->expense_total}}" name="expense_total"   placeholder="Expense Total">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Advance Amt</label>
                                                <input type="text"  class="form-control cal" id="advance_amt" value="{{ $tripsheet->advance_amt}}" name="advance_amt"   placeholder="Advance amt">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Balance Amount</label>
                                                <input type="text"  class="form-control" id="balance_amount" value="{{ $tripsheet->balance_amount}}" name="balance_amount"   placeholder="Balance Amount">
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control"  id="status" required>
                                                    <option value="">--- Select Status ---</option> 
                                                            <option {{ ($tripsheet->status=='trip_created') ? 'selected' : "" }} value="trip_created">Trip Created</option>
                                                            <option {{ ($tripsheet->status=='trip_started') ? 'selected' : "" }} value="trip_started">Trip started</option>
                                                            <option {{ ($tripsheet->status=='on_the_way') ? 'selected' : "" }} value="on_the_way">On the Way</option> 
                                                            <option {{ ($tripsheet->status=='trip_finished') ? 'selected' : "" }} value="trip_finished">Trip Finished</option> 
                                                    </select>
                                                    @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror  
                                            </div>
                                        </div>
                                    </div>

                                </div> 

                                <div class="text-center" style="display:block;">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update
                                    </button>
                                    <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>
                            </form>
                             

                            </div> 
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
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
<script> 
$( document ).ready(function() {
    var type = '<?=$tripsheet->type?>';
     
    if( type == 'vendor') {
        $(".vehicle").hide();
        $(".vendor").show();

    } else {
        $(".vendor").hide();
        $(".vehicle").show();

    }

});
 

$('#type').on('change', function () { 
    var type = $(this).val(); 
    
    if( type == 'vendor') {
        $(".vehicle").hide();
        $(".vendor").show();

    } else {
        $(".vendor").hide();
        $(".vehicle").show();

    }
});


$('.cal').on('change keyup', function () {  

console.log( "Ssa ");
var advance_amt = parseFloat($('#advance_amt').val()); 
// var expense_total = parseFloat($('#expense_total').val()); 
var other_exp = parseFloat($('#other_exp').val()); 
var food_amt = parseFloat($('#food_amt').val()); 
var toll_expense = parseFloat($('#toll_expense').val()); 
var phone_exp = parseFloat($('#phone_exp').val()); 
var batha_amt = parseFloat($('#batha_amt').val()); 
var diesel_amt = parseFloat($('#diesel_amt').val()); 
var total_rent = parseFloat($('#total_rent').val()); 


var total_amt =   other_exp + food_amt + toll_expense + phone_exp + batha_amt + diesel_amt + total_rent;
    $('#expense_total').val(total_amt); 

    var balance_amount = total_amt - advance_amt;
   
    $('#balance_amount').val(balance_amount); 


});


$('#vehicle_id').on('change', function () {

var vehicle_id = $(this).val();
$('#loader').removeClass('d-none');
const url = "{{route('branch.driver.getVechileDetailsById')}}?vehicle_id=" + vehicle_id;
console.log(url);
$.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (result) {
        // when call is sucessfull
        console.log(result);
        $('#loader').addClass('d-none');
        
            $("#driver_name").val(result.driver_name);  
            $("#driver_mobile").val(result.driver_mobile);  
            
        

    }, error: function (er) {
        console.log(er);
    }

}); // ajax call closing

});


$('#vendor_id').on('change', function () {

var vendor_id = $(this).val();
$('#loader').removeClass('d-none');
const url = "{{route('branch.vendor.getVendorDetailsById')}}?vendor_id=" + vendor_id;
console.log(url);
$.ajax({
url: url,
type: "GET",
dataType: "json",
success: function (result) {
    // when call is sucessfull
    console.log(result);
    $('#loader').addClass('d-none');
        $("#authorized_person").val(result.authorized_person);  
        $("#mobile_number").val(result.mobile_number);  
        
    

}, error: function (er) {
    console.log(er);
}

}); // ajax call closing

});



 
$('.kmCalculate').keyup(function () {   
    var stop_km =   $('#stop_km').val();
    var start_km  =  $('#start_km').val();
    var total = stop_km-  start_km;
    $('#total_km').val(total);
});

</script>  
@endsection 
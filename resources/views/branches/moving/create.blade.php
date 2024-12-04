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
                <!-- end page title -->
<!-- <a href="javascript:void();" class="save" id="saveMovingDraft" title="Save as Draft"> 
<i class="fa fa-save my-save"></i>
</a> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form action="{{store_url()}}"  id="addMoving" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                <div class="row"> 
                                    <div class="col-md-6  "> 
                                            <h4>Basic Info</h4>  
                                    </div> 
                                    <div class="col-md-6">
                                        <a href="{{index_url()}}" type="button"
                                        class="btn btn-primary waves-effect waves-light" style="float:right;">Back
                                        </a>
                                    </div>
                                </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking No.</label>
                                                <input type="text" value="{{$nextBookingNumber}}" name="moving_number" class="form-control"
                                                       required readonly >
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
                                                <option value='' selected="selected">Select </option>
                                                    @foreach (get_customers('sender') as $sender)
                                                        <option    value="{{ $sender->id }}"  data-phone="{{$sender->phone??""}}"
                                                                data-address="{{$sender->address->address??""}}">{{ $sender->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('sender_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" id="AddSender" class="btn btn-primary mt-sm-4"><i
                                                        class="fa fa-plus"></i></button>
                                            </div>

                                        </div>
                                        <div class="row form-group col-md-12">
                                            <label>Sender Address</label>
                                            <input readonly type="text" id="sender_address" class="form-control">
                                        </div>

                                        <div class="row form-group col-md-12">
                                            <label>Phone</label>
                                            <input readonly type="text" id="sender_phone" class="form-control">
                                        </div>
                                    </div>

                                  
                                        
                                    <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Source</label>
                                                    <select name="source_city" class="form-control"> 
                                                        @foreach ($cities_in_uae as $city)
                                                        <option     value="{{ $city->id }}">{{ $city->name }}</option>
                                                        @endforeach 
                                                    </select>
 
                                                </div>
                                            </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Destination</label>
                                            <select name="destination_city" class="form-control"> 
                                                @foreach ($cities_in_uae as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach 
                                            </select>

                                        </div>
                                    </div>

                                    <!--  -->


                                     
                                </div>

                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Moving Info</h4>
                                    </div>
                                    <div class="body">

                                        <div class="row">

                                        <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Moving Type</label>
                                                    <select name="moving_type" class="form-control">
                                                        <!-- <option value="Best Express"> Best Express</option> -->
                                                        @foreach ($movingTypes as $movingType)
                                                        <option
                                                            value="{{ $movingType->id }}">{{ $movingType->name }}</option>
                                                        @endforeach 
                                                    </select>

                                                    <!-- <input type="text" value="{{ old('agency_id') }}"
                                                           name="agency_id" class="form-control"> -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Shipping Info</h4>
                                    </div>
                                    <div class="body">

                                        <div class="row">

                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Payment Method</label>
                                                    <select name="payment_method" class="form-control" id="">
                                                        <option
                                                            {{ (!empty( $previous_booking->payment_method) == 'cash_payment') ? 'selected' : "" }} value="cash_payment">
                                                            Cash Payment
                                                        </option> 
                                                        <option
                                                            {{ (!empty( $previous_booking->payment_method) == 'credit') ? 'selected' : "" }} value="credit">
                                                            Credit
                                                        </option>                                                              
                                                        <option
                                                            {{ (!empty( $previous_booking->payment_method) == 'bank') ? 'selected' : "" }} value="bank">
                                                            Bank
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status_id" class="form-control"  id="status" required>
                                                    <option value="">--- Select Status ---</option>
                                                        @foreach (\App\Models\MovingStatuses::where('status',1)->get() as $item)
                                                            <option
                                                                {{ $item->id == 1 ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('status_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label>Date</label>
                                                        <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : date('Y-m-d')}}" max=""
                                                            class="form-control" id="propertyname" name="created_date"
                                                            placeholder="Enter title">
                                                </div>
                                            </div> 

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Collected By</label>
                                                    <select class="form-control" name="collected_by" id="collected_by" required>
                                                        <option value>Select</option>                                                        
                                                            <option  {{ (!empty($previous_booking->collected_by) == "driver" ) ? 'selected' : "" }} value="driver">Driver</option>
                                                            <option  {{ (!empty($previous_booking->collected_by) == "staff" ) ? 'selected' : "" }} value="staff">Office</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>  


                                        </div>
                                        <div class="row">
                                           
                                            
                                           
                                          
                                            <div class="col-md-3" id="driver_or_staff">
                                                <div class="form-group">
                                                @if(!empty($previous_booking->collected_by) == "driver")
                                                    <label>Driver Name</label>
                                                    <select class="form-control" name="driver_id">
                                                        <option value>Selct Driver</option>
                                                        @foreach($drivers as $driver)
                                                            <option  {{ (!empty($previous_booking->driver_id) == $driver->id ) ? 'selected' : "" }} value="{{$driver->id}}">{{$driver->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @else 
                                                    <label>Staff Name</label>
                                                        <select class="form-control" name="staff_id">
                                                            <option value>Selct Driver</option>
                                                            @foreach($staffs as $staff)
                                                                <option  {{ (!empty($previous_booking->staff_id) == $staff->id ) ? 'selected' : "" }} value="{{$staff->id}}">{{$staff->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @endif

                                                </div>
                                            </div>  

                                            <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label for="propertyname">Time</label>
                                                        <input type="text" name="time" value="" class="timepicker form-control"
                                                            id="propertyname" required
                                                            placeholder="Select Time" autocomplete="off" id="setTimeExample"> 
                                                    </div>  

                                                  
                                                </div>


                                                <div class="col-md-3">
                                                        <div class="form-group" id="confirmed_date"> 
                                                        <label>Confirmed Date</label>
                                                                <input type="date" value="{{date('Y-m-d')}}" max=""
                                                                    class="form-control" id="propertyname" name="confirmed_date"
                                                                    placeholder="Enter title">
                                                        </div>
                                                    </div> 



                                            <!-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Delivery Type</label>

                                                    <select class="form-control" name="delivery_type" id="delivery_type" required>
                                                        <option value>Select</option>                                                        
                                                            <option  {{ (!empty($previous_booking->delivery_type) == 'door_to_door' ) ? 'selected' : "" }} value="door_to_door">Door To Door</option>
                                                            <option  {{ (!empty($previous_booking->delivery_type) ==  'door_to_port' ) ? 'selected' : "" }} value="door_to_port">Door To Port</option>
                                                        
                                                    </select>

                                                    
                                                </div>
                                            </div>  -->
                                        </div>

                                        </div>
 
                                    

                                      
                                </div>


                                <div style="display:block;" class="mt-5"  >
                                    <div id="newBoxContainer" class="boxcount">  
                                        <div class="package col-md-12"  id="package_ID" >
                                            <div class="header">
                                                <div class="col-md-6"  style="float:left">  
                                                    <h5 class="packageinfo-head">PICK UP AND DROPS ITEMS</h5>
                                                </div> 
                                                <div class="col-md-6 text-right pb-2" style="float:left">  
                                                    <button type="button" id="addpackage" class="btn btn-success addpackage">Add Items</button>  
                                                </div> 
                                            </div>
                                            <div class="body" id="packageinfo"> 
                                                <table class="table table-bordered packageinfo">
                                                    <tr>
                                                    <td width="2%">
                                                        <span class="form-control border-0">1</span>
                                                        </td>

                                                        <td width="40%">
                                                            <input type="text" placeholder="Enter description"
                                                                name="description[]"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" placeholder="Enter quantity"
                                                                name="qty[]"
                                                                class="form-control qty">
                                                        </td> 
                                                        <td>
                                                            <button type="button"  name="remove[]" class="remove btn btn-danger" data-remove="">X</button>
                                                        </td>

                                                    </tr>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div style="display:block;" class="mt-5"  >
                                    <div id="newDismantlingContainer" class="boxcount">  
                                        <div class="dismantling col-md-12"  id="dismantling_ID" >
                                            <div class="header">
                                                <div class="col-md-6"  style="float:left">  
                                                    <h5 class="dismantling_info-head">DISMANTLING & FITTING</h5>
                                                </div> 
                                                <div class="col-md-6 text-right pb-2" style="float:left">  
                                                    <button type="button" id="add_dismantling" class="btn btn-success add_dismantling">Add Items</button>  
                                                </div> 
                                            </div>
                                            <div class="body" id="dismantlinginfo"> 
                                                <table class="table table-bordered dismantlinginfo">
                                                    <tr>
                                                    <td width="2%">
                                                        <span class="form-control border-0">1</span>
                                                        </td>

                                                        <td width="40%">
                                                            <input type="text" placeholder="Enter description"
                                                                name="dis_description[]"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" placeholder="Enter quantity"
                                                                name="dis_qty[]"
                                                                class="form-control dis_qty">
                                                        </td> 
                                                       
                                                        <td>
                                                            <button type="button"  name="remove[]" class="remove btn btn-danger" data-remove="">X</button>
                                                        </td>

                                                    </tr>
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                    <div class="col-md-12">                                    
                                        <div class="body">
                                            <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <span><b>Total Amount</b></span>                                                      
                                                        </div>
                                                    </div>                                             
                                                    <div class="col-md-4">
                                                        <div class="form-group">                                                    
                                                            <input type="text" placeholder="Total Amount"
                                                                        name="total_amount"
                                                                        class="form-control total_amount">
                                                            
                                                        </div>
                                                    </div> 
                                            </div>

                                            <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <span><b>Total Discount</b></span>                                                      
                                                        </div>
                                                    </div>                                             
                                                    <div class="col-md-4">
                                                        <div class="form-group">                                                    
                                                            <input type="text" placeholder="Total Discount"
                                                                        name="total_discount"
                                                                        class="form-control total_discount">
                                                            
                                                        </div>
                                                    </div> 
                                            </div>


                                            <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <span><b>Total</b></span>                                                      
                                                        </div>
                                                    </div>                                             
                                                    <div class="col-md-4">
                                                        <div class="form-group">                                                    
                                                            <input type="text" placeholder="Total"
                                                                        name="total"
                                                                        class="form-control total">
                                                            
                                                        </div>
                                                    </div> 
                                            </div>



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
@include('branches.modals.add_client')
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
<script>
 
$(function () {
    var pack_count=0;
    var dismantling_count=0;
    document.getElementById("addMoving").onkeypress = function(e) {
    var key = e.charCode || e.keyCode || 0;  
    if (key == 13) {  

     e.preventDefault();
    }
    else {
        // addItems(count);
    }
    } 

    $('input.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 1,   
            dynamic: false,
            dropdown: true,
            scrollbar: true
    });

    $('#confirmed_date').addClass('d-none'); 


});


$('#status').change(function(){
        var type = $(this).val();
        if(type==2)
        {
            $('#confirmed_date').removeClass('d-none');
            
        }else{
            $('#confirmed_date').addClass('d-none'); 
        }
    })

    $(".total_discount , .total_amount ").keyup(function(){
 
        var total_discount = parseFloat($(".total_discount").val());
        var total_amount = parseFloat($(".total_amount").val());
        $(".total").val(total_amount - total_discount) ;

    });

$('#sender_id').on('change', function () {
                var address = $(this).find(":selected").data('address');
                var phone = $(this).find(":selected").data('phone');
                $("#sender_address").val(address);
                $("#sender_phone").val(phone);
            });



            $(document).on("click", ".addpackage", function (event) {    
                var i = $(this).attr("data-myattri"); 
                var si = parseInt($(':input[name="description[]"]').length)+1;
                var tr = $('#tr').html();
                        var html = `<tr>
                                    <td style="padding:10px" width="2%"><span class="form-control border-0">`+si+`</span></td>
                                    <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description[]" class="form-control"></td>
                                        <td style="padding:10px"><input placeholder="Enter quantity" type="text" name="qty[]"  class="form-control qty"></td> 
                                        <td>
                                        <button type="button"  name="remove[]" class="remove btn btn-danger" data-remove="">X</button>
                                        </td>
                                    </tr>`;
                        $('#packageinfo table').append(html);
                        addremoveClass();
                        $("input[name='description[]']").focus();

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
                        $(".msic_weight").trigger("input");
                        $(".total").trigger("input");
                        $("#discount").trigger("input"); 
                        $(".qty").trigger("keyup"); 
                        $(".unit").trigger("keyup");                        

                        // addItems(boxCount);
                        $(".tot_wgt, .tot_rate, .tot_amt").trigger("input");
            });


            $(document).on("click", ".add_dismantling", function (event) {    
                var i = $(this).attr("data-myattri"); 
                var si = parseInt($(':input[name="dis_description[]"]').length)+1;
                var tr = $('#tr').html();
                        var html = `<tr>
                                    <td style="padding:10px" width="2%"><span class="form-control border-0">`+si+`</span></td>
                                    <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="dis_description[]" class="form-control"></td>
                                        <td style="padding:10px"><input placeholder="Enter quantity" type="text" name="dis_qty[]"  class="form-control dis_qty"></td> 
                                        <td>
                                        <button type="button"  name="remove[]" class="remove btn btn-danger" data-remove="">X</button>
                                        </td>
                                    </tr>`;
                        $('#dismantlinginfo table').append(html);
                        addremoveClass();
                        $("input[name='dis_description[]']").focus();

            });


            $(document).on("keyup", ".qty", function (event) {  
                var keyPressed = event.keyCode || event.which;                        
                if (keyPressed == 13) {
                     
                    $(".addpackage").click(); 
                    event.preventDefault();
                    return false;
                } 
              
            });


            $(document).on("keyup", ".dis_qty", function (event) {  
                var keyPressed = event.keyCode || event.which;                        
                if (keyPressed == 13) { 
                    $(".add_dismantling").click(); 
                    event.preventDefault();
                    return false;
                } 
              
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

        });
    }


    $('#AddSender').click(function () {
                $('#AddClient h4.modal-title').text("Add Sender");
                $('#AddClient #clientType').val("sender");
                $('.id_no label').text("Sender Id");
                $('.id_type label').text("Sender Identification Type");
                $("select[name='client_identification_type']").val('<?=$previous_sender->identification_type?>');
                $("select[name='country_id']").val(<?=$previous_sender->address->country_id?>);

                $('#state_id').html('');
                $('#whatsapp_number').html('');

                
                <?php foreach ($previous_sender_state as $key => $value) { ?>
                      $('#state_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");  
                <?php } ?> 

                $('#city_id').html('');
                <?php foreach ($previous_sender_city as $key => $value) { ?>
                      $('#city_id').append("<option value='<?=$value->id?>'><?=$value->name?></option>");  
                <?php } ?>                 


                $("#phone").attr("maxlength", <?=$prev_sender_phon_length->phone_no_length?>); 
                $("#whatsapp_number").attr("maxlength", <?=$prev_sender_phon_length->phone_no_length?>);

                $("#phone").attr("placeholder", "Enter "+<?=$prev_sender_phon_length->phone_no_length?>+" digits");
                $("#whatsapp_number").attr("placeholder", "Enter "+<?=$prev_sender_phon_length->phone_no_length?>+" digits");
                
                $("select[name='state_id']").val(<?=$previous_sender->address->state_id?>);
                $("select[name='city_id']").val(<?=$previous_sender->address->city_id?>);
                $("select[name='country_code_whatsapp']").val(<?=$previous_sender->country_code_whatsapp?>);
                $("select[name='country_code_phone']").val(<?=$previous_sender->country_code_phone?>);                

                $('#AddClient').modal('show');

            });
   
            

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
                            $("#phone").attr("maxlength", result.phone_no_length); 
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
                        } else {
                            $("#phone").attr("placeholder", "Enter phone");  

                        }

                    }, error: function (er) {
                        console.log(er);
                    }
                }); // ajax call closing


            });

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

        function clearForm() {
            $('#name').val("");
            $('#email').val("");
            $('#phone').val("");
            $('#zip_code').val("");
            $('#address').val("");
            $('#client_identification_number').val("");
        }
    </script>

@endsection

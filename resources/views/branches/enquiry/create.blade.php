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

    <div class="content-page">
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

                            <form action="{{store_url()}}"  id="addEnquiry" method="post" enctype="multipart/form-data">
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
                                                <label>Enquiry/ Booking</label>
                                                <select name="enquiry_type" class="form-control"  id="enquiry_type" required>
                                                        <option value="">--- Select Enquiry / Booking ---</option>                                                      
                                                        <option   value="booking">Booking</option>
                                                        <option   value="enquiry">Enquiry</option>                                                        
                                                </select>                                               
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking Type</label>
                                                <select name="type" class="form-control"  id="type" required> 
                                                        <option value="">--- Select Type ---</option>                                                      
                                                        <option   value="cargo">Cargo</option>
                                                        <option   value="moving">Moving</option>                                                        
                                                        <option   value="courier">Courier</option>                                                        
                                                        <option   value="travels">Travels</option>                                                        
                                                        <option   value="logistics">Logistics</option>                                                        
                                                </select>   
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Collected By</label>
                                                <select name="collected_by" class="form-control"  id="collected_by" required>
                                                        <option value="">--- Select Type ---</option>           
                                                        @foreach($staffs as $staff)                                           
                                                        <option   value="{{$staff->id}}">{{$staff->full_name}}</option> 
                                                        @endforeach
                                                </select>   
                                            </div>
                                        </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input type="text" value="" name="customer_name" class="form-control"
                                                         >
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Email</label>
                                                <input type="text" value="" name="customer_email" class="form-control"
                                                        placeholder="" >
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Country code</label>
                                                <select name="customer_code" class="form-control"  id="customer_code" required>
                                                        <option value="">--- Select Code ---</option>           
                                                        @foreach($country_code as $code)                                           
                                                        <option  {{ ($code->phonecode== '91') ? 'selected' : "" }}   value="{{$code->phonecode}}">{{$code->phonecode}}</option>
                                                        @endforeach
                                                </select>
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer Mobile</label>
                                                <input type="text" value="" id="customer_mobile" name="customer_mobile" class="form-control"
                                                        placeholder="" >
                                                @error('customer_mobile_error')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Country code</label>
                                                <select name="country_code_whatsapp" class="form-control"  id="country_code_whatsapp" required>
                                                        <option value="">--- Select Code ---</option>           
                                                        @foreach($country_code as $code)                                           
                                                        <option  {{ ($code->phonecode== '91') ? 'selected' : "" }}   value="{{$code->phonecode}}">{{$code->phonecode}}</option>
                                                        @endforeach
                                                </select>
                                                @error('country_code_whatsapp')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Whatsapp Number</label>
                                                <input type="text" value="" id="whatsapp_number"  name="whatsapp_number" class="form-control"
                                                        placeholder="" >
                                                @error('whatsapp_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-md-6">
                                        <div class="form-group id_type">
                                            <label for="emailAddress1">Sender Identification Type</label>
                                            <select name="client_identification_type" id="client_identification_type" class="form-control client_identification_type" >
                                                <option value="emirates_id">Emirates Id</option>
                                                <option value="aadhar">Aadhar</option>
                                                <option value="Driving Licence">Driving Licence</option>
                                                <option value="Passport">Passport</option>
                                                <option value="Iqama">Iqama</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group id_no">
                                            <label for="">Sender Id</label>
                                            <input type="text" class="form-control" name="client_identification_number" id="client_identification_number" placeholder="document id" onkeyup='validateAadhar(event)'>
                                            <div id="client_identification_number_error" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                    <input type="file"   name="document"    id="document"    multiple="true"
                                                class="form-control @error('files') is-invalid @enderror">
                            
                                            @error('files')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                         
                                    <!-- <div class="upload__box">
                                        <div class="upload__btn-box">
                                            <label class="upload__btn">
                                            <p>Upload Documents</p>
                                            <input type="file" multiple  name="documents[]"  class="upload__inputfile">
                                            
            
                                            </label>
                                        </div>
                                        <div class="upload__img-wrap"></div>
                                        </div>


                                    </div>  -->

                                    </div> 

                                     

                                </div>

                            

                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Location Info</h4>
                                    </div>
                                    <div class="body"> 
                                        <div class="row">  

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select style="width: 100% !important;" class="select form-control" name="country_id" id="country_id">
                                                    
                                                    @foreach ($countries as $item)
                                                        <option {{ ($item->id==14) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Emirates</label>  
                                                    <select name="state_id" class="form-control"  id="state_id" required>  
                                                    <option   value="">--- Select Emirate ---</option> 
                                                     
                                                        <option value="3396">Abu Dhabi</option>
                                                        <option value="3391">Dubai</option>                                                        
                                                        <option value="3390">Sharjah</option>                                                        
                                                        <option value="3394">Ras Al Khaimah</option>                                                        
                                                        <option value="3393">Fujairah</option>                                                        
                                                        <option value="3392">Umm al-Quwain</option>                                                        
                                                        <option value="3395">Ajman</option>                                                        
                                                    </select>   
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                           


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">District</label>
                                                    <select style="width: 100% !important;" class="select form-control" id="district_id" name="district_id">
                                                        <option value="">Select District</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">City</label>
                                                    <select style="width: 100% !important;" class="select form-control" id="city_id" name="city_id">
                                                        
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Street</label>
                                                    <input type="text" value="" name="street" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Po</label>
                                                    <input type="text" class="form-control" name="post" id="post" placeholder="post code">
                                                    <div id="post_error" class="text-danger"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">Zip / PinCode</label><span class="text-danger">*</span>
                                                    <input type="text" id="zip_code" name="zip_code" class="form-control"  onkeyup='validatePincode(event)'>
                                                    <div id="zip_code_error" class="text-danger"></div>
                                                    {{-- <select style="width: 100% !important;" disabled class=" form-control" id="city_modal_user select2" name="city_modal_user">
                                                    </select> --}}
                                                </div>
                                            </div>

                                            
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Building Name</label>
                                                    <input type="text" value="" name="building_name" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Flat no</label>
                                                    <input type="text" value="" name="flat_no" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="form-group" style="display: flex;align-items: top;">
                                                    <label for="booking_details">Details</label><br>
                                                        <textarea id="booking_details" name="booking_details"  class="form-control" rows="4" cols="50"> 
                                                        </textarea>
                                                </div>
                                            </div> -->

                                            <div class="col-md-6">
                                                <label for="booking_details" class="form-label">Details (Comments)</label>
                                                <textarea class="form-control"   name="booking_details"  id="booking_details" rows="3"></textarea>
                                            </div>

                                        </div> 
                                    </div>  
                                </div>


                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Dates</h4>
                                    </div>
                                    <div class="body"> 
                                        <div class="row">  
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date & Time</label>
                                                    <input type="datetime-local" name="date_time" class="form-control"  />
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of Survey</label>
                                                    <input type="date" value="" name="date_of_survey" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date for Collection</label>
                                                    <input type="date" value="" name="date_of_collection" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>  

                                               <input type="hidden" value="{{$nextBookingNumber}}" name="code" class="form-control"
                                                       required readonly >    
                                            
                                        </div> 

                                        <div class="text-center" style="display:block;">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                                </button>
                                                <a href="{{index_url()}}" type="button"
                                                class="btn btn-danger waves-effect waves-light">Cancel
                                                </a>
                                        </div>

                                    </div>  
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


@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')   
<script> 

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


function validate(event) {
    var maxlength =  $("#customer_mobile").attr("maxlength");
    var text = $("#customer_mobile").val();
    if( (text.length+1) == maxlength ) { 
        $("#customer_mobile").val(text.substr(0, maxlength)); 
        $("#customer_mobile_error").text("Number not more than " + maxlength);
        setTimeout(function(){ 
	            $("#customer_mobile_error").hide(); 
            },1000);            
    }
    else if( (text.length+1) <  maxlength ) {
        $("#customer_mobile_error").text("Number should be " + maxlength);
        setTimeout(function(){ 
	            $("#customer_mobile_error").show(); 
            },1000); 
    }

    var number = $("#customer_mobile").val();
    var code = $("#customer_code").val(); 
    const url = "{{route('checkPhoneNumberExists')}}?number=" + number+"&code="+code;       
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (result) {            
            if(result.status == "exist"){
                $("#customer_mobile_error").text("Already Exist for " + result.data.name );
                $("#customer_mobile_error").show();
            }
        }, error: function (er) {
            console.log(er);
        }
    }); // ajax call closing    
}


function validateWhatsapp(event) {
    var maxlength =  $("#whatsapp_number").attr("maxlength");
    var text = $("#whatsapp_number").val();       
    if( (text.length+1) ==  maxlength ) {
        $("#whatsapp_number").val(text.substr(0, maxlength)); 
        $("#whatsapp_number_error").text("Number not more than " + maxlength);
        setTimeout(function(){ 
	            $("#whatsapp_number_error").hide(); 
            },1000);            
    }
    else if( (text.length+1) <  maxlength )  {
        $("#whatsapp_number_error").text("Number should be " + maxlength);
        setTimeout(function(){ 
	            $("#whatsapp_number_error").show(); 
            },1000); 
    }

    var number = $("#whatsapp_number").val();
    var code = $("#country_code_whatsapp").val();
    $('#loader').removeClass('d-none');
    const url = "{{route('checkNumberExists')}}?number=" + number+"&code="+code;    
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (result) {            
            if(result.status == "exist"){
                $("#whatsapp_number_error").text("Already Exist for " + result.data.name );
                $("#whatsapp_number_error").show();
            }
        }, error: function (er) {
            console.log(er);
        }
    }); // ajax call closing
}


function validateAadhar(event) {
    var maxlength =  12;
    var text = $("#client_identification_type").val();
    var country_id = $("#country_id").val();
    var doc=  $("#client_identification_number").val();     
        if(text == "aadhar") {
            if( (doc.length) > maxlength ) {
                    $("#client_identification_number").val(doc.substr(0, maxlength)); 
                    $("#client_identification_number_error").text("Number not more than " + maxlength);
                    setTimeout(function(){ 
                            $("#client_identification_number_error").show(); 
                        },1000);                        
                }
                else if( (doc.length) < maxlength )  {
                    $("#client_identification_number_error").text("Number should be " + maxlength);
                    setTimeout(function(){ 
                           
                            $("#client_identification_number_error").hide(); 
                        },1000); 
                }
        }    
}

function validatePincode(event) {
    var maxlength =  6; 
    var country_id = $("#country_id").val();
    var doc=  $("#zip_code").val();
    if(country_id == '101') { 
            if( (doc.length) >  maxlength ) {
                $("#zip_code").val(doc.substr(0, maxlength)); 
                $("#zip_code_error").text("Number not more than " + maxlength);
                setTimeout(function(){ 
                        $("#zip_code_error").show(); 
                    },1000);                        
            }
            else if( (doc.length) <  maxlength )  {
                $("#zip_code_error").text("Number should be " + maxlength);
                setTimeout(function(){                           
                        $("#zip_code_error").hide(); 
                    },1000); 
            }
        
    }    
}

</script>

@endsection

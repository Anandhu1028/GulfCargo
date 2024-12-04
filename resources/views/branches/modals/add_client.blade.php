<div class="modal fade" id="AddClient" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add sender</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="add_client_shipments" name="add_client_shipments" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div id="msg" class="w-100"></div>
                        </div>
                    </div>

                    <input type="hidden" id="clientType" name="client_type" value="sender">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailAddress1">Name</label> <span class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailAddress1">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="<?php //echo $lang['user_manage5'] ?>">
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group id_no">
                                <label for="">Sender Id</label>
                                <input type="text" class="form-control" name="client_identification_number" id="client_identification_number" placeholder="document id" onkeyup='validateAadhar(event)'>
                                <div id="client_identification_number_error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Upload Document</label>
                                <input type="file" class="form-control" name="document" id="document" placeholder="document">
                            </div>
                        </div>
                    </div>





                    <hr>
                    <h4>Add Address </h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country</label><span class="text-danger">*</span>
                                <select style="width: 100% !important;" class="select form-control" name="country_id" id="country_id">

                                        @foreach ($countries as $item)
                                        <option value="{{ $item->id }}" data-phonecode={{ $item->phonecode }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">State</label><span class="text-danger">*</span>
                                <select style="width: 100% !important;" class="select form-control" id="state_id" name="state_id">
                                    <option value="273">Al Manamah</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">District</label><span class="text-danger">*</span>
                                <select style="width: 100% !important;" class="select form-control" id="district_id" name="district_id">
                                    <option value="">Select District</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">City</label>
                                {{-- <select style="width: 100% !important;" class="select form-control" id="city_id" name="city_id">

                                </select> --}}

                                <input type="text" class="form-control" name="cities" id="cities" placeholder="city" >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Po</label>
                                <input type="text" class="form-control" name="post" id="post" placeholder="post" >
                                <div id="post_error" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">Zip / PinCode</label>{{-- <span class="text-danger">*</span> --}}
                                <input type="text" id="zip_code" name="zip_code" class="form-control" >
                                {{-- <div id="zip_code_error" class="text-danger"></div> --}}
                                {{-- <select style="width: 100% !important;" disabled class=" form-control" id="city_modal_user select2" name="city_modal_user">
                                </select> --}}
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Code</label>
                                <select style="width: 100% !important;" class="select form-control country_code" name="country_code_whatsapp" id="country_code_whatsapp">
                                @foreach (get_country_code() as $code)
                                    <option value="{{ $code }}" data-address="{{$code }}">{{ $code }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for=""  id="mobile1">Mobile 1</label><span class="text-danger">*</span>
                                <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" placeholder="whatsapp number" onkeyup='validateWhatsapp(event)'>
                                <div id="whatsapp_number_error" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-1 " >
                            <label for=""></label>
                            <div class="form-group pt-1 " style="width: 23px;">
                                <input class="form-control" type="checkbox" value="" id="whatsapp_same">
                              </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Code</label>
                                <select style="width: 100% !important;" class="select form-control country_code" name="country_code_phone" id="country_code_phone">
                                @foreach (get_country_code() as $code)
                                    <option value="{{ $code }}" data-address="{{$code }}" >{{ $code }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" id="mobile2">Mobile 2</label><span class="text-danger">*</span>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="phone"   onkeyup='validate(event)'>
                                <div id="phone_error" class="text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phoneNumber1">Address</label> <span class="text-danger">*</span>
                                <textarea rows="1" class="form-control" name="address" id="address" placeholder="address"></textarea>
                            </div>
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="save_data_user">Save</button>
                 <!-- Button for editing an existing sender -->
    <button type="button" id="update_data_user" class="btn btn-success" style="display: none;">Update Sender</button>
      <!-- Button for editing an existing receiver -->
      <button type="button" id="update_data_receiver" class="btn btn-success" style="display: none;">Update Receiver</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>

function validate(event) {
    var maxlength =  $("#phone").attr("max");
    console.log(maxlength);
    var text = $("#phone").val();
    if( (text.length+1) == maxlength ) {
        $("#phone").val(text.substr(0, maxlength));
        $("#phone_error").text("Number not more than " + maxlength);
        setTimeout(function(){
	            $("#phone_error").hide();
            },1000);
    }
    else if( (text.length+1) <  maxlength ) {
        $("#phone_error").text("Number should be " + maxlength);
        setTimeout(function(){
	            $("#phone_error").show();
            },1000);
    }

    var number = $("#phone").val();
    var code = $("#country_code_phone").val();
    const url = "{{route('checkPhoneNumberExists')}}?number=" + number+"&code="+code;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function (result) {
            if(result.status == "exist"){
                $("#phone_error").text("Already Exist for " + result.data.name );
                $("#phone_error").show();
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

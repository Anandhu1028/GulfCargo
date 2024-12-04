@extends('layouts.app')

@section('content')
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
	bottom:80px;
	left:40px;
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
	bottom:150px;
	left:40px;
	background-color:#cc5100;
	color:#FFF;
	/* border-radius:50px; */
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-save{
	margin-top:22px;
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
                <!-- end page title -->

 
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <form action="{{update_url($enquiry->id)}}" id="editEnquiry" method="post" enctype="multipart/form-data">
                                @method('PUT')
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
                                                        <option    {{ ($enquiry->enquiry_type== 'booking') ? 'selected' : "" }}    value="booking">Booking</option>
                                                        <option    {{ ($enquiry->enquiry_type== 'enquiry') ? 'selected' : "" }}  value="enquiry">Enquiry</option>                                                        
                                                </select>                                               
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking Type</label>
                                                <select name="type" class="form-control"  id="type" required> 
                                                        <option value="">--- Select Type ---</option>                                                      
                                                        <option  {{ ($enquiry->type== 'cargo') ? 'selected' : "" }} value="cargo">Cargo</option>
                                                        <option  {{ ($enquiry->type== 'moving') ? 'selected' : "" }} value="moving">Moving</option>                                                        
                                                        <option  {{ ($enquiry->type== 'courier') ? 'selected' : "" }} value="courier">Courier</option>                                                        
                                                        <option  {{ ($enquiry->type== 'travels') ? 'selected' : "" }} value="travels">Travels</option>                                                        
                                                        <option  {{ ($enquiry->type== 'logistics') ? 'selected' : "" }} value="logistics">Logistics</option>                                                        
                                                </select>   
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Collected By</label>
                                                <select name="collected_by" class="form-control"  id="collected_by" required>
                                                        <option value="">--- Select Type ---</option>           
                                                        @foreach($staffs as $staff)                                           
                                                        <option  {{ ($enquiry->collected_by== $staff->id) ? 'selected' : "" }}   value="{{$staff->id}}">{{$staff->full_name}}</option> 
                                                        @endforeach
                                                </select>   
                                            </div>
                                        </div>

                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input type="text" value="{{$enquiry->customer_name}}" name="customer_name"  class="form-control"
                                                         >
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Customer Email</label>
                                                <input type="text" value="{{$enquiry->customer_name}}" name="customer_email" class="form-control"
                                                        placeholder="" >
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    
                                        <!-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Country code</label>
                                                <input type="text" value="{{$enquiry->customer_name}}" name="customer_code" class="form-control"
                                                        placeholder="" >
                                                @error('booking_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> -->

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Country code</label>
                                                <select name="customer_code" class="form-control"  id="customer_code" required>
                                                        <option value="">--- Select Code ---</option>           
                                                        @foreach($country_code as $code)                                           
                                                        <option  {{ ($enquiry->customer_code ==  $code->phonecode) ? 'selected' : "" }}   value="{{$code->phonecode}}">{{$code->phonecode}}</option>
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
                                                <input type="text" value="{{$enquiry->customer_mobile}}" name="customer_mobile" class="form-control"
                                                        placeholder="" >
                                                @error('booking_number')
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
                                            <input type="text" value="{{ $enquiry->whatsapp_number }}" id="whatsapp_number"  name="whatsapp_number" class="form-control"
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
                                                <option  {{ ($enquiry->client_identification_type ==  'emirates_id' ) ? 'selected' : "" }} value="emirates_id">Emirates Id</option>
                                                <option  {{ ($enquiry->client_identification_type ==  'aadhar' ) ? 'selected' : "" }} value="aadhar">Aadhar</option>
                                                <option  {{ ($enquiry->client_identification_type ==  'Driving Licence' ) ? 'selected' : "" }} value="Driving Licence">Driving Licence</option>
                                                <option  {{ ($enquiry->client_identification_type ==  'Passport' ) ? 'selected' : "" }} value="Passport">Passport</option>
                                                <option  {{ ($enquiry->client_identification_type ==  'Iqama' ) ? 'selected' : "" }} value="Iqama">Iqama</option>
                                                <option  {{ ($enquiry->client_identification_type ==  'Other' ) ? 'selected' : "" }} value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group id_no">
                                            <label for="">Sender Id</label>
                                            <input type="text" class="form-control" value="{{$enquiry->client_identification_number}}" name="client_identification_number" id="client_identification_number" placeholder="document id" onkeyup='validateAadhar(event)'>
                                            <div id="client_identification_number_error" class="text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="emailAddress1">Document &nbsp;&nbsp; &nbsp;
                                        @if(!empty($enquiry->logo))
                                        <a href="{{asset($enquiry->logo)}}" target="_blank" />View Doc</a></label> 
                                        @endif

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
                                                <option  {{ ($enquiry->country_id== '') ? 'selected' : "" }} value="">--- Select Country ---</option>       
                                                    @foreach ($countries as $item)
                                                        <option {{ ($item->id==$enquiry->country_id ) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div> 

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Emirates</label> 
                                                    <select name="state_id" class="form-control"  id="state_id" required>  

                                                    <option  {{ ($enquiry->state_id== '') ? 'selected' : "" }} value="">--- Select Emirate ---</option>       
                                                    @foreach ($states as $item)
                                                        <option {{ ($item->id== $enquiry->state_id ) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach  
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
                                                        <option  {{ ($item->id== '' ) ? 'selected' : "" }} value="">Select District</option> 
                                                    @foreach ($districts as $item)
                                                        <option {{ ($item->id==$enquiry->district_id ) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">City</label>
                                                    <select style="width: 100% !important;" class="select form-control" id="city_id" name="city_id">
                                                    <option  {{ ($enquiry->city_id== '') ? 'selected' : "" }} value="">--- Select City ---</option>       
                                                    @foreach ($cities as $item)
                                                        <option {{ ($item->id==$enquiry->city_id ) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Street</label>
                                                    <input type="text" value="{{$enquiry->street}}" name="street" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Po</label>
                                                    <input type="text" class="form-control" name="post" value="{{$enquiry->post}}" id="post" placeholder="post code">
                                                    <div id="post_error" class="text-danger"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="">Zip / PinCode</label><span class="text-danger">*</span>
                                                    <input type="text" id="zip_code" name="zip_code"  value="{{$enquiry->zip_code}}" class="form-control"  onkeyup='validatePincode(event)'>
                                                    <div id="zip_code_error" class="text-danger"></div>
                                                    {{-- <select style="width: 100% !important;" disabled class=" form-control" id="city_modal_user select2" name="city_modal_user">
                                                    </select> --}}
                                                </div>
                                            </div>
 

                                        
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Building Name</label>
                                                    <input type="text" value="{{$enquiry->building_name}}"   name="building_name" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Flat no</label>
                                                    <input type="text" value="{{$enquiry->flat_no}}" name="flat_no" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <label for="booking_details" class="form-label">Details (Comments)</label>
                                                <textarea class="form-control"   name="booking_details"  id="booking_details" rows="3"> {{$enquiry->booking_details}}</textarea>
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
                                                    <input type="datetime-local" value="{{$enquiry->date_time}}" name="date_time" class="form-control"  />
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date of Survey</label>
                                                    <input type="date" value="{{ isset($enquiry->date_of_survey) ? date('Y-m-d', strtotime($enquiry->date_of_survey)) : date('Y-m-d')}}" name="date_of_survey" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date for Collection</label>
                                                    <input type="date" value="{{ isset($enquiry->date_of_collection) ? date('Y-m-d', strtotime($enquiry->date_of_collection)) : date('Y-m-d')}}" name="date_of_collection" class="form-control"
                                                            placeholder="" >
                                                    @error('booking_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>  

                                               <input type="hidden" value="{{$enquiry->code}}" name="code" class="form-control"
                                                       required readonly >    
                                            
                                        </div>  
                                       
                                        <div class="text-center" style="display:block;">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Update
                                        </button>
                                        <a href="{{index_url()}}" type="button"
                                        class="btn btn-danger waves-effect waves-light">Cancel
                                        </a>
                                    </div> 


                                    </div>  
                                </div>

                                    
                            </form>
                       
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
  
 

</script>

@endsection

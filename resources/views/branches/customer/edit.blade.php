@extends('layouts.app')

@section('content')

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
                        <form action="{{ update_url($customer->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="propertyname">Name</label>
                                        <input type="text" name="name" value="{{ $customer->name}}" class="form-control" id="propertyname" required placeholder="Enter Name">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="propertyname">Email</label>
                                        <input type="text" name="email" value="{{ $customer->email}}" class="form-control" id="propertyname" required placeholder="Enter Email id">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="logo">Selct Branch</label>
                                        <select class="form-control" name="branch_id" required>
                                            <option value="">---Selct Branch---</option>
                                            @foreach(\App\Models\Branches::all() as $branch)
                                            <option value="{{$branch->id}}" @if($customer->branch_id==$branch->id) selected @endif >{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="logo">Selct Customer Type</label>
                                        <select class="form-control" name="type" required>
                                            <option value>Selct Type</option>
                                            <option value="sender" @if($customer->type== 'sender') selected @endif >Sender</option>
                                            <option value="receiver" @if($customer->type== 'receiver') selected @endif>Receiver</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <select style="width: 100% !important;" class="select form-control" name="country_code_whatsapp" id="country_code_whatsapp">
                                            @foreach (get_country_code() as $code)
                                            <option value="{{ $code }}" data-address="{{$code }}" @if($customer->country_code_whatsapp== $code) selected @endif >+{{ $code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="propertyname">Whatsapp number</label>
                                        <input type="text" name="whatsapp_number" value="{{ $customer->whatsapp_number}}" class="form-control" id="whatsapp_number" required placeholder="Enter contact number">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <select style="width: 100% !important;" class="select form-control" name="country_code_phone" id="country_code_phone">
                                            @foreach (get_country_code() as $code)
                                            <option value="{{ $code }}" data-address="{{$code }}" @if($customer->country_code_phone== $code) selected @endif>+{{ $code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="propertyname">Contact number</label>
                                        <input type="text" name="phone" value="{{$customer->phone}}" class="form-control" id="phone" required placeholder="Enter contact number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group id_type">
                                        <label for="emailAddress1">Sender Identification Type</label>
                                        <select name="client_identification_type" class="form-control">
                                            <option value="cpr_no" @if($customer->country_code_phone== "cpr_no") selected @endif >CPR No</option>
                                            <option value="aadhar" @if($customer->country_code_phone== "aadhar") selected @endif>Aadhar</option>
                                            <option value="Driving Licence" @if($customer->country_code_phone== "Driving Licence") selected @endif>Driving Licence</option>
                                            <option value="Passport" @if($customer->country_code_phone== "Passport") selected @endif>Passport</option>
                                            <option value="Iqama" @if($customer->country_code_phone== "Iqama") selected @endif>Iqama</option>
                                            <option value="Other" @if($customer->country_code_phone== "Other") selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group id_no">
                                        <label for="">Sender Id</label>
                                        <input type="text" class="form-control" name="client_identification_number" id="client_identification_number" placeholder="document id" value="{{$customer->phone}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Upload Document</label>
                                        <img src="{{url($customer->logo??'#') }}" width="50"class=" mr-3">
                                        <input type="file" class="form-control" name="document" id="document" placeholder="document">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h4>Add Address </h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select style="width: 100% !important;" class="select form-control" name="country_id" id="country_id">
                                            @foreach ($countries as $item)
                                            <option {{ ( $customer->address->country_id == $item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="">State</label>
                                        <select style="width: 100% !important;" class="select form-control" id="state_id" name="state_id">
                                            <option value="{{$customer->address->state->id}}">{{$customer->address->state->name}}</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="">District</label>
                                        <select style="width: 100% !important;" class="select form-control" id="district_id" name="district_id">
                                            <option value="{{$customer->address->district->id??'-'}}">{{$customer->address->district->name??'-'}}</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="">City</label>
                                        <select style="width: 100% !important;" class="select form-control" id="city_id" name="city_id">
                                            <option value="{{$customer->address->city->id??'-'}}">{{$customer->address->city->name??'-'}}</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="">Zip Code</label>
                                        <input type="text" id="zip_code" name="zip_code" class="form-control" value="{{$customer->address->zip_code}}">
                                        {{-- <select style="width: 100% !important;" disabled class="select2 form-control" id="city_modal_user" name="city_modal_user">
                                                </select> --}}
                                    </div>
                                </div>

                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phoneNumber1">Address</label>
                                        <textarea rows="3" class="form-control" name="address" id="address" placeholder="address">{{$customer->address->address}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- end row -->

                            <div class="text-center">
                            <input type="hidden" name="user_id" value="{{ $customer->user->id}}" />
                                <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                </button>
                                <a href="{{index_url()}}" type="button" class="btn btn-danger waves-effect waves-light">Cancel
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


    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    2018 - 2020 &copy; Zircos theme by <a href="#">Coderthemes</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>
@endsection
@section('styles')
@include('layouts.datatables_style')
@endsection

@section('scripts')
@include('layouts.datatables_js')
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




    </script>
@endsection

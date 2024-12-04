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

                            <form action="{{update_url($shipment->id)}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="header">
                                            <h4>Basic Info</h4>
                                        </div>
                                        <div class="body">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Booking No.</label>
                                                        <input type="text" name="booking_number" value="{{ $shipment->booking_number }}" class="form-control" required>
                                                        @error('booking_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Agency List</label>
                                                        <select autofocus name="agency_list" id="agency_list" class="form-control">
                                                            @foreach ($agencies as $agency)
                                                                <option {{ ($shipment->agency_list==$agency->id) ? 'selected' : "" }} value="{{ $agency->id }}">{{ $agency->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Origin Office</label>
                                                        <select name="origin_office" id="origin_office" class="form-control">
                                                            @foreach ($origin_offices as $office)
                                                                <option {{ ($shipment->origin_office==$office->id) ? "selected" : "" }} value="{{ $office->id }}">{{ $office->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="header">
                                            <h4>Sender Info</h4>
                                        </div>
                                        <div class="body row">
                                            <div class="form-group col-md-10">
                                                <label>Sender/Customer</label>
                                                <select name="sender_id" id="sender_id" class="form-control">
                                                    @foreach (get_customers("sender") as $sender)
                                                        <option {{ ($shipment->sender_id==$sender->id) ? "selected" : "" }} value="{{ $sender->id }}">{{ $sender->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('sender_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" id="AddSender" class="btn btn-primary mt-4"><i class="fa fa-plus"></i></button>
                                            </div>

                                        </div>
                                        <div class="body">
                                            <div class="form-group">
                                                <label>Sender Address</label>
                                                <input readonly type="text" value="{{ ($shipment->sender->address) ? $shipment->sender->address->address : "" }}"  id="sender_address" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="header">
                                            <h4>Receiver Info</h4>
                                        </div>
                                        <div class="body row">
                                            <div class="form-group col-md-10">
                                                <label>Receiver/Customer</label>
                                                <select name="receiver_id" id="receiver_id" class="form-control">
                                                    @foreach (get_customers("receiver") as $receiver)
                                                        <option {{ ($shipment->receiver_id==$receiver->id) ? "selected" : "" }} value="{{ $receiver->id }}">{{ $receiver->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('receiver_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" id="AddReceiver" class="btn btn-primary mt-4"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="body">
                                            <div class="form-group">
                                                <label>Receiver Address</label>
                                                <input readonly type="text" value="{{ ($shipment->receiver) ? $shipment->receiver->address->address??"" : "" }}" id="receiver_address" class="form-control">
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
                                                        <label>Receipt Number</label>
                                                        <input type="text" value="{{ $shipment->receipt_number }}" class="form-control"  name="receipt_number">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Packaging Type</label>
                                                        <input type="text" value="{{ $shipment->packing_type }}" name="packing_type" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Courier Company</label>
                                                        <input type="text" value="{{ $shipment->courier_company }}" name="courier_company" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Shipping Methods</label>
                                                        <select name="shiping_method" class="form-control" id="">
                                                            <option {{ ($shipment->shiping_method=='Air') ? 'selected' : "" }} value="Air">Air</option>
                                                            <option {{ ($shipment->shiping_method=='Sea') ? 'selected' : "" }} value="Sea">Sea</option>
                                                            <option {{ ($shipment->shiping_method=='Raoad') ? 'selected' : "" }} value="Road">Road</option>

                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Payment Method</label>
                                                        <select name="payment_method" class="form-control" id="">
                                                            <option {{ ($shipment->payment_method=='cash_payment') ? 'selected' : "" }} value="cash_payment">Cash Payment</option>
                                                            <option {{ ($shipment->payment_method=='paypal') ? 'selected' : "" }} value="paypal">Paypal</option>
                                                            <option {{ ($shipment->payment_method=='stripe') ? 'selected' : "" }} value="stripe">Stripe</option>
                                                            <option {{ ($shipment->payment_method=='paystack') ? 'selected' : "" }} value="paystack">Paystack</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Delivery Status</label>
                                                        <select name="status_id" class="form-control" id="">
                                                            @foreach ( status_list_admin() as $item)
                                                                <option {{ ($shipment->status_id==$item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('status_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>No.of Pcs</label>
                                                        <input value="{{ $shipment->number_of_pcs }}" type="text" name="number_of_pcs" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Weight</label>
                                                        <input type="text" id="weight" value="{{ $shipment->weight ?? 0 }}" name="weight" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Rate</label>
                                                        <input type="text" id="rate" value="{{ $shipment->rate ?? 0 }}" name="rate" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Packing Charge</label>
                                                        <input type="text" value="{{ $shipment->packing_charge ?? 0 }}" id="packing_charge" class="form-control" name="packing_charge">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Other Charges</label>
                                                        <input type="text" value="{{ $shipment->other_charges ?? 0 }}" id="other_charges" class="form-control" name="other_charges">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Discount</label>
                                                        <input type="text" value="{{ $shipment->discount ?? 0 }}" id="discount" name="discount" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Total</label>
                                                        <input type="text" value="{{ $shipment->total_amount ?? 0 }}" name="total_amount"  id="total_amount" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Length</label>
                                                        <input type="text" name="length" value="{{ $shipment->length }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Width</label>
                                                        <input class="form-control" value="{{ $shipment->width }}" type="text" name="width">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Height</label>
                                                        <input type="text" name="height" value="{{ $shipment->height }}" class="form-control">
                                                    </div>
                                                </div>                                                
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Driver Name</label>
                                                        <select class="form-control" name="driver_id" required>
                                                            <option value>Selct Driver</option>
                                                            @foreach($drivers as $driver)
                                                                <option {{ (isset($shipment->driver->id) == $driver->id) ? 'selected' : "" }} 
                                                                value="{{$driver->id}}">{{ $driver->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>LRL Tracking Code</label>
                                                        <input type="text" value="{{$shipment->lrl_tracking_code}}" name="lrl_tracking_code" class="form-control">
                                                    </div>
                                                </div>




                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="header">
                                                <h4>Package Info</h4>
                                                <div class="text-right">
                                                    <button type="button" id="addpackage"  class="btn btn-success">Add Boxes or Packages</button>
                                                </div>
                                            </div>
                                            <div class="body" id="packageinfo">

                                                <table class="table table-bordered packageinfo">
                                                    @php
                                                        $total=0;
                                                        $total_qty=0;
                                                    @endphp
{{--                                                    @if($shipment->package!=null)--}}
                                                        @foreach($shipment->packages as $package)

                                                            <tr>
                                                                <td width="40%">
                                                                    <input type="text" value="{{ $package->description }}" placeholder="Enter description" name="description[]" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="number" value="{{ $package->quantity }}" placeholder="Enter quantity" name="qty[]"  class="form-control qty">
                                                                </td>
                                                                <td>
                                                                    <input type="number" value="{{ $package->unit_price }}" placeholder="Enter unit price" name="unit[]" class="form-control unit">
                                                                </td>
                                                                <td>
                                                                    <input type="number" value="{{ $package->subtotal }}" name="subtotal[]" readonly class="form-control value">
                                                                </td>
                                                                <td><button type="button"  class="remove btn btn-danger">X</button></td>
                                                            </tr>
                                                            @php
                                                                $total+=$package->subtotal;
                                                                $total_qty+=$package->quantity;
                                                            @endphp
                                                        @endforeach
{{--                                                    @endif--}}
                                                </table>

                                            </div>
                                            <div class="body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td width="25%"><h4>Amount : </h4></td>
                                                        <td width="25%"><h4><span id="totalAmt">{{ $total }}</span></h4></td>
                                                        <td width="25%"><h4>Quantity: </h4></td>
                                                        <td width="25%"><h4><span id="totalqty">{{ $total_qty }}</span></h4></td>
                                                    </tr>
                                                </table>

                                            </div>



                                        </div>


                                        <div class="text-center">
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
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script>
        $(function() {
            // validation needs name of the element
            // initialize after multiselect
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#sender_id').on('change', function () {
                var address = $(this).find(":selected").data('address');
                // alert(address)
                $("#sender_address").val(address);
            });
            $('#receiver_id').on('change', function () {
                var address = $(this).find(":selected").data('address');
                $("#receiver_address").val(address);
            });


            $('.remove').click(function(){
                $(this).closest("tr").remove();
                var sum = 0;
                $("input[name='subtotal[]']").each(function() {
                    sum += +$(this).val();
                });
                $("#totalAmt").text(sum);

                var sum = 0;
                $("input[name='qty[]']").each(function() {
                    sum += +$(this).val();
                });
                $("#totalqty").text(sum);
            })


            $('#AddSender').click(function(){
                $('#AddClient h4.modal-title').text("Add Sender");
                $('#AddClient #clientType').val("sender");
                $('#AddClient').modal('show');
            });

            $('#AddReceiver').click(function(){
                $('#AddClient h4.modal-title').text("Add Receiver");
                $('#AddClient #clientType').val("receiver");
                $('#AddClient').modal('show');
            });
            var index = 1;
            $('#addpackage').click(function(){

                var tr = $('#tr').html();
                var html= `<tr>
                            <td style="padding:10px" width="40%"><input placeholder="Enter description" type="text" name="description[]" class="form-control"></td>
                                <td style="padding:10px"><input placeholder="Enter quantity" type="number" name="qty[]"  class="form-control qty"></td>
                                <td style="padding:10px"><input type="number" placeholder="Enter unit price" name="unit[]" class="form-control unit"></td>
                                <td style="padding:10px"><input type="number" readonly name="subtotal[]" class="form-control value"></td>

                            </tr>`;
                $('#packageinfo table').append(html)
            })


            $(document).on("input", ".form-control", function() {
                $("input[name='unit[]']").each(function(){
                    var qty = $(this).parent('td').prev('td').find('input').val()
                    var unit =$(this).val();
                    $(this).parent('td').next('td').find('input').val(qty*unit);
                });

            })


            $(document).on("input", ".form-control", function() {
                var sum = 0;
                $("input[name='subtotal[]']").each(function() {
                    sum += +$(this).val();
                });
                $("#totalAmt").text(sum);
            })

            $(document).on("input", ".form-control", function() {
                var sum = 0;
                $("input[name='qty[]']").each(function() {
                    sum += +$(this).val();
                });
                $("#totalqty").text(sum);
            })

            // $(document).on("button", ".remove", function() {
            //     $(this).closest("tr").remove();
            // })

            // $('.remove').live(function(){
            //     $(this).closest("tr").remove();
            // })


            $('#country_id').change(function(){
                var country_id = $(this).val();
                console.log(country_id);
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
                        $.each(result, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                    }

                }); // ajax call closing
            })

            function calculateTotal()
            {
                let weight = $('#weight').val()
                let rate = $('#rate').val();
                let packing_charge = $('#packing_charge').val();
                let other_charges = $('#other_charges').val();
                let discount = $('#discount').val();
                console.log(weight*rate);
                if(typeof weight==="undefined" || weight==null)
                {
                    weight = 0;
                }
                if(typeof rate==="undefined" || rate==null)
                {
                    rate = 0;
                }
                if(typeof packing_charge==="undefined" || packing_charge==null)
                {
                    packing_charge = 0;
                }
                if(typeof other_charges==="undefined" || other_charges==null)
                {
                    other_charges = 0;
                }
                if(typeof discount==="undefined" || discount==null)
                {
                    discount = 0;
                }
                let am = (weight*rate);
                let grossTotal = am+parseFloat(packing_charge)+parseFloat(other_charges)
                let total = grossTotal-discount;
                $('#total_amount').val(total);
            }

            $('#weight, #rate, #packing_charge, #other_charges, #discount').on('blur', function(){
                calculateTotal();
            })



            $("#save_data_user").click(function(){
                $('.valid-err').hide()
                $('#loader').removeClass('d-none');
                var data = $('#add_client_shipments').serialize();
                $.ajax({
                    url: `{{ route('branch.customers.store') }}`,
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function (result) {
                        // when call is sucessfull
                        if (result.success === true) {
                            clearForm()
                            $('#loader').addClass('d-none');
                            var message = `<span class="alert alert-success">` + result.message + `</span>`;
                            console.log(result);
                            $('#msg').html(message)
                            $('#' + result.data.type + '_id').append(`<option value="` + result.data.id + `" selected>` + result.data.name + `<option>`);

                            $('#' + result.data.type + '_address').val(result.data.address.address)
                            setTimeout(() => {
                                $('.modal').modal('hide');
                                $('.alert').hide();
                            }, 1000);
                        } else {
                            toastr.error(result.message);
                        }

                    },
                    error: function (err) {
                        // check the err for error details
                        $('#loader').addClass('d-none');
                        $.each(err.responseJSON.errors, function (key, item)
                        {
                            //$("#err").append("<li class='alert alert-danger'>"+item+"</li>")

                            $('#'+key).after('<label class="valid-err text-danger">'+item+'</label>')
                        });
                    }
                }); // ajax call closing

            });

        });


        function clearForm()
        {
            $('#name').val("");
            $('#email').val("");
            $('#phone').val("");
            $('#zip_code').val("");
            $('#address').val("");
            $('#client_identification_number').val("");
        }


    </script>
@endsection

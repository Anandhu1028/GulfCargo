    @extends('layouts.app')

@section('content')
<style>
.boxContainer{
    border:1px solid black;
    padding:5px;
    margin-top:5px;
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
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('branch.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('branch.ship.create')}}">Shipment List</a></li>
                                    <li class="breadcrumb-item active">View Manifesto</li>

                                </ol>
                            </div>
                            <h4 class="page-title">View Manifesto</h4>
                            <div class="fa-pull-left pb-3">
                                <button type="button" id="transferGoods" class="btn btn-primary">Export to Excel</button>&nbsp;&nbsp;&nbsp;
<!--
                                <button type="button" id="addCargos" class="btn btn-primary">Add Cargos</button>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.report')}}" class="btn btn-primary">Print All</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.report')}}" class="btn btn-primary">New Print</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.time')}}" class="btn btn-primary">Print Selected</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.time')}}" class="btn btn-primary">Delete</a>&nbsp;&nbsp;&nbsp; -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Filter by</label>
                                                    <select autofocus name="filterType" id="filterType" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="bookingNumber">Booking Number</option>
                                                        <option value="boxNumber">Box Number</option>
                                                        <option value="Status">Status</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 textDiv hidden">
                                                <div class="form-group">
                                                    <label>Search Field</label>
                                                    <input type="text" class="form-control" name="search" id="search">
                                                </div>
                                            </div>
                                            <div class="col-md-4 statusDiv hidden">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control" name="status" id="status" ship_id="{{$id}}">
                                                        @foreach($statuses as $status)
                                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button class="btn btn-success waves-effect waves-light m-t-32 searchClass"> Search</button>
                                                <button class="btn btn-success waves-effect waves-light m-t-32 clearClass"> Clear</button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                    <div class="col-sm-12 m-t-50"  style="overflow-x: auto">
                      <div class="">
                        <div class=" ">


                        </div>

                            <table id="datatable1"
                                   class="table table-striped table-bordered nowrap" >
                                <thead><input type="hidden" id="shipName" value="{{ $getShips->shipment_id}}">
                                    <tr>
                                        <th><input type="checkbox" id="allcb" name="allcb" class="selectAll" /></th> </th>
                                        <th>Courier Company</th>
                                        <th>Shipment Number</th>
                                        <th>Destination</th>
                                        <th># Number</th>
                                        <th>Tracking No:</th>
                                        <th>Box No:</th>
                                        <th>Number of Pieces</th>
                                        <th>Weight</th>
                                        <th>Re weight</th>
                                        <th>Recieved Pieces</th>
                                        <th>Sender address </th>
                                        <th>Receiver address </th>
                                        <th>Receiver Phone </th>
                                        <th>State </th>
                                        <th>District </th>
                                        <th>Pincode </th>
                                        <th>Goods Details </th>
                                        <th>Shipment started Date </th>
                                        <th>Received at Hub </th>
                                        <th>Connecting Date</th>
                                        <th>LR Number</th>
                                        <th>Good Status hgh</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody class="bookingData">
                                @foreach($boxes as $box)

                                <?php
                                $lastStatus = '';
                                $itemList = [];
                                        foreach($box->packages as $item) {
                                            $itemList[] = $item->description."-".$item->quantity;
                                        }
                                        $itemsCount = count($itemList);
                                        $itemsList = implode(', ', $itemList);
                                        if(($box->boxStatuses != null)) {
                                            $status = collect($box->boxStatuses)->last();
                                            $shipmentStatus = collect($box->shipment->shipmentStatus)->last();
                                            $lastStatus = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;
                                            if($lastStatus == 'Pending') {
                                                $style= "background-color:#ec1616e6;";
                                                $disabled = "disabled='disabled'";
                                                $newClass ="k-state-disabled";
                                            } else if ($lastStatus == 'Shipment on hold') {
                                                $style= "background-color:#ffdb00;";
                                                $disabled = "disabled='disabled'";
                                                $newClass ="k-state-disabled";
                                            } else {
                                                $style= "background-color:none;";
                                                $disabled = "";
                                                $newClass = "k-checkbox";
                                            }
                                            $addressString = $box->shipment->receiver->address->address;
                                            $pieces = explode(',', $addressString);
                                            $district = array_pop($pieces);
                                        }
                                        ?>

                                <tr style="{{ $style}}">
                                        <td >
                                            <input {{$disabled}} type="checkbox" name="invoice[]"  class="checkbox-item {{$newClass}}" id="chkBx-{{$box->id}}"  value="{{$box->id}}-{{$box->box_name}}"  />
                                        </td>
                                        <td>{{ $box->shipment->agency?$box->shipment->agency->name:'-' }}</td>
                                        <td>{{$getShips->shipment_id}}</td>
                                        <td>{{$box->shipment->receiver->address->country->name}}</td>
                                        <td>{{$box->shipment->id}}</td>
                                        <td>{{$box->shipment->booking_number}}</td>
                                        <td>{{$box->box_name?$box->box_name: $box->id }}</td>
                                        <td>1</td>
                                        <td>{{number_format($box->weight,2)}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$box->shipment->sender->name}} - {{  Str::words($box->shipment->sender->address->address, '25')  }}</td>
                                        <td>{{$box->shipment->receiver->name}} - {{  Str::limit($box->shipment->receiver->address->address, '5')  }}</td>
                                        <td>{{$box->shipment->receiver->phone}}</td>
                                        <td>{{$box->shipment->receiver->address->state->name}}</td>
                                        <td>{{$district}}</td>
                                        <td>{{$box->shipment->receiver->address->zip_code}}</td>
                                        <td>{{$itemsList}}</td>
                                        <td>{{date('d-m-Y',strtotime($box->shipment->created_date))}}</td>
                                        <td> </td>
                                        <td></td>
                                        <td>{{$box->shipment->lrl_tracking_code}}</td>
                                        <td> {{ $lastStatus }} </td>
                                        <td></td>



                                     <?php /*
                                        <!--  <td>{{$box->shipment->receiver->address->country->name}}</td>
                                        <td>{{$ship->shipment->id}}</td>
                                        <td>{{$ship->shipment->booking_number}}</td>
                                        <td>{{$box->box_name}}</td>
                                        <td>{{count($box->packages)}}</td>
                                        <td>{{number_format($box->weight,2)}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$ship->shipment->sender->name}} - {{$ship->shipment->sender->address->address}}</td>
                                        <td>{{$ship->shipment->receiver->name}} - {{$ship->shipment->receiver->address->address}}</td>
                                        <td>{{$ship->shipment->receiver->phone}}</td>
                                        <td>{{$ship->shipment->receiver->address->state->name}}</td>
                                        <td>{{$ship->shipment->receiver->address->country->name}}</td>
                                        <td>{{$ship->shipment->receiver->address->zip_code}}</td>
                                        <td>{{$itemsList}}</td>
                                        <td> </td>
                                        <td> </td>
                                        <td></td>
                                        <td>{{$ship->shipment->lrl_tracking_code}}</td>
                                        <td>{{$lastStatus}}</td>
                                        <td></td>  */ ?>
                                    </tr>



                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->



    </div>
    @include('branches.modals.transfer')
@endsection
@section('styles')
    @include('layouts.datatables_style')
    <style>
        .m-t-32 {margin-top:32px;}
        .hidden {display:none;}
        div.dt-buttons {
            float: right;
            margin-bottom:10px;
            margin-top: -50px;
        }
        #datatable1_filter {display:none;}
        .m-t-50 {margin-top:50px;}
    </style>
@endsection

@section('scripts')
@include('layouts.datatables_js')
<script>
    $(document).ready(function () {



        $('#datatable1').DataTable({
            searching: true, paging: false, info: false,filter: true, "aaSorting":true,
            scrollX: true,
                scrollX: true,
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'excel',
                    title: '',
                }]
            });


    $('#allcb').click(function (e) {
        if( $("#allcb").prop('checked') == true) {
            $.each($('td:not(.k-state-disabled) .k-checkbox'), function () {
                $(this).prop("checked", true)
            });
        }
        else {
            $('.k-checkbox').prop('checked', false);
        }
            // $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    });

        $('#transferGoods').click(function () {
            if ($(".k-checkbox").prop('checked')==true){
                var checkValues = $('td:not(.k-state-disabled) .k-checkbox:checked').map(function(){
                            return $(this).val();
                        }).get();
                    } else {
                        return false;
                    }
                        $("#sel_goods_id").val(checkValues);
                        $('#transfer').modal('show');

                });


        });


            $("#transfer_shipment").submit(function (e) {
                e.preventDefault();
                $('.valid-err').hide()
                $('#loader').removeClass('d-none');
                //var data = $('#transfer_shipment').serialize();
                var formData = new FormData(this);
                for (var p of formData) {
                    let name = p[0];
                    let value = p[1];

                    console.log(name, value)
                }
                $.ajax({
                    url: `{{ route('branch.shipment.transferGoods') }}`,
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        // when call is sucessfull
                        if (result.success === true) {
                            // clearForm()
                            $('#loader').addClass('d-none');
                            var message = `<span class=" ">` + result.message + `</span>`;
                            console.log(result);
                            $('#msg').html(message)
                            // $('#' + result.data.type + '_id').append(`<option value="` + result.data.id + `" selected>` + result.data.name + `<option>`);
                            toastr.info(result.message);

                            // setTimeout(() => {
                            //     $('.modal').modal('hide');
                            //     $('.alert').hide();
                            // }, 2000);
                        } else {
                            toastr.error(result.message);
                        }
                        window.location.reload(true);
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

            $(".clearClass").on('click', function() {
                location.reload();
            });

            $("#filterType").on('change', function() {
                var type = $(this).val();
                if(type == 'Status') {
                    $(".textDiv").addClass('hidden');
                    $(".statusDiv").removeClass('hidden');
                } else if(type == 'boxNumber') {
                    $(".statusDiv").addClass('hidden');
                    $(".textDiv").removeClass('hidden');
                } else if(type == 'bookingNumber') {
                    $(".statusDiv").addClass('hidden');
                    $(".textDiv").removeClass('hidden');
                }
            });
            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    $('.searchClass').click();
                }
            });
            $(".searchClass").on('click', function() {
                var table = $('#datatable1').DataTable();
                var filter = $("#filterType").val();
                var ship_id = $("#status").attr('ship_id');
                table.column(5).search('');
                table.column(22).search('');
                if(filter == 'Status') {
                    var status = $("#status :selected").text();
                    var type = "status";
                    table.column(22).search( status ).draw();
                    // var url = "{{route('branch.ships.viewManifestoFilterData')}}/"+ship_id+"/"+type+"/"+status;;
                    // viewData(url);
                } else if(filter == 'boxNumber') {
                    var search = $("#search").val();
                    var type = "boxNumber";
                    var url = "{{route('branch.ships.viewManifestoFilterData')}}/"+ship_id+"/"+type+"/"+search;;
                    viewData(url);
                } else {
                    var search = $("#search").val();
                    var type = "bookingNumber";
                    // table.column(5).search( search ).draw();
                    var url = "{{route('branch.ships.viewManifestoFilterData')}}/"+ship_id+"/"+type+"/"+search;;
                    viewData(url);
                }

            });

            function viewData(url){
                var shipName = $("#shipName").val();
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success:function(response){
                        console.log(response);
                        var html = [];
                        $('.bookingData').html('');
                        if(response.length == 0) {
                            html += '<tr>'+
                            '<td colspan="23">No matching records found</td>'+
                            '</tr>';
                        } else {
                            $.each(response, function (key, value) {
                                html += '<tr style="'+value.style+'">'+
                                    '<td><input '+value.disabled+' type="checkbox" name="invoice[]"  class="checkbox-item '+value.newClass+'" id="chkBx-"'+value.id+'"  value="'+value.id+'"-"'+value.box_name+'"  /></td>'+
                                    '<td>'+value.shipment.agency.name+'</td>'+
                                    '<td>'+shipName+'</td>'+
                                    '<td>'+value.shipment.receiver.address.country.name+'</td>'+
                                    '<td>'+value.shipment.id+'</td>'+
                                    '<td>'+value.shipment.booking_number+'</td>'+
                                    '<td>'+value.box_name+'</td>'+
                                    '<td>1</td>'+
                                    '<td>'+value.weight+'</td>'+
                                    '<td></td>'+
                                    '<td></td>'+
                                    '<td>'+value.shipment.sender.name+' - '+value.shipment.sender.address.address+'</td>'+
                                    '<td>'+value.shipment.receiver.name+' - '+value.shipment.receiver.address.address+'</td>'+
                                    '<td>'+value.shipment.receiver.phone+'</td>'+
                                    '<td>'+value.shipment.receiver.address.state.name+'</td>'+
                                    '<td>'+value.district+'</td>'+
                                    '<td>'+value.shipment.receiver.address.zip_code+'</td>'+
                                    '<td>'+value.itemsList+'</td>'+
                                    '<td>'+value.dated_on+'</td>'+
                                    '<td>'+value.dated_on+'</td>'+
                                    '<td></td>'+
                                    '<td>'+value.shipment.lrl_tracking_code+'</td>'+
                                    '<td>'+value.last_status+'</td>'+
                                    '<td></td>'+
                                '</tr>';
                    });

                        }

                        $('.bookingData').html(html);

                    }
                });
            }



</script>
@endsection

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
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="">
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
                                    <div class="col-md-4 text-right ">   
                                        <div class="row floatRight" >
                                            <a href="{{route('branch.shipment.manifestoExportView',$id)}}" class="btn btn-success">Export View</a>
                                        </div>
                                    </div>
                                </div>
                            <table id="datatable1"
                                   class="table table-striped table-bordered nowrap" >
                                <thead><input type="hidden" id="shipName" value="{{ $getShips->shipment_id}}">
                                    <tr>
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
                                        <th>Good Status</th>                                    
                                        <th>Remarks</th>                                    
                                    </tr>
                                </thead>
                                <tbody class="bookingData">
                                    @foreach($ships as $ship)
                                    <?php
                                        $itemList = [];
                                        foreach($ship->packages as $item) {
                                            $itemList[] = $item->description."-".$item->quantity;
                                        }
                                        $itemsCount = count($itemList);

                                        $itemsList = implode(', ', $itemList);
                                        $receivedType = collect($ship->shipment->shipmentStatus)->where('statuses_id', 1)->first();
                                        $status = '';
                                        $lastStatus = '';
                                        
                                        $List = '';
                                        $boxList = [];
                                        if(!empty($ship->shipment->boxes)) {
                                            foreach($ship->shipment->boxes as $box) {
                                                $boxList[] =  (!empty($box->box_name) )? $box->box_name : $box->id ;
                                            }
                                        $List = implode(', ', $boxList);
                                        }
                                        $status = '';
                                        $lastStatus = '';
                                        if(($ship->boxStatuses != null)) {
                                            $status = collect($ship->boxStatuses)->last();
                                            $shipmentStatus = collect($ship->shipment->shipmentStatus)->last();
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

                                            $addressString = $ship->shipment->receiver->address->address;
                                            $pieces = explode(',', $addressString);
                                            $district = array_pop($pieces);
                                        }
                                    ?>
                                    <tr style="{{ $style}}">
                                     
                                        <td>{{$ship->shipment->agency?$ship->shipment->agency->name:'--' }}</td>
                                        <td>{{$getShips->shipment_id}}</td>
                                        <td>{{$ship->shipment->receiver->address->country->name}}</td>
                                        <td>{{$ship->shipment->id}}</td>
                                        <td class="" value="{{$ship->shipment->id}}">{{$ship->shipment->booking_number}}</td>
                                        <td>{{$ship->box_name}}</td>
                                        <td>1</td>
                                        <td>{{number_format($ship->weight,2)}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$ship->shipment->sender->name}} - {{$ship->shipment->sender->address->address}}</td>
                                        <td>{{$ship->shipment->receiver->name}} - {{$ship->shipment->receiver->address->address}}</td>
                                        <td>{{$ship->shipment->receiver->phone}}</td>
                                        <td>{{$ship->shipment->receiver->address->state->name}}</td>
                                        <td>{{$district}}</td>
                                        <td>{{$ship->shipment->receiver->address->zip_code}}</td>
                                        <td>{{$itemsList}}</td>
                                        <td>{{date('d-m-Y',strtotime($ship->shipment->created_date))}}</td>
                                        <td>{{(!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : ''}}</td>
                                        <td></td>
                                        <td>{{$ship->shipment->lrl_tracking_code}}</td>
                                        <td>{{$lastStatus}}</td>
                                        <td></td>
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

        <div id="currentStatusModal" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('branch.ships.boxStatusUpdatetoship')}}" method="post">
                            @csrf
                            <div class="col-md-12"> 
                                <div class="row">
                                    <table id="shipsTable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Box Name</th>
                                            <th>Current Status</th>
                                            <th>Dated on</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fetchData">  
                                            
                                        </tbody>
                                    </table>                              
                                </div>
                            </div> 

                            
                        </form>     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
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
        .detailedView {color:#661ec2;}
        .floatRight {float:right;margin-top:30px;}
    </style>
@endsection

@section('scripts')
@include('layouts.datatables_js')
<script>
    $(document).ready(function () {
        $(document).on('click', ".detailedView", function() {
                var bookingId = $(this).attr('value');
                var boxName = $(this).closest('tr').find('.boxName').text();
                var boxId = $(this).closest('tr').find('.boxName').attr('ids');
                $("#currentStatusModal").modal('show');
                var d = new Date();
                $.ajax({
                        headers: {
                            "content-type" : "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        url: `{{ route('branch.ship.list.getBoxDetails') }}`,
                        type: "POST",
                        async:false,
                        data: JSON.stringify({"bookingId":bookingId, "boxName":boxName }),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {  
                            var html = [];
                            $('.fetchData').html('');
                            $.each(result, function (key, value) {
                                var statusCount = value.box_statuses.length;
                                var lastNum = statusCount - 1;

                                if(value.box_statuses[lastNum].status.name == 'Pending') {
                                    var style =  "background-color:#ec1616e6";
                                } else if(value.box_statuses[lastNum].status.name == 'Shipment on hold') {
                                    var style =  "background-color:#ffdb00";
                                } else {
                                    var style =  "background-color:none";
                                }
                                html += '<tr style="'+style+'">'+
                                        '<td>'+value.box_name+'</td>';
                                        if(lastNum >= 0) {
                                            html +=   '<td>'+value.box_statuses[lastNum].status.name+'</td>';
                                            html +=   '<td>'+value.dated+'</td>';

                                        } else {
                                            html +=  '<td>--</td>';
                                            html +=  '<td>--</td>';
                                            
                                        }
                                        
                                        html += '</tr>';
                            });
                            $('.fetchData').html(html);
                            $('.select2').select2();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                }); // ajax call closing
            });

        $('#datatable1').DataTable({
            searching: true, paging: false, info: false,filter: true, "aaSorting":true,
            scrollX: true,
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
                table.column(4).search('');
                table.column(21).search('');
                if(filter == 'Status') {
                    var status = $("#status :selected").text();
                    var type = "status";
                    table.column(21).search( status ).draw();
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
                    // table.column(4).search( search ).draw();
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

    }); 
</script>
@endsection

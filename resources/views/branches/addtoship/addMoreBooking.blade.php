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
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('super-admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('branch.ship.create')}}">Shipment List</a></li>
                                    <li class="breadcrumb-item active">View Assigned</li>

                                </ol>
                            </div>
                            <h4 class="page-title">View Assigned Shipment</h4>

                        </div>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card-box">
                            
                            <div class="body">
                                <!-- <div class="header">
                                    <h6>Assigned New Booking</h6>
                                </div> -->
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
                                                    <select class="form-control" name="status" id="status" ship_id="{{$ships->id}}">
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
                                            <a href="{{route('branch.shipment.viewManifesto',$ships->id)}}" class="btn btn-success waves-effect waves-light changeStatus"  id="changeStatus">View Manifesto</a> 

                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="shipsTable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <input type="hidden" id="shipName" value="{{ $ships->shipment_id}}">
                                        <tr>
                                            <th>Booking No</th>
                                            <th>Shipment name</th>
                                            <th>No of Pcs</th>
                                            <th>Box Name</th>
                                            <th>Total Weight</th>
                                            <th>Total value</th>
                                            <th>Shipment Status</th>
                                            <th>Created Date</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData" class="bookingData">
                                        <?php

                                        $res ='';
                                        $tot_weight_exist = 0;
                                        $tot_value_exist = 0;
                                        $tot_temp_exist =0;
                                        $totalPieces =0;

                                        foreach( $ship_bookingsList as $booking) { 
 
                                            $tot_temp_exist= $booking->weight;
                                            $tot_weight_exist +=$tot_temp_exist;
                                            $tot_value_exist += $booking->total_value + $booking->box_packing_charge;
                                            $totalPieces += 1; 
                                            $List = '';
                                            $ListValue = '';
                                            $boxList = [];
                                            $boxListValue = [];
                                            
                                            $status = '';
                                            $lastStatus = '';
                                            if(($booking->boxStatuses != null)) {
                                                $status = collect($booking->boxStatuses)->last();
                                                $shipmentStatus = collect($booking->shipment->shipmentStatus)->last();
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
                                            }             
                                            ?>                                            
                                            <tr style="{{ $style }}">
                                                <td style="text-align:center" value="{{$booking->shipment->id}}">{{ $booking->shipment->booking_number}}</td>  
                                                <td style="text-align:center">{{ $ships->shipment_id}}</td>
                                                <td style="text-align:center">1</td>
                                                <td style="text-align:center" class="boxName" id="boxId" ids="{{$ListValue}}">{{ $booking->box_name }}</td>
                                                <td style="text-align:center">{{ number_format($booking->weight,2) }}</td>
                                                <td style="text-align:center">{{ number_format($booking->total_value + $booking->box_packing_charge,2) }}</td>
                                                <td style="text-align:center">{{ $lastStatus }}</td>
                                                <td style="text-align:center">{{ !empty($booking->created_at) ? date('d-m-Y', strtotime($booking->created_at)) : '' }}</td>
                                            </tr>  
                                            <?php     
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-box">
                                    <div class="col-md-8"> 
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Total Pieces</label>
                                                   <input type="text" readonly class="form-control" id="noOfPieces" value="{{ $totalPieces}}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <label>Total Weight</label>
                                                    <input type="text" readonly class="form-control" name="totalWt" id="totalWt" value="{{ number_format($tot_weight_exist,2)}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group">
                                                    <label>Total Value</label>
                                                    <input type="text" readonly class="form-control" name="totalvalue" id="totalvalue" value="{{ number_format($tot_value_exist, 2) }}">
                                                </div>
                                            </div>
                                        </div>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end container-fluid -->

        </div>
    </div>
        <!-- end content -->
@endsection
@section('styles')
    @include('layouts.datatables_style')
    <style>
        .floatRight {float:right;margin-top:30px;}
        .m-l-10 {margin-left:10px!important;}
        .detailedBoxView {color:#661ec2;}
        .m-t-32 {margin-top: 32px!important;}
        .btnManifesto {float:right;}
        /* .changeStatus {margin-bottom:10px;} */
        .hidden {display:none;}
        #shipsTable_filter, #shipsTable_length {display:none;}
        table.dataTable thead .sorting, 
        table.dataTable thead .sorting_asc, 
        table.dataTable thead .sorting_desc {
            background : none;
        }

    </style>
@endsection

@section('scripts')
    @include('layouts.datatables_js')

    <script>
        $(document).ready(function () {
            $('#shipsTable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                aoColumnDefs: [
                    {
                        bSortable: false,
                        aTargets: [ 0,1,2,3,4,5,6,7 ]
                    }
                ],
                initComplete: function(settings, json) {
                doSum();
                }
            }); 
            function doSum() {
                var table = $('#shipsTable').DataTable();
                var totalValue  = table
                            .column(5, { page: 'current' })
                            .data()
                            .reduce((a, b) => parseInt(a) + parseInt(b),0);
                var totalWt  = table
                            .column(4, { page: 'current' })
                            .data()
                            .reduce((a, b) => parseInt(a) + parseInt(b),0);
                var totalPcs  = table
                            .column(2, { page: 'current' })
                            .data()
                            .reduce((a, b) => parseInt(a) + parseInt(b),0);
                // place the sum in the fields:
                $("#totalvalue").val( totalValue );
                $("#totalWt").val( totalWt );
                $("#noOfPieces").val( totalPcs );
            }
            $(".clearClass").on('click', function() {
                location.reload();
            });
            $(document).ready(function () {
                $('.select2').select2();
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
                var table = $('#shipsTable').DataTable();
                var filter = $("#filterType").val();
                var ship_id = $("#status").attr('ship_id');
                table.column(0).search('');
                table.column(6).search('');
                if(filter == 'Status') {
                    var status = $("#status :selected").text();
                    var type = "status";
                    table.column(6).search( status ).draw();
                    doSum();
                    // var url = "{{route('branch.ships.manifestoFilterData')}}/"+ship_id+"/"+type+"/"+status;;
                    // viewData(url);
                } else if(filter == 'boxNumber') {
                    var search = $("#search").val();
                    var type = "boxNumber";
                    // table.column(3).search( search ).draw();
                    var url = "{{route('branch.ships.manifestoFilterData')}}/"+ship_id+"/"+type+"/"+search;;
                    viewData(url);
                } else {
                    var search = $("#search").val();
                    var type = "bookingNumber";
                    // table.column(0).search( search ).draw();
                    var url = "{{route('branch.ships.manifestoFilterData')}}/"+ship_id+"/"+type+"/"+search;;
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
                            '<td colspan="8">No matching records found</td>'+
                            '</tr>';
                            $("#noOfPieces").val("");
                            $("#totalWt").val("");
                            $("#totalvalue").val("");
                        } else {
                            var totalWt = 0;
                            var totalValue = 0;
                            var totalCount = response.length;
                            $.each(response, function (key, value) {
                                var total = parseInt(value.total_value) + parseInt(value.box_packing_charge);
                                html += '<tr style="'+value.style+'">'+
                                    '<td>'+value.shipment.booking_number+'</td>'+
                                    '<td>'+shipName+'</td>'+
                                    '<td>1</td>'+
                                    '<td>'+value.box_name+'</td>'+
                                    '<td>'+value.weight+'</td>'+
                                    '<td>'+total+'</td>'+
                                    '<td>'+value.last_status+'</td>'+
                                    '<td>'+value.dated_on+'</td>'+
                                '</tr>';
                                totalWt += parseInt(value.weight);
                                totalValue += parseInt(total);
                            });

                            $("#noOfPieces").val(totalCount);
                            $("#totalWt").val(totalWt);
                            $("#totalvalue").val(totalValue);
                        }
                        
                        $('.bookingData').html(html);
                        
                    } 
                });
            }
        });
        
   
 </script>

@endsection

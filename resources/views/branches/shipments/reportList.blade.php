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
                                {!! breadcrumbs() !!}
                            </div>
                            <h4 class="page-title">Consignment Reports</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box">
                        <div class=" ">   
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Filter by</label>
                                    <select autofocus name="filterType" id="filterType" class="form-control">
                                        <option value="">Select</option>
                                        <option value="shipmentNumber">Shipment Number</option>
                                        <option value="Status">Status</option>
                                        <option value="Date">Date</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 statusDiv hidden">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" id="status">
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id}}">{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 textDiv hidden">
                                <div class="form-group">
                                    <label>Search Field</label>
                                    <input type="text" class="form-control" name="search" id="search">
                                </div>
                            </div>
                            <div class="col-md-3 dateDiv hidden">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="from_dated" id="from_dated">
                                </div>
                            </div>
                            <div class="col-md-3 dateDiv hidden">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="to_dated" id="to_dated">
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
                            <table id="datatable1"
                                   class="table table-striped table-bordered nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Detailed</th>
                                        <th>Shipment Number</th>
                                        <th>Port of Origin</th>
                                        <th>Shipment Type</th> 
                                        <th>AWB No:</th>                                    
                                        <th>Date</th>                                    
                                        <th>Clearing Agent</th>                                    
                                        <th>Created By</th>                                    
                                        <th>Booking No:</th>                                    
                                        <th>Box No:</th>                                    
                                        <th>Enquiry collected</th>                                    
                                        <th>Shipment Received</th>                                    
                                        <th>Shipment Booked</th>                                    
                                        <th>Shipment Forwarded</th>                                    
                                        <th>Shipment Arrived</th>                                    
                                        <th>Waiting for Clearance</th>                                    
                                        <th>Shipment Hold</th>                                    
                                        <th>Shipment Cleared</th>
                                        <th>Received</th>                                    
                                        <th>Hold</th> 
                                        <th>Short</th>                                   
                                        <th>Delivery Arranged</th>                                    
                                        <th>Out for Delivery</th>                                    
                                        <th>Delivered</th>                                    
                                        <th>Not Delivered</th>                                    
                                        <th>Pending</th>                                    
                                        <!-- <th>More Tracking</th>                                     -->
                                        <th>Transfer</th>                                    
                                    </tr>
                                </thead>
                                <tbody class="fetchDataMain">
                                    @foreach($datas as $data)
                                    <tr style="{{ $data['style']  }}">
                                        <td>{!!$data['view']!!}</td>
                                        <td>{{$data['shipment_id']}}</td>
                                        <td>{{$data['portOfOrigins']}}</td>
                                        <td>{{$data['shipmentTypes']}}</td>
                                        <td>{{$data['awb_number']}}</td>
                                        <td>{{$data['createdDate']}}</td>
                                        <td>{{$data['clearingAgents']}}</td>
                                        <td>{{$data['createdBy']}}</td>
                                        <td>{{$data['booking_number']}}</td>
                                        <td>{{$data['boxes']}}</td>
                                        <td>{{$data['collectedDate']}}</td>
                                        <td>{{$data['receivedDate']}}</td>
                                        <td>{{$data['bookedDate']}}</td>
                                        <td>{{$data['forwardedDate']}}</td>
                                        <td>{{$data['arrivedDate']}}</td>
                                        <td>{{$data['waitingDate']}}</td>
                                        <td>{{$data['onHoldDate']}}</td>
                                        <td>{{$data['clearedDate']}}</td>
                                        <td>{{$data['receivedDate']}}</td>
                                        <td>{{$data['holdDate']}}</td>
                                        <td>{{$data['shortDate']}}</td>
                                        <td>{{$data['arrangedDate']}}</td>
                                        <td>{{$data['outDate']}}</td>
                                        <td>{{$data['deliveredDate']}}</td>
                                        <td>{{$data['notDeliveredDate']}}</td>
                                        <td>{{$data['pendingDate']}}</td>
                                        <!-- <td>{{$data['moreTrackingDate']}}</td> -->
                                        <td>{{$data['transferDate']}}</td>
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

<div id="detailedModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                @csrf
                <div class="col-md-12"> 
                    <div class="row">
                        <table id="shipsTable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Box Name</th>
                                <th>Status</th>
                                <th>Date</th>
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
    </style>
@endsection

@section('scripts')
@include('layouts.datatables_js')
<script>
    $(document).ready(function () {

        $('#datatable1').DataTable({
                paging: false, info: false,filter: true, "aaSorting":true,
                processing: true,
                serverSide: false,
                searching: true,
                
                "aaSorting": [ [2,'desc'] ],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'excel',
                    title: '',
                }]
        }); 
        $(".clearClass").on('click', function() {
            location.reload();
        });

        $("#filterType").on('change', function() {
            var type = $(this).val();
            if(type == 'Status') {
                $(".dateDiv").addClass('hidden');
                $(".textDiv").addClass('hidden');
                $(".branchDiv").addClass('hidden');
                $(".statusDiv").removeClass('hidden');
            } else if(type == 'Date') {
                $(".statusDiv").addClass('hidden');
                $(".textDiv").addClass('hidden');
                $(".branchDiv").addClass('hidden');
                $(".dateDiv").removeClass('hidden');
            } else if(type == 'shipmentNumber') {
                $(".statusDiv").addClass('hidden');
                $(".dateDiv").addClass('hidden');
                $(".branchDiv").addClass('hidden');
                $(".textDiv").removeClass('hidden');
            } 
        });

        $(".searchClass").on('click', function() {
            var table = $('#datatable1').DataTable();
            var filter = $("#filterType").val();

            if(filter == 'shipmentNumber') {
                table.column(1).search( $("#search").val() ).draw();
            } else if(filter == 'Status') {
                var status = $("#status").val();
                var url = "{{route('branch.shipment.list.reportStatusData')}}/"+status;
                viewData(url);
                // table.search(search).draw();
                // table.draw();
            } else if(filter == 'Date') {
                var fromDate = $("#from_dated").val();
                var toDate = $("#to_dated").val();
                var url = "{{route('branch.shipment.list.reportData')}}/"+fromDate+"/"+toDate;
                viewData(url);
                // table.search( [fromDate, toDate] ).draw();
            }
            
        });

        function viewData(url){
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    var html = [];
                    $('.fetchDataMain').html('');
                    if(response.length == 0) {
                        html += '<tr>'+
                        '<td colspan="25">No matching records found</td>'+
                        '</tr>';
                    } else 
                    $.each(response, function (key, value) {
                        html += '<tr style="'+value.style+'">'+
                                    '<td>'+value.view+'</td>'+
                                    '<td>'+value.shipment_id+'</td>'+
                                    '<td>'+value.portOfOrigins+'</td>'+
                                    '<td>'+value.shipmentTypes+'</td>'+
                                    '<td>'+value.awb_number+'</td>'+
                                    '<td>'+value.createdDate+'</td>'+
                                    '<td>'+value.clearingAgents+'</td>'+
                                    '<td>'+value.createdBy+'</td>'+
                                    '<td>'+value.booking_number+'</td>'+
                                    '<td>'+value.boxes+'</td>'+
                                    '<td>'+value.collectedDate+'</td>'+
                                    '<td>'+value.receivedDate+'</td>'+
                                    '<td>'+value.bookedDate+'</td>'+
                                    '<td>'+value.forwardedDate+'</td>'+
                                    '<td>'+value.waitingDate+'</td>'+
                                    '<td>'+value.arrivedDate+'</td>'+
                                    '<td>'+value.onHoldDate+'</td>'+
                                    '<td>'+value.clearedDate+'</td>'+
                                    '<td>'+value.receivedDate+'</td>'+
                                    '<td>'+value.holdDate+'</td>'+
                                    '<td>'+value.shortDate+'</td>'+
                                    '<td>'+value.arrangedDate+'</td>'+
                                    '<td>'+value.outDate+'</td>'+
                                    '<td>'+value.deliveredDate+'</td>'+
                                    '<td>'+value.notDeliveredDate+'</td>'+
                                    '<td>'+value.pendingDate+'</td>'+
                                    '<td>'+value.transferDate+'</td>'+
                                '</tr>';
                        
                    });
                    $('.fetchDataMain').html(html);
                    
                } 
            });
        }

        $(document).on('click',".detailedView", function() {
            var shipmentNumber = $(this).closest('tr').find("td:eq(1)").text();
            var bookingNumber = $(this).closest('tr').find("td:eq(9)").text();
            if(shipmentNumber != '' && bookingNumber != '') {
                $.ajax({
                        headers: {
                            "content-type" : "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        url: `{{ route('branch.shipment.report.detailed') }}`,
                        type: "POST",
                        async:false,
                        data: JSON.stringify({"bookingNumber":bookingNumber, "shipmentNumber":shipmentNumber }),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {  
                            var html = [];
                            $('.fetchData').html('');
                            $("#detailedModal").modal('show');
                            var statusCount = result.box_statuses.length;
                            $.each(result.box_statuses, function (key, value) {
                                if(statusCount > 0) {
                                    // for(var i=0;i<statusCount; i++) {
                                        if(value.status.name == 'Pending') {
                                            var style =  "background-color:red";
                                        } else if(value.status.name == 'Shipment on hold') {
                                            var style =  "background-color:orange";
                                        } else if(value.status.name == 'Not Delivered') {
                                            var style =  "background-color:yellow";
                                        } else {
                                            var style =  "background-color:none";
                                        }
                                        html += '<tr style="'+style+'">'+
                                                '<td>'+result.box_name+'</td>';
                                                if(statusCount >= 0) {
                                                    html +=   '<td>'+value.status.name+'</td>';
                                                    html +=   '<td>'+value.dated+'</td>';
                                                } else {
                                                    html +=  '<td>--</td>';
                                                    html +=  '<td>--</td>';
                                                }
                                                html += '</tr>';
                                    // }
                                } else {
                                    
                                    html += '<tr>';
                                    if(value.box_name != null) {
                                        html +=  '<td>'+result.box_name+'</td>';
                                    } else {
                                        html +=  '<td>'+result.id+'</td>';
                                    }
                                    html +=  '<td>--</td>';
                                    html +=  '<td>--</td>';
                                    html += '</tr>';
                                }
                            });
                            $('.fetchData').html(html);
                        },
                        error: function (err) {
                            console.log(err);
                        }
                }); // ajax call closing
            }
        });

    }); 
</script>
@endsection

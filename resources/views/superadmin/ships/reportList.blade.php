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
                                        <th>Shipment Booked</th>                                    
                                        <th>Shipment Forwarded</th>                                    
                                        <th>Shipment Arrived</th>                                    
                                        <th>Waiting for Clearance</th>                                    
                                        <th>Shipment Hold</th>                                    
                                        <th>Shipment Cleared</th>                                    
                                        <th>Delivery Arranged</th>                                    
                                        <th>Out for Delivery</th>                                    
                                        <th>Delivered</th>                                    
                                        <th>Not Delivered</th>                                    
                                        <th>Pending</th>                                    
                                        <th>More Tracking</th>                                    
                                        <th>Transfer</th>                                    
                                    </tr>
                                </thead>
                                
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
                searching: true, paging: false, info: false,filter: true, "aaSorting":true,
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'view', name: 'view', orderable: false, searchable: false},
                    {data: 'ship.shipment_id', name: 'ship.shipment_id'},
                    {data: 'port_of_origins', name: 'portOfOrigin'},
                    {data: 'shipment_types', name: 'shipmentType'},
                    {data: 'awb_number', name: 'awbNumber'},
                    {data: 'createdDate', name: 'createdDate'},
                    {data: 'clearing_agents', name: 'clearingAgent'},
                    {data: 'created_by', name: 'createdBy'},
                    {data: 'shipment.booking_number', name: 'bookingNumber',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'boxes', name: 'boxes',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'collectedDate', name: 'collectedDate',
                        render: function(data) {
                            if(data != null) {
                                $("")
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'receivedDate', name: 'receivedDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'bookedDate', name: 'bookedDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'forwardedDate', name: 'forwardedDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'arrivedDate', name: 'arrivedDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'waitingDate', name: 'waitingDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'onHoldDate', name: 'onHoldDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'clearedDate', name: 'clearedDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'arrangedDate', name: 'arrangedDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'outDate', name: 'outDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'deliveredDate', name: 'deliveredDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'notDeliveredDate', name: 'notDeliveredDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'pendingDate', name: 'pendingDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'moreTrackingDate', name: 'moreTrackingDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                    {data: 'transferDate', name: 'transferDate',
                        render: function(data) {
                            if(data != null) {
                                return data;
                            }else if (data == null) {
                                return '';
                            }
                        }
                    },
                ],
                "aaSorting": [ [2,'desc'] ],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'excel',
                    title: '',
                }]
        }); 

        $("#filterType").on('change', function() {
            var type = $(this).val();
            if(type == 'Status') {
                $(".dateDiv").addClass('hidden');
                $(".textDiv").addClass('hidden');
                $(".statusDiv").removeClass('hidden');
            } else if(type == 'Date') {
                $(".statusDiv").addClass('hidden');
                $(".textDiv").addClass('hidden');
                $(".dateDiv").removeClass('hidden');
            } else if(type == 'shipmentNumber') {
                $(".statusDiv").addClass('hidden');
                $(".dateDiv").addClass('hidden');
                $(".textDiv").removeClass('hidden');
            }
        });

        $(".searchClass").on('click', function() {
            var table = $('#datatable1').DataTable();
            var filter = $("#filterType").val();
            table.column(1).search('');
            table.column(10).search('');
            table.column(11).search('');
            table.column(12).search('');
            table.column(13).search('');
            table.column(14).search('');
            table.column(15).search('');
            table.column(16).search('');
            table.column(17).search('');
            table.column(18).search('');
            table.column(19).search('');

            if(filter == 'shipmentNumber') {
                table.column(1).search( $("#search").val() ).draw();
            } else if(filter == 'Status') {
                var search = $("#status").val();
                if(search == '15') {
                    table.column(10).search(search).draw();
                } else if(search == '3') { 
                    table.column(11).search(search).draw();
                } else if(search == '5') { 
                    table.column(12).search(search).draw();
                } else if(search == '7') { 
                    table.column(13).search(search).draw();
                } else if(search == '8') { 
                    table.column(14).search(search).draw();
                } else if(search == '9') { 
                    table.column(15).search(search).draw();
                } else if(search == '10') { 
                    table.column(16).search(search).draw();
                } else if(search == '11') { 
                    table.column(17).search(search).draw();
                } else if(search == '12') { 
                    table.column(18).search(search).draw();
                } else if(search == '17') { 
                    table.column(19).search(search).draw();
                }  else {

                }
            } else if(filter == 'Date') {
                var fromDate = $("#from_dated").val();
                var toDate = $("#to_dated").val();
                table.search( [fromDate, toDate] ).draw();
            }
            
        });

        $(document).on('click',".detailedView", function() {
            var shipmentNumber = $(this).closest('tr').find("td:eq(2)").text();
            var bookingNumber = $(this).closest('tr').find("td:eq(9)").text();
            $.ajax({
                    headers: {
                        "content-type" : "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url: `{{ route('super-admin.shipment.report.detailed') }}`,
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
                        $.each(result, function (key, value) {
                            // console.log(result);
                            var statusCount = value.box_statuses.length;
                            if(statusCount > 0) {
                                for(var i=0;i<statusCount; i++) {
                                    if(value.box_statuses[i].status.name == 'Pending') {
                                        var style =  "background-color:red";
                                    } else if(value.box_statuses[i].status.name == 'Shipment on hold') {
                                        var style =  "background-color:orange";
                                    } else if(value.box_statuses[i].status.name == 'Not Delivered') {
                                        var style =  "background-color:yellow";
                                    } else {
                                        var style =  "background-color:none";
                                    }
                                    html += '<tr style="'+style+'">'+
                                            '<td>'+value.box_name+'</td>';
                                            if(statusCount >= 0) {
                                                html +=   '<td>'+value.box_statuses[i].status.name+'</td>';
                                                html +=   '<td>'+value.dated+'</td>';
                                            } else {
                                                html +=  '<td>--</td>';
                                                html +=  '<td>--</td>';
                                            }
                                            html += '</tr>';
                                }
                            } else {
                                
                                html += '<tr>';
                                if(value.box_name != null) {
                                    html +=  '<td>'+value.box_name+'</td>';
                                } else {
                                    html +=  '<td>'+value.id+'</td>';
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
        });

    }); 
</script>
@endsection

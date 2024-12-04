@extends('layouts.appagency')

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


                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <form action="{{update_url($ships->id)}}" method="post" enctype="multipart/form-data">

                                @csrf
                                <div class="col-md-12"> 

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking No</label>
                                                <select name="booking_id" id="booking_id" class="form-control"  multiple>
                                                    @foreach($bookings as $booking)
                                                    <option value="{{$booking->id}}">{{$booking->booking_number}}</option> 
                                                    @endforeach 
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                     
                                            <div class="form-group">
                                                <label>Shipment ID</label>
                                                <input type="text" class="form-control" name="shipment_id" value="{{$ships->id}}" />
                                                <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}" />
                                            </div>

                                         
                                        </div> 
                                    </div> 
                                </div> 


                                <div class="col-md-12"> 

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>AWB id</label>
                                                <input type="text" class="form-control" name="awd_id" value="" />
                                                
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                            <label>Date 11</label>
                                                    <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : ''}}" max=""
                                                        class="form-control" id="propertyname" name="created_date"
                                                        placeholder="Enter title">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">                                     
                                            <div class="form-group">
                                                    <label>Shipment Status</label>
                                                    <select name="status_id" class="form-control" id="">
                                                        @foreach (status_list_admin() as $item)
                                                            <option
                                                                {{ (old('status_id')==$item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('status_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                        </div>                                        

                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                            <label>Estimated Delivery</label>
                                                    <input type="date" value="{{ isset($date_from) ? $date_from : ''}}" max="{{date('Y-m-d')}}"
                                                        class="form-control" id="propertyname" name="date_from"
                                                        placeholder="Enter title">
                                            </div>
                                        </div>
                                    </div> 
                                </div> 

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <!-- <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a> -->
                                </div>

                            </form>
                            <!-- end form -->

                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>




                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="body p-5">
                                <div class="header">
                                    <h4>Assigned Shipments</h4>
                                </div>
                                <div class="col-md-12 text-right ">   
                                    <!-- <form action="http://127.0.0.1:8000/branch/ship/printall" method="post" target="_blank">  -->
                                            <button type="submit" class="btn btn-icon waves-effect waves-light btn-success" style="margin-bottom:10px;" form="form1" value="Submit"> <i class="fas fa-print"> Print all</i></button> 
                                    <!-- </form>                                     -->
                                </div>
                                <div class="table-responsive">
                                    <table id="shipsTable" class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th>Booking No</th>
                                            <th>Shipment name</th>
                                            <th>No of Pcs</th>
                                            <th>Total Weight</th>
                                            <th>Total value</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData">
                                            <!-- <tr id="bookingData">
                                                <td>4545454</td>
                                                <td>Shipment 112</td>
                                                <td>3</td>
                                                <td>10</td>
                                                <td>25</td>
                                                <td>Shipment Forwarded</td>
                                                <td> 
                                                @can(permission_edit())
                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan
                                                    @can(permission_view())
                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-success">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('shipment-print')
                                                    <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-warning">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-success">
                                                            <i class="fas fa-print"></i>
                                                        </a>                                                        

                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-dark">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                    @endcan

                                                </td>
                                            </tr> -->
                                       

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->

@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')

    <script>
        $(function () {
            // validation needs name of the element
            // initialize after multiselect

            $(document).ready(function () {
                $('.select2').select2();
                // addItems();
            });
            
        });

$(document) .ready(function() {
        $("#booking_id").change(function(){
        var opts = [];
        // var values=$(this).val(); //$("#booking_id option:selected");
        // var ship_id = $("#ship_id").val();
        // var bookingIds = {bookinigId:values, ship_id:ship_id};

        var selMulti = $.map($("#booking_id option:selected"), function (el, i) {
         return $(el).text();
        });
        // $("#result").text(selMulti.join(", "));         
        var values= selMulti.join(", "); //$("#booking_id option:selected");
        var ship_id = $("#ship_id").val();
        var bookingIds = {bookinigId:values, ship_id:ship_id};

        $.ajax({
                    headers: {
                        "content-type" : "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url: `{{ route('branch.ship.groupbookings') }}`,
                    type: "POST",
                    async:false,
                    data: JSON.stringify(bookingIds),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {  
                        $('#bookingData').html(result);
                        datatable = $('#shipsTable').DataTable();
                        datatable.draw();  
                     },
                    error: function (err) {
                     
                        console.log(err);
                       
                    }
                }); // ajax call closing
        });
});

 </script>

@endsection

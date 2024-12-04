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
                            <form action="{{route('branch.ships.createbookingtoship')}}" method="post" enctype="multipart/form-data">

                                @csrf
                                <div class="col-md-12"> 

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking No</label>
                                                <select name="booking_ids[]" id="booking_ids" class="select2 form-control"  multiple>
                                                    @foreach($bookings as $booking)
                                                    <option value="{{$booking->id}}">{{$booking->booking_number}}</option> 
                                                    @endforeach 
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                     
                                            <div class="form-group">
                                                <label>Shipment ID</label>
                                                <input type="text" class="form-control" name="shipment_id" value="{{$ships->shipment_id}}" />
                                            </div>

                                         
                                        </div> 
                                    </div> 
                                </div> 


                                <div class="col-md-12"> 

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>AWB id</label>
                                                <input type="text" class="form-control" name="awd_id" value="{{$ships->awd_id}}" />
                                                
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-3">
                                            <div class="form-group"> 
                                            <label>Date</label>
                                                    <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : ''}}" max=""
                                                        class="form-control" id="propertyname" name="created_date"
                                                        placeholder="Enter title">
                                            </div>
                                        </div> -->
                                        
                                        <div class="col-md-4">                                     
                                            <div class="form-group">
                                                    <label>Shipment Status</label>
                                                    <select name="status_id" class="form-control" id="">
                                                        @foreach (status_list_admin() as $item)
                                                            <option
                                                                {{ ( $ships->shipment_status==$item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('status_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                        </div>
                                        <!--  -->

                                        

                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                            <label>Estimated Delivery</label>
                                                    <input type="date" value="{{ isset($ships->estimated_delivery) ? date('Y-m-d', strtotime($ships->estimated_delivery)) : ''}}" max=""
                                                        class="form-control" id="propertyname" name="estimated_delivery"
                                                        placeholder="Enter title">
                                            </div>
                                        </div>
                                    </div> 
                                </div> 

                                <div class="text-center">
                                    <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}" />
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


                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <form action="{{route('branch.ships.updatebookingtoship')}}" method="post" enctype="multipart/form-data">

                                @csrf 

                                <div class="col-md-12"> 

                                    <div class="row">
                                        <div class="col-md-4">                                             
                                            <div class="form-group">
                                                <label>Change Shipment Status</label>
                                                <select name="status_id" class="form-control" id="">
                                                    @foreach (status_list_admin() as $item)
                                                        <option
                                                            {{ ( $ships->shipment_status==$item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('status_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                            <label>Date</label>
                                                    <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : ''}}" max=""
                                                        class="form-control" id="propertyname" name="created_date"
                                                        placeholder="Enter title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                            <label>Tracking Url</label>
                                                    <input type="text" value="" max=""
                                                        class="form-control" id="tracking_url" name="tracking_url"
                                                        placeholder="Enter tracking url">
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                        <div class="form-group"> 
                                                <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}" />
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Update
                                                </button>
                                                </div>
                                            
                                        </div>
                                    </div>

                                    </div> 
                                    
                                </div> 

                                <!-- <div class="text-center">
                                    <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}" />
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update
                                    </button>
                                      <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>  
                                </div> -->

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
                                    <form action="{{route('branch.shipment.printall')}}" method="post" target="_blank" > 
                                @csrf 
                                        <?php  foreach( $ship_bookingsList as $booking) {   
                                               echo '<input type="hidden" name="booking_ids[]" value="'. $booking->shipment->id. '">'; 
                                        }
                                         ?>
                                            <button type="submit" class="btn btn-success waves-effect waves-light"><i class="fas fa-print"> Print all</i>
                                    </button>

                                            <!-- <button type="submit" class="btn btn-icon waves-effect waves-light btn-success" style="margin-bottom:10px;"  form="form1" value="Submit"> <i class="fas fa-print"> Print all</i></button>  -->
                                    </form>                                    
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
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData">
                                        <?php

                                        $res ='';
                                        $tot_weight = 0;
                                        $tot_value = 0;
                                        $tot_temp =0;

                                        foreach( $ship_bookingsList as $booking) { 
 
                                            $tot_temp= $booking->shipment->total_weight +$booking->shipment->msic_weight;
                                            $tot_weight +=$tot_temp;
                                            $tot_value += $booking->shipment->grand_total;                                          
                                            ?>                                            
                                            <tr>
                                             <td style="text-align:center" >{{ $booking->shipment->booking_number}}</td>  
                                             <td style="text-align:center">{{ $booking->ship->shipment_name}}</td>
                                             <td style="text-align:center">{{ $booking->shipment->number_of_pcs }}</td>
                                             <td style="text-align:center">{{ $booking->shipment->total_weight + $booking->shipment->msic_weight }}</td>
                                             <td style="text-align:center">{{$booking->shipment->grand_total}}</td>
                                             <td style="text-align:center">{{ $booking->ship->shipmentStatus->name}}</td>
                                             <td style="text-align:center">{{ !empty($booking->ship->created_date) ? date('Y-m-d', strtotime($booking->ship->created_date)) : '' }}</td>
                                            <td>            
                                                    <a href="#"
                                                    class="btn btn-icon waves-effect waves-light btn-success">
                                                        <i class="fas fa-eye"></i>
                                                    </a>    
                                                    <a href="/branch/shipment/print/{{$booking->shipment->id}}" target="_blank"
                                                    class="btn btn-icon waves-effect waves-light btn-success">
                                                        <i class="fas fa-print"></i>
                                                    </a> 

                                                    

                                                    
                                                    <a href="{{route('branch.ships.undoaddbooking',$booking->id)}}"
                                                    class="btn btn-icon waves-effect waves-light btn-dark">
                                                        <i class="fas fa-undo"></i>
                                                    </a>
                                                </td> </tr>  
                                            <?php     
                                            }
                                            ?>
                                            <tr><td  colspan="3"> </td><td style="text-align:center">{{ $tot_weight}}</td><td style="text-align:center" >{{ $tot_value }}</td> <td colspan="2"  ></td></tr>   
                                                    
                                        

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

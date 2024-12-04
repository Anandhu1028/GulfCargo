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
                            <div class="fa-pull-right pb-3"><a href="{{create_url()}}" class="btn btn-success">Add New</a></div>

                            @can(permission_create())
                                
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">  
                            <table id="movingdatatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr> 
                                    <th>TRIP No</th>
                                    <th>VEHICLE/ VENDOR DETAILS</th>
                                    <th>TRIP DETAILS</th>
                                    <th>EXPENSE DETAILS</th>
                                    <th>STATUS</th>
                                    <th style="text-align: center">ACTIONS</th>                                   

                                                                   
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($tripsheets as $tripsheet) 
                                        <?php if($tripsheet->destination == 'vendor')
                                            $style="background-color:#f1c9ff";
                                        else     
                                            $style="background-color:white";
                                        
                                        ?>

                                        <tr style="{{$style}}">
                                            <td>{{$tripsheet->tripsheet_no }}</td>
                                            <td>
                                                @if($tripsheet->type== 'vehicle')
                                                <b>Vehicle No </b>: {{$tripsheet->vehicle->vehicle_no}} <br>
                                                <b>Driver Name </b>: {{$tripsheet->vehicle->driver_name }} <br>
                                                <b>Driver Mob </b>: {{$tripsheet->vehicle->driver_mobile }} <br>
                                                @else 
                                                <b>Vendor Name </b>: {{$tripsheet->vendor->name??''}} <br>
                                                <b>Authorized Person </b>: {{$tripsheet->vendor->authorized_person??'' }} <br>
                                                <b>Vendor Mob </b>: {{$tripsheet->vendor->mobile_number??'' }} <br>
                                                @endif
                                            </td>
                                            <td>
                                                <b>Trip Date </b>: {{$tripsheet->trip_date}} <br>
                                                <b>Start K.M </b>: {{$tripsheet->start_km }} <b>| Stop K.M </b>: {{$tripsheet->stop_km }} <br>
                                                <b>Total K.M </b>: {{$tripsheet->total_km}}
                                            </td>
                                            <td>
                                                <b>Expense Total </b>: {{$tripsheet->expense_total}} <br>
                                                <b>Expense Advance </b>: {{$tripsheet->advance_amt }} <br>
                                                <b>Balance </b>: {{$tripsheet->balance_amount}}
                                            </td>
                                            <td>                                                
                                                @if($tripsheet->status=='trip_created')
                                                Trip Created 
                                                @elseif($tripsheet->status=='trip_started') 
                                                Trip started 
                                                @elseif($tripsheet->status=='on_the_way')
                                                On the Way  
                                                @elseif($tripsheet->status=='trip_finished') 
                                                Trip Finished  
                                                @endif
                                            </td>
                                            <td  style="text-align:center">
                                                <div class="btn-group">
                                                    <a href="#"  data-original-title="Print" >
                                                    <i class="fa fa-print p-1"  style="font-size:24px;color:grey" aria-hidden="true"></i> </a>
                                                    <a href="{{route('branch.tripsheet.cargos',$tripsheet->id)}}"  data-original-title="Add Cargos"  >
                                                    <i class="fa fa-truck p-1"  style="font-size:24px; color:grey"></i></a>
                                                    <!-- class="btn btn-xs btn-icon waves-effect waves-light btn-warning" -->
                                                    <a href="{{edit_url($tripsheet->id)}}"  data-original-title="Update Trip Sheet" >
                                                        <i class="fa fa-edit p-1" style="font-size:24px;color:grey"></i>
                                                    </a>

                                                    <!-- <a href="http://demo.indianlivecargo.com/trip_sheet/update/95"  data-original-title="Update Trip Sheet">
                                                    <i class="fa fa-edit p-1"  style="font-size:24px;color:grey"></i></a> -->
                                                </div> 
                                            </td>
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
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script>

$(document).ready(function () {
    $('#movingdatatable').DataTable({  
        "autoWidth": false,
        "aaSorting": [ [0,'desc'] ], 
        "scrollX": true,
        "responsive": false
    });  

}); 

    </script>
@endsection

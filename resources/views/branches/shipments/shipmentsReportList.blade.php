@extends('layouts.app')

@section('content')
<style>
.boxContainer{
    border:1px solid black;
    padding:5px;
    margin-top:5px;
}
.icons {
    padding:5px;
    font-size:x-small;
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
                                    <li class="breadcrumb-item"><a href="{{route('super-admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('branch.ship.create')}}">Shipment List</a></li>
                                    <li class="breadcrumb-item active">Shipment Report</li>

                                </ol>
                            </div>
                            <h4 class="page-title">Shipment Report</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <table id="datatable1" class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th style="display:none;">Ship ID </th>
                                    <th>Shipment No:</th>
                                    <th>Shipment Date</th>
                                    <th>Shipment Type</th>
                                    <th>No of boxes</th>
                                    <th>Port of Origin</th>
                                    <th>Port of Destination</th>
                                    <th>Clearing Agent</th>
                                    <th>Shipping Status</th>                                    
                                    <th>Status Date</th>                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach( $ships as $ship)
                                    <tr>
                                        <td style="display:none;">{{$ship->id}}</td>
                                        <td>{{$ship->shipment_id}}</td>
                                        <td>{{$ship->created_date}}</td>
                                        <td>{{$ship->shipmentMethodTypes->name}}</td>
                                        <td>{{$ship->portOfOrigins->name??''}}</td>
                                        <td>{{$ship->portOfDestinations->name??''}}</td>
                                        <td>{{$ship->clearingAgents->name??''}}</td>
                                        <td>{{$ship->createdBy->full_name}}</td>
                                        <td>{{ !empty($ship->created_date) ? date('Y-m-d',strtotime($ship->created_date)) : '' }}</td>
                                        <td>{{ !empty($ship->shipment_status) ? $ship->shipmentStatus->name : '' }}</td>
                                        
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
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
@include('layouts.datatables_js')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
        $('#datatable1').DataTable({
            "ordering": false,
            "scrollX": true,
            "responsive": false,
              'columnDefs' : [
                //hide the second & fourth column
                { 'visible': false, 'targets': [0] }
            ]
        }); 
    }); 
</script>
@endsection

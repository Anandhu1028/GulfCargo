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
                            @can(permission_create())
                                <div class="fa-pull-right pb-3"><a href="{{create_url()}}"
                                                                   class="btn btn-success">Add New</a></div>
                            @endcan
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12">

                        <div class="card-box table-responsive">
{{--                            <form action="" method="get">--}}
{{--                                <div class="row justify-content-center">--}}

{{--                                    <div class="form-group">--}}
{{--                                        <input type="date" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}"--}}
{{--                                               class="form-control" id="propertyname" name="date"--}}
{{--                                               placeholder="Enter title">--}}
{{--                                    </div>--}}
{{--                                    <div class="pl-1">--}}
{{--                                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit--}}
{{--                                        </button>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </form>--}}

  
                            <table id="bookingdatatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>

                                <tr>
                                    <th>Booking No</th>
                                    <th>Sender Name</th>
                                    <th>Receiver Name</th>
                                    <th>Shipping Status</th>
                                    <th>Payment Method</th>
                                    <th>Courier Company</th>
                                    <th>Driver</th>
                                    <th>Date</th>
                                    @canany([permission_edit(),permission_view(),'shipment-show']) 
                                        <th style="text-align: center">Action</th>
                                    @endcanany
                                </tr>

                                </thead>

                                <tbody>
                                @foreach($shipments as $key=> $shipment)
                                <?php 
                                        if($shipment->statusVal->name == "Enquiry collected") {
                                            $showAddItems = true;
                                            $style ="style=background-color:yellow;padding:5px;";
                                        } else {
                                            $style ="style=background-color:none";
                                            $showAddItems = false;

                                        }
                                ?>
                                    <tr>
                                        <td>{{ $shipment->booking_number }}</td>
                                        <td>{{ $shipment->sender->name }}</td>
                                        <td>{{ $shipment->receiver->name??""}}</td>
                                        <td><span {{ $style}}>{{ $shipment->statusVal->name }}</span></td>
                                        <td>{{ $shipment->payment_method }}</td>
                                        <td>{{ $shipment->courier_company }}</td>
                                        <td>{{ $shipment->driver?$shipment->driver->name:'-'}}</td>                                        
                                        <td>{{ !empty($shipment->created_date)? date('Y-m-d', strtotime($shipment->created_date)):''  }}</td>
                                        <td>  
                                        @can(permission_edit())   
                                        @if(agency_branch()->id == $shipment->branch_id)                                             
                                            <a href="{{edit_url($shipment->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endif
                                        @endcan
                                        @can(permission_view())
                                            <a href="{{show_url($shipment->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-success">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('shipment-print')
                                            <a href="{{route('branch.shipment.print',$shipment->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-dark">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        @endcan
                                        @if($showAddItems)
                                        @if(agency_branch()->id == $shipment->branch_id)    
                                            <a href="{{route('branch.shipment.item',$shipment->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-warning">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        @endif
                                        @endif 
                                        </td>
                                        <!-- @canany([permission_edit(),permission_view(),'shipment-show'])
                                            <form method="post" action="{{delete_url($shipment->id)}}"> -->
                                                <!-- <td>   
                                                    @can(permission_edit())
                                                        <a href="{{edit_url($shipment->id)}}"
                                                           class="btn btn-icon waves-effect waves-light btn-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan
                                                    @can(permission_view())
                                                        <a href="{{show_url($shipment->id)}}"
                                                           class="btn btn-icon waves-effect waves-light btn-success">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('shipment-print')
                                                        <a href="{{route('branch.shipment.print',$shipment->id)}}"
                                                           class="btn btn-icon waves-effect waves-light btn-dark">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                    @endcan
                                                    @if($showAddItems)
                                                        <a href="{{route('branch.shipment.item',$shipment->id)}}"
                                                           class="btn btn-icon waves-effect waves-light btn-warning">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    @endif 
                                                </td> -->
                                            <!-- </form> -->
                                        <!-- @endcanany -->
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
    $('#bookingdatatable').DataTable({
        "aaSorting": [ [0,'desc'] ]
    }); 


}); 

    </script>
@endsection

@extends('layouts.app')

@section('content')
<style>
.head {
    background-color:#002dd1;
    color:#fff;
    padding:5px 10px;
    font-size:24px;
    text-transform: uppercase;
    font-weight:bold;
}
.desc {
    padding:10px 0px 10px 10px;
}
.detailHead {
    border: 1px solid;
    background-color: #d3d3d3;
}
.statusStyle {color:red;}
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
                                    <li class="breadcrumb-item active">Edit Shipment</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Shipment Details</h4>
                        </div>
                    </div>
                </div>
                <?php
                    $tot_weight_exist = 0;
                    $tot_value_exist = 0;
                    $tot_temp_exist =0;
                    $totalPieces =0;
                    $lastStatus = '';
                    $statusList = [];

                    foreach( $shipBookings as $booking) { 

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
                        $boxList = [];
                        $boxListValue = [];
                        if(!empty($booking->shipment->boxes)) {
                            foreach($booking->shipment->boxes as $box) {
                                $boxList[] = (!empty($box->box_name) )? $box->box_name : $box->id ;
                                $boxListValue[] = $box->id ;
                            }
                            $List = implode(', ', $boxList);
                            $ListValue = implode(', ', $boxListValue);
                        }  
                        
                        if(($booking->boxStatuses != null)) {
                            $statusList[] = $booking->last_status;
                            
                            $delete_item = 'Pending';
                            $delete_item1 = 'Shipment on hold';
                            $statusListNew = array_diff($statusList, array($delete_item,$delete_item1));
                            $count1 = array_count_values($statusListNew);
                            $count = count($count1);
                            $getNum = $count - 1; 
                            $status = implode(', ', $statusListNew);
                            // $shipmentStatus = collect($booking->shipment->shipmentStatus)->last();
                        }  

                        if(!empty($booking->boxStatuses)) {
                            $collectedType = collect($booking->shipment->shipmentStatus)->where('statuses_id', 15)->last();
                            $receivedType = collect($booking->boxStatuses)->where('status_id', 1)->last();
                            $bookedType = collect($booking->boxStatuses)->where('status_id', 2)->last();
                            $forwardedType = collect($booking->boxStatuses)->where('status_id', 3)->last();
                            $arrivedType = collect($booking->boxStatuses)->where('status_id', 4)->last();
                            $waitingType = collect($booking->boxStatuses)->where('status_id', 5)->last();
                            $onHoldType = collect($booking->boxStatuses)->where('status_id', 7)->last();
                            $clearedType = collect($booking->boxStatuses)->where('status_id', 8)->last();
                            $arrangedType = collect($booking->boxStatuses)->where('status_id', 9)->last();
                            $outType = collect($booking->boxStatuses)->where('status_id', 10)->last();
                            $deliveredType = collect($booking->boxStatuses)->where('status_id', 11)->last();
                            $notDeliveredType = collect($booking->boxStatuses)->where('status_id', 12)->last();
                            $pendingType = collect($booking->boxStatuses)->where('status_id', 13)->last();
                            $moreTrackingType = collect($booking->boxStatuses)->where('status_id', 14)->last();
                            $transferType = collect($booking->boxStatuses)->where('status_id', 17)->last();
            
                            $collectedDate = (!empty($collectedType)) ? date('d-m-Y',strtotime($collectedType->created_at)) : '' ;
                            $receivedDate = (!empty($receivedType)) ? date('d-m-Y',strtotime($receivedType->created_at)) : '' ;
                            $bookedDate = (!empty($bookedType)) ? date('d-m-Y',strtotime($bookedType->created_at)) : '' ;
                            $forwardedDate = (!empty($forwardedType)) ? date('d-m-Y',strtotime($forwardedType->created_at)) : '' ;
                            $arrivedDate = (!empty($arrivedType)) ? date('d-m-Y',strtotime($arrivedType->created_at)) : '' ;
                            $waitingDate = (!empty($waitingType)) ?  date('d-m-Y',strtotime($waitingType->created_at)) : '' ;
                            $onHoldDate = (!empty($onHoldType)) ?  date('d-m-Y',strtotime($onHoldType->created_at)) : '' ;
                            $clearedDate = (!empty($clearedType)) ? date('d-m-Y',strtotime($clearedType->created_at)) : '' ;
                            $arrangedDate = (!empty($arrangedType)) ?  date('d-m-Y',strtotime($arrangedType->created_at)) : '' ;
                            $outDate = (!empty($outType)) ?  date('d-m-Y',strtotime($outType->created_at)) : '' ;
                            $deliveredDate = (!empty($deliveredType)) ?  date('d-m-Y',strtotime($deliveredType->created_at)) : '' ;
                            $notDeliveredDate = (!empty($notDeliveredType)) ?  date('d-m-Y',strtotime($notDeliveredType->created_at)) : '' ;
                            $pendingDate = (!empty($pendingType)) ?  date('d-m-Y',strtotime($pendingType->created_at)) : '' ;
                            $moreTrackingDate = (!empty($moreTrackingType)) ?  date('d-m-Y',strtotime($moreTrackingType->created_at)) : '' ;
                            $transferDate = (!empty($transferType)) ?  date('d-m-Y',strtotime($transferType->created_at)) : '' ;
                        }
                    }  
                    $lastStatus = (!empty($statusList) ) ? $statusListNew[$getNum] : $shipment->shipmentStatus->name ;

                ?>  
                <div class="row detailHead">
                        <div class="col-md-6">
                            <h1>{{$shipment->shipment_id}}</h1>
                            <h3>{{$shipment->shipment_id}}</h3>
                        </div>
                        <div class="col-md-6" style="margin-top:32px;">
                            <h5>AWB NO: {{$shipment->awb_number}}</h5>
                            <h5>STATUS : <span class="statusStyle">{{$lastStatus}}</span></h5>
                        </div>
                </div>
                <div class="row clearfix" style="border:1px solid;">    
                        <div class="col-md-6" style="padding-left:0px; border-right:1px solid;">
                            <div class="desc">
                                <table style="width:100%">
                                    <tr>
                                        <th style="width:30%">Shipment No:</th>  
                                        <th >: {{ $shipment->shipment_id ?? "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Port of Origin</th>  
                                        <th>: {{ $shipment->portOfOrigins->name ?? "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Total Box</th>  
                                        <th>: {{ $totalPieces ?? "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Total Weight</th>  
                                        <th>: {{ $tot_weight_exist ?? ""}}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Created on</th>  
                                        <th>: {{  date('d-m-Y',strtotime($shipment->created_date)) ?? ""}}</th>  
                                    </tr>
                                    <tr>
                                        <th>License Details</th>  
                                        <th>: {{ $shipment->license_details ?? ""}}</th>  
                                    </tr> 
                                    <tr>
                                        <th>Shipment Status</th>  
                                        <th>: {{ $lastStatus }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Enquiry Collected</th>  
                                        <th>: {{ (!empty($collectedDate)) ? $collectedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Received</th>  
                                        <th>: {{ (!empty($receivedDate)) ? $receivedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Booked</th>  
                                        <th>: {{ (!empty($bookedDate)) ? $bookedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Forwarded</th>  
                                        <th>: {{ (!empty($forwardedDate)) ? $forwardedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Arrived</th>  
                                        <th>: {{ (!empty($arrivedDate)) ? $arrivedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Waiting for Clearance</th>  
                                        <th>: {{  (!empty($waitingDate)) ? $waitingDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment on Hold</th>  
                                        <th>: {{ (!empty($onHoldDate)) ?  $onHoldDate : "" }}</th>  
                                    </tr>
                                </table>
                            </div>                        
                        </div>

                        <div class="col-md-6" style="padding-right:0px;">
                            <div class="desc">
                                <table style="width:100%">
                                    
                                    <tr>
                                        <th>Port of Destination</th>  
                                        <th>: {{ $shipment->portOfDestinations->name ?? "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Type</th>  
                                        <th>: {{ $shipment->shipmentMethodTypes->name ?? ""}}</th>  
                                    </tr> 
                                    <tr>
                                        <th style="width:30%">Total Value in DH</th>  
                                        <th >: {{$tot_value_exist}} </th>  
                                    </tr>
                                    <tr>
                                        <th>Total Value in USD</th>  
                                        <th>: {{$tot_value_exist * 0.27}}</th>  
                                    </tr>
                                    <tr>
                                        <th>Carrier Agent</th>  
                                        <th>: {{$shipment->clearingAgents->name}} </th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Details</th>  
                                        <th>: {{$shipment->shipment_details}}</th>  
                                    </tr>
                                    <tr>
                                        <th>Shipment Cleared</th>  
                                        <th>: {{ (!empty($clearedDate)) ? $clearedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Delivery Arranged</th>  
                                        <th>: {{ (!empty($arrangedDate)) ? $arrangedDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Out for Delivery</th>  
                                        <th>: {{ (!empty($outDate)) ? $outDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Delivered</th>  
                                        <th>: {{ (!empty($deliveredDate)) ? $deliveredDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Not Delivered</th>  
                                        <th>: {{ (!empty($notDeliveredDate)) ? $notDeliveredDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Pending</th>  
                                        <th>: {{ (!empty($pendingDate)) ? $pendingDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>More Tracking</th>  
                                        <th>: {{ (!empty($moreTrackingDate)) ? $moreTrackingDate : "" }}</th>  
                                    </tr>
                                    <tr>
                                        <th>Transfer</th>  
                                        <th>: {{ (!empty($transferDate)) ? $transferDate : "" }}</th>  
                                    </tr>
                                </table>
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
@endsection

<?php $i = 1;?>
    @foreach( $ships as $ship)
    <?php 
    $List = '';
    $boxList = [];
    if(!empty($ship->shipment->boxes)) {
        foreach($ship->shipment->boxes as $box) {
            $boxList[] = $box->id;
        }
    $List = implode(', ', $boxList);
    }
    $i++;
    if(count($boxList) == 1 ) {
        $color = 'style=background-color:#6B8E23;';
    }
    if(count($boxList) == 2 ) {
        $color = 'style=background-color:#00FA9A;';
    }
    if(count($boxList) == 3 ) {
        $color = 'style=background-color:#E9967A;';
    }
    if(count($boxList) == 4 ) {
        $color = 'style=background-color:#d6d6d6;';
    }
    ?>
    @foreach($boxList as $listData)
    <tr {{$color}}  {{count($boxList)}}>
        <td>{{$ship->ship->shipment_name}} </td>
        <td>{{$ship->ship->portOfOrigins->name}}</td>
        <td>{{$ship->ship->shipmentTypes->name}}</td>
        <td>{{ (!empty($ship->ship->awb_number))? $ship->ship->awb_number : ''}}</td>
        <td>{{ (!empty($ship->ship->created_date))? date('d-m-Y',strtotime($ship->ship->created_date)) : ''}}</td>
        <td>{{ !empty($ship->ship->clearing_agent_id) ? $ship->ship->clearingAgents->name : '' }}</td>
        <td>{{ !empty($ship->ship->created_by) ? $ship->ship->createdBy->full_name : '' }}</td>
        <td>{{ !empty($ship->shipment->booking_number) ? $ship->shipment->booking_number : '' }}</td>
        <td>{{$listData}}</td>
        <td> 
            <?php 
                $collected = $ship->shipment->status->where('name', 'Enquiry collected')->first();
            ?>
            {{ (!empty($collected->pivot->created_at)) ? date('d-m-Y',strtotime($collected->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $received = $ship->shipment->status->where('name', 'Shipment received')->first();
            ?>
            {{ (!empty($received->pivot->created_at)) ? date('d-m-Y',strtotime($received->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $waiting = $ship->shipment->status->where('name', 'Waiting for clearance')->first();
            ?>
            {{ (!empty($waiting->pivot->created_at)) ? date('d-m-Y',strtotime($waiting->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $hold = $ship->shipment->status->where('name', 'Shipment on hold')->first();
            ?>
            {{ (!empty($hold->pivot->created_at)) ? date('d-m-Y',strtotime($hold->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $cleared = $ship->shipment->status->where('name', 'Shipment cleared')->first();
            ?>
            {{ (!empty($cleared->pivot->created_at)) ? date('d-m-Y',strtotime($cleared->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $deliveryArranged = $ship->shipment->status->where('name', 'Delivery arranged')->first();
            ?>
            {{ (!empty($deliveryArranged->pivot->created_at)) ? date('d-m-Y',strtotime($deliveryArranged->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $outForDelivery = $ship->shipment->status->where('name', 'Shipment out for delivery')->first();
            ?>
            {{ (!empty($outForDelivery->pivot->created_at)) ? date('d-m-Y',strtotime($outForDelivery->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $delivered = $ship->shipment->status->where('name', 'Delivered')->first();
            ?>
            {{ (!empty($delivered->pivot->created_at)) ? date('d-m-Y',strtotime($delivered->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $notDelivered = $ship->shipment->status->where('name', 'Not Delivered')->first();
            ?>
            {{ (!empty($notDelivered->pivot->created_at)) ? date('d-m-Y',strtotime($notDelivered->pivot->created_at)) : '' }}
        </td>
        <td>
            <?php 
                $pending = $ship->shipment->status->where('name', 'Pending')->first();
            ?>
            {{ (!empty($pending->pivot->created_at)) ? date('d-m-Y',strtotime($pending->pivot->created_at)) : '' }}
        </td>

    </tr>
    
    @endforeach 
    @endforeach 
    @section('scripts')
@include('layouts.datatables_js')
<script>
    $(document).ready(function () {
        // $('#example').DataTable();
        $('#datatable1').DataTable({
                searching: false, paging: false, info: false,
                "aaSorting": [ [1,'desc'] ],
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'excel',
                    title: '',
                }]
        }); 

    }); 
</script>
@endsection

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
                                {!! breadcrumbs() !!}
                            </div>
                            <h4 class="page-title">{{page_title()}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form action="{{store_url()}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Basic Info</h4>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment Number</label>
                                                <input type="text" name="shipment_id"
                                                       value= "" class="form-control"
                                                       required >
                                                @error('shipment_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Port Of Origin</label>
                                                <select name="port_of_origin" class="form-control" required >
                                                    <option value="0">Select</option>
                                                    @foreach($ports as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('port_of_origin')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Port Of Destination</label>
                                                <select name="port_of_destination" class="form-control" required >
                                                    <option value="0">Select</option>
                                                    @foreach($ports as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('port_of_destination')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipping Method</label>
                                                <select name="shipment_type" class="form-control" required >
                                                    <option value="0">Select</option>
                                                    @foreach($shipmentTypes as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('shipment_type')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>AWB No / Container no:</label>
                                                <input type="text" name="awd_number"
                                                       value= "" class="form-control"
                                                       required >
                                                @error('awb_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Created On</label>
                                                    <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) :  date('Y-m-d') }}" max=""
                                                        class="form-control" id="propertyname" name="created_date"
                                                        placeholder="Enter title">
                                            </div>

                                        </div>
                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="propertyname">Time</label>
                                                <input type="time" name="created_time" value="{{isset($ships->created_date) ? $ships->created_time:'' }}" class="  form-control"
                                                    required
                                                    placeholder="Select Time" autocomplete="off" id="setTimeExample">
                                            </div>
                                        </div> -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Clearing Agent</label>
                                                <select name="clearing_agent" id="clearing_agent" class="form-control" required>
                                                    @foreach($agents as $agent)
                                                    <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Created by</label>
                                                <select name="created_by" id="created_by" class="form-control" required>
                                                    @foreach($staffs as $staff)
                                                    <option value="{{$staff->id}}">{{$staff->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment Status</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="">Select</option>
                                                    @foreach($statuses as $status)
                                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>License Details</label>
                                                <input type="text" name="license_details"
                                                       value= "" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment Details</label>
                                                <input type="text" name="shipment_details"
                                                       value= "" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Exchange Rate</label>
                                                <input type="text" name="exchange_rate"
                                                       value= "" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>
                                </div>
                            </form>
                            <!-- end form -->

                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->



                <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box">
                            <table id="datatable1" class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th style="display:none;">Ship ID </th>
                                    @canany([permission_edit(),permission_view(),'shipment-show'])
                                        <th style="text-align: center" colspan="">Action</th>
                                    @endcanany
                                    <th>Shipment No:</th>
                                    <th>Shipment Type</th>
                                    <th>Port of Origin</th>
                                    <th>Port of Destination</th>
                                    <th>Clearing Agent</th>
                                    <th>Shipment Status</th>
                                    <th>Created by</th>
                                    <th>Created On</th>
                                    <th>Total Box</th>
                                    <th>Total Weight</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach( $ships as $ship)
                                    <?php
                                        $boxDetails = \App\Models\Boxes::with('shipment.driver','boxStatuses.status','shipment.shipmentStatus')->whereHas('shipment',function ($query) {
                                            $query->where('branch_id', branch()->id);
                                        })->where('ship_id',$ship->id)->where('is_shipment',1)->get();
                                        $tot_weight_exist = 0;
                                        $tot_value_exist = 0;
                                        $tot_temp_exist =0;
                                        $totalPieces =0;
                                        $count = 0;
                                        $lastStatus = '';
                                        $hrefTag = "#";
                                        $statusList = [];
                                        foreach( $boxDetails as $key => $booking) {
                                            $lastStatus = collect($booking->boxStatuses)->last();
                                            $boxDetails[$key]["last_status"] = $lastStatus->status->name;

                                            $tot_temp_exist= $booking->weight;
                                            $tot_weight_exist +=$tot_temp_exist;
                                            $tot_value_exist += (float)$booking->total_value + (float)$booking->box_packing_charge;
                                            $totalPieces += 1;

                                            if(($lastStatus != null)) {
                                                $statusList[] = $booking->last_status;

                                                $delete_item = 'Pending';
                                                $delete_item1 = 'Shipment on hold';
                                                $statusListNew = array_diff($statusList, array($delete_item,$delete_item1));
                                                $count1 = array_count_values($statusListNew);
                                                $count = count($statusListNew);
                                                $getNum = $count - 1;
                                                // $status = implode(', ', $statusListNew);
                                                $shipmentStatus = collect($booking->shipment->shipmentStatus)->last();
                                                if($count <= 0) {
                                                    $status =  $ship->shipmentStatus->name;
                                                } else {
                                                    $status =  $statusList[$getNum];
                                                }
                                            }
                                            if($booking->is_transfer == 1) {
                                                $hrefTag = "transfer";
                                            }
                                        }
                                        $lastStatus = ($totalPieces != 0 ) ?  $status : $ship->shipmentStatus->name ;
                                    ?>
                                    <tr>
                                        <td style="display:none;">{{$ship->id}}</td>
                                        <td>
                                            <a href="{{route('branch.ships.editShip', [$ship->id])}}"
                                                class="btn btn-icon waves-effect waves-light btn-warning icons" title="Edit Shipment">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="{{route('branch.ships.detailedView', [$ship->id])}}" class="btn btn-icon waves-effect waves-light btn-warning icons" title="Shipment Detailed View">
                                                <i class="fas  fa-lg fa-eye"></i>
                                            </a>
                                            <a @if($hrefTag != 'transfer') href="{{route('branch.ships.addbookingtoship', array('ship_id' => $ship->id))}}" @endif  class="btn btn-icon waves-effect waves-light btn-warning icons" title="View">
                                                <i class="fas  fa-lg fa-cog"></i>
                                            </a>
                                            {{-- <a href="{{route('branch.ships.addMoreBookingtoship', array('ship_id' => $ship->id))}}" class="btn btn-icon waves-effect waves-light btn-warning icons" title="Add Booking">
                                                <i class="fas  fa-lg fa-plus"></i>
                                            </a>                                       --}}
                                        </td>
                                        <td>{{$ship->shipment_id}}</td>
                                        <td>{{$ship->shipmentMethodTypes->name}}</td>
                                        <td>{{$ship->portOfOrigins->name??''}}</td>
                                        <td>{{$ship->portOfDestinations->name??''}}</td>
                                        <td>{{$ship->clearingAgents->name??''}}</td>
                                        <td>{{ $lastStatus }}</td>
                                        <td>{{$ship->createdBy->full_name}}</td>
                                        <td>{{ !empty($ship->created_date) ? date('Y-m-d',strtotime($ship->created_date)) : '' }}</td>
                                        <td>{{($totalPieces == 0) ? '' : $totalPieces}}</td>
                                        <td>{{($tot_weight_exist == 0 ? '' : $tot_weight_exist)}}</td>
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

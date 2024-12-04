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
                                    <li class="breadcrumb-item active">Edit Shipment</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Edit Shipment</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form action="{{route('branch.ships.shipDetailesUpdate')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$ship->id}}" name="shipId">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6  ">
                                                <h4>Basic Info</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{url('branch/ship/create')}}" type="button"
                                            class="btn btn-primary waves-effect waves-light" style="float:right;">Back
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment Number</label>
                                                <input type="text" name="shipment_id"
                                                       value= "{{$ship->shipment_id}}" class="form-control"
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
                                                    <option @if($ship->port_of_origin_id == $type->id) ? selected : '' @endif value="{{$type->id}}">{{$type->name}}</option>
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
                                                    <option  @if($ship->port_of_destination_id == $type->id) ? selected : '' @endif value="{{$type->id}}">{{$type->name}}</option>
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
                                                    <option @if($ship->shipment_type_id == $type->id) ? selected : '' @endif value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>AWB No:</label>
                                                <input type="text" name="awd_number"
                                                       value= "{{$ship->awb_number}}" class="form-control"
                                                       required >
                                                @error('awb_number')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Created On</label>
                                                    <input type="date" value="{{ isset($ship->created_date) ? date('Y-m-d', strtotime($ship->created_date)) : ''}}" max=""
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
                                                    <option  @if($ship->clearing_agent_id == $agent->id) ? selected : '' @endif value="{{$agent->id}}">{{$agent->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Created by</label>
                                                <select name="created_by" id="created_by" class="form-control" required>
                                                    @foreach($staffs as $staff)
                                                    <option  @if($ship->created_by == $staff->id) ? selected : '' @endif  value="{{$staff->id}}">{{$staff->full_name}}</option>
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
                                                    <option @if($ship->shipment_status == $status->id) ? selected : '' @endif value="{{$status->id}}">{{$status->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>License Details</label>
                                                <input type="text" name="license_details"
                                                       value= "{{$ship->license_details}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment Details</label>
                                                <input type="text" name="shipment_details"
                                                value= "{{$ship->shipment_details}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Exchange Rate</label>
                                                <input type="text" name="exchange_rate"
                                                       value= "{{$ship->exchange_rate}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update
                                    </button>
                                    <a href="{{route('branch.ship.create')}}" type="button"
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

</script>
@endsection

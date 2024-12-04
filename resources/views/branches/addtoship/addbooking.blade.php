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
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('super-admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('branch.ship.create')}}">Shipment List</a></li>
                                    <li class="breadcrumb-item active">View Assigned</li>

                                </ol>
                            </div>
                            <h4 class="page-title">Assigned Shipments</h4>

                        </div>
                    </div>

                </div>

                <?php
                    $selectedBoxId = [];
                    $res ='';
                    $total_count = 0;
                    $tot_sel_weight = 0;
                    $tot_sel_amt = 0;
                    $tot_weight = 0;
                    $tot_value = 0;
                    $tot_temp =0;
                    $tot_sel_temp =0;
                    $totalPieces =0;

                    foreach( $ship_bookingsList as $booking) {

                        $tot_temp= $booking->weight;
                        $tot_weight +=$tot_temp;
                        $tot_value += $booking->shipment->grand_total;
                        $totalPieces += 1;
                        // $totalPieces += $booking->shipment->number_of_pcs;
                        $List = '';
                        $ListValue = '';
                        $boxList = [];
                        $boxListValue = [];

                        $status = '';
                        $lastStatus = '';
                        if(!empty($booking->shipment->bookingNumberStatus)) {
                            $status = collect($booking->shipment->bookingNumberStatus)->last();

                            // $lastStatus = (!empty($status)) ? $status->status->name : $booking->ship->shipmentStatus->name ;
                        }

                    }
                        ?>
                <!-- <div class="row">
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

                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label>Date</label>
                                                    <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : ''}}" max=""
                                                        class="form-control" id="propertyname" name="created_date"
                                                        placeholder="Enter title">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                    <label>Shipment Status</label>
                                                    <select name="status_id" class="form-control" id="">
                                                        @foreach ( status_list_admin() as $item)
                                                            <option
                                                                {{ ( $ships->shipment_status==$item->id) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('status_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                        </div>



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
                                </div>

                            </form>

                        </div>



                    </div>
                </div> -->


                <!-- <div class="row">
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
                                                    @foreach (\App\Models\Statuses::all() as $item)
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



                            </form>

                        </div>



                    </div>
                </div> -->



                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="body">
                                <div class="header">
                                    <!-- <h4>Assigned Shipments</h4> -->
                                </div>
                                <div class="row detailHead">
                                        <div class="col-md-6">
                                            <h1>{{$ships->shipment_id}} / AWB NO: {{$ships->awb_number}}</h1>
                                            <h3>Boxes:<span class="fontRed"> {{$totalPieces}}</span> , Weight: <span class="fontRed">{{number_format($tot_weight,2)}} KG</span> </h3>
                                        </div>
                                        <div class="col-md-6" style="margin-top:32px;">
                                            <h5>&nbsp;</h5>
                                            <h5>FROM: <span class="fontRed">{{$ships->portOfOrigins->name}}</span> To: <span class="fontRed">{{$ships->portOfDestinations->name}}</span></h5>
                                        </div>
                                </div>
                                <div class="col-md-12 text-right ">

                                    <div class="row floatRight" >
                                        <a  href="{{route('branch.ships.deliverylistptint', array('ship_id' => $ships->id))}}" class="btn btn-success mr-3 mb-1"> Delivery List</a>
                                        <a  href="{{route('branch.ships.packinglistptint', array('ship_id' => $ships->id))}}" class="btn btn-success mr-3 mb-1"> Packing List </a>
                                        <a  href="{{route('branch.ships.customermanifestptint', array('ship_id' => $ships->id))}}" class="btn btn-success mr-3 mb-1"> Customs Manifest</a>
                                        <button type="submit" class="btn btn-success waves-effect waves-light changeStatus mb-1"  id="changeStatus">Change Status</button>

                                        <div class="modal fade" id="printAllModal" tabindex="-1" aria-labelledby="printAllModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content w-75">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="printAllModalLabel">Print All Shipments</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('branch.shipment.printall') }}" method="post" target="_blank">
                                                            @csrf
                                                            @foreach ($ship_bookingsList as $booking)
                                                                <input type="hidden" name="booking_ids[]" value="{{ $booking->id }}">
                                                            @endforeach
                                                            <div class="row">
                                                                <label class="ml-3">Select Courier Company</label>
                                                                <div class="form-group col-md-12">
                                                                    <input type="text" name="awb_no" value="{{$ships->awb_number}}" class="d-none">
                                                                    <select name="agency" id="sender_id" class="form-control" required>
                                                                        @foreach ($agencies as $agency)
                                                                            <option value="{{$agency->id}}">{{$agency->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 text-center mt-2" >
                                                                <button type="submit"  class="btn btn-success p-2" >Print all</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" id="printallButton" class="btn btn-success waves-effect waves-light ml-2 mb-1" data-bs-toggle="modal" data-bs-target="#printAllModal" disabled>
                                            <i class="fas fa-print"> Print all</i>
                                        </button>

                                        <form action="{{route('branch.shipment.loadingExport')}}" class="m-l-10" method="post" target="_blank">
                                            @csrf
                                            <input type="hidden" value="" class="hidShipIds" name="shipmentId" />
                                            <input type="hidden" value="" class="hidBoxIds" name="boxId" />
                                            <input type="hidden" value="{{$shipId}}" class="selectedShipIds" name="shipIds" />

                                            <button type="submit" class="btn btn-success waves-effect waves-light loadingExport"><i class="fas fa-print"> Export Loading List</i>
                                            </button>
                                        </form>

                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="shipsTable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr >
                                            <th><input type="checkbox" id="allcb" name="shipBookId[]" class="shipmentIds checkbox-item selectAll" value="{{(!empty($booking->shipment->id))}}" shipId="{{(!empty($booking->ship->id))}}"></th>
                                            <th>Booking No</th>
                                            <th>State</th>
                                            <th>Shipment name</th>
                                            <th>Shipment <br>Type</th>
                                            <th>No of Pcs</th>
                                            <th>Box Numbers</th>
                                            <th>Total Weight</th>
                                            <th>Invoice value</th>
                                            <th>Status</th>
                                            <th>Booking Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData">
                                        <?php
                                        $tot_weight_exist = 0;
                                        $tot_value_exist = 0;
                                        $tot_temp_exist =0;
                                        $totalPieces =0;
                                        $boxList = [];

                                        foreach( $ship_bookingsList as $booking) {

                                            $tot_temp_exist= $booking->weight;
                                            $tot_weight_exist +=$tot_temp_exist;
                                            $tot_value_exist += $booking->packages->pluck('subtotal')->sum();
                                            $totalPieces += 1;
                                            $List = '';
                                            $ListValue = '';
                                            $boxList = [];
                                            $boxListValue = [];

                                            $status = '';
                                            $lastStatus = '';
                                            if(($booking->boxStatuses != null)) {
                                                $status = collect($booking->boxStatuses)->last();
                                                $expectedDate = $status->expected_date;
                                                $comment = $status->comment;
                                                $shipmentStatus = collect($booking->shipment->shipmentStatus)->last();
                                                $lastStatus = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;
                                                if($lastStatus == 'Pending') {
                                                    $style= "background-color:#ec1616e6;";
                                                    $disabled = "disabled='disabled'";
                                                    $newClass ="k-state-disabled";
                                                } else if ($lastStatus == 'Shipment on hold') {
                                                    $style= "background-color:#ffdb00;";
                                                    $disabled = "disabled='disabled'";
                                                    $newClass ="k-state-disabled";
                                                } else {
                                                    $style= "background-color:none;";
                                                    $disabled = "";
                                                    $newClass = "k-checkbox";
                                                }
                                            }

                                            ?>
                                            <tr style="{{ $style }}">
                                                <td style="text-align:center" ><input {{$disabled}} type="checkbox" name="shipBookId[]" class="shipmentIds {{$newClass}} shipmet_check" value="{{$booking->shipment->id}}" shipId="{{$booking->shipment_id}}" boxId="{{$booking->id}}"></td>
                                                <td style="text-align:center" class="detailedBoxView" value="{{$booking->id}}" dateVal="{{date('Y-m-d')}}" expectedDate="{{$expectedDate}}" comment="{{$comment}}">{{ $booking->shipment->booking_number}}</td>
                                                <td style="text-align:center">{{$booking->shipment->receiver->address->state->name}}</td>
                                                <td style="text-align:center">{{$ships->shipment_id}}</td>
                                                <td>{{$booking->shipment->shipMethType?$booking->shipment->shipMethType->name:''}}</td>
                                                <td style="text-align:center">1</td>
                                                <td style="text-align:center" class="boxName" boxId="{{$booking->id}}" ids="{{$ListValue}}">{{ $booking->box_name }}</td>
                                                <td style="text-align:center">{{ number_format($booking->weight,2) }}</td>
                                                {{-- <td style="text-align:center">{{ number_format(floatval($booking->total_value) + floatval($booking->box_packing_charge),2)}}</td> --}}
                                                <td style="text-align:center">{{$booking->packages->pluck('subtotal')->sum()}}</td>


                                                <td style="text-align:center">{{$lastStatus}}</td>
                                                <td style="text-align:center">{{ !empty($booking->created_at) ? date('d-m-Y', strtotime($booking->created_at)) : '' }}</td>
                                                <td>
                                                    <a href="#" title="View"
                                                    class="btn btn-icon waves-effect waves-light btn-success icons">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="/branch/shipment/single_print/{{$booking->id}}" title="Print" target="_blank"
                                                    class="btn btn-icon waves-effect waves-light btn-success icons">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                        <a href="{{route('branch.ships.undoaddbooking',$booking->id)}}" title="Remove"
                                                        class="btn btn-icon waves-effect waves-light btn-dark icons">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                            <tr>
                                                <td  colspan="5"> </td><td style="text-align:center">{{ $totalPieces}}</td>
                                                <td  colspan="1"> </td><td style="text-align:center">{{ number_format($tot_weight_exist,2)}}</td>
                                                <td style="text-align:center" >{{ number_format($tot_value_exist,2) }}</td>
                                                <td colspan="3"  >
                                                    <div class="row"><div class="col-6">Average : {{$tot_weight_exist?number_format($tot_value_exist * $ships->exchange_rate/$tot_weight_exist,3):'0'}}  </div> <div class="col-6">Duty : {{$tot_weight_exist?number_format($tot_value_exist*$ships->exchange_rate/$tot_weight_exist*77.28/100,3):'0'}}</div></div>

                                                </td>
                                            </tr>



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
                        <div class="col-md-12 text-left ">

                            <div class="floatLeft" >
                                <select name="" id="shipmentTypeSelect" class="p-2 pb-0">
                                    <option value="">All</option>
                                    @foreach ($ship_types as $ship_types_data )
                                        <option value="{{$ship_types_data->id}}">{{$ship_types_data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table id="bookingList" class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="font-size:14px;">
                            <tr >
                                    <th><input type="checkbox" id="bookingList_checkbox"></th>
                                    <th>Collection Date <br> Collection Office</th>
                                    <th>ship metho</th>
                                    <th>Collection Staff<br> Collection Agent</th>
                                    <th>Customer<br>Sender/Receiver</th>
                                    <th>State/Emirates<br>Country</th>
                                    <th>Cargo No<br>Type</th>
                                    <th>Cargo Box<br>No</th>
                                    <th>Total<br>Weight</th>
                                    <th>Total<br>Amount</th>
                                    <th>Total<br>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boxes as $key=> $boxes)
                                    <?php

                                        if(!empty($boxes->shipment->statusVal->name)){
                                            if($boxes->shipment->statusVal->name == "Enquiry collected") {
                                                $showAddItems = true;
                                                $style ="style=background-color:yellow;padding:5px;";
                                            } else {
                                                $style ="style=background-color:none";
                                                $showAddItems = false;

                                            }
                                        }
                                        $type = "";
                                        if(!empty($boxes->shipment->delivery_type)){
                                            if($boxes->shipment->delivery_type == "door_to_door") {
                                                $type = "Door To Door";
                                            } elseif($boxes->shipment->delivery_type == "door_to_port"){
                                                $type ="Door To Port";
                                            }
                                            else {
                                                $type ="";
                                            }
                                        }
                                        if($boxes->is_select == 1) {
                                            $total_count += 1;
                                            $tot_sel_amt += $boxes->packages->pluck('subtotal')->sum();
                                            $tot_sel_weight += $boxes->weight;
                                            $boxList[] = $boxes->id;

                                        }
                                    ?>
                                    <tr data-shipment-type-id="{{ $boxes->shipment->shipping_method_id }}">
                                        <td><input type="checkbox" name="bookingSelection[]" class="bookingSelection" id="bookingSelection" selectBoxId="{{$boxes->id}}" value="{{$boxes->id}}" boxWt="{{$boxes->weight??0}}" boxVal="{{$boxes->packages->pluck('subtotal')->sum()??0}}" @if($boxes->is_select == 1) checked @endif ></td>
                                        <td>{{ !empty($boxes->shipment->created_date)? date('d-m-Y', strtotime($boxes->shipment->created_date)):''  }}
                                            <br> {{ $boxes->shipment->agency?$boxes->shipment->agency->name:'-' }}
                                        </td>
                                        <td>{{$boxes->shipment->shipMethType?$boxes->shipment->shipMethType->name:''}}</td>

                                        <td> @if($boxes->shipment->collected_by == 'driver')
                                                    {{ $boxes->shipment->driver?$boxes->shipment->driver->name:'-'}}
                                                @else
                                                    {{$boxes->shipment->staff?$boxes->shipment->staff->full_name:'-'}}
                                                @endif
                                        </td>
                                        <td>{{ $boxes->shipment->receiver->name??""}} <br>{{ $boxes->shipment->receiver->address->country->name??""}}</td>
                                        <td>{{ $boxes->shipment->receiver->address->country->name??""}}</td>
                                        <td>{{ $boxes->shipment->booking_number??""}} <br> {{ $type }}</td>
                                        <td>{{ $boxes->box_name??""}}</td>
                                        <td>{{ $boxes->weight??""}}</td>
                                        {{-- <td>{{ number_format(floatval($boxes->total_value),2)??""}}</td> --}}
                                        <td class="tot_amnt">{{$boxes->packages->pluck('subtotal')->sum()}}</td>

                                        {{-- <td class="boxVal">{{ number_format((floatval($boxes->total_value) + floatval($boxes->box_packing_charge)),2) ?? ""}}</td> --}}
                                        <td class="boxVal">{{$boxes->shipment->amount_normal_weight??0 }}</td>

                                    </tr>
                                @endforeach
                                <?php

                                $List = implode(', ', $boxList);
                                ?>
                            </tbody>
                        </table>
                        <div class="row m-t-50">
                            <div class="col-md-12">
                                <div class="">
                                    <form action="{{route('branch.ships.addMultipleBookingtoshipSubmit')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Total Selected Boxes</label>
                                                        <input type="text" class="form-control" id="total_selected_boxes" value="{{$total_count}}" name="total_selected_boxes">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Total Weight</label>
                                                        <input type="text" class="form-control" name="total_weight" id="total_weight" value="{{$tot_sel_weight}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Total Amount</label>
                                                        <input type="text" class="form-control" name="total_value" id="total_value" value="{{$tot_sel_amt}}" />
                                                    </div>
                                                </div>
                                            

                                                
                                                <form action="{{route('branch.ships.addMultipleBookingtoshipSubmit')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- form contents -->
                                                
                                                    <div class="col-md-2" style="margin:30px;">
                                                        <div class="form-group">
                                                            <input type="hidden" class="form-control" name="box_id" value="{{($List) ? $List : ''}}" id="selected_box_id"/>
                                                            <input type="hidden" id="hidSelectList" name="hidSelectList" value="0"/>
                                                            <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}"/>
                                                            <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </form>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->
<div id="statusModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
                <div class="col-md-12">
                <input type="hidden" value="" class="selectedShipIds" name="shipIds" />
                <input type="hidden" value="" class="selectedShipmentId" name="shipmentIds" />
                <input type="hidden" value="" class="selectedBoxId" name="boxIds" />

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Change Shipment Status</label>
                                <select name="status_id" class="form-control" id="status_id">
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
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Comment</label>
                            <textarea name="comment" id="status_comment" cols="30" rows="0" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Date</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" max=""
                                        class="form-control" id="created_date" name="created_date"
                                        placeholder="Enter title">
                            </div>
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Expected Date</label>
                                    <input type="date" value="" max=""
                                        class="form-control" id="expected_date" name="expected_date"
                                        placeholder="Enter title">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                                <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}" />
                                <button type="submit" class="btn btn-success waves-effect waves-light updateStatus">Update
                                </button>
                                </div>

                        </div>
                    </div>
                </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="statusModalSucess" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="successMsg">Status Updated Successfully</div>
                            </div>
                        </div>
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

<div id="currentStatusModal" class="modal fade bd-example-modal-lg" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form action="{{route('branch.ships.boxStatusUpdatetoship')}}" method="post">
                @csrf
                <div class="col-md-12">
                    <div class="row">
                        <table id="shipsTable1" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Box Name</th>
                                <th>Current Status</th>
                                <th>Dated on</th>
                                <th>Update Status</th>
                                <th>Update Status Date</th>
                                <th>Expected Date</th>
                                <th>Comment</th>
                            </tr>
                            </thead>
                            <tbody class="fetchData" status="{{status_list_admin() }}">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                        <input type="hidden" id="ship_id" name="ship_id" value="{{$ships->id}}" />
                        <button type="submit" class="btn btn-success waves-effect waves-light">Update
                        </button>
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
        .floatRight {float:right;}
        .m-l-10 {margin-left:10px!important;}
        .detailedBoxView {color:#661ec2;}
        .modal-lg {max-width:1000px !important;}
        .successMsg {font-size:18px; color:green;}
        .fontRed {color:red;}
        .icons {padding: 5px; font-size: x-small;}
        #shipsTable {font-size:14px !important;}
        .detailHead {
            border: 1px solid #d6d6d6;
            margin: 25px 80px;
            background-color: #d6d6d6;
        }
        #bookingList {font-size:14px !important;}
        #bookingList thead{font-size:14px !important;}
        #bookingList_length {display:none;}
        .m-t-50 {margin-top:50px;}
    </style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @include('layouts.datatables_js')

    <script>
        $(document).ready(function() {

            $('.shipmet_check').change(function(){
                if($(this).is(':checked')){
                    $('#printallButton').prop('disabled', false);
                } else {
                    $('#printallButton').prop('disabled', true);
                }
            });

            $('#allcb').change(function(){
                if($(this).is(':checked')){
                    console.log('hhhhhhhhhhhhhhhhhhhhhhhhhh');
                    $('#printallButton').prop('disabled', false);
                } else {
                    $('#printallButton').prop('disabled', true);
                }
            });


            $('#bookingList_checkbox').click(function() {
                $('.bookingSelection').prop('checked', $(this).prop('checked')).change();
                window.location.reload();

            });




            $(document).ready(function() {
                // Check if any .bookingSelection checkboxes are checked on page load
                if ($('.bookingSelection:checked').length > 0) {
                    $('#bookingList_checkbox').prop('checked', true);
                } else {
                    $('#bookingList_checkbox').prop('checked', false);
                }

                // Handle changes in .bookingSelection checkboxes
                $('.bookingSelection').change(function() {
                    if ($('.bookingSelection:checked').length > 0) {
                        $('#bookingList_checkbox').prop('checked', true);
                    } else {
                        $('#bookingList_checkbox').prop('checked', false);
                    }
                });


                $('#bookingList_checkbox').change(function() {
                    if (!$(this).prop('checked')) {
                        window.location.reload();
                    }
                });


            });


            $('#shipmentTypeSelect').change(function() {
                var selectedType = $(this).val();
                $('#bookingList tbody tr').hide().find('input.bookingSelection').removeClass('bookingSelection'); // Hide all rows and remove class from all td elements
                if (selectedType === "") { // Show all if "All" is selected
                    $('#bookingList tbody tr').show().find('input#bookingSelection').addClass('bookingSelection');
                } else if (selectedType) {
                    $('#bookingList tbody tr[data-shipment-type-id="' + selectedType + '"]').show().find('input#bookingSelection').addClass('bookingSelection');
                }
            });

        });

    $(document).ready(function () {
        $('#bookingList').DataTable( {
            "autoWidth": false,
            "scrollX": true,
            "aaSorting": [ [0,'desc'] ],
            "bSort": false,
            "responsive": false
        });

    });

        $(function () {
            // validation needs name of the element
            // initialize after multiselect

            $(document).ready(function () {
                $('.select2').select2();
                if (window.location.href.indexOf('reload')==-1) {
                    window.location.replace(window.location.href+'?reload');
                }

            });



            var $checkboxes = $('.checkbox-item');
            $('#allcb').click(function (e) {
                    var checkboxesLength = $checkboxes.length;
                    var checkedCheckboxesLength = $checkboxes.filter(':checked').length;
                    if(checkboxesLength == checkedCheckboxesLength) {
                        $('#allcb').prop('checked', true);
                    }else{
                        $('#allcb').prop('checked', false);
                    }

                    // $('#allcb').click(function (e) {
                    if( $("#allcb").prop('checked') == true) {
                        $.each($('td:not(.k-state-disabled) .k-checkbox'), function () {
                            $(this).prop("checked", true)
                        });
                    }
                    else {
                        $('.k-checkbox').prop('checked', false);
                    }
                    // $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
                // });
            });

            $(document).on('click', ".detailedBoxView", function() {
                var boxId = $(this).attr('value');
                var dateVal = $(this).attr('dateVal');
                var boxName = $(this).closest('tr').find('.boxName').text();
                var expectedDate = $(this).attr('expecteddate');
                var comment = $(this).attr('comment');
                $("#currentStatusModal").modal('show');
                var d = new Date();
                $.ajax({
                        headers: {
                            "content-type" : "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        url: `{{ route('branch.ship.list.getBoxDetails') }}`,
                        type: "POST",
                        async:false,
                        data: JSON.stringify({"boxId":boxId, "boxName":boxName }),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            var html = [];
                            $('.fetchData').html('');
                            // $.each(result, function (key, value) {
                                var selectOptionhtml = '';
                                var dt = new Date();
                                var newDate = '<input type="date" name="statusDate[]" class="form-control" value="'+dateVal+'">';
                                var expectedDateInput = '<input type="date" name="expected_date[]" class="form-control" value="'+expectedDate+'" >';
                                var commentInput  = '<input type="text" name="comment[]" class="form-control" value="'+comment+'" >';
                                var statusCount = result.box_statuses.length;
                                var lastNum = statusCount - 1;
                                var selectOption = JSON.parse($(".fetchData").attr("status"));
                                selectOptionhtml += "<select class='form-control class-form' name='status[]'><option value='0'>Select</option>";
                                for (var i = 0; i < selectOption.length; i++) {
                                    // Check if the id matches
                                    var selected = selectOption[i].id === result.box_statuses[lastNum].status.id ? ' selected' : '';

                                    // Append the option with the selected attribute if applicable
                                    selectOptionhtml += "<option value='" + selectOption[i].id + "'" + selected + ">" + selectOption[i].name + "</option>";
                                }
                                selectOptionhtml += "</select>";
                                html += '<tr>'+
                                        '<td>'+result.box_name+'<input type="hidden" name="boxIds[]" value="'+result.id+'"></td>';
                                        if(statusCount > 0) {
                                            html +=   '<td>'+result.box_statuses[lastNum].status.name+'</td>';
                                            html +=   '<td>'+result.dated+'</td>';

                                            html +=   '<td>'+selectOptionhtml+'</td>';
                                            html +=   '<td>'+newDate+'</td>';
                                            html +=  '<td>'+expectedDateInput+'</td>';
                                            html +=  '<td>'+commentInput +'</td>';
                                        } else {
                                            html +=  '<td>--</td>';
                                            html +=  '<td>--</td>';

                                            html +=  '<td>'+selectOptionhtml+'</td>';
                                            html +=  '<td>'+newDate+'</td>';
                                            html +=  '<td>'+expectedDateInput+'</td>';
                                            html +=  '<td>'+commentInput +'</td>';
                                        }

                                        html += '</tr>';
                            // });
                            $('.fetchData').html(html);
                            $('.select2').select2();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                }); // ajax call closing
            });

            $(document).on('click',"#changeStatus", function() {
                var checked = $(".shipmentIds").is(":checked");
                if(checked == true) {
                    var boxesName = $(this).attr('boxesName');
                    var boxesVal = $(this).attr('boxesVal');
                    var shipmentId = $(".shipmentIds").attr('value');
                    $("#statusModal").modal('show');
                }
            });

            $(document).on('click', '.updateStatus', function(){
                var url = "{{route('branch.ships.multiUpdatebookingtoship')}}";
                var selectedShipIds = $(".selectedShipIds").val();
                var selectedShipmentId = $(".selectedShipmentId").val();
                var selectedBoxId = $(".selectedBoxId").val();
                var status_id = $("#status_id").val();
                var status_comment = $("#status_comment").val();
                var created_date = $("#created_date").val();
                var expected_date = $("#expected_date").val();
                $.ajax({
                        headers: {
                            "content-type" : "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        url: url,
                        type: "POST",
                        async:false,
                        data: JSON.stringify({"shipIds":selectedShipIds,"selectedBoxId":selectedBoxId, "shipmentIds":selectedShipmentId, "status_id":status_id, "created_date":created_date, 'comment':status_comment, "expected_date":expected_date, }),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if(result.success == 'Status Updated Successfully') {
                                $("#statusModalSucess").modal('show');
                            }
                            location.reload();
                        },
                        error: function (err) {
                            console.log(err);
                        }
                }); // ajax call closing
            });


            $(document).on('click', ".shipmentIds", function() {
                var val = [];
                var valshipId = [];
                var boxesVal = [];
                var boxesName = [];
                $(':checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                    valshipId[i] = $(this).attr('shipId');
                    boxesName[i] = $(this).closest('tr').find('.boxName').text();
                    boxesVal[i] = $(this).closest('tr').find('.boxName').attr('boxId');
                });
                $(".hidShipIds").val(val);
                $(".hidBoxIds").val(boxesVal);
                $(".selectedBoxId").val(boxesVal);
                $(".selectedShipmentId").val(val);
                $("#changeStatus").attr('shipId',valshipId);
                $("#changeStatus").attr('shipmentId',val);
                $("#changeStatus").attr('boxesVal',boxesVal);
                $("#changeStatus").attr('boxesName',boxesName);
            });
            var arr = [];
            var alreadyExist = [];
            var removeItem = [];

            $("input:checkbox.bookingSelection").change(function() {

            });


            $(document).on('change',".bookingSelection", function() {

                var ischecked= $(this).is(':checked');
                if(ischecked){
                // alert('checkd ' + $(this).val());
                arr.push($(this).val());
                $("#selected_box_id").val(arr);
                }
                else {
                // alert('uncheckd ' + $(this).val());
                removeItem.push($(this).val());
                $("#hidSelectList").val(removeItem);
                }
                var checked = $(this).is(":checked");
                var total_selected_boxes = $("#total_selected_boxes").val();
                var total_weight = $("#total_weight").val();
                var total_value = $("#total_value").val();
                var boxesVal = $(this).attr('boxVal');
                var boxWt = $(this).attr('boxWt');
                var selectedBoxId = $(this).attr('selectBoxId');
                // $.each($(":checkbox:checked"), function(){
                //     arr.push($(this).val());
                // });
                $("#selected_box_id").val(arr);

                if(checked == true) {
                    var newBoxes = parseFloat(total_selected_boxes) + parseFloat(1);
                    var newWeight = parseFloat(total_weight) + parseFloat(boxWt);
                    var newValue = parseFloat(total_value) + parseFloat(boxesVal);

                } else {
                    var newBoxes = parseFloat(total_selected_boxes) - parseFloat(1);
                    var newWeight = parseFloat(total_weight) - parseFloat(boxWt);
                    var newValue = parseFloat(total_value) - parseFloat(boxesVal);
                }
                $("#total_selected_boxes").val(newBoxes);
                $("#total_weight").val(newWeight);
                $("#total_value").val(newValue);
                var selectedBoxes = $("#selected_box_id").val();
                var hidSelectList = $("#hidSelectList").val();
                var url = "{{route('branch.ships.multiSelectionUpdate')}}";
                $.ajax({
                        headers: {
                            "content-type" : "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        url: url,
                        type: "POST",
                        async:false,
                        data: JSON.stringify({"selectedBoxes":selectedBoxes, "hidSelectList":hidSelectList, "shipId":"1" }),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            console.log(result);
                            var html = [];
                            html = result.boxes
                            $("#selected_box_id").val(html);
                        },
                        error: function (err) {
                            console.log(err);
                        }
                });
                alreadyExist = [];
                arr = [];
            });

        });

</script>

@endsection

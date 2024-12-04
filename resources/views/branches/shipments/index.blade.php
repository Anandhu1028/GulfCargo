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
                            <h4 class="page-title">Invoices</h4>
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

                            <div class="d-flex justify-content-end" >
                                <form action="/branch/shipment" class="d-flex" id="shipmentForm">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="text" name="from_date" class="form-control datepicker"  placeholder="From date" value="{{ request('from_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <input type="text" name="to_date" class="form-control datepicker"    placeholder="To date" value="{{ request('to_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input name="search" value="{{$search??''}}" class="form-control " type="search" placeholder="Search" aria-label="Search">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button class="btn btn-info t-5" type="submit">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-success" id="exportButton">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                  </form>
                            </div>
                            <table id="bookingdatatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>

                                <tr>
                                    @canany([permission_edit(),permission_view(),'shipment-show'])
                                        <th style="text-align: center">Action</th>
                                    @endcanany
                                    <th>Book<br>No</th>
                                    <th>No<br>Pcs</th>
                                    <th>Tot<br>Wgt</th>
                                    <th>Shipment <br>Type</th>
                                    <th>Sender<br>Name</th>
                                    <th>Sender<br>Phone</th>
                                    <th>Receiver<br>Name</th>
                                    <th>Receiver<br>Country</th>
                                    <th>Receiver<br>State</th>
                                    <th>Shipping<br>Status</th>
                                    <th>Payment<br>Method</th>
                                    <th>Courier<br>Company</th>
                                    <th>Driver/<br>Staff</th>
                                    <th>Date</th>

                                </tr>

                                </thead>

                                <tbody>
                                    <?php
                                        $lastStatus = '';
                                        $statusList = [];
                                    ?>
                                @foreach($shipments as $key=> $shipment)

                                <?php
                                    // if(!empty($shipment->statusVal->name)){
                                        // if($shipment->statusVal->name == "Enquiry collected") {
                                        //     $showAddItems = true;
                                        //     $style ="style=background-color:yellow;padding:5px;";
                                        // } else {
                                        //     $style ="style=background-color:none";
                                        //     $showAddItems = false;
                                        // }
                                    // }
                                    $status = '';
                                    $lastStatus = '';
                                    $statusList = '';

                                    $status = $shipment->statusVal->name;
                                    foreach($shipment->boxes as $box) {
                                        if(($box->boxStatuses != null)) {
                                            $statusList = $shipment->last_status;
                                        }
                                    }


                                    $lastStatus = (!empty($statusList) ) ? $statusList : $status ;
                                    if($lastStatus == 'Enquiry collected') {
                                            $showAddItems = true;
                                            $style ="style=background-color:yellow;padding:5px;";
                                    } else {
                                        $style ="style=background-color:none";
                                        $showAddItems = false;
                                    }
                                    $statusss = null;
                                    if ($shipment->boxes->isEmpty()) {
                                        $statusss = $shipment->status_id;
                                    } else {
                                        if($statusss == 15 || $statusss == 1 || $statusss == null) {

                                            foreach ($shipment->boxes as $box) {
                                                $latestStatus = $box->boxStatuses()->orderBy('id', 'desc')->first();
                                                if ($latestStatus && ($latestStatus->id != 15 && $latestStatus->id != 1)) {
                                                    $statusss = $latestStatus->status_id;
                                                    break;
                                                }
                                            }
                                        }
                                        else{
                                            $statusss = $shipment->status_id;
                                        }

                                    }
                                ?>
                                    <tr>
                                        <td>
                                            @can(permission_edit())
                                            @if(branch()->id == $shipment->branch_id)
                                                <a href="{{edit_url($shipment->id)}}"
                                                    class="btn btn-xs btn-icon waves-effect waves-light btn-warning editBtn" ststus="{{$statusss}}" statusName="{{  $lastStatus??'' }}">
                                                    <i class="fas  fa-lg fa-pencil-alt"></i>
                                                </a>
                                            @endif
                                            @endcan
                                            @can(permission_view())
                                                <a href="{{show_url($shipment->id)}}"
                                                    class="btn btn-xs btn-icon waves-effect waves-light btn-success ">
                                                    <i class="fas  fa-lg fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('shipment-print')
                                                <a href="{{route('branch.shipment.print',$shipment->id)}}" target="_blank"
                                                    class="btn btn-xs btn-icon waves-effect waves-light btn-dark">
                                                    <i class="fas  fa-lg fa-print"   title="Customs copy"></i>
                                                </a>

                                                <!--<a href="{{route('branch.shipment.print_customer',$shipment->id)}}" target="_blank"-->
                                                <!--    class="btn btn-xs btn-icon waves-effect waves-light btn-dark" style="background:#1274bb; border: 0px;"  >-->
                                                <!--    <i class="fas  fa-lg fa-print"   title="Customer copy"></i>-->
                                                <!--</a>-->

                                            @endcan
                                            @if($showAddItems)
                                                @if(branch()->id == $shipment->branch_id)
                                                    <a href="{{edit_url($shipment->id)}}"
                                                        class="btn btn-xs btn-icon waves-effect waves-light btn-warning" >
                                                        <i class="fas  fa-lg fa-plus"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $shipment->booking_number }}</td>
                                        <td>{{ $shipment->number_of_pcs?$shipment->number_of_pcs: $shipment->number_of_pcs_create }}</td>
                                        <td>{{ $shipment->grand_total_weight }}</td>
                                        <td>{{ $shipment->shipMethType->name??"" }}</td>
                                        <td>{{ $shipment->sender->name }}</td>
                                        <td>{{ $shipment->sender->phone??'-' }}</td>
                                        <td>{{ $shipment->receiver->name??""}}</td>
                                        <td>{{ $shipment->receiver->address->country->name??""}}</td>
                                        <td>{{ $shipment->receiver->address->state->name??""}}</td>
                                        <td><span {{  (!empty($lastStatus))?$style:''}}>{{  $lastStatus??'' }}</span></td>
                                        <td>{{ $shipment->payment_method }}</td>
                                        <td>{{ $shipment->agency?$shipment->agency->name:'-' }}</td>
                                        <td>    @if($shipment->collected_by == 'driver')
                                                    {{ $shipment->driver?$shipment->driver->name:'-'}}
                                                @else
                                                    {{$shipment->staff?$shipment->staff->full_name:'-'}}
                                                @endif
                                        </td>
                                        <td>{{ !empty($shipment->created_date)? date('d-m-Y', strtotime($shipment->created_date)):''  }}</td>

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
                            <div class="d-flex justify-content-end">
                                {{ $shipments->onEachSide(1)->links() }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Enter access key</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <input type="password" class="form-control" id="passkey">
                  </div>
                </div>
                <div class="modal-footer justify-content-center">
                  {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                  <button type="button" class="btn btn-primary" id="passkeyBtn">Submit</button>
                </div>
              </div>
            </div>
        </div>

@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    @if(session('showModal'))
        <script>
            $(document).ready(function() {
                $('#exampleModalCenter').modal('show');
            });
        </script>
    @endif
    <script>

$(document).ready(function () {
    $('#bookingdatatable').DataTable({
        "autoWidth": false,
        "aaSorting": [ [0,'desc'] ],
        "scrollX": true,
        "paging": false,
        "responsive": false,
        "searching": false
    });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });


    $('#exportButton').click(function(event) {
        event.preventDefault();

        var formData = $('#shipmentForm').serialize();

        var exportUrl = '/branch/shipment/export?' + formData;

        window.location.href = exportUrl;
    });

    $('.editBtn').click(function(event) {
        event.preventDefault();
        var status = $(this).attr('ststus') || null;
        var statusName = $(this).attr('statusName');
        console.log(statusName);
        var url = $(this).attr('href');
        if(statusName == "Shipment received" || statusName == "Enquiry collected"){
            if(status == 15 || status == 1 || status == 2 || status == null ){
            window.location.href = url;
            }
            else{
                $('#passkey').attr('data-url', url);
                $('#exampleModalCenter').modal('show');
            }
        }
        else{
            $('#passkey').attr('data-url', url);
            $('#exampleModalCenter').modal('show');
        }
    });

    $('#passkeyBtn').click(function(event) {
        var passkey = $('#passkey').val();
        var url = $('#passkey').data('url');
        var encryptedPasskey = CryptoJS.SHA256(passkey).toString();

        var exportUrl = url + '?password=' + encodeURIComponent(encryptedPasskey);

        window.location.href = exportUrl;
    });



});

    </script>
@endsection

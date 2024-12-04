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

                            <div class="d-flex " >
                                <form action="/super-admin/shipment" class="d-flex" id="shipmentForm">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <select name="branch" id="branch" class="form-control">
                                                    <option value="">Select branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                                                <a href="#" class="btn btn-success" id="exportButton">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table id="bookingdatatableAdmin"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>

                                <tr>
                                    <th>Booking No</th>
                                    <th>Branch</th>
                                    <th>Sender Name</th>
                                    <th>Sender Phone</th>
                                    <th>Receiver Name</th>
                                    <th>Shipping Status</th>
                                    <th>Payment Method</th>
                                    <th>Courier Company</th>
                                    <th>Driver</th>
                                    <th>Date</th>
                                    <th style="text-align: center">Action</th>

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
                                        <td>{{ $shipment->branch->name??"" }}</td>
                                        <td>{{ $shipment->sender->name??"" }}</td>
                                        <td>{{ $shipment->sender->phone??'-' }}</td>
                                        <td>{{ $shipment->receiver->name??""}}</td>
                                        <td class="detailedBoxView" value="{{$shipment->id}}" dateVal="{{date('Y-m-d')}}" booking_no="{{ $shipment->booking_number }}"><span {{ $style}}>{{ $shipment->statusVal->name }}</span></td>
                                        <td>{{ $shipment->payment_method }}</td>
                                        <td>{{ $shipment->courier_company }}</td>
                                        <td>{{ $shipment->driver?$shipment->driver->name:'-'}}</td>
                                        <td>{{ !empty($shipment->created_date)? date('d-m-Y', strtotime($shipment->created_date)):''  }}</td>
                                        <td>

                                            <a href="{{show_url($shipment->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-success">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/super-admin/shipment/delete/{{$shipment->id   }}"
                                                class="btn btn-icon waves-effect waves-light btn-danger" onclick="alert('Do you want to delete the invoice!');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            <a href="{{route('super-admin.shipment.print',$shipment->id)}}" target="_blank"
                                                class="btn  btn-icon waves-effect waves-light btn-dark">
                                                <i class="fas  fa-lg fa-print"   title="Customs copy"></i>
                                            </a>

                                            <a href="{{route('super-admin.shipment.print_customer',$shipment->id)}}" target="_blank"
                                                class="btn  btn-icon waves-effect waves-light btn-dark"  >
                                                <i class="fas  fa-lg fa-print"   title="Customer copy"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $shipments->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->
        <div id="currentStatusModal" class="modal fade bd-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                  </div>
                  <div class="modal-body">
                      <form action="{{route('branch.ships.boxStatusUpdatetoship')}}" method="post" id="change_ststus">
                          @csrf
                          <div class="col-md-12">
                              <div class="row">
                                  <table id="shipsTable1" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                      <thead>
                                      <tr>
                                          <th>Invoice</th>
                                          <th>Update Status</th>
                                      </tr>
                                      </thead>
                                      <tbody class="fetchData">
                                        <tr>
                                            <td id="modal_inv"></td>
                                            <td>
                                                <select class="form-control" >
                                                    @foreach (status_list_admin() as $status)
                                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                  </table>
                              </div>
                          </div>

                          <div class="form-group">
                                  <input type="hidden" id="inv_id" name="inv_id" value="" />
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>

$(document).ready(function () {
    $('#bookingdatatableAdmin').DataTable({
        "aaSorting": [ [0,'desc'] ],
        "paging": false,
        "searching": false,
        "language": {
            "info": ""
        }
    });

    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $('#exportButton').click(function(event) {
        event.preventDefault();

        var formData = $('#shipmentForm').serialize();

        var exportUrl = '/super-admin/shipment/export?' + formData;

        window.location.href = exportUrl;
    });

    $(document).on('click', ".detailedBoxView", function() {
                var boxId = $(this).attr('value');
                var dateVal = $(this).attr('dateVal');
                var booking_no = $(this).attr('booking_no')
                $("#currentStatusModal").modal('show');
                $("#modal_inv").text(booking_no);
    });

    $('#change_ststus').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '', // Replace with your route name or URL
                data: formData,
                success: function(response) {
                    $('#responseMessage').html(response);
                    $('#change_ststus')[0].reset(); // Optionally clear the form
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

});

    </script>
@endsection

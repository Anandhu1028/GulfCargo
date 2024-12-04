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

                        </div>
                    </div>

                </div>


                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th width="20%">Booking No : </th><td width="25%">{{ $shipment->booking_number }}</td>
                                            <th>Sender Name : </th><td width="25%">{{ $shipment->sender->name ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sender Address : </th><td width="25%">
                                                {{ $shipment->sender->address->address ?? "" }}</td>
                                            <th>Sender Phone : </th><td width="25%">{{ $shipment->sender->phone ?? "" }}</td>
                                        </tr>

                                        <tr>
                                            <th>Receiver Name : </th><td width="25%">{{ $shipment->receiver->name ?? "" }}</td>
                                            <th>Receiver Address : </th><td width="25%">{{ $shipment->receiver->address->address ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <th>Receiver Phone : </th><td width="25%">{{ $shipment->receiver->phone ?? "" }}</td>
                                            <th>  </th><td width="25%"></td>

                                        </tr>
                                        <tr>

                                            <th>Shipment No. : </th><td width="25%">{{  $shipment->company->shipment_reference_id ?? "" }}</td>
                                            <th> Status : </th><td width="25%">{{ $shipment->statusVal->name ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Method : </th><td width="25%">{{ $shipment->payment_method }}</td>
                                            <th>Other Charge : </th><td width="25%">{{ $shipment->other_charges }}</td>
                                        </tr>
                                        <tr>
                                            <th>Driver Name : </th><td width="25%">{{ isset($shipment->driver->name) ? $shipment->driver->name :'' }}</td>
                                            <th>Courier Company : </th><td width="25%">{{ $shipment->courier_company }}</td>
                                        </tr>

                                        <tr>
                                            <th>Shiping Date : </th><td width="25%">{{ date('d-m-Y', strtotime($shipment->shiping_date)) }}</td>
                                            <th>Receipt Number : </th><td width="25%">{{ $shipment->receipt_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Packing  Type : </th><td width="25%">{{ $shipment->packing_type }}</td>
                                            <th>Shipping Method : </th><td width="25%">{{ $shipment->shiping_method }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Status : </th><td width="25%">{{ $shipment->payment_status }}</td>
                                            <th>No. of Pcs : </th><td width="25%">{{ $shipment->number_of_pcs }}</td>
                                        </tr>
                                        <tr>
                                            <th>Weight : </th><td width="25%">{{ $shipment->weight }}</td>
                                            <th>Rate : </th><td width="25%">{{ $shipment->rate }}</td>
                                        </tr>

                                        <tr>
                                            <th>Paacking Charge : </th><td width="25%">{{ $shipment->packing_charge }}</td>
                                            <th>Discount : </th><td width="25%">{{ $shipment->discount }}</td>
                                        </tr>

                                        <tr>

                                            <th>Total Amount : </th><td width="25%">{{ $shipment->total_amount }}</td>
                                            <th>Length : </th><td width="25%">{{ $shipment->length }}</td>
                                        </tr>

                                        <tr>
                                            <th>Width : </th><td width="25%">{{ $shipment->width }}</td>
                                            <th>Height  : </th><td width="25%">{{ $shipment->height }}</td>
                                        </tr>
                                        </thead>

                                    </table>


                                </div>
                            </div>
                            <div class="body">
                                <div class="header">
                                    <h4>Packages</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th>#Sl No</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($shipment->packages as $key =>  $package)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $package->description }}</td>
                                                <td>{{ $package->quantity }}</td>
                                                <td>{{ $package->unit_price }}</td>
                                                <td>{{ $package->quantity*$package->unit_price }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

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

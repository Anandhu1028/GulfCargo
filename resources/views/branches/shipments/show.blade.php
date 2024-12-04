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
                <div class="row clearfix" style="border-left:1px solid;border-right:1px solid; border-top:1px solid;">
                    <div class="col-md-6" style="padding-left:0px; border-right:1px solid;">
                        <div class="head">Customer</div>
                        <div class="desc">
                            <table style="width:100%">
                                <tr>
                                    <th>Customer Name</th>
                                    <th style="text-transform: uppercase;">: {{ $shipment->sender->name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th style="width:30%">Mobile</th>
                                    <th >: {{ $shipment->sender->phone ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>: {{ $shipment->sender->email ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Customer Address</th>
                                    <th style="text-transform: uppercase;">: {{ $shipment->sender->address->address ?? ""}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6" style="padding-right:0px;">
                    <div class="head">Sender</div>
                    <div class="desc">
                            <table style="width:100%">
                                <tr>
                                    <th style="width:30%">Name :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->sender->name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <th>{{ $shipment->sender->email ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Emirates/ State :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->sender->address->state->name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th >Country :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->sender->address->country->name ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Phone :</th>
                                    <th>{{ $shipment->sender->phone ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Ohter Phone :</th>
                                    <th>{{ $shipment->sender->whatsapp_number ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Address :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->sender->address->address ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Document No :</th>
                                    <th>{{ $shipment->sender->identification_number ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Document Type :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->sender->identification_type ?? ""}}</th>
                                </tr>
                            </table>
                        </div>


                    </div>
                </div>


                <div class="row clearfix" style="border-left:1px solid;border-right:1px solid;">
                    <div class="col-md-6" style="padding-left:0px;  border-right:1px solid;">
                        <div class="head">Receiver</div>
                        <div class="desc">
                            <table style="width:100%">
                            <tr>
                                    <th style="width:30%; text-transform;">Name :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <th>{{ $shipment->receiver->email ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>City :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->city_name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>District  :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->address->district->name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Emirates/ State :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->address->state->name ?? "" }}</th>
                                </tr>
                                <tr>
                                    <th>Country :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->address->country->name ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Phone :</th>
                                    <th>{{ $shipment->receiver->phone ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Ohter Phone :</th>
                                    <th>{{ $shipment->receiver->whatsapp_number ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Address :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->address->address ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Pin :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->address->zip_code ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Document No :</th>
                                    <th>{{ $shipment->receiver->identification_number ?? ""}}</th>
                                </tr>
                                <tr>
                                    <th>Document Type :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->receiver->identification_type ?? ""}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6" style="padding-right:0px;">
                    <div class="head">Collection Details</div>
                    <div class="desc">
                            <table style="width:100%">
                                <tr>
                                    <th style="width:30%">Booking No :</th><th>{{ $shipment->booking_number }}</th>
                                </tr>
                                <tr>
                                    <th>Shipment No. : </th>
                                    <th >{{ $ship != null?$ship->shipment_id:'' }}</th>
                                </tr>
                                <tr>
                                    <th>Shipment status : </th>
                                    <th>
                                        @if (isset($status->status->name))
                                            {{$status->status->name}}
                                        @else
                                            {{$invStatus->name}}
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>Expected Date : </th>
                                    <th>
                                        @if (isset($status->expected_date))
                                            {{$status->expected_date}}
                                        @else
                                            {{$invStatus->expected_date??''}}
                                        @endif
                                    </th>
                                </tr>
                                {{-- <tr>
                                    <th> Status : </th>
                                    <th style="text-transform: uppercase;">{{ $shipment->statusVal->name ?? "" }}</th>
                                </tr> --}}
                                <tr>
                                    <th>Driver Name : </th>
                                    <th style="text-transform: uppercase;">{{ isset($shipment->driver->name) ? $shipment->driver->name :'' }}</th>
                                </tr>
                                <tr>
                                    <th>Courier Company : </th>
                                    <th style="text-transform: uppercase;">{{ $shipment->agency_id? $shipment->agency->name:'' }}</th>
                                </tr>
                                <tr>
                                    <th>Shiping Date : </th>
                                    <th>{{ date('d-m-Y', strtotime($shipment->shiping_date)) }}</th>
                                </tr>
                                <tr>
                                    <th>Receipt Number : </th>
                                    <th>{{ $shipment->receiver->whatsapp_number.', '.$shipment->receiver->phone }}</th>
                                </tr>
                                {{-- <tr>
                                    <th>Packing  Type : </th>
                                    <th style="text-transform: uppercase;">{{ $shipment->packing_type }}</th>
                                </tr> --}}
                                <tr>
                                    <th>Shipping Method : </th>
                                    <th>{{ $shipment->shipMethType ? $shipment->shipMethType->name : '' }}</th>
                                </tr>
                                <tr>
                                    <th>No. of Pcs : </th>
                                    <th>{{ $shipment->number_of_pcs ? $shipment->number_of_pcs : ($shipment->number_of_pcs_create ? $shipment->number_of_pcs_create : 0) }}</th>
                                </tr>
                                <tr>
                                    <th>Weight : </th>
                                    <th>{{ $shipment->grand_total_weight }}</th>
                                </tr>
                                {{-- <tr>
                                    <th>Width : </th>
                                    <th>{{ $shipment->width }}</th>1
                                </tr>
                                <tr>
                                    <th>Height  : </th>
                                    <th>{{ $shipment->height }}</th>
                                </tr>
                                <tr>
                                    <th>Length : </th>
                                    <td>{{ $shipment->length }}</td>
                                </tr>
                                <tr>
                                    <th>Moving Type : </th>
                                    <td style="text-transform: uppercase;">{{ $shipment->movingType->name??'' }}</td>
                                </tr> --}}
                            </table>
                        </div>

                    </div>
                </div>


                <div class="row clearfix" style="border-left:1px solid;border-right:1px solid;">
                    <div class="col-md-6" style="padding-left:0px; border-right:1px solid;">
                        <div class="head">Sender & Receiver
                        </div>
                        <div class="desc">
                            <table style="width:100%">

                                @foreach ($shipment->boxes as $box )
                                <tr>
                                    <th style="width:30%;border-bottom:solid 1px;"> {{$box->box_name}} :</th>
                                    <th style="text-transform: uppercase; border-bottom:solid 1px;">
                                        <div class="row">
                                            <div class="col-6">
                                                <b >Sender</b>
                                                <p style="font-size:13px;">{{$box->sender_name}}<br>
                                                {{$box->sender_address}}<br>
                                                {{$box->sender_mob}}<br>
                                                {{$box->sender_id_type.' :-'}}<br>{{$box->sender_id_no}}</p>

                                            </div>
                                            <div class="col-6">
                                                <b>Receiver</b>
                                                <p style="font-size:13px;">{{$box->receiver_name}}<br>
                                                {{$box->receiver_address}}<br>
                                                {{$box->receiver_mob}}<br>
                                                {{$box->receiver_id_type.' :-'}}<br>{{$box->receiver_id_no}}</p>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6"  style="padding-right:0px;">
                        <div class="head">Charges & Payments</div>
                        <div class="desc">
                            <table style="width:100%">
                                <tr>
                                    <th style="width:30%">Payment Method : </th>
                                    <th style="text-transform: uppercase;">{{ $shipment->payment_method }}</th>
                                </tr>
                                <tr>
                                    <th>Total Weight</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_normal_weight }}</th>
                                </tr>
                                <tr>
                                    <th>Duty</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_electronics_weight }}</th>
                                </tr>
                                <tr>
                                    <th>Packing charge :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_msic_weight }}</th>
                                </tr>
                                <tr>
                                    <th>Additional Packing charge :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_add_pack_charge }}</th>
                                </tr>
                                <tr>
                                    <th>Insurance :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_insurance }}</th>
                                </tr>
                                <tr>
                                    <th>AWB Fee :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_awbfee }}</th>
                                </tr>
                                <tr>
                                    <th>VAT Amount :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_vat_amount }}</th>
                                </tr>
                                <tr>
                                    <th>Volume weight :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_volume_weight }}</th>
                                </tr>
                                <tr>
                                    <th>Discount :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_discount_weight }}</th>
                                </tr>

                                <tr>
                                    <th>Total :</th>
                                    <th style="text-transform: uppercase;">{{ $shipment->amount_grand_total }}</th>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>


                <div class="row clearfix" style="border:1px solid;">
                    <div class="col-md-12"  style="padding-left:0px; padding-right:0px;">
                        <div class="head">Other Details</div>
                        <div class="desc">
                            <table class="table table-responsive text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Box</th>
                                        <th>Items</th>
                                        <th>Shipment No</th>
                                        <th>Weight</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipment->boxes as $box)
                                    <tr>
                                        <td>{{$box->box_name}}</td>
                                        <td>
                                            @foreach ($box->packages as $item )
                                                {{ $item->description }} -{{$item->quantity}}
                                            @endforeach
                                        </td>
                                        <td>{{$box->getShip->shipment_id??""}}</td>
                                        <td>{{$box->weight??""}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                    <th>Staff :
                                        </th>
                                    <th>
                                        @if($shipment->collected_by == 'driver')
                                                {{ $shipment->driver?$shipment->driver->name:'-'}}
                                            @else
                                                {{$shipment->staff?$shipment->staff->full_name:'-'}}
                                            @endif
                                    </th>
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

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
                                {{-- {!! breadcrumbs() !!} --}}
                            </div>
                            <h4 class="page-title"> Delivery List</h4>

                        </div>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="body p-2">
                                <div class="table-responsive">
                                    <button id="exportBtn" class="btn btn-secondary mb-2">Export to Excel</button>

                                    <table id="table1" class="table center-aligned-table">
                                        <thead class="text-center">
                                        <tr>
                                            <th>SL NO</th>
                                            <th>INVOICE NO</th>
                                            <th>NO OF PCs</th>
                                            <th>WEIGHT </th>
                                            <th>CONSIGNEE ADDRESS</th>
                                            <th>STATE</th>
                                            <th>BOX NUMBER </th>

                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData">
                                        <?php

                                        $tot_weight_exist = 0;
                                        $tot_value_exist = 0;
                                        $tot_temp_exist =0;
                                        $totalPieces =0;
                                        $boxList = [];
                                        $book_no = null;
                                        $noofpc = 0;
                                        foreach( $delivery_list as $index=>$booking) {
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
                                            if(($booking->boxStatuses != null)) {
                                                $status = collect($booking->boxStatuses)->last();
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
                                            $nofpc = 0;
                                            $tot_weight = 0;
                                            $adress = null;
                                            $state = null;
                                            foreach ($ship_bookingsList as $key => $value) {
                                                if($value->shipment->booking_number == $booking->booking_number){
                                                    $nofpc = $nofpc + 1;
                                                    $tot_weight = $tot_weight + $value->weight;
                                                    $adress = $value->shipment->receiver->name.", ".
                                                        $value->shipment->receiver->address->address.", ".
                                                        $value->shipment->receiver->post.", ".
                                                        $value->shipment->receiver->city_name.", ".
                                                        $value->shipment->receiver->address->district->name.", ".
                                                        $value->shipment->receiver->address->state->name .", ".
                                                        $value->shipment->receiver->address->country->name.", ".
                                                        'PIN:-'.$value->shipment->receiver->address->zip_code.
                                                        '<br> MOB:'.$value->shipment->receiver->phone.','.$value->shipment->receiver->whatsapp_number;
                                                    // $state = $value->shipment->receiver->address->state->name;
                                                }
                                            }



                                            ?>
                                            <tr style="">
                                                <td style="text-align:center" >{{$index+1}}</td>
                                                <td style="text-align:center" >{{ $booking->booking_number}}</td>
                                                <td style="text-align:center">{{$nofpc}}</td>
                                                <td style="text-align:center">{{ $tot_weight}}</td>
                                                <td style="text-align:center; text-transform: uppercase;">{!! strtoupper($adress) !!}</td>
                                                {{-- <td style="text-align:center">{{$state}}</td> --}}
                                                {{-- <td style="text-align:center">
                                                    @foreach ($booking->packages as $item)
                                                        {{$item->description}}-{{$item->quantity}},
                                                    @endforeach
                                                </td> --}}
                                                <td>{{strtoupper($booking->receiver->address->state->name??'')}}</td>
                                                <td style="text-align:center">
                                                    @foreach($booking->boxes as $box)
                                                        {{$box->box_name}},
                                                    @endforeach
                                                </td>

                                            </tr>
                                        <?php
                                        }
                                        ?>

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


@endsection
@section('styles')
    @include('layouts.datatables_style')
    <style>
        .floatRight {float:right;}
        .m-l-10 {margin-left:10px!important;}
    </style>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script>
        document.getElementById('exportBtn').addEventListener('click', function () {
            exportToExcel();
        });

        function exportToExcel() {
            let table1 = document.getElementById('table1');

            // Create a new workbook
            let wb = XLSX.utils.book_new();

            // Create a worksheet
            let ws = XLSX.utils.table_to_sheet(table1);

            // Set alignment for each cell
            for (let i = 0; i < ws['!ref'].split(':')[1].replace(/[A-Z]/g, '').charCodeAt(0); i++) {
                for (let j = 1; j < ws['!ref'].split(':')[1].replace(/\d/g, ''); j++) {
                    let cellAddress = XLSX.utils.encode_cell({ r: j, c: i });
                    if (ws[cellAddress]) {
                        ws[cellAddress].v = ws[cellAddress].v.toString().toUpperCase();
                        ws[cellAddress].s = { alignment: { horizontal: 'center' } };
                    }
                }
            }

            // Add the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');

            // Save the workbook
            XLSX.writeFile(wb, 'table.xlsx');
        }
    </script>
    <script>
        $(function () {
            $('#shipsTable').DataTable( {
                ordering: false,
                searching: false,
                info: false,
                bPaginate: false,
                dom: 'Bfrtip',
                autoWidth: false,
                scrollX: true,
                buttons: [
                {
                 ,
                }]
            } );
        });


 </script>

@endsection

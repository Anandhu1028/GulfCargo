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
                            <h4 class="page-title">Loading Export List</h4>

                        </div>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="body p-2">
                                <div class="table-responsive">
                                    {{-- <table id="shipsTable" class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>BOOKING NO:</th>
                                            <th>INVOICE NO:</th>
                                            <th>No: of Pcs</th>
                                            <th>WEIGHT</th>
                                            <th>DEST</th>
                                            <th>MODE</th>
                                            <th>ITEM LIST</th>
                                            <th>OFFICE</th>
                                            <th>STATUS</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData">
                                        <?php

                                        $res ='';
                                        $tot_weight = 0;
                                        $tot_value = 0;
                                        $tot_temp =0;
                                        $totalPieces =0;

                                        foreach( $datas as $booking) {

                                            $tot_temp= $booking->weight;
                                            $tot_weight +=$tot_temp;
                                            $tot_value += $booking->shipment->grand_total;
                                            $totalPieces += 1;

                                            $itemList = [];
                                            $packages = collect($booking->shipment->packages)->where('box_id', $booking->id);
                                            foreach($packages as $item) {
                                                $itemList[] = $item->description;
                                            }
                                            $List = implode(', ', $itemList);

                                            if(($booking->boxStatuses != null)) {
                                                $status = collect($booking->boxStatuses)->last();
                                                $shipmentStatus = collect($booking->shipment->shipmentStatus)->last();
                                                $lastStatus = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;
                                            }
                                            ?>
                                            <tr>
                                                <td style="text-align:center">{{ !empty($booking->shipment->created_date) ? date('d-m-Y', strtotime($booking->shipment->created_date)) : '' }}</td>
                                                <td style="text-align:center" >{{ $booking->shipment->booking_number}}</td>
                                                <td style="text-align:center" >{{$booking->box_name}}</td>
                                                <td style="text-align:center" >{{ count($packages) }}</td>
                                                <td style="text-align:center">{{ number_format($booking->shipment->total_weight + $booking->shipment->msic_weight, 2) }}</td>
                                                <td style="text-align:center">{{ $booking->shipment->receiver->address->state->name }}</td>
                                                <td style="text-align:center">{{$mode->shipmentMethodTypes->name}}</td>
                                                <td style="text-align:center">{{ $List }}</td>
                                                <td style="text-align:center">{{ $booking->shipment->branch->name }}</td>
                                                <td style="text-align:center">{{ $lastStatus }}</td>
                                            </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table> --}}
                                    {{-- <hr> --}}
                                    <button id="exportBtn" class="btn btn-secondary">Excel</button>

                                    <table class="table center-aligned-table">

                                        {{-- <tbody > --}}
                                            {{-- <tr class="text-center">
                                                <td><b>LOADING LIST</b></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>LOGO</td>
                                            </tr> --}}
                                            <table  id="table1" id="shipsTable" class="table center-aligned-table">
                                                    <tr >
                                                        <td align=center colspan=5 style=" font-size:20px;"><b>LOADING LIST</b> </td>
                                                     </tr>
                                                    <tr style="color: black; font-size:17px;">
                                                        <td><b>CON NO:</b></td>
                                                        <td><b>ORG:</b></td>
                                                        <td><b>DST:</b></td>
                                                        <td><b>DATE :</b></td>
                                                        <td><b>AIR WAY BILL :</b></td>

                                                    <tr>
                                                        <td><b>SL</b></td>
                                                        <td><b>INVOICE</b></td>
                                                        <td><b>PCS</b></td>
                                                        <td></td>
                                                        <td><b>WT </b></td>
                                                        {{-- <td><b>WT </b></td> --}}
                                                    </tr>
                                                <tbody >
                                                    <?php

                                                    $res ='';
                                                    $tot_weight = 0;
                                                    $tot_value = 0;
                                                    $tot_temp =0;
                                                    $totalPieces =0;

                                                    foreach( $datas as $index=>$booking) {

                                                        $tot_temp= $booking->weight;
                                                        $tot_weight +=$tot_temp;
                                                        $tot_value += $booking->shipment->grand_total;
                                                        $totalPieces += 1;

                                                        $itemList = [];
                                                        $packages = collect($booking->shipment->packages)->where('box_id', $booking->id);
                                                        foreach($packages as $item) {
                                                            $itemList[] = $item->description;
                                                        }
                                                        $List = implode(', ', $itemList);

                                                        if(($booking->boxStatuses != null)) {
                                                            $status = collect($booking->boxStatuses)->last();
                                                            $shipmentStatus = collect($booking->shipment->shipmentStatus)->last();
                                                            $lastStatus = (!empty($status)) ? $status->status->name : $shipmentStatus->status->name ;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td >{{$index + 1}}</td>
                                                            <td >{{ $booking->box_name}}</td>
                                                            {{-- <td style="text-align:center" >{{$booking->box_name}}</td> --}}
                                                            <td >1</td>
                                                            <td></td>
                                                            <td >{{ number_format($booking->weight, 2) }}</td>
                                                            {{-- <td >{{ number_format($booking->shipment->total_weight + $booking->shipment->msic_weight, 2) }}</td> --}}

                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>

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
                        ws[cellAddress].s = { alignment: { horizontal: 'center' } };
                    }
                }
            }

            // Add the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');

            // Save the workbook
            XLSX.writeFile(wb, 'Loading export list.xlsx');
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
                    extend: 'excel',
                    title: '<?=$excelName?>',
                }]
            } );
        });


 </script>

@endsection

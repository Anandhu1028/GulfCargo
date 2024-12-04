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
                            <h4 class="page-title"> Customer Manifest List</h4>

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
                                        <thead>
                                        <tr style="text-align:center">
                                            <th>SL NO</th>
                                            <th>HAWB NO</th>
                                            <th>NO OF PCs</th>
                                            <th>WEIGHT </th>
                                            <th>SHIPPER ADDRESS</th>
                                            <th>CONSIGNEE ADDRESS</th>
                                            <th>CONSIGNEE PINCODE</th>
                                            <th>DESCRIPTION OF GOODS</th>
                                            <th>INVOICE VALUE</th>
                                            <th>GSTIN TYPE </th>
                                            <th>GSTINNO</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData">
                                            <?php
                                        $tot_weight_exist = 0;
                                        $tot_value_exist = 0;
                                        $tot_temp_exist =0;
                                        $totalPieces =0;
                                        $boxList = [];

                                        foreach( $ship_bookingsList as $index=>$booking) {

                                            $tot_temp_exist= $booking->weight;
                                            $tot_weight_exist +=$tot_temp_exist;
                                            $tot_value_exist += floatval($booking->total_value) + floatval($booking->box_packing_charge);
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

                                            ?>
                                            <tr style="{{ $style }}">
                                                <td style="text-align:center" >{{$index+1}}</td>
                                                <td style="text-align:center" class="boxName" boxId="{{$booking->id}}" ids="{{$ListValue}}">{{ $booking->box_name }}</td>
                                                <td style="text-align:center">1</td>
                                                <td style="text-align:center">{{ number_format($booking->weight,2) }}</td>
                                                <td style="text-align:center">{{ $booking->sender_name.", ".$booking->sender_address}}<br>{{'MOB:'.$booking->sender_mob }}<br>{{ ' ID : '.$booking->sender_id_no }}</td>
                                                <td style="text-align:center">{{ $booking->receiver_name.", ".$booking->receiver_address}}<br>{{'MOB:'.$booking->receiver_mob }}<br>{{ ' ID : '.$booking->receiver_id_no }}</td>
                                                <td style="text-align:center">{{$booking->receiver_pin}}</td>
                                                <td style="text-align:center">
                                                    @foreach ($booking->packages as $item)
                                                        {{$item->description}}-{{$item->quantity}},
                                                    @endforeach
                                                </td>
                                                <td style="text-align:center">{{$booking->packages->pluck('subtotal')->sum()}}</td>
                                                <td style="text-align:center">{{$booking->receiver_id_type}}</td>
                                                <td style="text-align:center">{{$booking->receiver_id_no}}</td>
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
                        ws[cellAddress].s = { alignment: { horizontal: 'center' } };
                    }
                }
            }

            // Add the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet 1');

            // Save the workbook
            XLSX.writeFile(wb, ' Customs Manifest.xlsx');
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

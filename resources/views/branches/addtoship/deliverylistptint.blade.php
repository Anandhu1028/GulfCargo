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
                                                <th>WEIGHT</th>
                                                <th>CONSIGNEE ADDRESS</th>
                                                <th>STATE</th>
                                                <th>BOX NUMBER</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bookingData">
                                        @php
                                            $sl_no = 1; // Initialize a counter for SL NO
                                        @endphp
                                        @foreach($delivery_list as $index => $booking)
                                            @php
                                                $nofpc = 0;
                                                $tot_weight = 0;
                                                $adress = null;
                                                $state = null;
                                    
                                                // Collecting all relevant address information for the consignee
                                                foreach ($ship_bookingsList as $key => $value) {
                                                    if ($value->shipment->booking_number == $booking->booking_number) {
                                                        $nofpc++;  // Increment number of pieces for each associated shipment
                                                        $tot_weight += $value->weight;
                                                        $adress = $value->shipment->receiver->name . ", " .
                                                            $value->shipment->receiver->address->address . ", " .
                                                            $value->shipment->receiver->post . ", " .
                                                            $value->shipment->receiver->city_name . ", " .
                                                            $value->shipment->receiver->address->district->name . ", " .
                                                            $value->shipment->receiver->address->state->name . ", " .
                                                            $value->shipment->receiver->address->country->name . ", " .
                                                            'PIN:-' . $value->shipment->receiver->address->zip_code . 
                                                            '<br> MOB:' . $value->shipment->receiver->phone . ',' . $value->shipment->receiver->whatsapp_number;
                                                    }
                                                }
                                            @endphp
                                    
                                            @foreach($booking->boxes as $box)
                                                <tr style="">
                                                    <td style="text-align:center">{{ $sl_no++ }}</td> <!-- SL NO is now incremented for each row -->
                                                    <td style="text-align:center">{{ $booking->booking_number }}</td> <!-- INVOICE NO stays the same -->
                                                    <td style="text-align:center">1</td> <!-- NO OF PCs is 1 per box -->
                                                    <td style="text-align:center">{{ $box->weight }}</td> <!-- Display the weight for this box -->
                                                    <td style="text-align:center; text-transform: uppercase;">{!! strtoupper($adress) !!}</td> <!-- Same address for all boxes -->
                                                    <td style="text-align:center">{{ strtoupper($booking->receiver->address->state->name ?? '') }}</td> <!-- Same state for all boxes -->
                                                    <td style="text-align:center">{{ $box->box_name }}</td> <!-- Display the box number -->
                                                </tr>
                                            @endforeach
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
            XLSX.writeFile(wb, 'Delivery List.xlsx');
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
                    filename: 'Delivery List',
                }]
            } );
        });


 </script>

@endsection

<?php
 $shipment_count = count($shipments );
 foreach($shipments  as $key => $shipment) {
      $key+1;
    ?>

<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>
<style type="text/css">

    @page {     margin: 0 !important; }
    @media print{
        .print{
            display: none;

        }
        table{
            width: 100% !important;
        }
        .table-50 {
            width: 50% !important;
        }
        table{
         position: static;
        }

        .container{
            min-height:29.7cm;
        }
    }


        table {
  border-collapse: collapse;
  /*^^^ merges adjacent cell and table borders (so table height != sum of row heights!)*/
  border-spacing: 0 0; /*removes space between cells*/
  -webkit-border-vertical-spacing: 0;
  /*^^^ removes Chrome's border-spacing (sort of redundant with border-spacing: 0 0;)*/
}
table > thead {
  vertical-align: bottom;
  /*^^^ affects the height of rows that get broken by page breaks*/
}
table > tbody {
  vertical-align: top;
  /*^^^ affects the height of rows that get broken by page breaks*/
}
table > * > * > tr,
table > * > * > td,
table > * > * > th {
  border: 1px solid #2559eb;
  padding-top: 0; /*cancels out browser's default cell padding*/
  padding-bottom: 0; /*cancels out browser's default cell padding*/
}

table tr, th, td {
    border: 1px solid #2559eb;
}

    }
    table {
        border-collapse: collapse;
        /*^^^ merges adjacent cell and table borders (so table height != sum of row heights!)*/
        border-spacing: 0 0; /*removes space between cells*/
        -webkit-border-vertical-spacing: 0;
        /*^^^ removes Chrome's border-spacing (sort of redundant with border-spacing: 0 0;)*/
        }
        table > thead {
        vertical-align: bottom;
        /*^^^ affects the height of rows that get broken by page breaks*/
        }
        table > tbody {
        vertical-align: top;
        /*^^^ affects the height of rows that get broken by page breaks*/
        }
        table > * > * > td,
        table > * > * > th {
        border: 1px solid #2559eb;
        padding-top: 5px; /*cancels out browser's default cell padding*/
        padding-bottom: 0; /*cancels out browser's default cell padding*/
        }
    .print{
        padding: 5px;
        background-color: aqua;
        border: solid 1px #ddd;
    }
    body {
        font-family: 'Roboto Condensed', sans-serif;
        color:#2559eb;

    }
    .invoice-table tr td{
        padding: 3px 8px;
    }
    .text-right{
        text-align: right;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }
    .w-25 {
        width: 25%;
    }

    .w-15 {
        width: 15%;
    }

     .logo {
        height: 50px;
        padding: 0px;
        margin: 0px;
     }
     .website {
        color:red;
        font-size: 14px;
        padding: 0px;
        text-align: center;
        /* font-weight: bold; */
     }
     .website-tel {
        color:red;
        font-size: 14px;
        padding: 0px;
        text-align: right;
        /* font-weight: bold;     */
    }
    .tab-title {
        text-transform: uppercase;
        text-align: center;
        font-weight: bold;

    }
    .tab-title-left {
        text-transform: uppercase;
        text-align: left;
        font-weight: bold;
    }
    /* .logo img {
        width: 45px;
        height: 45px;
        padding-top: 30px;
    }

    .logo span {
        margin-left: 8px;
        top: 19px;
        position: absolute;
        font-weight: bold;
        font-size: 25px;
    } */

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid #2559eb;
    }

    table tr,
    th,
    td {
        border: 1px solid #2559eb;
        border-collapse: collapse;
        padding: 4px 8px;
    }



    table tr th {
        background: #F4F4F4;
        font-size: 13px;width:25%
    }

    table tr td {
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
    .border-r-n{
        border-right-style : hidden!important;
    }
    .border-t-n{
        border-top-style : hidden!important;
    }
    .border-l-n{
        border-left-style : hidden!important;
    }
    .border-b-n{
        border-bottom-style : hidden!important;
    }
    .border-top{
        border-top-style : border: 1px solid #d2d2d2;
    }

    @media (min-width: 1200px) {
        .container{
            max-width: 970px;
        }
    }
    .text-right{
        text-align: right;
    }
    table tbody tr td{
        border-bottom: none !important;
    }
    .pod {
        writing-mode: vertical-rl;
        text-orientation: upright;
        padding: 7px;
        background-color: red;
        color: white;
        font-weight: bolder;
        font-size: 20px;
        text-align: center;
        letter-spacing: 2px;

    }

.total-tab tr  td {
    padding: 1px;
    /* color:red; */
}
.item-table tr {
 height:8px !important;
 padding: 0px !important;
}

.item-table td {
  padding:0px !important;
}
#print_button button{
    position: fixed;
    top: 20px;
    right:50px;
    padding: 10px;
    font-size: 18px;
}
</style>

<body>
    @php
        $countryname = false;
        $sender_countryname = false;
        if($shipment->receiver && $shipment->receiver->address && $shipment->receiver->address->country)
        {
            $countryname = true;
        }
        if($shipment->sender && $shipment->sender->address && $shipment->sender->address->country)
        {
            $sender_countryname = true;
        }
    @endphp


<div class="container">
    <div class="table-section bill-tbl w-100 mt-10">
        <table style="width: 100%; height: 50px;" cellspacing="0">
            <tbody>
            <tr>
                <td style= "width:20%; padding:0px;">
                    <img src="{{asset('assets/images/best_express_cargo_logo.png')}}" alt="Bestexpress" class="img-responsive logo" >
                </td>
                <td   class="website">
                    www.bestexpresscargo.com <br/>
                    bestexpresscargouae@gmail.com </br>
                    bestexpresscargoauh@gmail.com
                </td>
                <td  class="website-tel">
                    Toll Free: 8003977 <br/>
                    Mobile : 050 2837 500 </br>
                    &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;:058 9017 500
                </td>

            </tr>
            </tbody>
        </table>

            <table style="width: 100%; height: 100px;  border:1 px solid" cellspacing="0">
            <tbody>
            <tr class="tab-title">
                <td colspan="2">Date</td>
                <td>Origin</td>
                <td>Pcs</td>
                <td>Weight</td>
                <td>Airway bill</td>
            </tr>
            <tr style="text-align:center">
                <td colspan="2">{{ date('d-m-Y',strtotime($shipment->shiping_date)) }}</td>
                <td></td>
                <td>{{ $shipment->number_of_pcs }}</td>
                <td></td>
                <td>
                    @php
                        $booking_number = (int) $shipment->booking_number;
                        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($booking_number, 'C39+', true) . '" alt="barcode"   /><br>'.'<b>'.$booking_number.'</b>';
                    @endphp
                </td>
            </tr>
            <tr style="border: 1px solid"  class="tab-title-left ">
                <td colspan="3" style="width:50%;">Sender's Name & Address</td>
                <td colspan="3">Consignee's Name & Address</td>
            </tr>
            <tr style=" text-align:justify;">
                <td colspan="3" style="width:50%;padding:1px; margin:1px;">
                        {{ ($sender_countryname) ? $shipment->sender->name.','.$shipment->sender->address->address.', '."PIN : " .$shipment->sender->address->zip_code.', '.
                        $shipment->sender->address->state->name.', '.$shipment->sender->address->country->name : "" }}
                        {{ $shipment->sender->phone }}
                </td>
                <td colspan="3" style="padding:1px; margin:1px;">
                        {{ ($countryname) ? $shipment->receiver->name.','.$shipment->receiver->address->address.', '." PIN : ".
                        //                            $shipment->receiver->address->address.", ".
                        $shipment->receiver->address->state->name.', '.$shipment->receiver->address->country->name : "" }}
                        {{ $shipment->receiver->phone }}

                </td>
            </tr>
            <tr style="border: 1px solid" class="tab-title-left">
                <td colspan="3" style="width:50%;">Tel: {{$shipment->sender->country_code_phone .$shipment->sender->phone }}</td>
                <td colspan="3">Mobile: </td>
            </tr>

            <tr style="border: 1px solid" class="tab-title-left">
                <td colspan="3" style="width:50%;">If non document, value declared for customs </td>
                <td colspan="2"  style="width:30%;">Tel: {{$shipment->receiver->country_code_phone .$shipment->receiver->phone }}</td>
                <td colspan="1">Pin: </td>
            </tr>

            </tbody>
        </table>
        <table style="width: 50%; height: 130px;   float: left" cellspacing="0" class="border-0 table-50 total-tab">
            <tbody>
            <tr  class="border-top-0">
                <td style="width:5%" rowspan="3" class="pod">POD</td>
                <td style="height:10px">I understood on befalf of the above sender/ shipper acknowledge <br>
                   the receipt of good condition
                </td>
            </tr>
            <tr >
                <td style="height:10px"> Receiver's Name: {{$shipment->receiver->name }}<br>
                     <span>Date: </span><span style="margin-left:180px;"> Time:</span><span style="float:right;">AM/PM</span>
                </td>
            </tr>
            <tr>
                <td >SIGNATURE</td>
            </tr>

            </tbody>
        </table>
        <table style="width: 50%; height: 100px; float: left" cellspacing="0" class="border-0 table-50 total-tab">
            <tbody>
            <tr>
                <td style="width:25%">Total Weight</td>
                <td style="width:25%">{{$shipment->total_weight}}</td>
                <td style="width:25%">Total Freight</td>
                <td style="width:25%">{{$shipment->total_freight}}</td>
            </tr>
            <tr>
                <td>MISC Weight</td>
                <td>{{$shipment->msic_weight}}</td>
                <td>MISC Freight</td>
                <td>{{$shipment->misc_freight}}</td>
            </tr>
            <tr>
                <td>No. of Pcs</td>
                <td>{{$shipment->number_of_pcs}}</td>
                <td>Packing</td>
                <td>{{$shipment->packing_charge}}</td>
            </tr>
            <tr>
                <td rowspan="4">Mode of <br>Shipment</td>
                <td rowspan="4">{{$shipment->shiping_method}}</td>
                <td>Other Charges</td>
                <td>{{$shipment->other_charges}}</td>
            </tr>
            <tr>
                <td>Document Charges</td>
                <td>{{$shipment->document_charge}}</td>
            </tr>
            <tr>
                <td>Discount</td>
                <td>{{$shipment->discount}}</td>
            </tr>

            <tr>
                <td>Total</td>
                <td>{{$shipment->grand_total}}</td>
            </tr>

            </tbody>
        </table>
        <table style="width: 100%; height: 15px; " cellspacing="0" class="border-0">
            <tbody>
            <tr>
                <td style="text-align:center ; padding:0px;">INVOICE/ PACKING LIST</td>
            </tr>
            </tbody>
        </table>
        <table style="width: 100%; height: 300px;border:#2559eb;" cellspacing="0" class="border-0" >
            <tbody>
            <tr>
               <td>
                    <!-- <table style="width: 50%; height: 100px;  float:left;" cellspacing="0" class="border-0"  class="item-table"> -->
                    <table style="width: 50%;  float: left" cellspacing="0" class="border-0 table-50 total-tab item-table">
                        <tbody>
                        <tr style="height:8px;">
                            <td style="text-align:center">SL No. </td>
                            <td style="text-align:center">DESCRIPTION</td>
                            <td style="text-align:center">QTY</td>
                            <td style="text-align:center">VALUE</td>
                            <td style="text-align:center">TOTAL VALUE</td>
                        </tr>

                        @foreach($shipment->packages as $k => $package )
                            @if($k%2==0)
                                <?php if( $package->box_id % 2 == 0)
                                $color="#ccc";
                                else
                                $color = "white";
                                ?>
                        <tr>
                            <td style="text-align:center; background-color:<?=$color?>">{{$k+1}}</td>
                            <td style="text-align:center;  background-color:<?=$color?>">{{ $package->description}}</td>
                            <td style="text-align:center;  background-color:<?=$color?>">{{ $package->quantity}}</td>
                            <td style="text-align:center;  background-color:<?=$color?>">{{ $package->unit_price}}</td>
                            <td style="text-align:center;  background-color:<?=$color?>">{{ $package->subtotal}}</td>
                        </tr>
                            @endif
                            @endforeach

                        <!-- <tr style="border:#2559eb;">
                            <td style="text-align:center; height:10px; background-color:#2559eb;color:#fff; padding:0px;"  colspan="6"><h4 style=" letter-spacing: 4px;margin:0px; padding:2px;">DECLARED VALUE (A.E.D) </h4></td>
                            <td style="text-align:center"></td>
                        </tr> -->
                        </tbody>
                    </table>
                    <table style="width: 50%; float: left" cellspacing="0" class="border-0 table-50 total-tab item-table">
                        <tbody>
                        <tr style="height:8px;">
                            <td style="text-align:center">SL No. </td>
                            <td style="text-align:center">DESCRIPTION</td>
                            <td style="text-align:center">QTY</td>
                            <td style="text-align:center">VALUE</td>
                            <td style="text-align:center">TOTAL VALUE</td>
                        </tr>
                        @foreach($shipment->packages as $k => $package )
                            @if($k%2==1)
                            <?php if( $package->box_id % 2 == 1)
                                $color1="white";
                                else
                                $color1 = "#ccc";
                            ?>
                        <tr>
                            <td style="text-align:center; background-color:<?=$color1?>">{{$k+1}}</td>
                            <td style="text-align:center; background-color:<?=$color1?>">{{ $package->description}}</td>
                            <td style="text-align:center; background-color:<?=$color1?>">{{ $package->quantity}}</td>
                            <td style="text-align:center; background-color:<?=$color1?>">{{ $package->unit_price}}</td>
                            <td style="text-align:center; background-color:<?=$color1?>">{{ $package->subtotal}}</td>
                        </tr>
                            @endif
                            @endforeach

                        <!-- <tr style="border:#2559eb;">
                            <td style="text-align:center; height:10px; background-color:#2559eb;color:#fff; padding:0px;"  colspan="6"><h4 style=" letter-spacing: 4px;margin:0px; padding:2px;">DECLARED VALUE (A.E.D) </h4></td>
                            <td style="text-align:center"></td>
                        </tr> -->
                        </tbody>
                    </table>

            </td>
            </tr>
            <!-- <tr class="border-0" style="border:none">
                <td class="border-0">
                    <span style="float:right">Total values are Customs purpose only, not for commercial purpose Reason : Gift</span>

                </td>
            </tr>   -->

            <tr>
                <td>
                    <p style=" margin:0 0 0 350px; font-size:10px; font-weight:bold;">Total values are Customs purpose only, not for commercial purpose Reason : Gift</p>

                         <ul style="list-style-type: decimal;font-size:8px; text-align:justify; margin-bottom:0px; margin-top:0px;">
                            <li>I Mr/Mrs...<b>{{ $shipment->sender->name }}</b>... declare that above goods are fully legal and non dangerous. Declares that I am liable for any customs duty  penalties. </li>

                            <li>Shippe certifies that the particulars on the face her are of correct an insofar any part of this consignment contains dangerous goods, if any , such part is properly mentioned by name and in proper condition for carriage by air transport assocaition applicable dangerous goods and civil aviation regulation of UAE.

                            </li>
                            <li>
                            Maximum payback for total lost will be Dhs.20/-per kilogram(Included sending charge).
                            Total cargo value should not exceed Rs.20,000/-.BEST EXPRESS CARGO LLC is not responsible for any damages of fragle(glass etc.) items and shipment delay occuring due to the formalities of Government/Air/Sea authorities. We request our customers to corporate with us.
                            </li>
                            <li>
                            I hereby authorize BEST EXPRESS CARGO is not liable of the shipment in full or part as therir convenience.
                            </li>
                            <li>
                            I agree that BEST EXPRESS CARGO is not liable of the shipment delays due to customs Clearence/ Natural Disasters and all the problems occures out of their hands.  </li>
                            <li>
                             All fragle Glass items must be transported at the shipper's risk since it has no claims on any damageous.
                             </li> <br>
                            <span> Signature of Consigner:..................................... </span> <span style="margin-left:250px;">For Best Express Cargo L.L.c............................................... </span>

                        </ul>

                </td>
            </tr>
            </tbody>
        </table>





    </div>
</div>







    <!-- <div class="container">

        <div class="table-section bill-tbl w-100 mt-10">
            <table style="width: 100%; height: 300px;  border:1 px solid" cellspacing="0">
                <tbody>

                <tr  style="border:1 px solid">
                <td class="border-b-n"  colspan="6" align="left" height="29">
                    <img src="{{asset('assets/images/best_express_cargo_logo.png')}}" alt="Bestexpress" class="img-responsive logo" height="60">
                </td>

                <td> testtt</td>

                <td class="border-l-n text-center" colspan="3" style="width: 74px;" align="left">
                    <h3>AIRWAY BILL NO</h3>
                       @php

                            $booking_number = (int) $shipment->booking_number;

                    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($booking_number, 'C39+', true) . '" alt="barcode"   /><br>'.'<b>'.$booking_number.'</b>';

                       @endphp



                </td>

                </tr>
                <tr>
                <td style="width: 124px;" align="center" valign="middle" height="25">DATE</td>
                <td style="width: 104px;" align="center" valign="middle">ORIGIN</td>
                <td style="width: 182px;" align="center" valign="middle">DESTINATION</td>
                <td style="width: 522px;border-top-style : hidden!important" colspan="6" rowspan="2" >

                </td>
                </tr>
                <tr>
                <td style="width: 124px;" align="center" valign="middle" height="25">{{ date('d-m-Y',strtotime($shipment->shiping_date)) }}</td>
                <td style="width: 104px;" align="center" valign="middle">BAH</td>
                <td style="width: 182px;" align="center" valign="middle">{{ ($countryname) ?  strtoupper($shipment->receiver->address->country->name) : "" }}</td>
                </tr>
                <tr>
                <td style="width: 50%" colspan="4" rowspan="7" align="left" valign="top" height="23">Declaration :<p>shipper certifies that the nature of goods is as AIR WAY
                    BILL the shipper agree to and accept the contract conditions on
                    the revers side here of and acknowledges that the goods
                    described herein is accepted by AEROSPACE CARGO for
                    transportation to said contract condition.</p><p>
                    shipper declares that goods carried under this consignment
                    contain no DANGEROUS GOODS, as described under the
                    IATA dangerous goods regulation</p>
                </td>
                <td colspan="3" align="left">Signature Of Receiver</td>
                <td  align="center" valign="middle"><strong>DATE</strong></td>
                <td style="width: 250px"  align="center" valign="middle"><strong>{{ $shipment->created_at->format('d-m-Y') }}</strong></td>
                </tr>
                <tr class="no-change-padding">

                <td style="width: 10%" align="center" valign="center">PICES</td>
                <td style="width: 10%" align="center" valign="center">{{ $shipment->number_of_pcs }}</td>
                <td style="width: 10%" class="border-b-n" rowspan="2" align="center" valign="middle">KG</td>
                <td style="width: 20%" colspan="2" align="center" valign="middle">Total Value</td>
                </tr>
                <tr>

                <td style="width: 10%" align="center" valign="top">WEIGHT</td>
                <td style="width: 10%" align="center" valign="top">{{ $shipment->weight }}</td>
                <td style="width: 20%" colspan="2" align="center" valign="middle">$.{{ $shipment->total_amount }}</td>
                </tr>
                <tr>

                <td style="width: 50%" colspan="5" rowspan="4" align="left">I null holder of Indian Passport No :/ID No : null....Do here by appointed MANAMA as my authorised agent
                    to do the courier baggage clearance in india for me and
                    setting to <b>{{ strtoupper($shipment->receiver->name) }}</b> as a gift consignment.
                </td>

                </tr>
                </tbody>
                </table>

        </div>
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <tr>
                    <th width="100%" colspan="10">INVOICE</th>
                </tr>
                <tr>
                    <th width="50%" colspan="5">Sender Name & Address</th>
                    <th width="50%" colspan="5">Consignee Name & Address</th>
                </tr>
                <tr>
                    <td width="50%" colspan="5">
                        <p> {{ ($sender_countryname) ? $shipment->sender->name.','.$shipment->sender->address->address.', '."PIN : " .$shipment->sender->address->zip_code.', '.
                        $shipment->sender->address->state->name.', '.$shipment->sender->address->country->name : "" }}
                        {{ $shipment->sender->phone }}</p>
                    </td>
                    <td width="50%" colspan="5">
                        <p>

                            {{ ($countryname) ? $shipment->receiver->name.','.$shipment->receiver->address->address.', '." PIN : ".
//                            $shipment->receiver->address->address.", ".
                            $shipment->receiver->address->state->name.', '.$shipment->receiver->address->country->name : "" }}
                            {{ $shipment->receiver->phone }}
                        </p>

                    </td>
                </tr>
                <tr>
                    <td colspan="2">Pre-Carriage By</td>
                    <td colspan="3">Place Of Receipt By Pre-Carrier</td>
                    <td colspan="5">Terms Of Delivery And Payment</td>
                </tr>
                <tr>
                    <td colspan="2">Vessele/Flight No.</td>
                    <td colspan="3">Port Of Loading <br><b>{{ 'BAH' }}</b></td>
                    <td rowspan="2" colspan="5">HOUSE HOLD GIFT ITEMS FOR PERSONAL USE
                        ONLY</td>
                </tr>
                <tr>
                    <td colspan="2">Port Of Discharge <br><b>BAHRAIN</b></td>
                    <td colspan="3">Final Destination <br>
                        <b>{{ ($shipment->company) ? $shipment->company->destination : "" }}</b>
                    </td>
                </tr>

            </table>
        </div>
        <div class="table-section bill-tbl  w-100 mt-10">
            <table class="table w-100 mt-10 invoice-table">
                <tr>
                    <th>Sl</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Rate USD</th>
                    <th>Val USD</th>
                    <th>Sl</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Rate USD</th>
                    <th>Val USD</th>
                </tr>
                <tbody>
                @foreach($shipment->packages as $k=> $package)


                        @if($k%2==0)
                        <tr align="center">
                        <td>{{ $k+1 }}</td>
                        <td>{{ $package->description }}</td>
                        <td>{{ $package->quantity }}</td>
                        <td>{{ $package->unit_price }}</td>
                        <td>{{ $package->subtotal }}</td>
                        @else
                        <td>{{ $k+1 }}</td>
                        <td>{{ $package->description }}</td>
                        <td>{{ $package->quantity }}</td>
                        <td>{{ $package->unit_price }}</td>
                        <td>{{ $package->subtotal }}</td>
                    </tr>
                        @endif

                @endforeach
                <tr>
                    <td colspan="5"><b>HOUSE HOLD GIFT ITEMS</b></td>
                    <td colspan="5"><b>Signature & Date:</b></td>
                </tr>
            </tbody>

            </table>
        </div>

        <div class="text-center" style="margin: 30px">
            <button type="button" onclick="window.print()" class="print">Print</button>
        </div>

    </div> -->
@if( $shipment_count == $key+1)
    <div class="text-center" id="print_button" >
            <button type="button" onclick="window.print()" class="print">Print</button>
        </div>
@endif
</body>

</html>
<?php } ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $shipment->booking_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>

    @media print {
      @page {
        size: A4 !important;
        margin: 0;
      }
      /* .printxxxx {
        page-break-after: always;
      } */
      td{
        padding:0px !important;
      }
        h4{
            padding:0px !important;
            margin:0px !important;
        }
        #print_button button{
            display:none;
        }
        .address {
            font-size: 14px !important;
        }
        .pod{
            height: 180px !important;
        }
        .inv_no {
            font-size: 20px !important;
        }
        .#00b050{
            height: 100px !important;
        }
        .value_goods{
            height: 34px !important;
        }
        .value_goods1{
            padding: 9px !important;
        }

        .value_goods .vr_line{
            height: 33px !important;
            border-top: none !important;
            border-bottom: none !important;
            border-right: none !important;

        }
        .bottom_table{
            width:98% !important;
        }

        .bottom_table table{
            width:106% !important ;
        }

        .blank_row{
            height: 110px !important;
        }

        .spcl_remark p{
            padding: .5px !important;
            font-size: 9px !important;
        }
        .ind_air1{
            padding: 7px !important;
        }
        .ind_air2{
            padding: 6px !important;
        }

        .home_del{
            height: 22px !important;
        }



        .#00b050 p{
            font-size: 8px !important;
            padding: 4px !important;
        }

        .adress_table div{
            font-size: 7px !important;
        }

        [style*="border-bottom: 2px solid"] {
                border: 1px solid #000 !important;
        }

        [style*="border-top: 2px solid"] {
            border: 1px solid #000 !important;
        }
        [style*="border-left: 2px solid"] {
            border: 1px solid #000 !important;
        }
        [style*="border-right: 2px solid"] {
            border: 1px solid #000 !important;
        }
        [style*="border-bottom: 2px solid"] {
            border: 1px solid #000 !important;
        }

        .pacling_list th,td{
            border-top: 1px solid #000 !important;
            border-bottom: 1px solid #000 !important;
            border-right: 1px solid #000 ;
            padding: 3px !important;
        }


        .table_head th{
            border-bottom: 1px solid #000 !important;
            border-top: 1px solid #000  !important;

        }

        .consignee_add{
            border:1px solid #000  !important;
        }

        .spcl_remark{
            border-bottom:1px solid #000  !important;
        }

        .bottom_table thead{
            border-top:1px solid #000  !important;
        }

        .shipper_add th{
            font-size: 9px;
            padding: 2px;
        }


        .shipper_add b{
            font-size: 9px;
            padding: 0px !important;

        }

        .spcl_remark1{
            height:27px !important ;
        }

        .bottom_table td{
            border: none !important;
        }

        .foot_eng{
            line-height: 10px !important;
            font-size: 9px;
        }

        .date_table td{
            padding: 4px !important;
            font-size: 12px !important;
        }

        .header{
            margin-left: 6px !important ;
        }

        .barcode_sec text{
            font-size: 28px !important;
        }



    }







    .barcode_sec text{
        font-size: 32px;
        transform: translateY(-10px);
    }

    .main_div{
            font-size: 10px !important;
        }

        .pod{
            height: 242px;
            background: gray;
            color:#fff;
        }
        .container {
            width: 100%;


        }
        .main_div{
            border: 2px solid #000 ;
        }
        .ml-4{
            margin-left: 30px;
        }
        .ml-3{
            margin-left: 15px;
        }
        .ml-5{
            margin-left: 35px;
        }

        .inv_no{
            /* background: black; */
            color: #0070c0;
            /* width: 100px; */
            /* width: 155px; */
            padding: 5px;
        }
        .table_head th{
            border-bottom: 2px solid #000;
            border-top: 2px solid #000;
            background: #0070c0;
            padding: unset;
        }
        .table_head span{
            color:#fff;
        }

        .date_table tbody span{
            font-size: 13px !important;
            font-weight: 700 !important;
        }

        .green_bg span{
            color: #fff;
        }
        input[type="checkbox"] {
            transform: scale(1); /* Change the scale value to adjust the size */
        }
        input[type="checkbox"] {
            border-width: 2px; /* Change the border-width value to adjust the width */
        }
        .pacling_list td{
            border-right: 1px solid #000;
            border-bottom: 2px solid #000;
            text-align: 2px solid #000;
        }

        .pacling_list th{
            border-right: 1px solid #000;
            border-top: 2px solid #000;
            padding-top: 7px !important;
        }
        .pacling_list .sno{
            background: #d9d9d9;
        }

        .adress_table td{
            padding: 1px;
        }
        .item_table td, th{
            padding: 5px;
        }
        .item_table td{
            text-align: center;
        }
        .item_table th, td{
            padding:3px;
        }

        .pacling_list .row{
            margin: -4px;
        }
        .pacling_list span{
            color: #fff;
        }
        .adress_table .row{
            margin: -4px;
        }




        .footer b, p {
            margin:1px;
            /* text-align: justify; */
        }

        .header h6{
            font-size: 12px;
        }
        .pod_right_table td{
            text-align: left;
            padding: 10px;
        }

        .pod_right_table p{
            text-align: justify;
        }

        .left-span {
            text-align: initial !important;
        }
        .right-span {
            text-align: right !important;
        }

        .green_bg td{
            background: #00b050;
        }
        .bottom_table th{
            background: #0070c0;
            color: #fff;
        }

        .bottom_table td{
            border-bottom: none !important;
        }


        @media screen and (max-width: 600px) {
            .shipment-info {
            text-align: left;
            }
        }
        #printButton {
            position: fixed;
            top: 30px;
            left: 30px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #c52014;
            color: #fff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            z-index: 1000;
            width: 95px
        }

        #printButton:hover {
            background-color: #009eb3;
        }
        body{
            text-transform: uppercase;
        }


        .shipper_add th{
            border-bottom: 1px solid;
        }

        .consignee_add th{
            border-bottom: 1px solid;
        }

    </style>
</head>

<body>
    <button id="printButton" onclick="printPDF()">Print</button>

    <div class="p-3" style="overflow: hidden;">
        <div class="main_div">
            <div class="row">
                <div class="col-5 mt-4 ml-4 header">
                    <div  style="float:left;">
                        <img src="{{asset($shipment->agency->logo??'') }}" alt="Bestexpress" style="height:90px;" class="img-responsive logo" >
                    </div>
                        {{-- <h6 class="text-uppercase">DIVISION OF {{$shipment->agency->name}},
                            {{$shipment->agency->address}},
                            {{$shipment->agency->district}},
                            PIN:- {{$shipment->agency->pincode}}
                        </h6> --}}
                </div>
                <div class="col-3 d-flex align-items-center justify-content-center" >
                    <h1 class="inv_no">عرفة للشحن ذ.م.م</h1>
                </div>
                <div class="col-3 d-flex align-items-center justify-content-center barcode_sec" >
                    <div class="row text-center">
                        <div class="col-12 " style="margin-bottom:-10px;">
                            <h6>Invoice Number</h6>
                        </div>
                        <div class="col-12">
                            <svg id="barcode"></svg>
                        </div>
                    </div>
                    {{-- <h1 class="inv_no">{{ $shipment->booking_number }} </h1> --}}
                </div>
            </div>
            <div class="row text-center" style="font-size: 12px">
                <div class="col-4"><b style="font-size: 14px;">WORLD WIDE CARGO SERVICES</b></div>
                <div class="col-4"><b>TAX INVOICE</b></div>
                <div class="col-4"><b>TRN NO: 100556301800003</b></div>
            </div>
            <div class="col-12" style="margin-bottom: -16px;">
                <table class="table text-center date_table">
                    <thead  class="table_head">
                        <tr>
                            <th style="border-left:1px solid #0070c0;"> <span>DATE</span>  <br><span>تاريخ</span></th>
                            <th> <span>REF NO.</span>  <br><span>مصدر رقم.</span></th>
                            <th><span>PKG</span> <br><span> طَرد</span></th>
                            <th><span>WEIGHT</span> <br><span>وزن</span></th>
                            <th><span>ORIGIN</span> <br><span>أصل</span></th>
                            <th><span>DESTINATION</span> <br><span> وجهة</span></th>
                            <th><span>MODE OF SHIPMENT</span><br><span>طريقة الشحن</span></th>
                        </tr>
                    </thead>
                    <tbody class="green_bg" style="border-bottom: 2px solid;">
                        <tr>
                            <td style="border-left: 1px solid #00b050"><span>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span></td>
                            <td><span>{{ $shipment->booking_number }}</span> </td>
                            <td><span>{{ $shipment->number_of_pcs ? $shipment->number_of_pcs : ($shipment->number_of_pcs_create ? $shipment->number_of_pcs_create : 0) }}</span></td>
                            <td><span>{{ round($shipment->grand_total_weight, 2) }}</span></td>
                            <td><span>UAE</span></td>
                            <td><span>INDIA</span></td>
                            <td style="border-right: 1px solid #00b050"><span>{{ $shipment->shipMethType ? $shipment->shipMethType->name : '' }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead class="adress_sec" style="border-bottom: 1px solid !important;">
                            <tr>
                                <th class="col-6 " style="border-right: 1px solid; "> <div class="row"><div class="col-6"><b>SHIPPER ADDRESS</b></div> <div class="col-6 text-end" ><b> من العنوان</b></div></div>   </th>
                                <th class="col-6"> <div class="row"><div class="col-6"><b>CONSIGNEE ADDRESS</b> </div> <div class="col-6 text-end"><b>إلى عنوان </b></div> </div> </th>
                                {{-- <th class="col-4 text-center" ><span>SERVICE</span> <br><span class="text-center"> خدمة</span></th> --}}
                            </tr>
                        </thead>

                    </table>

                </div>
                <div class="row shipper_add" style="margin-left: 3px; margin-bottom: -17px;">
                    <div class="col-3 " style="margin-top: -16px !important; border-right: 1px solid #000 !important ;border-left: none !important; border-top: none !important; border-width: 2px; padding: 0px !important; margin-left: -3px;">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">NAME</div>
                                            <div class="col-6 text-end">اسم</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">ADDRESS</div>
                                            <div class="col-6 text-end">عنوان</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start"> ZIP/POST CODE </div>
                                            <div class="col-6 text-end">شفرة البرٌد</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">STATE / PROVINCE</div>
                                            <div class="col-6 text-end">والٌة</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">COUNTRY</div>
                                            <div class="col-6 text-end">دولة</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">TEL:</div>
                                            <div class="col-6 text-end"> هاتف</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">MOBILE:</div>
                                            <div class="col-6 text-end"> متحرك</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr >
                                    <th style="border-bottom:none !important; ">
                                        <div class="row">
                                            <div class="col-6 text-start">E-MAIL:</div>
                                            <div class="col-6 text-end">بريد إلكتروني</div>
                                        </div>
                                    </th>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-3  pt-3 " style=" border-width: 1px;margin-top: -16px; font-size: 12px; margin-left: -1px;">
                        <b class="align-items-center justify-content-center shipment-info">
                            {{ $shipment->sender->name }} ,
                            {{ $shipment->sender->address->address }},
                            {{ $shipment->sender->post? $shipment->sender->post.',' :''}}
                            <br>
                            {{ $shipment->sender->city_name ? $shipment->sender->city_name.',' : ''}}
                            {{ $shipment->sender->address->district ? $shipment->sender->address->district->name.',' : ''}}
                            {{ $shipment->sender->address->state ? $shipment->sender->address->state->name.',' : ''}}
                            {{-- {{ $shipment->sender->address->country_id ? $shipment->sender->address->country->name.',' : ''}} --}}
                            ,UAE
                            <br>
                            {{$shipment->sender->address ? 'PIN:-'.$shipment->sender->address->zip_code.',' : ''}}
                            MOB:
                            +{{ $shipment->sender->country_code_whatsapp}} {{ $shipment->sender->whatsapp_number }},
                            +{{ $shipment->sender->country_code_phone}} {{ $shipment->sender->phone }},
                            <br>
                            ID - {{ $shipment->sender->identification_number }}
                            {{-- <span style="text-transform:lowercase !important;">{{ $shipment->sender->user ? $shipment->sender->user->email : ''}}</span> --}}

                        </b>
                    </div>
                    <div class="col-2 consignee_add" style="border:1px solid #000 !important; margin-left: 0.5px; ; border-top: none !important; border-width: 2px; margin-top: -16px; border-bottom:none; --bs-gutter-x: -0.5rem;">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">NAME</div>
                                            <div class="col-6 text-end">اسم</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">ADDRESS</div>
                                            <div class="col-6 text-end">عنوان</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">STREET-1</div>
                                            <div class="col-6 text-end">شارع 1</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">STREET-2</div>
                                            <div class="col-6 text-end">شارع 2</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">DISTRICT</div>
                                            <div class="col-6 text-end"> ٌصرف</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">STATE/ PIN</div>
                                            <div class="col-6 text-end"> والٌة</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">TEL:</div>
                                            <div class="col-6 text-end"> هاتف</div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="border-bottom:none !important; ">
                                        <div class="row">
                                            <div class="col-6 text-start">MOBILE:</div>
                                            <div class="col-6 text-end"> متحرك</div>
                                        </div>
                                    </th>
                                </tr>
                                {{-- <tr>
                                    <th>
                                        <div class="row">
                                            <div class="col-6 text-start">E-MAIL:</div>
                                            <div class="col-6 text-end">بريد إلكتروني</div>
                                        </div>
                                    </th>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="col-4  pt-3" style=" border-width: 2px; margin-top: -16px; font-size: 12px; ">
                        <b class="align-items-center justify-content-center shipment-info">

                            {{ $shipment->receiver->name }} ,
                            {{ $shipment->receiver->address->address }},
                            {{ $shipment->receiver->post?$shipment->receiver->post.',':'' }}
                            <br>
                            {{ $shipment->receiver->city_name ? $shipment->receiver->city_name.',': ''}}
                            {{ $shipment->receiver->address->district ? $shipment->receiver->address->district->name .',': ''}}
                            {{ $shipment->receiver->address->district ? $shipment->receiver->address->state->name .',': ''}}
                            {{ $shipment->receiver->address->country_id ? $shipment->receiver->address->country->name.',' : ''}}<br>
                            {{$shipment->receiver->address ? 'PIN:-'.$shipment->receiver->address->zip_code.',' : ''}}
                             MOB:
                            +{{ $shipment->receiver->country_code_whatsapp}} {{ $shipment->receiver->whatsapp_number }},
                            +{{ $shipment->receiver->country_code_phone}} {{ $shipment->receiver->phone }},
                            <br>
                            id - {{ $shipment->receiver->identification_number }}
                            {{-- <span style="text-transform:lowercase !important;">{{ $shipment->receiver->user ? $shipment->receiver->user->email : ''}}</span> --}}

                        </b>
                    </div>
                    {{-- <div class="col-2 " style="border:solid; border-top:none; border-width: 3px; margin-top: -16px;">
                        <table class="table" >
                            <tbody  class="tb_checkbox">
                                <tr><td>DOCUMENTS <span style="padding-left:10px; ">وثائق</span><input type="checkbox" class="ml-3"></td></tr>
                                <tr><td>INSURANCE <span style="padding-left:16px; ">تأمين</span><input type="checkbox" class="ml-3"></td></tr>
                                <tr><td>EXPRESS <span style="padding-left:36px; ">يعبر</span><input type="checkbox" class="ml-3"></td></tr>
                                <tr><td>PARCEL <span style="padding-left:33px; ">قطعة</span><input type="checkbox" class="ml-3"></td></tr>
                            </tbody>
                        </table>
                    </div> --}}
                </div>
                <div class="row " style="margin-left: 0px; " >
                    <div class="col-12 text-center" style="background: #0070c0;border-top:1px solid #000;">
                        <div class="mt-1"><h6 style="color: #fff">SHIPMENT INFORMATION</h6></h5>
                    </div>
                </div>
            </div>


            <div class="row item_table">
                <div class="col-8"  >
                    <table class="table  pacling_list">
                        <thead >
                            <tr>
                                <th style="background:#00b050; padding: 8px !important;"> <div class="row text-white"><div class="col-6 text-start">DESCRIPTION</div><div class="col-6 text-end">عنوان الشاحن</div></div> </th>
                                <th style="background:#00b050; text-align:center; border-bottom: 2px solid #000; "><span>Quantity </span> </th>
                                <th style="background:#00b050; text-align:center; border-bottom: 2px solid #000; "> <span> Unit Rate</span></th>
                                <th style="background:#00b050; text-align:center; border-bottom: 2px solid #000; border-right: none !important;"> <span>Amount</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">Freight charge</div>
                                        <div class="col-6 text-end" >رسوم الشحن</div>
                                    </div>
                                </th>
                                <td>{!! $shipment->grand_total_weight ?? '<span style="color:#fff;">0</span>' !!}</td>
                                <td>{!! $shipment->rate_normal_weight ?? ' <span style="color:#fff;">0</span>' !!}</td>
                                <td>{!! $shipment->amount_normal_weight ?? '<span style="color:#fff;">0</span> ' !!}</td>
                            </tr>
                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">Duty</div>
                                        <div class="col-6 text-end" >واجب</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->electronics_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->rate_electronics_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->amount_electronics_weight ?? ' <span style="color:#fff;">0</span>'!!}</td>
                            </tr>
                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">Packing charge</div>
                                        <div class="col-6 text-end">تهمة التعبئة</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->msic_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->rate_msic_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->amount_msic_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                            </tr>

                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">Add-Packing charge</div>
                                        <div class="col-6 text-end"> رسوم التعبئة الإضافية</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->add_pack_charge ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->rate_add_pack_charge ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->amount_add_pack_charge ??'<span style="color:#fff;">0</span> '!!}</td>
                            </tr>
                            <tr>
                                <th><div class="row">
                                    <div class="col-6 text-start">Insurance</div>
                                    <div class="col-6 text-end">تأمين</div>
                                </div></th>
                                <td>{!! $shipment->insurance ?? '<span style="color:#fff;">0</span>' !!}</td>
                                <td>{!!$shipment->rate_insurance ?? ' <span style="color:#fff;">0</span>'!!}</td>
                                <td>{!!$shipment->amount_insurance ?? ' <span style="color:#fff;">0</span>'!!}</td>
                            </tr>
                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">AWB Fee</div>
                                        <div class="col-6 text-end">رسوم بوليصة الشحن الجوي</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->awbfee ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->rate_awbfee ?? ' <span style="color:#fff;">0</span>'!!}</td>
                                <td>{!!$shipment->amount_awbfee ?? '<span style="color:#fff;">0</span> '!!}</td>
                            </tr>
                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">VAT Amount</div>
                                        <div class="col-6 text-end">قيمة الضريبة</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->vat_amount ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->rate_vat_amount ?? ' <span style="color:#fff;">0</span>'!!}</td>
                                <td>{!!$shipment->amount_vat_amount ?? ' <span style="color:#fff;">0</span>'!!}</td>
                            </tr>

                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">Volume weight</div>
                                        <div class="col-6 text-end">وزن الحجم</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->volume_weight ?? ' <span style="color:#fff;">0</span>'!!}</td>
                                <td>{!!$shipment->rate_volume_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->amount_volume_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                            </tr>

                            <tr>
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">Discount</div>
                                        <div class="col-6 text-end">تخفيض</div>
                                    </div>
                                </th>
                                <td>{!!$shipment->discount_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->rate_discount_weight ?? '<span style="color:#fff;">0</span> '!!}</td>
                                <td>{!!$shipment->amount_discount_weight ?? ' <span style="color:#fff;">0</span>'!!}</td>
                            </tr>

                            <tr style="border-bottom: 2px solid #000; border-left:none !important;">
                                <th>
                                    <div class="row">
                                        <div class="col-6 text-start">No.of Pcs</div>
                                        <div class="col-6 text-end"> كمية</div>
                                    </div>
                                </th>
                                <td colspan="3">
                                    {{ $shipment->number_of_pcs ? $shipment->number_of_pcs : ($shipment->number_of_pcs_create ? $shipment->number_of_pcs_create : 0) }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3"><h6>TOTAL AMOUNT (AED)</h6></td>
                                <td><h6>{{$shipment->amount_grand_total}}</h6></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-4 #00b050">
                    <div class="row text-center spcl_remark spcl_remark1" style="border:1px solid #000; border-right: none;  margin-left: -25px; margin-right: -24px; height:28px; "  >
                        <b class="" style=" color:#fff; background:#00b050 " ><div class="row" style="padding: 5px !important;"><div class="col-6 text-start">SPECIAL REMARKS</div><div class="col-6 text-end">كلمة خاصة</div></div></b>
                    </div>
                    <div class="row text-center blank_row spcl_remark align-items-center justify-content-center" style="border:1px solid #000; border-top:none;border-left: none !important; border-right: none; margin-left: -25px; margin-right: -24px; height: 38%; max-height: 38% !important; ">
                        <p>
                            {{$shipment->special_remarks?? ''}}
                        </p>

                    </div>
                    <div class="row text-center spcl_remark home_del" style="border:1px solid #000; border-top:none; border-right: none;border-left: none !important; margin-left: -25px; margin-right: -24px;">
                        <b style="padding: 6px;">HOME DELIVERY -NOT FOR SALE</b>
                    </div>
                    <div class="row text-center spcl_remark ind_air1" style="border:1px solid #000; border-top:none; border-right: none;border-left: none !important; margin-left: -25px; margin-right: -24px;">
                        <p style="padding: 10px;">INDIA-AIR CARGO ESTIMATED DELIVERY TIME -10-15 WORKING DAYS,  وقت الهندي الجوي الشح التسليم المقدر 15-10- يوم عمل</p>
                    </div>
                    <div class="row text-center spcl_remark ind_air2" style="border:1px solid #000; border-top:none; border-right: none;border-left: none !important; margin-left: -25px; margin-right: -24px; margin-top: 2px;">
                        <p style="padding: 10px;">INDIA-SEA CARGO ESTIMATED DELIVERY TIME 45-60 WORKING DAYS, وقت الهندي البحري الشحن التسليم المقدر 60-45 يوم عمل</p>
                    </div>
                    <div class="row text-center value_goods spcl_remark" style="border:1px solid #000; border-top:none; border-right: none;border-left: none !important; margin-left: -25px; margin-right: -24px;">
                        <div class="col-7 value_goods1" style="padding:11px;">
                            <b >VALUE OF GOODS (AED) </b>

                        </div>
                        <div class="col-1 vr_line"  style="border-left: 2px solid #000; height: 38px"></div>
                        <div class="col-3" style="padding-top:8px;" >
                            <h6>{{$shipment->value_of_goods??''}}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4 ">
                <div class="col-6 footer">
                    <div class="col-10 ml-4 foot_eng" style="margin-top: -25px; text-align: justify; line-height: 13px;">
                        <p><b>DECLARATION,</b></p>
                        <b>TERMS & CONDITIONS</b>
                        <p>Complaints will not be accepted after three days from the date of delivery.
                            No Guarantee for Glassware's and Electronics items which does not original
                            company packing or wooden packing.
                        </p>
                        <p>* Maximum payback for total loss will be Dhs. 20/- per kilogram.</p>
                        <p>* I consent to send promotional messages to my given number.</p>
                        <p>* In case of any delay due to customs clearance in destination country,
                            customer should wait until it's solved
                        </p>
                    </div>
                </div>
                <div class="col-6" style="text-align: right !important; line-height: 13px;">
                    <p style="margin-top: -21px;"><b>تصرٌح،</b></p>
                    <p><b>البنود و الظروف</b></p>
                    <p>لن ٌتم قبول الشكاوى بعد مرور ثالثة أٌام من تارٌخ التسلٌم</p>
                    <p>ال ٌوجد ضمان على األوانً الزجاجٌة واإللكترونٌات التً ال تحتوي على عبوات
                        أصلٌة من الشركة أو عبوات خشبٌة.
                    </p>
                    <p> الحد األقصى السترداد إجمالً الخسارة سٌكون درهماً . 20 جنٌ ًها للكٌلو جرام *</p>
                    <p> أوافق على إرسال رسائل تروٌجٌة إلى رقمً المحدد *</p>
                    <p>  فً حالة وجود أي تأخٌر بسبب التخلٌص الجمركً فً بلد المقصد، ٌجب على *</p>
                    <p>العمٌل االنتظار حتى ٌتم حل المشكلة</p>

                </div>

            </div>
            <div class="row pt-2 ml-3">
                <div class="col-6">
                    <p>FOR ARAFA CARGO LLC ………………………………………………………</p>
                    <br>
                    <p>COMPUTERISED INVOICE , DOEST NOT REQUIRED SIGNATURE</p>
                </div>
                <div class="col-6">
                    <p>SHIPPER SIGNATURE ……………………………………………
                    </p>
                </div>
            </div>
            <div class="row bottom_table" style=" width:98%; margin-left: 13px; ">
                <div class="" style="border-left:2px solid #000;">
                    <table class="table text-center" style="margin-left: -27px; width: 104%; margin-bottom: 0px;border-color: #000;                    " >
                        <thead style=" background:#0070c0; border-top:2px solid #000; ">
                            <tr>
                                <th style="border-right: 1px solid #000">ABUDHABI </th>
                                <th style="border-right: 1px solid #000">AL AIN</th>
                                <th style="border-right: 1px solid #000"> MUSAFFAH</th>
                            </tr>
                        </thead>
                        <tbody style="border-right: 1px solid #000;">
                            <tr>
                                <td style="background: #00b050; color: #fff;border-right: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">NEAR NMC HOSPITAL , MADINAT ZAYED </td>
                                <td style="background: #00b050; color: #fff;border-right: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">KHALIFA STREET , OPPO: RAK BANK</td>
                                <td style="background: #00b050; color: #fff;border-right: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">SHABIYA 11 , NEAR EXTEL MOBILE
                                </td>
                            </tr>
                            <tr>
                                <td>02-5659017</td>
                                <td>03 7640664</td>
                                <td>02 5659017</td>
                            </tr>
                            <tr>
                                <td>056 5441003</td>
                                <td>050 7530694</td>
                                <td>054 4320240</td>
                            </tr>
                            <tr>
                                <td>056 5463000</td>
                                <td>055 7176243</td>
                                <td>054 3225594</td>
                            </tr>
                            <tr >
                                <td colspan="3" style="background: #0070c0; color: #fff; border-top:1px solid #000; text-transform: lowercase;"> <b>www.arafacargo.com</b></td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
    <script>
        JsBarcode("#barcode", "<?php echo $shipment->booking_number ?>",{
            width: 2,
            height: 50,
            fontSize: 30,
        });
        function printPDF() {
            // Hide the print button while printing
            document.getElementById('printButton').style.display = 'none';

            // Print the content
            window.print();

            // Show the print button again after printing is done
            document.getElementById('printButton').style.display = 'block';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

@if(isset($shipment->boxes))
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <style>
        @media print{
            body{
                width: 1100px !important;
            }
            .main{
                size: a4;
            }
            #printButton{
                display: none;
            }
            .address-line {
        word-wrap: break-word; /* Break long words at the container's edge */
        white-space: normal; /* Allow line breaks */
        max-width: 400px !important; /* Set a maximum width to control where text wraps */
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
      .

      #printButton:hover {
          background-color: #009eb3;
      }

      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .headermaindiv{
            display: flex;
            justify-content: space-evenly;
        }
        .header img {
            /* max-width: 120px;
            margin-bottom: 10px; */
            max-height: 150px;
        }
        .headerh1 {
            font-size: 22px;
            margin: 0;
        }
        .header p {
            font-size: 12px;
            margin: 5px 0;
        }
        .contact-info {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }
        .notes {
            font-size: 10px;
            margin-top: 10px;
        }
        .notes p {
            margin: 5px 0;
        }
        .signature {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
        }
        .signature div {
            display: inline-block;
            width: 30%;
        }
        .logotext{
            color: #262262;
        }
        .mail-div{
            display: flex;
            justify-content: space-around;
        }
        .tabledata {
            height: 30px;
        }
        .tableheadBackground {
            background-color: #d8d5de;
            color: #262262;
        }
        .shiptd{
            height: 150px;
            justify-content: start;

        }
        .ship-consi-maindiv {
            display: flex;
            border: 1px solid #262262;
            height: 150px;
            justify-content: space-around;
            position: relative; /* Needed for positioning the pseudo-element */
            text-align: center;
        }

        .ship-consi-maindiv::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 1px;
            background-color: #262262;
            transform: translateX(-50%);
        }
        .shipper-div{
            font-size: small;
        }
        .consignee-div{
            font-size: small;
        }
        .main-small-div{
            display: flex;
            /* border-left: 1px solid #262262; */
            margin-bottom: 5px;
        }
        .small-div{
            height: 25px;
            border-right:1px solid #262262;
            border-bottom: 1px solid#262262;
            width: 27px;
        }
        .sp-small-div{
            height: 25px;
            border-right:1px solid #262262;
            border-bottom: 1px solid#262262;
            width: 25px;
            background-color: #d8d5de;
            text-align: center;
            font-size: x-small;
            padding-top: 5px;
        }
        .tablemaindiv{
            display: flex;
            gap: 5px;

        }
        .tablefirstrow{
            width:45px ;
        }
        .dec-value-main{
            display: flex;
            gap: 10px;
            height: 35px;
            width: 450px;
            border: 1px solid#262262;
        }
        .dec1-value{
            background-color:#d8d5de;
            width: fit-content;
            padding: 5px 5px 0px 5px;
        }
        .dec2-value{
            width: 10px;
        }
        .text{
            color: #262262;
        }
        p{
            color: #262262;
        }
        td{
            color: #262262;
        }
        th{
            color: #262262;
        }
        div{
            color: #262262;
        }
        .headarabic{
            color: red;
        }
        .mailimg{
            margin: 10px 3px 10px 3px;
        }
        .whatsappimg{
            margin: 3px 3px 3px 3px;
        }
        .contact-sub{
            display: flex;
        }
        .main{
            margin: 40px;
        }
        .address-line {
            overflow-wrap: break-word; /* Break long words */
            hyphens: auto; /* Add hyphens where possible */
        white-space: normal; /* Allow line breaks */
        max-width: 600px; /* Set a maximum width to control where text wraps */
        text-transform: capitalize !important;
    }
    </style>
</head>

<body style="overflow-x: hidden; " >

    <button id="printButton" onclick="printPDF()">Print</button><br>
    {{-- <button id="printTiff" >TIFF</button> --}}
{{-- @dd($shipment) --}}
<a href="#" id="btn-Convert-Html2Image" onclick="printTIFF()" class="btn btn-info" style="display:none;">TIFF</a>

    <div id="myElement" inv_no={{$shipment->booking_number}}>
        <div class="main">
            <div class="row mt-5">
                <div class="headermaindiv">
                <div class="header">
                    <img src="{{isset($shipment->agency->logo)?asset($shipment->agency->logo):'' }}" alt="Logo">
                   <i><p class="logotext">"where every shipment tells a story"</p></i>
                </div>
                <div class="header">
                    <h1 class="headerh1">Gulfinternational Cargo Packaging L.L.C</h1>
                    <h1 class="headarabic">الخليج الدولية لتغليف البضائع ذ.م.م</h1>
                    <p>UAE | KSA | INDIA | SRILANKA</p>
                    <div class="mail-div">
                        <div  class="mail-div">
                            <img class="mailimg" src="assets/Images/global.png" height="10px" alt="" >
                            <p>www.gulfcargouae.com</p>
                        </div>
                       <div class="mail-div">
                        <img class="mailimg" src="assets/Images/gmail.png" height="10px" alt="">
                        <p>gulfcargouae@gmail.com</p>
                    </div>

                    </div>
                </div>

                <div class="contact-info">
                  <div class="contact-sub">

                    <p>+971 50 873 5100</p>
                    <img class="whatsappimg" src="assets/Images/whatsapp.png" alt="" height="20px">
                  </div>
                  <div class="contact-sub">

                    <p>+971 50 469 7200</p>
                    <img class="whatsappimg" src="assets/Images/whatsapp.png" alt="" height="20px">
                  </div>


                </div>
                 </div>
                 <div class="table-responsive">
                    <table style="border: 1px solid#262262;">
                        <tr>
                            <th class="tableheadBackground">Date</th>
                            <th class="tableheadBackground">Origin</th>
                            <th class="tableheadBackground">Destination</th>
                            <th class="tableheadBackground">No. Pcs</th>
                            <th class="tableheadBackground">Weight</th>
                            <th class="tableheadBackground">Mode of Shipment</th>
                            <th class="tableheadBackground">Airway Bill</th>
                        </tr>
                        <tr>
                            <th class="tabledata">{{!empty($shipment->created_date)? date('d-m-Y', strtotime($shipment->created_date)):''}}</th>
                            <th>DUBAI</th>
                            <th>INDIA</th>
                            <th>{{ $shipment->number_of_pcs ? $shipment->number_of_pcs : ($shipment->number_of_pcs_create ? $shipment->number_of_pcs_create : 0) }}</th>
                            <th>{{ round($shipment->grand_total_weight, 2) }}</th>
                            <th>{{ $shipment->shipMethType ? $shipment->shipMethType->name : '' }}</th>
                            <th>{{$shipment->booking_number}}</th>
                        </tr>
                    </table>


                <div class="ship-consi-maindiv">
                    <div class="shipper-div">
                        <b>SHIPPER'S NAME AND ADDRESS:</b><br>
                        <h6>
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
                        </h6>
                    </div>
                    <div class="consignee-div">
                        <b>CONSIGNEE'S NAME AND ADDRESS:</b>
                        <h6>
                            {{ $shipment->receiver->name }} ,<br>
                           <div class="address-line">
                                {{ strtolower($shipment->receiver->address->address )}},
                            </div>
                            {{ $shipment->receiver->post?$shipment->receiver->post.',':'' }}
                            
                            {{ $shipment->receiver->city_name ? $shipment->receiver->city_name.',': ''}}
                            {{ $shipment->receiver->address->district ? $shipment->receiver->address->district->name .',': ''}}
                            {{ $shipment->receiver->address->district ? $shipment->receiver->address->state->name .',': ''}}
                            {{ $shipment->receiver->address->country_id ? $shipment->receiver->address->country->name.',' : ''}}<br>
                            {{$shipment->receiver->address ? 'PIN:-'.$shipment->receiver->address->zip_code.',' : ''}}
                             MOB:
                            +{{ $shipment->receiver->country_code_whatsapp}} {{ $shipment->receiver->whatsapp_number }},
                            +{{ $shipment->receiver->country_code_phone}} {{ $shipment->receiver->phone }},
                            <br>
                            ID - {{ $shipment->receiver->identification_number }}
                            {{-- <span style="text-transform:lowercase !important;">{{ $shipment->receiver->user ? $shipment->receiver->user->email : ''}}</span> --}}
                        </h6>
                    </div>
                </div>
            </div>
                <div class="main-small-div">
                    <div class="sp-small-div" style="border-left: 1px solid #262262;">T</div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="sp-small-div">M</div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="sp-small-div">T</div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="sp-small-div">M</div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                    <div class="small-div"></div>
                </div>
                <div class="tablemaindiv">
    <!-- First Table for Odd Rows -->
    <div class="w-50">
        <table class="table table-responsive text-center" style="width: 100%">
            <thead>
                <tr>
                    <th class="tablefirstrow">S.No</th>
                    <th>Box No</th>
                    <th>Weight</th>
                    <th>Items List</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $prevBoxId = null;
                    $color = 'background-color: #FFFFFF'; // Default row color
                @endphp
                @foreach ($shipment->boxes as $index => $box)
                    @foreach ($box->packages as $packageIndex => $item)
                        @if (($index + $packageIndex) % 2 === 0) <!-- Odd Row -->
                            @php
                                // Alternate row color
                                $color = ($color === 'background-color: #C0C0C0') ? 'background-color: #FFFFFF' : 'background-color: #C0C0C0';
                            @endphp
                            <tr>
                                <td style="{{ $color }}">{{ $index + $packageIndex + 1 }}</td>
                                <td style="{{ $color }}">{{ $box->box_name }}</td>
                                <td style="{{ $color }}">{{ $box->weight }} kg</td>
                                <td style="{{ $color }}">
                                    {{ $item->description }} - {{ $item->quantity }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Second Table for Even Rows -->
    <div class="w-50">
        <table class="table table-responsive text-center" style="width: 100%">
            <thead>
                <tr>
                    <th class="tablefirstrow">S.No</th>
                    <th>Box No</th>
                    <th>Weight</th>
                    <th>Items List</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $prevBoxId = null;
                    $color = 'background-color: #FFFFFF'; // Default row color
                @endphp
                @foreach ($shipment->boxes as $index => $box)
                    @foreach ($box->packages as $packageIndex => $item)
                        @if (($index + $packageIndex) % 2 === 1) <!-- Even Row -->
                            @php
                                // Alternate row color
                                $color = ($color === 'background-color: #C0C0C0') ? 'background-color: #FFFFFF' : 'background-color: #C0C0C0';
                            @endphp
                            <tr>
                                <td style="{{ $color }}">{{ $index + $packageIndex + 1 }}</td>
                                <td style="{{ $color }}">{{ $box->box_name }}</td>
                                <td style="{{ $color }}">{{ $box->weight }} kg</td>
                                <td style="{{ $color }}">
                                    {{ $item->description }} - {{ $item->quantity }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <table>
                            <tr>
                                <td class="w-50">Total</td>
                                <td></td>
                            </tr>
                            <tr>
                                @if (isset($shipment->amount_electronics_weight) && $shipment->amount_electronics_weight != 0)
                                    <td>Duty</td>
                                    <td>{{ $shipment->amount_electronics_weight }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                @if (isset($shipment->amount_msic_weight) && $shipment->amount_msic_weight != 0)
                                    <td>Packing charge</td>
                                    <td>{{ $shipment->amount_msic_weight }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                @if (isset($shipment->amount_add_pack_charge) && $shipment->amount_add_pack_charge != 0)
                                    <td>Additional Packing charge</td>
                                    <td>{{ $shipment->amount_add_pack_charge }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                @if (isset($shipment->amount_insurance) && $shipment->amount_insurance != 0)
                                    <td>Insurance</td>
                                    <td>{{ $shipment->amount_insurance }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                @if (isset($shipment->amount_awbfee) && $shipment->amount_awbfee != 0)
                                    <td>AWB Fee</td>
                                    <td>{{ $shipment->amount_awbfee }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                @if (isset($shipment->amount_volume_weight) && $shipment->amount_volume_weight != 0)
                                    <td>Volume weight</td>
                                    <td>{{ $shipment->amount_volume_weight }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                @if (isset($shipment->amount_discount_weight) && $shipment->amount_discount_weight != 0)
                                    <td>Discount</td>
                                    <td>{{ $shipment->amount_discount_weight }}</td>
                                @endif
                            </tr>
                            
                            <tr>
                                <td>VAT %</td>
                                <td>{{$shipment->amount_vat_amount}}</td>
                            </tr>
                            <tr>
                                <td>Net Total</td>
                                <td>{{$shipment->amount_grand_total}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <center>
                <div class="dec-value-main">
                    <div class="dec1-value">Declared Value (AED)</div>
                    <div class="dec2-value"><p style="margin-top:5px; ">{{$shipment->value_of_goods}}</p> </div>
                </div>
            </center>
                <div class="notes">
                    <p><strong>TERMS AND CONDITIONS:</strong></p>
                    <p>Any complaints regarding this consignment should be reported within five days. <br>
                         Complaints will not be entertained after five days of delivery date. <br>
                         GULF INTERNATIONAL CARGO L.L.C is not responsible for any damage of the items at the time of delivery. <br>
                          GULF INTERNATIONAL CARGO L.L.C is not responsible for the shipment delay due to the government authorities or natural calamities. <br>
                           Maximum payback for total lost will be Dhs.20/- per Kilogram. <br>
                            Total cargo value should not be above INR 20,000/-.</p>

                    <p><strong class="mt-3">CUSTOMER DECLARTION:</strong></p>
                    <p>I, {{ $shipment->sender->name }}, holder of Emirates ID number: {{ $shipment->sender->identification_number }}, hereby declare that all the above-said items are my personal effects/home appliances sending to my Family Mr./Mrs. {{ $shipment->receiver->name }} through GULF INTERNATIONAL CARGO L.L.C, P.O BOX, Dubai, United Arab Emirates vide their waybill number: ______ which is sent as the unaccompanied baggage of an international passenger. If any extra duty/penalties occurs I am bound to pay the amount concerned.</p>
                </div>

                <div class="signature">
                    <div>Signature of Shipper</div>
                    <div>Signature of Consignee</div>
                    <div>For GULF INTERNATIONAL CARGO L.L.C</div>
                </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>



        function printPDF() {
            // Hide the print button while printing
            document.getElementById('printButton').style.display = 'none';
            // document.getElementById('printTiff').style.display = 'none';

            // Print the content
            window.print();

            // Show the print button again after printing is done
            document.getElementById('printButton').style.display = 'block';
            // document.getElementById('printTiff').style.display = 'block';

        }
    </script>
 <script src="https://cdn.jsdelivr.net/npm/utif@2.0.1/UTIF.min.js"></script>
 <script src="https://unpkg.com/compressorjs@latest/dist/compressor.min.js"></script>
 <script>

$(document).ready(function () {
    $("#printTiff").on('click', async function () {
        $("#printTiff").css('display', 'none');
        $(".main_div").css({
            "margin-left": "25px",
            "margin-right": "80px"
        });
        $(".above_main_div").css({
            "width": "900px",
            "padding-top": "5px",
            "padding-bottom": "10px"
        });

        var totalInvoice = Number("<?php echo count($shipment->boxes) ?>");
        function delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        // Function to print each TIFF
        async function printAllTIFFs() {
            for (let i = 0; i < totalInvoice; i++) {
                await printTIFF(i); // Await each printTIFF operation
                // await delay(2000);
            }
            // await printTIFF(1);
        }

        try {
            // Call the function to print all TIFFs
            await printAllTIFFs();

            // After all TIFFs are printed, reload the page
            // window.location.reload();
        } catch (error) {
            console.error('Error printing TIFFs:', error);
            // Handle errors if necessary
        }
    });
});

function printTIFF(a) {
    return new Promise((resolve, reject) => {
        var element = document.getElementById('myElement' + a);
        if (!element) {
            reject(new Error('Element not found'));
            return;
        }
        var inv_no = element.getAttribute('inv_no' + a);
        var rect = element.getBoundingClientRect();
        var scaleFactor = 9; // Adjusted scale factor to reduce size
        var marginRight = 450;
        var marginTop = 100;
        var marginBottom = 35;

        // Create a wrapper element to apply the margin
        var wrapper = document.createElement('div');
        wrapper.style.marginLeft = marginRight + 'px';
        wrapper.style.marginTop = marginTop + 'px';
        wrapper.style.paddingBottom = marginBottom + 'px';
        wrapper.appendChild(element.cloneNode(true)); // Clone the element to avoid moving the original one

        // Append the wrapper temporarily to the body to measure it
        document.body.appendChild(wrapper);
        var wrapperRect = wrapper.getBoundingClientRect();
        domtoimage.toPng(wrapper, {
            width: 8000,
            height: 11400,
            style: {
                transform: 'scale(' + scaleFactor + ')',
                transformOrigin: 'top left'
            },
            quality: 1, // Adjusted quality to reduce size
        })
        .then((dataUrl) => {
            // Create a Blob from the dataUrl
            fetch(dataUrl)
                .then(res => res.blob())
                .then((blob) => {
                    new Compressor(blob, {
                        quality: 10, // Lower quality for smaller size
                        maxWidth: 1050, // Resize if necessary
                        success(result) {
                            const compressedImg = new Image();
                            compressedImg.src = URL.createObjectURL(result);

                            compressedImg.onload = function() {
                                const compressedCanvas = document.createElement('canvas');
                                compressedCanvas.width = compressedImg.width;
                                compressedCanvas.height = compressedImg.height;

                                const compressedCtx = compressedCanvas.getContext('2d');
                                compressedCtx.drawImage(compressedImg, 0, 0);

                                const imageData = compressedCtx.getImageData(0, 0, compressedCanvas.width, compressedCanvas.height);
                                const rgbaData = imageData.data;

                                const tiffData = UTIF.encodeImage(rgbaData, compressedCanvas.width, compressedCanvas.height, 8, 3);
                                const tiffBlob = new Blob([tiffData], { type: 'image/tiff' });

                                const a = document.createElement('a');
                                a.href = URL.createObjectURL(tiffBlob);
                                a.download = inv_no+'.tif';
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);

                                // Resolve the promise once the operation completes
                                resolve();
                            };
                        },
                        error(err) {
                            console.error(err.message);
                            reject(err); // Reject promise on error
                        },
                    });
                });
        })
        .catch((error) => {
            console.error('Error:', error);
            reject(error); // Reject promise on error
        })
        .finally(() => {
            // Clean up: remove the wrapper element from the body
            document.body.removeChild(wrapper);
        });
    });
}

 </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
@endif

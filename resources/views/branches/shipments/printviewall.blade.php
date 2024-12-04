<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image-more@2.8.0/dist/dom-to-image-more.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <link rel="stylesheet" href="{{asset('assets/css/printview.css')}}">

</head>

<body style="overflow-x: hidden;" >

    <button id="printButton" onclick="printPDF()">Print</button><br>
    <button id="printTiff" >TIFF</button>
    @php
        $first_loop = true;
    @endphp

@foreach ($shipments as $i=>$item)

<a href="#" id="btn-Convert-Html2Image" onclick="printTIFF({{$i}})" class="btn btn-info" style="display:none;">TIFF</a>

    <div class=" mt-2 {{ $first_loop == false ? 'printable-invoice' : 'p-3 ' }}" id="html-content-holder{{$i}}"  >
        <div class="above_main_div" id="myElement{{$i}}" inv_no{{$i}}={{$item->box_name}} style="background-color: #fff !important; display: flex; justify-content: center; " >
            <div class="main_div " >
                <div class="row">
                    <div class="col-5 mt-4 ml-4 header">
                        <div  style="float:left;">
                            <img src="{{asset($agency->logo) }}" alt="Bestexpress"  class="img-responsive logo" >
                        </div><br><br><br><br>
                            <h6 class="text-uppercase">DIVISION OF {{$agency->name}},
                                {{$agency->address}},
                                {{$agency->district}},
                                PIN:- {{$agency->pincode}}</h6>
                    </div>
                    <div class="col-3 d-flex align-items-center" style="justify-content: right !important" >
                        <h2 class="inv_no">INV NO </h2>
                    </div>
                    <div class="col-3 d-flex align-items-center justify-content-center" >
                        <svg id="barcode{{$loop->index}}"></svg>

                        {{-- <h1 class="inv_no">{{ $shipment->booking_number }} </h1> --}}
                    </div>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead  class="table_head">
                            <tr>
                                <th>DATE</th>
                                <th>REF NO. </th>
                                <th>PKG</th>
                                <th>WGHT</th>
                                <th>ORIGIN</th>
                                <th>DESTINATION</th>
                                <th>AWB NO:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                                <td>{{ $item->box_name}} </td>
                                <td>1</td>
                                <td>{{ round($item->weight, 2) }}</td>
                                <td>UAE</td>
                                <td>COK</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <thead class="table_head head_frm_to">
                                <tr>
                                    <th class="col-4 text-center" > FROM ADDRESS</th>
                                    <th class="col-4 text-center" >TO ADDRESS</th>
                                    <th class="col-4 text-center" >SERVICE</th>
                                </tr>
                            </thead>

                        </table>

                    </div>
                    <div class="row adress_table" style="margin-left: 3px;">
                        <div class="col-2 adress_table_first_div" >
                            <table class="table">
                                <tbody>
                                        <tr><td>ADDRESS</td></tr>
                                        <tr><td>ZIP/ POST CODE</td></tr>
                                        <tr><td>STATE/ PROVINCE</td></tr>
                                        <tr><td>COUNTRY</td></tr>
                                        <tr><td>TEL:</td></tr>
                                        <tr><td>MOBILE:</td></tr>
                                        <tr><td> E-MAIL:</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3 mt-1 adress_table_sec_div" >
                            <b class="align-items-center justify-content-center shipment-info">
                                {{ $item->sender_name ? $item->sender_name  : ''}} ,
                                {{ $item->sender_address ? $item->sender_address : '' }},<br>
                                {{$item->sender_address ? 'PIN:-'.$item->sender_pin : '' }},
                                <br> MOB:
                                {{ $item->sender_mob ? $item->sender_mob : ''}} <br>
                                ID: {{$item->sender_id_no ? $item->sender_id_no : ''}}
                                <br>
                            </b>
                        </div>
                        <div class="col-2 adress_table_thrd_div" >
                            <table class="table">
                                <tbody>
                                        <tr><td>ADDRESS</td></tr>
                                        <tr><td>ZIP/ POST CODE</td></tr>
                                        <tr><td>STATE/ PROVINCE</td></tr>
                                        <tr><td>COUNTRY</td></tr>
                                        <tr><td>TEL:</td></tr>
                                        <tr><td>MOBILE:</td></tr>
                                        <tr><td> E-MAIL:</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-3 mt-1 adress_table_frth_div" >
                            <b class="align-items-center justify-content-center shipment-info">
                                {{ $item->receiver_name ? $item->receiver_name  : ''}} ,
                                {{ $item->receiver_address ? $item->receiver_address : '' }},<br>
                                {{$item->receiver_address ?'PIN:-'. $item->receiver_pin : '' }},
                                <br> MOB:
                                {{ $item->receiver_mob ? $item->receiver_mob : ''}} <br>
                                ID: {{$item->receiver_id_no ? $item->receiver_id_no : ''}}

                                <br>
                            </b>
                        </div>
                        <div class="col-2 adress_table_fifth_div" >
                            <table class="table" >
                                <tbody  class="tb_checkbox">
                                    <tr><td>DOCUMENTS <input type="checkbox" class="ml-3 service_1"></td></tr>
                                    <tr><td>INSURANCE <input type="checkbox" class="ml-3 service_2"></td></tr>
                                    <tr><td>EXPRESS<input type="checkbox" class="ml-3 service_3"></td></tr>
                                    <tr><td>PARCEL<input type="checkbox" class="ml-3 service_4"></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="mt-1"><b>PACKING LIST</b></h5>
                    </div>
                </div>

                <div class="row item_table">
                    <div class="col-6">
                        <table class="table text-center pacling_list">
                            <thead>
                                <tr>
                                    <th>SI NO.</th>
                                    <th>ITEM DESCRIPTION</th>
                                    <th>QTY</th>
                                    <th>PRICE($)</th>
                                    <th class="tot_val_hed_1">TOTAL VALUE</th>
                                </tr>
                            </thead>
                        <tbody>

                            @php
                            $total_value1 = 0;
                            $total_item = count($item->packages);
                            if (gettype($total_item/2) == 'integer') {
                                $left_count = $total_item/2;
                                $right_count = $left_count;
                            }
                            else {
                                $left_count = intval($total_item/2) + 1;
                                $right_count = $total_item - $left_count;
                            }
                            $left_data = $item->packages->take($left_count);
                            $right_data = $item->packages->slice($right_count );
                        @endphp
                            @for ($i = 0; $i< $left_count ; $i++)
                            @php
                                $items = $left_data[$i];
                            @endphp
                            <tr>
                                <td class="sno">{{$i + 1}}</td>
                                <td>{{$items->description}}</td>
                                <td>{{$items->quantity}}</td>
                                <td>{{number_format($items->unit_price,2)}}</td>
                                <td class="tot_val_hed_1">{{$items->subtotal}}</td>

                            </tr>
                            @php
                            $total_value1 += $items->subtotal
                            @endphp
                        @endfor

                        </tbody>
                        </table>
                    </div>
                    <div class="col-6"  style="margin-left: -24px;">
                        <table class="table text-center pacling_list item_tbl_1" >
                            <thead >
                                <tr>
                                    <th class="sino_hed_2">SI NO.</th>
                                    <th>ITEM DESCRIPTION</th>
                                    <th>QTY</th>
                                    <th>PRICE($)</th>
                                    <th class="tot_val_hed_2">TOTAL VALUE</th>
                                </tr>
                            </thead>
                        <tbody>
                            @php
                                $total_value2 = 0;
                                $total_item = count($item->packages);
                                if (gettype($total_item/2) == 'integer') {
                                    $left_count = $total_item/2;
                                    $right_count = $left_count;
                                }
                                else {
                                    $left_count = intval($total_item/2) + 1;
                                    $right_count = $total_item - $left_count;
                                }
                                $left_data = $item->packages->take($left_count);
                                $right_data = $item->packages->slice($right_count );


                            @endphp
                                @for ($i = $left_count; $i< $total_item; $i++)
                                @php
                                    $items = $right_data[$i];
                                @endphp
                                <tr>
                                    <td class="sno">{{$i + 1}}</td>
                                    <td>{{$items->description}}</td>
                                    <td>{{$items->quantity}}</td>
                                    <td>{{number_format($items->unit_price,2)}}</td>
                                    <td class="tot_val_hed_2">{{$items->subtotal}}</td>

                                </tr>
                                @php
                                $total_value2 += $items->subtotal
                                @endphp
                            @endfor



                                <tr>
                                    <td colspan="4" class="text-center"><b>TOTAL CIF VALUE IN USD </b></td>
                                    <td class="tot_val_hed_2"><b>${{$total_value1 + $total_value2}}</b></td>
                                </tr>
                        </tbody>
                        </table>
                    </div>
                </div>




                <div class="row" style="margin-top: -14px;">
                    <div class="col-12 text-center hr_line_col"  >
                        <b >Total Values are Customs purpose only, not for commercial purpose REASON : GIFT</b>
                        <hr style="height: 1px;background-color: black; 0;opacity: inherit; margin:0px !important; ">
                    </div>

                </div>
                <div class="row mt-2 footer">
                    <div class="col-8">
                        <div class="col-10 ml-4 decl_left">
                            <p><b>CONSIGNOR DECLARATION AND AUTHORISATION</b></p>
                            I <b> {{ $item->sender_name ? $item->sender_name  : ''}} , {{ $item->sender_address ? $item->sender_address : '' }}, MOB: {{ $item->sender_mob ? $item->sender_mob : ''}} , ID: {{$item->sender_id_no ? $item->sender_id_no : ''}}</b>
                            <p>
                                hereby declare that the Courier gift parcel being sent by me through ARAFA CARGO LLC / DIVISION OF
                                {{$agency->name}} does not contain any Dangerous / Hazardous goods as per IATA
                                regulations and does not carry cash/ currency
                            </p>
                            <p>
                                I do here by declare that the goods sending by me include only Bonafide commercial samples prototypes /
                                documents and bonafide gift articles for personal use which are not subject to any prohibition or restriction on
                                their import to India.
                            </p>
                            <p>
                                I do here by declare that the particulars of contain are in regulation with the International courier laws of the
                                land at the consignee point also.
                            </p>
                            <p>
                                I do here by declare that the food items contained in the consignment are within the period of validity
                                prescribed under low.
                            </p>
                            <p>
                                I do here by appointed and authorize M/s {{$agency->name}} as my authorized courier agent to do the
                                courier baggage clearance at India on behalf of me.
                            </p>
                            <b>SIGNATURE:</b>
                        </div>
                    </div>
                    <div class="col-1 mb-4 d-flex align-items-center justify-content-center " >
                        <h1 style="padding-right: 30px !important;">POD</h1>
                    </div>
                    <div class="col-3 mb-4 " >
                        <table class="table">
                            <tr>
                                <td><p>
                                    I’the undersigned, on behalf of the above sender/shipper
                                    acknowledge the receipt of the goods in good condition.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>RECEIVER’S NAME</b>
                                </td>
                            </tr>
                            <tr>
                                <td>DATE:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIME:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; AM / PM:</td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    <b>SIGNATURE</b>
                                </td>
                            </tr> --}}
                        </table>
                    </div>
                    <div class="row"><div class="col-6 pb-1" style="text-align: right;"><b>For ARAFA CARGO LLC</b></div> <div class="col-6" style="text-align: center;"><b>SIGNATURE</b></div></div>
                </div>

            </div>
        </div>
    </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>

        JsBarcode("#barcode"+"<?php echo $loop->index ?>", "<?php echo $item->box_name ?>",{
            width: 2,
            height: 70,
            fontSize: 30
        });
        function printPDF() {
            // Hide the print button while printing
            document.getElementById('printButton').style.display = 'none';
            document.getElementById('printTiff').style.display = 'none';

            // Print the content
            window.print();

            // Show the print button again after printing is done
            document.getElementById('printButton').style.display = 'block';
            document.getElementById('printTiff').style.display = 'block';

        }
    </script>
     @php
        $first_loop = false;
    @endphp
 @endforeach
 <script src="https://cdn.jsdelivr.net/npm/utif@2.0.1/UTIF.min.js"></script>
 <script src="https://unpkg.com/compressorjs@latest/dist/compressor.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

 <script>
var  loop_count = 0;
var totalCount = Number("<?php echo count($shipments) ?>");

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

        var totalInvoice = Number("<?php echo count($shipments) ?>");

        // Function to print each TIFF
        async function printAllTIFFs() {
            for (let i = 0; i < totalInvoice; i++) {
                await printTIFF(i); // Await each printTIFF operation
            }
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

// async function printTIFF(index) {
//     return new Promise(async (resolve, reject) => {
//         var node = document.getElementById("myElement" + index);
//         if (!node) {
//             console.error("Element not found: myElement" + index);
//             reject(new Error("Element not found: myElement" + index));
//             return;
//         }

//         var inv_no = node.getAttribute('inv_no' + index);
//         var clone = node.cloneNode(true);
//         document.body.appendChild(clone);

//         var imgElements = clone.getElementsByTagName("img");
//         for (var i = 0; i < imgElements.length; i++) {
//             imgElements[i].src = imgElements[i].src; // Ensure the image src is correctly set
//         }

//         var svgElements = clone.getElementsByTagName("svg");
//         for (var i = 0; i < svgElements.length; i++) {
//             var svg = svgElements[i];
//             var serializer = new XMLSerializer();
//             var svgString = serializer.serializeToString(svg);
//             var img = new Image();
//             img.src = 'data:image/svg+xml;base64,' + window.btoa(svgString);
//             await new Promise((resolve) => img.onload = resolve);
//             svg.parentNode.replaceChild(img, svg);
//         }

//         var scaleFactor = 1.5; // Adjusted scale factor to reduce size
//         var marginRight = 520;
//         var marginTop = 100;
//         var marginBottom = 35;

//         // Create a wrapper element to apply the margin
//         var wrapper = document.createElement('div');
//         wrapper.style.marginLeft = marginRight + 'px';
//         wrapper.style.marginTop = marginTop + 'px';
//         wrapper.style.paddingBottom = marginBottom + 'px';
//         wrapper.appendChild(clone); // Use the cloned element

//         // Append the wrapper temporarily to the body to measure it
//         document.body.appendChild(wrapper);

//         try {
//             // Use html2canvas to render the HTML element to a canvas
//             const canvas = await html2canvas(wrapper, {
//                 scale: scaleFactor,
//                 useCORS: true // Use CORS to handle images from other domains
//             });

//             const ctx = canvas.getContext('2d');
//             const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
//             const rgbaData = imageData.data;

//             // Encode the image data to TIFF format
//             const tiffData = UTIF.encodeImage(rgbaData, canvas.width, canvas.height);
//             const tiffBlob = new Blob([tiffData], { type: 'image/tiff' });

//             const a = document.createElement('a');
//             a.href = URL.createObjectURL(tiffBlob);
//             a.download = inv_no + '.tif';
//             document.body.appendChild(a);
//             a.click();
//             document.body.removeChild(a);

//             // Resolve the promise once the operation completes
//             resolve();
//         } catch (error) {
//             console.error('Error:', error);
//             reject(error); // Reject promise on error
//         } finally {
//             // Clean up: remove the wrapper element from the body
//             document.body.removeChild(wrapper);
//         }
//     });
// }

async function printTIFF(index) {
    return new Promise(async (resolve, reject) => {
        var node = document.getElementById("myElement" + index);
        if (!node) {
            console.error("Element not found: myElement" + index);
            reject(new Error("Element not found: myElement" + index));
            return;
        }

        var inv_no = node.getAttribute('inv_no' + index);
        var clone = node.cloneNode(true);
        document.body.appendChild(clone);

        var imgElements = clone.getElementsByTagName("img");
        for (var i = 0; i < imgElements.length; i++) {
            imgElements[i].src = imgElements[i].src; // Ensure the image src is correctly set
        }

        var svgElements = clone.getElementsByTagName("svg");
        for (var i = 0; i < svgElements.length; i++) {
            var svg = svgElements[i];
            var serializer = new XMLSerializer();
            var svgString = serializer.serializeToString(svg);
            var img = new Image();
            img.src = 'data:image/svg+xml;base64,' + window.btoa(svgString);
            await new Promise((resolve) => img.onload = resolve);
            svg.parentNode.replaceChild(img, svg);
        }

        var scaleFactor = 2; // Adjusted scale factor to reduce size
        var marginRight = 520;
        var marginTop = 100;
        var marginBottom = 35;

        // Create a wrapper element to apply the margin
        var wrapper = document.createElement('div');
        wrapper.style.marginLeft = marginRight + 'px';
        wrapper.style.marginTop = marginTop + 'px';
        wrapper.style.paddingBottom = marginBottom + 'px';
        wrapper.appendChild(clone); // Use the cloned element

        // Append the wrapper temporarily to the body to measure it
        document.body.appendChild(wrapper);

        try {
            // Use html2canvas to render the HTML element to a canvas
            const canvas = await html2canvas(wrapper, {
                scale: scaleFactor,
                useCORS: true // Use CORS to handle images from other domains
            });

            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const rgbaData = imageData.data;

            // Encode the image data to TIFF format
            const tiffData = UTIF.encodeImage(rgbaData, canvas.width, canvas.height);
            const tiffBlob = new Blob([tiffData], { type: 'image/tiff' });

            const formData = new FormData();
            formData.append('image', tiffBlob, 'image.tiff');
            formData.append('fileName', inv_no);

            // Use fetch to send the form data to the API
            const response = await fetch('https://tifcompressor.cyenosure.in/api/tiff/tiffcompressor', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            if (response.ok) {
                const result = await response.json();
                console.log('Success:', result);
                const  links = result.Link
                var downloadLink = document.createElement('a');
                    downloadLink.href = links;
                    downloadLink.download = inv_no + '.tif';
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    loop_count = loop_count+1;
                if(loop_count == totalCount){
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            } else {
                console.log('Error:', response.statusText);
            }



            // Resolve the promise once the operation completes
            resolve();
        } catch (error) {
            console.error('Error:', error);
            reject(error); // Reject promise on error
        } finally {
            // Clean up: remove the wrapper element from the body
            document.body.removeChild(wrapper);
        }
    });
}

 </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<style type="text/css">
    @media print {
      @page {
        margin: 0;
      }
      /* .printxxxx {
        page-break-after: always;
      } */
      tbody td {
        font-size: 14px !important;
      }
      p {
        font-size: 14px !important;

      }
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

    }

    h4{
        padding:0px !important;
        margin:0px !important;
      }
    tbody td {
      font-size: 20px !important;
    }
    table {
        margin-left: auto;
        margin-right: auto;
        font-size: 20px;
        height: 100%;
        table-layout: fixed;
    }
    .no-margin{
      margin:0px !important;
    }
    .tab td {
      border:none !important;
    }

    #print_button button{
    position: fixed;
    top: 20px;
    right:1050px;
    padding: 10px;
    font-size: 18px;
    background-color: #00ffee;
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
        <div class="printxxxx">
            <div class="block-content "> 
                <div class="row"> 
                    <div class="col-6 ml-3" style="float:left;">  
                    <img src="{{asset($shipment->agency->logo) }}" alt="Bestexpress" style="height:60px;" class="img-responsive logo" >
                    </div>
                    <div class="col-6 ml-3 address" style="float:right; text-align:left;"> 
                    {{ $shipment->agency->name }}<br>
                    {{ $shipment->agency->address }}<br>
                    {{ $shipment->agency->contact_no }}<br>
                    {{ $shipment->agency->email }}<br>
                    </div>
                </div>
            </div>  
        </div>

        <div class="row text-center table table-hover mb-0">
            <div class="col-12">
                <div class="block" style="margin-bottom:0px !important;">
                    <div class="block-content">
                        <table style="width: 100%;border-collapse: collapse;">
                            <!-- <tr style=" border: 1px solid black; ">
                            <td colspan="3" style="text-align: left;   padding: 3px !important;"></td>
                            <td colspan="3" style="text-align: right;    padding: 3px !important;"><h4 class="no-margin" style="text-align:right;" >TRN:+{{ $shipment->sender->country_code_phone}} {{ $shipment->sender->phone }}</h4></td>
                            </tr>  
                            <tr>  -->
                            <td colspan="3" style="text-align: left;   padding: 3px !important;"> 
                            <h4 class="no-margin" style=""> Airway Bill NO: {{ $shipment->booking_number }} </h4>
                            <h4 class="no-margin" style=""> Cargo Type: @if($shipment->delivery_type == 'door_to_door') Door to Door @else Door to Port @endif</h4>
                            </td>
                            <td colspan="3" style="text-align: left;    padding: 3px !important;"> 
                            <h4 class="no-margin" style="text-align:right;" >Colletion Date: {{ date('d-m-Y', strtotime($shipment->created_date))}}</h4>
                            <h4 class="no-margin" style="text-align:right;" >Office: {{ $shipment->branch->name}}</h4>
                            <h4 class="no-margin" style="text-align:right;" >Staff:{{ $shipment->staff?$shipment->staff->name :$shipment->driver->name}}</h4>
                            </td>
                            </tr>  
                        </table>
                        <hr style="margin:0px;padding:0px;">

                        <div >
                            <table style="width: 50%; float:left;" class="tab">
                                <tr style="">
                                <td colspan="3" style="text-align: left;   padding: 3px !important;"><h4 class="no-margin" style="color:grey;">Customer</h4></td>
                                <td colspan="3" style="text-align: left;    padding: 3px !important;"><h4 class="no-margin" style="text-align:right;" ></h4></td>
                                </tr> 

                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Customer  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important; color:black;"> 
                                {{ Str::title($shipment->sender->name) }}  
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important; color:black;"> 
                                Mobile  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                +{{ $shipment->sender->country_code_phone}} {{ $shipment->sender->phone }}   
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Sender  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{ Str::title($shipment->sender->name) }}    
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Phone  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                +{{ $shipment->sender->country_code_phone}} {{ $shipment->sender->phone }}     
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Emirates/State  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->sender->address->state->name}}  
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Doc Type  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->sender->identification_type}}     
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Doc No.  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->sender->identification_number}}  
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Address  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{ Str::title($shipment->sender->address->address)}}
                                </td>                           
                                </tr>  
                            </table>

                            <table style="width: 50%;border-collapse: collapse;" class="tab">
                                <tr style="">
                                <td colspan="3" style="text-align: left;   padding: 3px !important;"><h4 class="no-margin" style="color:grey;">Delivery/Receiver</h4></td>
                                <td colspan="3" style="text-align: left;    padding: 3px !important;"><h4 class="no-margin" style="text-align:right;" ></h4></td>
                                </tr>  
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Receiver  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important; color:black;"> 
                                {{ $shipment->receiver->name }}  
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important; color:black;"> 
                                Mobile  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                +{{ $shipment->receiver->country_code_phone}} {{ $shipment->receiver->phone }}   
                                </td>                           
                                </tr>                                 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Phone  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                +{{ $shipment->receiver->country_code_whatsapp}} {{ $shipment->receiver->whatsapp_number }}     
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Emirates/State  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->receiver->address->state->name}}  
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Doc Type  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->receiver->identification_type}}     
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Doc No.  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->receiver->identification_number}}  
                                </td>                           
                                </tr> 
                                <tr> 
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                Address  
                                </td>
                                <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                {{$shipment->receiver->address->address}}
                                </td>                           
                                </tr> 

                            </table>  
                        </div>


                    <div style="  clear:both">
                        <table style="width: 50%; float:left; " class="tab">
                            <tr style="">
                            <td colspan="3" style="text-align: left;   "><h4 class="no-margin" style="color:grey;">Cargo Details</h4></td>
                            <td colspan="3" style="text-align: left;    "><h4 class="no-margin" style="text-align:right;" ></h4></td>
                            </tr> 

                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            Total Weight  
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important; color:black;"> 
                            {{ round($shipment->normal_weight, 2) }}
                            </td>                           
                            </tr> 
                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important; color:black;"> 
                            Cargo Value  
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                                
                            </td>                           
                            </tr> 
                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            No.Of Boxes  
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            {{ $shipment->number_of_pcs }}
                            </td>                           
                            </tr> 
                            <tr> 
                                                       
                            </tr>                        
                        </table>

                        <table style="width: 50%;border-collapse: collapse;" class="tab">
                            <tr style="">
                            <td colspan="3" style="text-align: left; "><h4 class="no-margin" style="color:grey;">Receiver Details</h4></td>
                            <td colspan="3" style="text-align: left;  "><h4 class="no-margin" style="text-align:right;" ></h4></td>
                            </tr> 

                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            Receiver Name
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            : ...................................... 
                            </td>                           
                            </tr> 
                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            Contact No  
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            : ...................................... 
                            
                            </td>                           
                            </tr>  
                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            Document Type  
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            : ...................................... 
                             
                            </td>                           
                            </tr> 
                            <tr> 
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            Doc Number  
                            </td>
                            <td colspan="3" style="text-align: left;   padding: 3px !important;color:black;"> 
                            : ...................................... 
                             
                            </td>                           
                            </tr>  
                            
                        </table>
                    </div> 
                </div>
            </div>
        </div>


        <hr style="margin:0px;padding:0px;">
        <div class="row   ">
            <div class="col-12" style="margin-left:20px">
                <b>Item Details:</b> 
                @foreach($shipment->packages as $k => $package )  
                {{ $package->description}} -  {{ $package->quantity}},                                       
                @endforeach
            </div> 
            </div>  

            <div class="row  ">
            <div class="col-12" style="margin-left:20px">
            <h4 class="content-heading mb-0" style="padding:10px 10px 0 10px; font-weight: 600;color:grey; font-weight: 600;"><b>CUSTOMER DECLARATION</b></h4> 
            </div> 
            </div>  

            <div class="row  ">
                <div class="col-12" style="margin-left:20px; color:black">
                    <p class="mb-0">
                        <b>Note:</b> Any complaints arising against this consignment should be reported within seven days. Complaints will not be entertained after 7 days of delivery date.
                            Maximum payback for total lost will be Dhs.20/- per Kilogram. Total cargo value should not exceed Rs.20,000/-. BEST EXPRESS CARGO LLC is not responsible for any damages of 
                            fragile (glass etc.) items and shipment delay occurring due to the formalities of Government/Air/Sea authorities. We request our customers to cooperate with us.
                    </p>     
                    <p>I, {{ Str::title($shipment->sender->name) }} holder of {{$shipment->receiver->identification_type}}  number: {{$shipment->receiver->identification_number}} hereby declare that all the above said items are my personal effects/home appliances sending  to {{ Str::title($shipment->receiver->name) }}
                        through BEST EXPRESS CARGO LLC, P O BOX.69190, Dubai, United Arab Emirates vide their waybill number : 5000 which is sent as the unaccompanied baggage of an international passenger.
                        </p>
                </div>  
            </div>
            <div class="row  ">
            <div class="col-12" style="margin-right:20px; color:black;text-align:right;"> Goods received in good condition</div>
            </div>

        

            <div class="row " style="margin-top:50px;margin-bottom:50px;">
            <div class="col-6"style=" padding-left: 50px;color:black; float:left;">Signature of the shipper/sender<br><b> {{ Str::title($shipment->sender->name) }}</b></div>
            <div class="col-6" style=" text-align:right;color:black;">Signature of the consignee/receiver<br><b> {{ Str::title($shipment->receiver->name) }}</b></div>
            </div>
            <hr style="margin:0px;padding:0px;">
            <p style="text-align:center; color:black;margin:0px;padding:0px;">For Online Tracking https://bestexpressonline.com<p> 

            </div> 
        </div> 
         
    </div>
            <div class="text-center" id="print_button" >
                <button type="button" onclick="window.print()" class="print">Print</button>
            </div>
     

</body>

</html>

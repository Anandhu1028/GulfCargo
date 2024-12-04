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
                            <h4 class="page-title">All Goods</h4>
                            <div class="fa-pull-left pb-3">  

                                <button type="button" id="addCargos" class="btn btn-primary">Add Cargos</button>&nbsp;&nbsp;&nbsp;  
                                <button type="button" id="resetSelected" class="btn btn-primary">Reset Selected</button>&nbsp;&nbsp;&nbsp;  
                                <button type="button" id="transferGoods" class="btn btn-primary">Transfer Goods</button>&nbsp;&nbsp;&nbsp;  
                                <!-- <a href="#" class="btn btn-primary">Print All</a>&nbsp;&nbsp;&nbsp; 
                                <a href="##" class="btn btn-primary">Print Selected</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" class="btn btn-primary">Delete</a>&nbsp;&nbsp;&nbsp; -->
                            </div>
                            <form method="get" action="{{route('branch.goodsdetails.index')}}"  enctype="multipart/form-data"> 
                            <div class="fa-pull-left pb-3">  
                                <select class="form-control" id="serachq" name="serachq">
                                    <option value="invoice_number" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'invoice_number') {
                                                            echo 'selected="true"';
                                                        } ?>  >Invoice No</option>
                                      <option value="courier_company" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'courier_company') {
                                                            echo 'selected="true"';
                                                        } ?> >Company</option>

                                    <option value="phone" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'phone') {
                                                            echo 'selected="true"';
                                                        } ?> >Mobile</option>
                                    <option value="vendor" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'vendor') {
                                                            echo 'selected="true"';
                                                        } ?> >Vendor</option>
                                    <option value="state" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'state') {
                                                            echo 'selected="true"';
                                                        } ?> >State</option>
                                    <option value="district" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'district') {
                                                            echo 'selected="true"';
                                                        } ?> >District</option>
                                    <option value="number_of_pcs" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'number_of_pcs') {
                                                            echo 'selected="true"';
                                                        } ?> >Pcs</option>
                                    <option value="weight" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'weight') {
                                                            echo 'selected="true"';
                                                        } ?> >Weight</option>
                                    <!-- <option value="trip_no">Trip No</option> -->
                                    <option value="tracking_no"  <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'tracking_no') {
                                                            echo 'selected="true"';
                                                        } ?> >Tracking No</option>

                                    <!-- <option value="date" >Date</option> -->
                                    <option value="address" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'address') {
                                                            echo 'selected="true"';
                                                        } ?> >Address</option>
                                  
                                    <!-- <option value="shipmentname">Ship.Name</option> -->
                                    <option value="sendingdate" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'sendingdate') {
                                                            echo 'selected="true"';
                                                        } ?> >Sending Date</option>
                                    <option value="recievingdate" <?php if (isset($_GET['serachq']) && $_GET['serachq'] == 'recievingdate') {
                                                            echo 'selected="true"';
                                                        } ?> >Recciev.Date</option>
                                    
                                    <!-- <option value="boxno"># No</option> --> 
                                    <option value="status">Status</option>
                                </select>
                            </div>
                            <div class="fa-pull-left pb-3 ml-2">  
                                <input type="text" name="search" placeholder="search" value="<?=$_GET['search']??''?>"  id="search" class="form-control" autocomplete="off" />  
                            </div>
                            <button style="font-size:24px" id="search_button" class="primary"><i class="fa fa-search"></i></button>​
                            </form>
                            <div id="message"> </div>
                        </div>
                    </div>

                </div> 
 

                <div class="row">
                    <div class="col-sm-12"   style=" overflow: scroll; overflow: auto; ">
<!--   
                            <table id="bookingdatatable1"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">     -->

                                   <table class="table table-striped table-bordered dt-responsive nowrap table-responsive-xl">
                                <thead> <tr>
                                    <th class="th-lg" ><input type="checkbox" id="allcb" name="allcb" /></th> </th>
                                    <th class="th-lg" >SI No</th>
                                    <th class="th-lg" >Sort Order</th>
                                    <th class="th-lg" >Transfer Status</th>
                                    <th class="th-lg" >Company</th>
                                    <th class="th-lg" >Shipment Number</th>
                                    <th class="th-lg" >Origin</th>
                                    <th class="th-lg" >#Number</th>
                                    <th class="th-lg" >Tracking Number</th>
                                    <th class="th-lg" >Trip Number</th>
                                    <th class="th-lg" >Invoice Number:</th>                                  
                                    <th class="th-lg" >Pcs</th>                                    
                                    <th class="th-lg" >Weight</th>                                    
                                    <th class="th-lg" >Re weight</th>                                    
                                    <th class="th-lg" >Recieved Pieces</th>                                    
                                    <th class="th-lg" >Sender address </th>                                    
                                    <th class="th-lg" >Receiver address </th>                                    
                                    <th class="th-lg" >Phone </th>                                    
                                    <th class="th-lg" >State </th>                                    
                                    <th class="th-lg" >District </th>                                    
                                    <th class="th-lg" >Pincode </th>                                    
                                    <th class="th-lg" >Description of Goods</th>  
                                    <th class="th-lg" >Received at Hub </th>                                    
                                    <th class="th-lg" >Connecting Date</th>                                    
                                    <th class="th-lg" >Recieved at Branch</th>
                                    <th class="th-lg" >Vendor</th>
                                    <th class="th-lg" >Contact Number</th>
                                    <th class="th-lg" >Docket</th> 
                                    <th class="th-lg" >Good Status</th>                                    
                                    <th class="th-lg" >Remarks</th>
                                    <th class="th-lg" >Sending Date</th>
                                    <th class="th-lg" >Recciev.Date</th>
                                    </tr>                            
                                </thead>

                                <tbody>
                                @foreach($goods_det as $key=> $goods)
                               
                                        
                                <?php   $style ="";
                                        $showCheckbox = true;
                                        if(!empty($goods->status)){
                                            if($goods->status == "Hold") {
                                                $showCheckbox = false;
                                                $style ="style=background-color:#ffa1a1;";
                                            } else  if($goods->status == "Short") {
                                                $style ="style=background-color:#87dc87";
                                                $showCheckbox = false;
                                            } else  if($goods->status == "Received") {
                                                $style ="style=background-color:#c0ecff";
                                                $showCheckbox = true;
                                            } 
                                        } 
                                ?>
 
                                    <tr <?=$style?>>                                   
                                        <td>    
                                            @if($showCheckbox )                                        
                                            <input type="checkbox" name="invoice[]"  class="checkbox-item" id="chkBx-{{$goods->id}}"  value="{{$goods->id}}" 
                                            <?php if($goods->sort_order != null) { echo 'checked'; } ?> />    
                                            @endif                                         
                                        </td>
                                        <td>SI No</td>
                                        <td>Sort Order </td>
                                        <td>Transfer Status</td>
                                        <td>   <button type="button" id="addCargos" class="btn btn-warning btn-sm edit_info"  onclick="editGoods( '{{ $goods->id}}', '{{$goods->receiver->address->state->name??''}}', '{{$goods->receiver->address->city->name??''}}','{{ $goods->invoice_number }}', '{{ $goods->weight}}','{{ $goods->tracking_number}}' )" > <i class="fas fa-md fa-pencil-alt"></i></button>{{ $goods->agency->name }}</td>
                                        <td>{{ $goods->ship_id }}</td>
                                        <td>Origin</td>
                                        <td>#no</td>
                                        <td>{{ $goods->tracking_number}}</td>
                                        <td>Trip Number</td>
                                        <td>{{ $goods->invoice_number}}</td>
                                        <td>{{ $goods->number_of_pcs}}</td>
                                        <td>{{ $goods->weight}}</td>
                                        <td>{{ $goods->re_weight}} </td>
                                        <td>{{ $goods->number_of_pcs}}</td>
                                        <td style="width:200px;">{{$goods->sender->name}} -  {{  Str::words($goods->sender->address->address, '25')  }} </td>
                                        <td>{{$goods->receiver->name}} -  {{  Str::words($goods->receiver->address->address, '25')  }} </td>
                                        <td>{{$goods->receiver->phone}}</td>
                                        <td>{{$goods->receiver->address->state->name}}</td>
                                        <td>{{$goods->receiver->address->city->name??''}}</td>
                                        <td>{{$goods->receiver->address->zip_code}}</td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td></td>
                                        <td>{{$goods->vendorDetails?$goods->vendorDetails->name:'-'}}</td>
                                        <td>{{$goods->vendorDetails?$goods->vendorDetails->mobile_number:'-'}}</td>
                                        <td>{{$goods->lr_no?$goods->lr_no:'-'}}</td> 
                                        <td> {{ Str::title($goods->currentStatus?$goods->currentStatus->status->name:'') }}</td>
                                        <td>{{Str::title($goods->remarks)}}</td>                                        
                                        <td>{{$goods->transfer_date}}</td>
                                        <td>{{$goods->received_date}}</td>                 
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            
                        </div>
  
                        <div class="col-sm-12"   style="align:center;">
                         {{ $goods_det->links() }}

                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->
@include('branches.modals.addCargos')
@include('branches.modals.editGoods')
@include('branches.modals.transferGoods')
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script>

$(document).ready(function () {
    $('#bookingdatatable').DataTable({  
        "autoWidth": false,
        "aaSorting": [ [0,'desc'] ], 
        "scrollX": true,
        "responsive": false
    });  

}); 

 
function formatDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1; //Months are zero-based
    var year = date.getFullYear();
 
    // Pad the day and month with leading zeros, if necessary
    day = (day < 10) ? '0' + day : day;
    month = (month < 10) ? '0' + month : month;
 
    return year + '-' + month + '-' + day;
}
function editGoods(id, state, district, invoice_number, weight, tracking_number) {
    
    $('#editGoodsModal').modal('show'); 
    $('#goods_id').val(id);
    $('#state').text(state);
    $('#district').text(district);
    $('#invoice_number').text(invoice_number);
    $('#weight').text(weight);
    $('#tracking_number').text(tracking_number);

    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.goodsdetails.getByID') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({"goods_id":id  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
          
            var array1 = [24,26,27];   // 24 -received, 26 - hold, 27 -short
            var in_arr = (array1.includes( result.current_status.status_id));
            if( in_arr == false) {
                var status_id = 24;
            } else {
                var status_id = result.current_status.status_id;
            }
 
            $('#re_weight').val(result.re_weight);
            $('#received_date').val(result.received_date);

            if(result.connecting_date != null ){                
                var date = new Date( result.connecting_date ); 
                $('#connecting_date').val( formatDate(date) );
            }

            if(result.received_date != null ){                
                var date1 = new Date( result.received_date ); 
                $('#received_date').val( formatDate(date1) );
            }
           
            $('#number_of_pcs').val(result.number_of_pcs);
            $('#vendor').val(result.vendor);
            $('#status').val( status_id );
            $('#remarks').val(result.remarks);
          
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing    

}


<?php if(isset(($_GET['serachq'])) == 'invoice_number') {?> 
    // $('#inptvalue').focus().select(); 
    $('.edit_info').focus().select(); 

    // alert("ssasa");
    // editBtn
<?php } ?>

 


$('#allcb').click(function (e) {            
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});

var $checkboxes = $('.checkbox-item');
$('.checkbox-item').change(function(){
    var checkboxesLength = $checkboxes.length;
    var checkedCheckboxesLength = $checkboxes.filter(':checked').length;
    if(checkboxesLength == checkedCheckboxesLength) {
        $('#allcb').prop('checked', true);
    }else{
        $('#allcb').prop('checked', false);
    }
}); 




$('.checkbox-item').click(function (e) {    
    var id = $(event.target).attr('id' ) ;
    if (e.target.checked) { 
        var flag = 'true';
    } else {
        var flag = 'false';
    }
    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.goodsdetails.updateSortOrder') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({"id":id,"flag":flag  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing
})
 

$('#allcb').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
    var checkboxes = $( ':checkbox' );
    var checkedArray = [];     

    $.each($('.checkbox-item'),function(index,value){         
        var id = $(this).attr('id' ) ; 
        if( this.checked == true){
            flag="true";
            checkedArray.push( id);
        } else {
            flag="false";
            checkedArray.push( id);
        }
    });  

    if( this.checked == true){
        $('#selCnt').text('Total Count :'+ $('[type= checkbox]').length);
        $.ajax({
            headers: {
                "content-type" : "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            url:  `{{ route('branch.goodsdetails.updateMultipleSortOrder') }}`,
            type: "POST", 
            async:false,
            data: JSON.stringify({"checkedArray":checkedArray, "flag": flag  }), 
            cache: false,
            contentType: false,
            processData: false,
            success:function(data){
                $('#selCnt').text('Total Count :'+ data);                    
            }
        });

    }
    else {
        $('#selCnt').text('');
        $('#resetSelected').trigger('click');
    }

   
});
 

$('#resetSelected').click(function (e) {   
    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.goodsdetails.resetSortOrder') }}`,
        type: "POST", 
        async:false, 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            $("#message").html("<i class='fa fa-check-circle' style='color:green'></i>"+result);
            $("#message").show().delay(3000).fadeOut();            
        },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing
})


$('#addCargos').click(function () {  
    // var checkValues = $('.checkbox-item:checked').map(function(){
    //     return $(this).val();
    // }).get(); 
    
    var checkValues = [];  
    var uncheckedArray = []; 

    $.each($('.checkbox-item'),function(index,value){         
        var id = $(this).attr('id' ) ; 
        if( this.checked == true){
            flag="true";
            checkValues.push( id);
        } else {
            flag="false";
            uncheckedArray.push( id);
        }
    });  
    $('#msg').html( ); //clear msg div
    $("#sel_goods_id").val(checkValues); 
        $('#addCargosModal').modal('show'); 

});



$('#save_goods_details').click(function (e) { 


    var re_weight = $('#re_weight').val();
    var received_date = $('#received_date').val();
    var connecting_date = $('#connecting_date').val();
    var number_of_pcs = $('#number_of_pcs').val();
    var vendor = $('#vendor').val();
    var status = $('#status').val();
    var remarks = $('#remarks').val();
    var id = $('#goods_id').val();

  
    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.goodsdetails.ajaxUpdate') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({ "goods_id":id,"re_weight":re_weight,"received_date":received_date , "connecting_date":connecting_date,"number_of_pcs":number_of_pcs, "vendor":vendor,
            "status":status, "remarks":remarks  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {   
          
            $('#msg_edit').text( result ); 
            location.reload().delay(3000);
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing
})


$('#save_data_cargos').click(function (e) { 


    var trip_sheet_id = $("#trip_sheet_id").val();
    var checkedArray = $("#sel_goods_id").val();

    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.goodsdetails.addCargos') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({"trip_sheet_id":trip_sheet_id,"checkedArray":checkedArray  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            console.log( result );
            $('#msg').html( result );
            location.reload().delay(3000);
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing
})

 
 /*
    var path = "{{ route('branch.goodsdetails.autocomplete') }}";
    $('#search').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    */


    $('#transferGoods').click(function () {  
    // var checkValues = $('.checkbox-item:checked').map(function(){
    //     return $(this).val();
    // }).get(); 
    
    var checkValues = [];  
    var uncheckedArray = []; 

    $.each($('.checkbox-item'),function(index,value){         
        var id = $(this).attr('id' ) ; 
        if( this.checked == true){
            flag="true";
            checkValues.push( id);
        } else {
            flag="false";
            uncheckedArray.push( id);
        }
    });  
    $('#msg').html( ); //clear msg div
    $("#sel_goods_id").val(checkValues); 
        $('#transferGoodsModal').modal('show'); 

});


$('#vehicle_id').change(function(){

    var vehicle_id = $("#vehicle_id").val(); 

    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.goodsdetails.getVehicleDetails') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({"vehicle_id":vehicle_id  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            console.log( result );
            $('#vehicle_details').html( result );
            // location.reload().delay(3000);
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing

}); 


$('#transfer_cargo_goods').click(function(){

    var vehicle_id = $("#vehicle_id").val(); 
    var transfer_from = $("#transfer_from").val(); 
    var transfer_to = $("#transfer_to").val(); 
    var sel_goods_id = $("#sel_goods_id").val();

        $.ajax({
            headers: {
                "content-type" : "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            url:  `{{ route('branch.goodsdetails.branchTransfer') }}`,
            type: "POST", 
            async:false,
            data: JSON.stringify({"vehicle_id":vehicle_id , "sel_goods_id": sel_goods_id, "transfer_to" : transfer_to, "transfer_from": transfer_from }), 
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {  
                console.log( result );
                $('#transfer_msg').html( result );
                // location.reload().delay(3000);
                },
            error: function (err) {            
                console.log(err);            
            }
        }); // ajax call closing

});

</script>
@endsection

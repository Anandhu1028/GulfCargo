@extends('layouts.app')
@section('content')
<style>
.showEstimateDate{
    display:none;
}
.itemShow {
display:block;
}
</style>
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
                             
                            <div id="message"> </div>
                        </div>
                    </div>

                </div>


                <div class="row"> 
                    <div class="col-md-6  "> 
                    <h4 class="page-title">Tripsheet Cargos</h4>
                    </div> 
                    <div class="col-md-6">
                        <a href="{{index_url()}}" type="button"
                        class="btn btn-primary waves-effect waves-light" style="float:right;">Back
                        </a>
                    </div>
                
                    <div class="col-12">
                        <div class="page-title-box"> 
                         
                            <div class="fa-pull-left pb-3">  

                              <button type="button" id="changeStatusCargos" class="btn btn-primary">Change Status</button>&nbsp;&nbsp;&nbsp;  
                              <button type="button" id="addLRNoModel"   class="btn btn-primary">Add LR No/ URL</button>&nbsp;&nbsp;&nbsp;   
                              <input type="hidden" id="trip_sheet_id" value="<?= $tripsheet_id ?>" />
                         
                             
                            </div>
                            
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="col-sm-12"   style=" overflow: scroll; overflow: auto; ">
  
                            <table id="bookingdatatable1"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">    
                                <thead>
                                    <th><input type="checkbox" id="allcb" name="allcb" /></th> </th>
                                    <th>SI</th>
                                    <th>Courier Company</th>
                                    <th>Tracking No:</th> 
                                    <th># Number</th>
                                    <th>Box No:</th>   
                                    <th>Estimate Arrival Date</th>                                    
                                    <th>Invoice Number</th>   
                                    <th>Number of Pieces</th> 
                                    <th>LR Number</th>
                                    <th>Tracking Url</th>                                     
                                    <th>Status</th>                                    
                                    <th>Action</th>
                                </thead>

                                <tbody>
                                @foreach($goods as $key=> $goods) 
                             
                                    <?php 
                                    if($goods->currentStatus->status->name == 'Out for Delivery'){
                                        $style="background-color:#3f9ce8";
                                    } else if($goods->currentStatus->status->name == 'Not Delivered'){
                                        // color: #fff;
                                        // background-color: #ef5350;
                                        // border-color: #ea1c18;
                                        $style="background-color:red";
                                    }
                                    else if($goods->currentStatus->status->name == 'Pending'){
                                        $style="background-color:yellow";
                                        // color: #fff;
                                        // background-color: #ffca28;
                                        // border-color: #eab000;
                                    }
                                    else if($goods->currentStatus->status->name == 'In Transit'){
                                        $style="background-color:#26c6da";
                                    }
                                    else if($goods->currentStatus->status->name == 'Return'){
                                        $style="background-color:red";
                                    }
                                    else if($goods->currentStatus->status->name == 'On the Way'){
                                        // color: #212529;
                                        // background-color: #f0f2f5;
                                        // border-color: #cbd2dd;
                                        $style="background-color:blue";
                                    }else if($goods->currentStatus->status->name == 'Delivered'){
                                        $style="background-color:#9ccc65; color: #fff; border-color: #7eb73d;";  

                                    }else {
                                        $style="background-color:none";
                                    }

                                    // $style="style:background-color:none";
                                   



?>
                                    <tr>                                   
                                        <td>                                            
                                            <input type="checkbox" name="invoice[]"  class="checkbox-item" id="chkBx-{{$goods->id}}"  value="{{$goods->id}}" />                                             
                                        </td>
                                        <td>{{ $key+1}}</td>
                                        <td>{{ $goods->id }}{{ $goods->agency->name }}</td>
                                        <td>{{ $goods->tracking_number}}</td>  
                                        <td>#no</td> 
                                        <td>{{ $goods->ship_id }}</td>
                                        <td>{{date('d-m-Y', strtotime($goods->estimate_arrival_date)) }}</td>
                                        <td>{{ $goods->invoice_number}}</td>
                                        <td>{{ $goods->number_of_pcs}}</td> 
                                        <td>{{ $goods->lr_no }}</td>  
                                        <td>{{$goods->tracking_url}}</td>
                                        <!-- {{Str::title($goods->currentStatus->name??'')}} -->
                                        <!-- <td><input type="button" name="status" class="status" style="{{$style}}" value="{{Str::title($goods->current_status_id)}}" /></td> -->
                                        <td><input type="button" name="status" class="btn single-status" style="{{$style}}" value="{{Str::title($goods->currentStatus->status->name??'')}}"  
                                        onclick="singleStatusChange({{ $goods->id }})"/></td>
                                        <td>Action</td>                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            
                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content --> 

@include('branches.modals.changeStatusSingle')
@include('branches.modals.changeStatus')
@include('branches.modals.addLrNo')

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
    // $.ajax({
    //     headers: {
    //         "content-type" : "application/json",
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //     url:  `{{ route('branch.goodsdetails.updateSortOrder') }}`,
    //     type: "POST", 
    //     async:false,
    //     data: JSON.stringify({"id":id,"flag":flag  }), 
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     success: function (result) {  
            
    //         },
    //     error: function (err) {            
    //         console.log(err);            
    //     }
    // }); // ajax call closing
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

    // if( this.checked == true){
    //     $('#selCnt').text('Total Count :'+ $('[type= checkbox]').length);
    //     $.ajax({
    //         headers: {
    //             "content-type" : "application/json",
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //         url:  `{{ route('branch.goodsdetails.updateMultipleSortOrder') }}`,
    //         type: "POST", 
    //         async:false,
    //         data: JSON.stringify({"checkedArray":checkedArray, "flag": flag  }), 
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         success:function(data){
    //             $('#selCnt').text('Total Count :'+ data);                    
    //         }
    //     });

    // }
    // else {
    //     $('#selCnt').text('');
    //     $('#resetSelected').trigger('click');
    // }

   
});
 

$('#resetSelected').click(function (e) {   
    // $.ajax({
    //     headers: {
    //         "content-type" : "application/json",
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //     url:  `{{ route('branch.goodsdetails.resetSortOrder') }}`,
    //     type: "POST", 
    //     async:false, 
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     success: function (result) {  
    //         $("#message").html("<i class='fa fa-check-circle' style='color:green'></i>"+result);
    //         $("#message").show().delay(3000).fadeOut();            
    //     },
    //     error: function (err) {            
    //         console.log(err);            
    //     }
    // }); // ajax call closing
})
  

$('#changeStatusCargos').click(function () {      
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
        $('#changeStatusCargosModal').modal('show'); 

});

 

$('#update_status').click(function (e) {

    var checkedArray = $("#sel_goods_id").val();
    var goods_status = $("#goods_status_multiple").val();   

    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.tripsheet.updateStatus') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({ "checkedArray":checkedArray,  "goods_status":goods_status  }), 
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

 function singleStatusChange(id) { 
   $('#msg').html( ); //clear msg div
   $("#sel_goods_id").val(id); 
   $('#changeStatusSingleModal').modal('show'); 

};




$('#update_status_single').click(function (e) { 
    var goods_id = $("#sel_goods_id").val();
    var goods_status = $("#goods_status").val();

    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.tripsheet.updateStatusSingle') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({ "goods_id":goods_id,  "goods_status":goods_status  }), 
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


$('#addLRNoModel').click(function () {      
    $('#addLrNoModal').modal('show'); 
    var trip_sheet_id = $("#trip_sheet_id").val();
    var checkValues = [];  
    var uncheckedArray = []; 

    $.each($('.checkbox-item'),function(index,value){         
        var id = $(this).attr('value' ) ; 
        if( this.checked == true){
            flag="true";
            checkValues.push( id);
        } else {
            flag="false";
            uncheckedArray.push( id);
        }
    });  


    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.tripsheet.ajaxLoadupdate_lrNo') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({ "checkValues":checkValues,  "trip_sheet_id":trip_sheet_id  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            console.log( result );
            $('#cntnt').html( result );
            // location.reload().delay(3000);
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing

   
});
 

$(document).on('click', '#estimateDelDate', function(){
          if($(this).is(":checked")) { 
              $('.showEstimateDate').addClass("d-block");       
          } else {
            $('.showEstimateDate').removeClass("d-block");
          }           
});



$('#update_lr_no').click(function () {      

    var sel_tripsheet_id_lr = $("#sel_tripsheet_id_lr").val();
    var url = $("#url").val(); 
    var common_estimate_arrival_date = $("#common_estimate_arrival_date").val();
    var invoice_array = $('.invoice_no').map((_,el) => el.value).get();
    var estimate_arrival_date_array = $('.estimate_arrival_date').map((_,el) => el.value).get();
    var lr_no_array = $('.lr_no').map((_,el) => el.value).get();
    var goods_id_array = $('.goods_id').map((_,el) => el.value).get();
    
    /*
    var checkValues = [];  
    var uncheckedArray = [];  

    $.each($('.checkbox-item'),function(index,value){         
        var id = $(this).attr('value' ) ; 
        if( this.checked == true){
            flag="true";
            checkValues.push( id);
        } else {
            flag="false";
            uncheckedArray.push( id);
        }
    });  */

    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.tripsheet.ajaxUpdateLrNo') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({ "url":url, "sel_tripsheet_id_lr":sel_tripsheet_id_lr, "invoice_array": invoice_array, "estimate_arrival_date_array":estimate_arrival_date_array,
        "lr_no_array":lr_no_array ,"common_estimate_arrival_date": common_estimate_arrival_date ,"goods_id_array":goods_id_array}), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            // console.log( result );
            $('#msg_lrUpdate').html( result );
            location.reload().delay(3000);
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing

   
});



</script>
@endsection
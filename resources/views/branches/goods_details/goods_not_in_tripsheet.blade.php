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
                            <div class="fa-pull-left pb-3">  

 
                            </div>
                            <div id="message"> </div>
                        </div>
                    </div>

                </div>


                <div class="row"> 
                    <div class="col-md-6  ">  
                    <h4 class="page-title">Goods Not In Tripsheet</h4>

                    </div> 
                    <div class="col-md-6">
                        <a href="{{index_url()}}" type="button"
                        class="btn btn-primary waves-effect waves-light" style="float:right;">Back
                        </a>
                    </div>
                
                    <div class="col-12">
                        <div class="page-title-box"> 
                         
                          
                            
                        </div>
                    </div>

                </div>



                <div class="row mt-5">
                    <div class="col-sm-12"   style=" overflow: scroll; overflow: auto; ">
  
                            <table id="bookingdatatable1"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">    
                                <thead>
                                    <th><input type="checkbox" id="allcb" name="allcb" /></th> </th>
                                    <th>Courier Company</th>
                                    <th>Shipment Number</th>
                                    <th>Destination</th>
                                    <th># Number</th> 
                                    <th>Tracking No:</th>   
                                    <th>Box No:</th>                                  
                                    <th>Number of Pieces</th>                                    
                                    <th>Weight</th>                                    
                                    <th>Re weight</th>                                    
                                    <th>Recieved Pieces</th>                                    
                                    <th>Sender address </th>                                    
                                    <th>Receiver address </th>                                    
                                    <th>Receiver Phone </th>                                    
                                    <th>State </th>                                    
                                    <th>District </th>                                    
                                    <th>Pincode </th>                                    
                                    <th>Goods Details </th>                                    
                                    <th>Shipment started Date </th>                                    
                                    <th>Received at Hub </th>                                    
                                    <th>Connecting Date</th>                                    
                                    <th>LR Number</th>                                    
                                    <th>Good Status</th>                                    
                                    <th>Remarks</th>
                                </thead>

                                <tbody>
                                @foreach($goods as $key=> $goods)
                                
                                <?php /*if(!empty($shipment->statusVal->name)){
                                        if($shipment->statusVal->name == "Enquiry collected") {
                                            $showAddItems = true;
                                            $style ="style=background-color:yellow;padding:5px;";
                                        } else {
                                            $style ="style=background-color:none";
                                            $showAddItems = false;

                                        }
                                    } */
                                ?>
                                    <tr>                                   
                                        <td>                                            
                                            <input type="checkbox" name="invoice[]"  class="checkbox-item" id="chkBx-{{$goods->id}}"  value="{{$goods->id}}" 
                                            <?php if($goods->sort_order != null) { echo 'checked'; } ?> />                                             
                                        </td>
                                        <td>{{ $goods->id }}{{ $goods->agency->name }}</td>
                                        <td>{{ $goods->ship_id }}</td>
                                        <td>{{ $goods->receiver->address->country->name }}</td>
                                        <td>#no</td>
                                        <td>{{ $goods->tracking_number}}</td>
                                        <td>{{ $goods->invoice_number}}</td>
                                        <td>{{ $goods->number_of_pcs}}</td>
                                        <td>{{ $goods->weight}}</td>
                                        <td>{{ 'reweight'}}</td>
                                        <td>Received Pcs</td>
                                        <td style="width:200px;">{{$goods->sender->name}} -  {{  Str::words($goods->sender->address->address, '25')  }} </td>
                                        <td>{{$goods->receiver->name}} -  {{  Str::words($goods->receiver->address->address, '25')  }} </td>
                                        <td>{{$goods->receiver->phone}}</td>
                                        <td>{{$goods->receiver->address->state->name}}</td>
                                        <td>{{$goods->receiver->address->country->name}}</td>
                                        <td>{{$goods->receiver->address->zip_code}}</td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td></td>
                                        <td>{{$goods->lrl_tracking_code}}</td>
                                        <td>"last status"</td>
                                        <td>"Remarks"</td>


                                        
                                        
                                       
                                        
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
    var checkValues = $('.checkbox-item:checked').map(function(){
        return $(this).val();
    }).get(); 
    
    $("#sel_goods_id").val(checkValues); 
        $('#addCargosModal').modal('show'); 

});



$('#save_data_cargos').click(function (e) {

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


    var trip_sheet_id = $("#trip_sheet_id").val();
   
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
            
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing
})



</script>
@endsection

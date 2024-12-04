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
                            <h4 class="page-title">Pending Goods </h4>


                            <div class="fa-pull-left pb-3"> 
                                <button type="button" id="confirmGoods" class="btn btn-primary">Confirm Goods</button>&nbsp;&nbsp;&nbsp; 
                            </div>

                        </div>
                    </div>

                </div>

 



                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="body p-5">
                                <div class="header">
                                    <h4>Pending Goods</h4>
                                </div>
                                <div class="col-md-12 text-right ">   
                                    <!-- <form action="http://127.0.0.1:8000/branch/ship/printall" method="post" target="_blank">  -->
                                            <!-- <button type="submit" class="btn btn-icon waves-effect waves-light btn-success" style="margin-bottom:10px;" form="form1" value="Submit"> <i class="fas fa-print"> Print all</i></button>  -->
                                    <!-- </form>                                     -->
                                </div>
                                <div class="table-responsive">
                                    <table id="pending_goods" class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" id="allcb" name="allcb" /></th> </th>
                                            <th>Tracking No</th> 
                                            <th>Invoice No</th> 
                                            <th>No of Pcs</th>
                                            <th>Total Weight</th> 
                                            <th>Transfer Date</th>
                                            <th>Transferred From</th>
                                            <th>Transfer Status</th>
                                            <!-- <th>Driver Name</th>
                                            <th>Vehicle Number</th> -->
                                           
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData1">
                                            @foreach( $goods as $goods)
                                            <tr id="bookingData">
                                                <td><input type="checkbox" name="invoice[]"  class="checkbox-item" id="chkBx-{{$goods->id}}"  value="{{$goods->id}}"  /></td>
                                                <td>{{$goods->tracking_number }}</td> 
                                                <td>{{$goods->invoice_number }}</td> 
                                                <td>{{ $goods->number_of_pcs}}</td>
                                                <td>{{number_format( $goods->grand_total_weight,2)}}</td>
                                                <td>{{ $goods->transfer_date ? date('d-m-Y', strtotime($goods->transfer_date)) : '-'}}</td>
                                                <td>{{isset($goods->shipmentTransfer->transferFrom)? Str::title($goods->shipmentTransfer->transferFrom->name):''}}</td>
                                                <td>{{  Str::title($goods->transfer_status)}}</td>                                               
                                            </tr>
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
        <!-- end content -->
        @include('branches.modals.pending_condirmed')

@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')

<script>
$(function () {    
    
});
 

$(document).ready(function () { 

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

    $('#confirmGoods').click(function () {  
        var checkValues = $('.checkbox-item:checked').map(function(){
            return $(this).val();
        }).get();
        
        $("#sel_goods_id").val(checkValues); 
        $('#pending_condirmed').modal('show'); 

    });


    $("#transfer_confirmed").submit(function (e) { 
        e.preventDefault();
        $('.valid-err').hide()
        $('#loader').removeClass('d-none');
        //var data = $('#transfer_shipment').serialize();
        var formData = new FormData(this);
        for (var p of formData) {
            let name = p[0];
            let value = p[1];

            console.log(name, value)
        }
        $.ajax({
            url: `{{ route('branch.shipment.transferConfirm') }}`,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                // when call is sucessfull
                if (result.success === true) {
                    // clearForm()
                    $('#loader').addClass('d-none');
                    var message = `<span class=" ">` + result.message + `</span>`;
                    console.log(result);
                    $('#msg').html(message)
                    // $('#' + result.data.type + '_id').append(`<option value="` + result.data.id + `" selected>` + result.data.name + `<option>`);
                    toastr.info(result.message);
                    
                    // setTimeout(() => {
                    //     $('.modal').modal('hide');
                    //     $('.alert').hide();
                    // }, 2000);
                } else {
                    toastr.error(result.message);
                }
                window.location.reload(true);
            },
            error: function (err) {
                // check the err for error details
                console.log(err);
                $('#loader').addClass('d-none');
                $.each(err.responseJSON.errors, function (key, item) {
                    //$("#err").append("<li class='alert alert-danger'>"+item+"</li>")

                    $('#' + key).after('<label class="valid-err text-danger">' + item + '</label>')
                });
            }
        }); // ajax call closing

    });  
    


}); 


</script>

@endsection

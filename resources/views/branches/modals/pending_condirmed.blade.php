<div class="modal fade" id="pending_condirmed" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm pending goods</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="msg" class="mb-4" style="text-align:center;color:red; font-size:22px"></div>
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="transfer_confirmed" name="transfer_confirmed" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div id="msg" class="w-100"></div>
                        </div>
                    </div>

 

                        <input name="sel_goods_id" id="sel_goods_id" type="hidden">

                        <button type="submit" class="btn btn-success" id="save_data_user">Transfer Confirmed</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </form>


            </div>
            <div class="modal-footer">


                    
            </div>
        </div>
    </div>
</div>

<script> 
   
function getVehicleDetails(obj){
        var id = $(obj).val();
        $.ajax({
            type:'POST',
            url:"{{route('branch.driver.getVehicleDetails')}}", 
            data:{ '_token': '{{ csrf_token() }}','id':id},
            success:function(data){
                  $('#vehicle_details').html(data);
                // console.log(data, "sasas");
            }

        });
 


    }


     


</script>
<div class="modal fade" id="changeStatusCargosModal" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="msg" class="mb-4" style="text-align:center;color:red; font-size:22px"></div>
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="transfer_shipment" name="transfer_shipment" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div id="msg" class="w-100"></div>
                        </div>
                    </div>


                    <div class="row">
                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status List</label>
                                <select autofocus name="goods_status_multiple" id="goods_status_multiple" class="form-control">
                                    <option value="">--Select Status--</option>
                                    @foreach( status_list_front()  as  $key => $status) 
                                        <option value="{{$status->id}}">{{Str::title($status->name)}}</option> 
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>
                    </div>

                     
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-6"> 
                            <input name="sel_goods_id" id="sel_goods_id" type="hidden"> 
                            <button type="submit" class="btn btn-success" id="update_status">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>  
                    </div>
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
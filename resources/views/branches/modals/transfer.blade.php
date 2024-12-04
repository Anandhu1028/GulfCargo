<div class="modal fade" id="transfer" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transfer Goods</h4>
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
                                <label for="emailAddress1">Current</label> <span class="text-danger">*</span>   
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ branch()->name}}" readonly>
                                <input type="hidden" class="form-control" name="transfer_from" id="transfer_from"  value="{{ branch()->id}}">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Branch List</label>
                                <select autofocus name="transfer_to" id="transfer_to"
                                        class="form-control">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailAddress1">Transfer Date</label> <span class="text-danger">*</span>   
                                <input type="date" class="form-control" name="transfer_date" id="transfer_date" placeholder="transfer_date" required> 
                            </div>

                        </div>
                    </div>

                    <div class="row d-none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Drivers List</label>
                                <select name="driver_id" id="driver_id" class="form-control"  onchange="getVehicleDetails(this)">
                                        <option value="">--Select Vehicle--</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->vehicle_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="vehicle_details"> 
                        </div>  
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-6"> 
                            <input name="sel_goods_id" id="sel_goods_id" type="hidden"> 
                            <button type="submit" class="btn btn-success" id="save_data_user">Transfer</button>
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
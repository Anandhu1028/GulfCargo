<div class="modal fade" id="editGoodsModal" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Goods</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="msg_edit" class="mb-4" style="text-align:center;color:red; font-size:22px"></div>
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="edit_goods" name="edit_goods" enctype="multipart/form-data">

                    @csrf

                   


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>State</label> : <span id="state"></span> <br>
                                <label>Invoice</label> : <span id="invoice_number"></span>  <br>
                                <label>Weight</label> : <span id="weight"></span>  <br>                              
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>District</label> : <span id="district"></span>  <br>
                                <label>Tracking No</label> : <span id="tracking_number"></span>  <br>
                                <label>#No</label> : -- <br>                            
                            </div>
                        </div>
                        


                         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Re Weight</label> 
                                <input type="text" value=""  class="form-control" id="re_weight" name="re_weight" placeholder="Enter re weight">
                            </div>

                          
                        </div> 

                       

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Received Date at Hub</label> 
                                <input type="date"  value="{{ date('Y-m-d') }}"  class="form-control" id="received_date" name="received_date" placeholder="Enter re weight">

                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Received Pcs</label>                                
                                <input type="text" value="" class="form-control" id="number_of_pcs" name="number_of_pcs" placeholder="Enter number of pcs">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Connecting Date</label>  
                                <input type="date"  value="{{ date('Y-m-d') }}"   class="form-control" id="connecting_date" name="connecting_date" placeholder="Enter re weight">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vendor</label>  
                                <select class="form-control" name="vendor" id="vendor">
                                <!-- <option value="">--Select--</option>  -->
                                    @foreach($vendors as $vendor)
                                    <option value="{{$vendor->id}}">{{  Str::title($vendor->name)}}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label> 
                                <select class="form-control" name="status" id="status">
                                <!-- <option value="">--Select--</option>  -->
                                    @foreach(status_list_front_edit_goods() as $status)
                                    <option value="{{$status->id}}">{{  Str::title($status->name)}}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks</label>
                                <input type="text" value="2023-11-08" max="" class="form-control" id="remarks" name="remarks" placeholder="Enter remarks">
                                
                            </div>
                        </div>

                    </div>

                     

                        <input name="sel_goods_id" id="goods_id" type="hidden">

                        <button type="submit" class="btn btn-success" id="save_goods_details">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </form>


            </div>
            <div class="modal-footer">


                    
            </div>
        </div>
    </div>
</div>

<script> 


</script>
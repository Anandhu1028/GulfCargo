<div class="modal fade" id="addLrNoModal" role="dialog" aria-labelledby="Update LR No / Url">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update LR No / Url</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="msg_lrUpdate" class="mb-4" style="text-align:center;color:red; font-size:22px"></div>
 

                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="addLrNo" name="addLrNo" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div id="addLrNo_msg" class="w-100"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <div id="cntnt"> </div>  
                        </div>
                    </div> 
                 
                      
                    <div class="row text-center" style="margin-top:15px;">
                        <div class="col-md-12"> 
                           
                            <button type="button" class="btn btn-success" id="update_lr_no">Submit</button>
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


</script>
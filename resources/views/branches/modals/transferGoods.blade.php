<div class="modal fade" id="transferGoodsModal" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transfer Goods</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="transfer_msg" class="mb-4" style="text-align:center;color:red; font-size:22px"></div>
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="transfer_cargos" name="transfer_cargos" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-12"> 
                        </div>
                    </div>


                    <div class="row">
                         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Transfer From</label><br>
                                <span><b> {{ branch()->name}}</b></span>
                                <!-- <select autofocus name="trip_sheet_id" id="trip_sheet_id"
                                        class="form-control">
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select> -->
                                <input type="hidden" name="transfer_from" id="transfer_from" value="{{ $branch->id }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Transfer To</label>
                                <select autofocus name="transfer_to" id="transfer_to"
                                        class="form-control">
                                        @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Vehicles</label>
                                <select   name="vehicle_id" id="vehicle_id"
                                        class="form-control">
                                        <option value=""> Select Vehicle </option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->vehicle_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6" id="vehicle_details">
                           
                        </div> 

                    </div>

                    <div class="row">                         
                        <div class="col-md-6">
                            <input name="sel_goods_id" id="sel_goods_id" type="hidden"> 
                            <button type="button" class="btn btn-success" id="transfer_cargo_goods">Transfer Goods</button>
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
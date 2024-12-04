<div class="modal fade" id="addCargosModal" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Cargos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="msg" class="mb-4" style="text-align:center;color:red; font-size:22px"></div>
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="add_cargos" name="add_cargos" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div id="msg" class="w-100"></div>
                        </div>
                    </div>


                    <div class="row">
                         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tripsheet List</label>
                                <select autofocus name="trip_sheet_id" id="trip_sheet_id"
                                        class="form-control">
                                    @foreach ($tripsheets as $tripsheet)
                                        <option value="{{ $tripsheet->id }}">{{ $tripsheet->tripsheet_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                     

                        <input name="sel_goods_id" id="sel_goods_id" type="hidden">

                        <button type="submit" class="btn btn-success" id="save_data_cargos">Add Goods</button>
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
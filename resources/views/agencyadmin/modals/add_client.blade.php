<div class="modal fade" id="AddClient" role="dialog" aria-labelledby="modal_add_user_title">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add sender</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form onsubmit="event.preventDefault();" class="form-horizontal" method="post" id="add_client_shipments" name="add_client_shipments" enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div id="msg" class="w-100"></div>
                        </div>
                    </div>

                    <input type="hidden" id="clientType" name="client_type" value="sender">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailAddress1">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailAddress1">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="<?php //echo $lang['user_manage5'] ?>">
                            </div>
                        </div>

                    </div>

                   

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group id_type">
                                <label for="emailAddress1">Sender Identification Type</label>
                                <select name="client_identification_type" class="form-control" >
                                    <option value="emirates_id">Emirates Id</option>
                                    <option value="aadhar">Aadhar</option>
                                    <option value="Driving Licence">Driving Licence</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Iqama">Iqama</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_no">
                                <label for="">Sender Id</label>
                                <input type="text" class="form-control" name="client_identification_number" id="client_identification_number" placeholder="document id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Upload Document</label>
                                <input type="file" class="form-control" name="document" id="document" placeholder="document">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Code</label>
                                <select style="width: 100% !important;" class="select form-control" name="country_code_whatsapp" id="country_code_whatsapp">                                
                                @foreach (get_country_code() as $code)
                                    <option value="{{ $code }}" data-address="{{$code }}">+{{ $code }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Whatsapp number</label>
                                <input type="tel" class="form-control" name="whatsapp_number" id="whatsapp_number" placeholder="whatsapp number">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Code</label>
                                <select style="width: 100% !important;" class="select form-control" name="country_code_phone" id="country_code_phone">                                
                                @foreach (get_country_code() as $code)
                                    <option value="{{ $code }}" data-address="{{$code }}">+{{ $code }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="phone">
                            </div>
                        </div>
                    </div>



                    <hr>
                    <h4>Add Address </h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country</label>
                                <select style="width: 100% !important;" class="select form-control" name="country_id" id="country_id">
                                    @foreach ($countries as $item)
                                        <option {{ ($item->id==14) ? 'selected' : "" }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">State</label>
                                <select style="width: 100% !important;" class="select form-control" id="state_id" name="state_id">
                                    <option value="273">Al Manamah</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">City</label>
                                <select style="width: 100% !important;" class="select form-control" id="city_id" name="city_id">
                                     
                                </select>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="">Pin Code</label>
                                <input type="text" id="zip_code" name="zip_code" class="form-control">
                                {{-- <select style="width: 100% !important;" disabled class="select2 form-control" id="city_modal_user" name="city_modal_user">
                                </select> --}}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phoneNumber1">Address</label>
                                <textarea rows="1" class="form-control" name="address" id="address" placeholder="address"></textarea>
                            </div>
                        </div>


                    </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="save_data_user">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

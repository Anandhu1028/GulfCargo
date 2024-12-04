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
                            <h4 class="page-title">{{page_title()}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <form action="{{ update_url($vehicle->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                                @csrf

                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Vehicle Name</label>
                                                <input type="text" name="name" value="{{ $vehicle->name }}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Vehicle Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Driver Name</label>
                                                <input type="text" name="driver_name" value="{{ $vehicle->driver_name }}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Driver Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Mobile Number</label>
                                                <input type="text" name="driver_mobile" value="{{$vehicle->driver_mobile}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Driver Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Registration Date</label>
                                                <input type="date" name="reg_date" value="{{$vehicle->reg_date}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter reg_date id">
                                            </div>
                                        </div>
                                        

                               
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Registration expiry</label>
                                                <input type="date" name="reg_expiry" value="{{$vehicle->reg_expiry}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter reg_expiry">
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Next passing</label>
                                                <input type="date" name="next_passing" value="{{$vehicle->next_passing}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter next_passing">
                                            </div>
                                        </div> 

                                
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Sticker permission expiry</label>
                                                <input type="date" name="sticker_permission_expiry" value="{{$vehicle->sticker_permission_expiry}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter sticker_permission_expiry">
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Insurance expiry</label>
                                                <input type="date" name="insurance_expiry" value="{{$vehicle->insurance_expiry}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter insurance_expiry">
                                            </div>
                                        </div> 

                                
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Traffic no</label>
                                                <input type="text" name="traffic_no" value="{{$vehicle->traffic_no}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter traffic_no">
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">GPS permit expiry</label>
                                                <input type="date" name="gps_permit_expiry" value="{{$vehicle->gps_permit_expiry}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter gps_permit_expiry">
                                            </div>
                                        </div> 
 
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Vehicle no</label>
                                                <input type="text" name="vehicle_no" value="{{$vehicle->vehicle_no}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter vehicle_no">
                                            </div>
                                        </div> 

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Status</label>
                                                <select class="form-control" name="status" required>
                                                <option value="vehicle_cancel"  @if($vehicle->status =='vehicle_cancel') selected @endif >Vehicle Cancel</option>
                                                <option value="upto_date"  @if($vehicle->status =='upto_date') selected @endif>Up to date</option>
                                                <option value="expire_nearby"  @if($vehicle->status =='expire_nearby') selected @endif>Expire near by</option>                                               
                                            </select>                                                
                                            </div>
                                        </div> 

                                </div>

 

                                <!-- end row -->

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>
                                </div>
                            </form>
                            <!-- end form -->

                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->


        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        2018 - 2020 &copy; Zircos theme by <a href="#">Coderthemes</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
@endsection

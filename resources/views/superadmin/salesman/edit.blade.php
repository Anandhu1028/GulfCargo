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
                            <form action="{{ update_url($salesman->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                                @csrf


                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Salesman Name</label>
                                                <input type="text" name="name" value="{{ $salesman->name }}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Salesman Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Route</label>
                                                <input type="test" name="route" value="{{ $salesman->route }}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter route id">
                                            </div>
                                        </div> 

                                </div>
                                 
                                <div class="row">
                                    <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Vehicles</label> 
                                                <select class="form-control" name="vehicle_id" required>
                                                @foreach($vehicles as $vehicle)
                                                <option value="{{$vehicle->id}}"   @if($vehicle->vehicle_id ==$vehicle->id) selected @endif>{{$vehicle->name}}</option>
                                                @endforeach                                          
                                            </select>                                                
                                            </div>
                                        </div>   

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Drivers</label> 
                                                <select class="form-control" name="driver_id" required>
                                                @foreach($drivers as $driver)
                                                <option value="{{$driver->id}}"   @if($vehicle->driver_id ==$driver->id) selected @endif>{{$driver->name}}</option>
                                                @endforeach                                          
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

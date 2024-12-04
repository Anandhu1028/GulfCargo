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
                                Ship Type
                            </div>
                            <h4 class="page-title">Ship type</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                        <form action="{{ update_url($ship_type->id) }}" method="post" enctype="multipart/form-data">                          
                                @csrf 
                                @method('PUT')
                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Name</label>
                                                <input type="text" name="name" value="{{$ship_type->name}}" class="form-control"
                                                    id="name" required
                                                    placeholder="Enter shipment type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Value</label>
                                                <input type="text" name="value" value="{{$ship_type->value}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Value">
                                            </div>
                                        </div>  
                                         
                                </div>

                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Driver Rate</label>
                                                <input type="text" name="driver_rate" value="{{$ship_type->driver_rate}}" class="form-control"
                                                    id="driver_rate" required
                                                    placeholder="Enter Driver Rate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Office Rate</label>
                                                <input type="text" name="office_rate" value="{{$ship_type->office_rate}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter office Rate">
                                            </div>
                                        </div>  
                                         
                                </div>


                                   
                                   

                                <div class="text-center"> 
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update
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
<script>
$(document).ready(function(){
    $('input.timepicker').timepicker({});
});
</script>
@endsection

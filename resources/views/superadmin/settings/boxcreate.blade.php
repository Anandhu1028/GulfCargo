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
                                Box Dimensions
                            </div>
                            <h4 class="page-title">Box Dimensions </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                            <form action="{{route('super-admin.boxdimension.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">Length</label>
                                            <input type="text" name="length" value="" class="form-control"
                                                   id="length" required
                                                   placeholder="Length">
                                        </div>  
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">Width</label>
                                            <input type="text" name="width" value="" class="form-control"
                                                   id="width" required
                                                   placeholder="width">
                                        </div>  
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">Height</label>
                                            <input type="text" name="height" value="" class="form-control"
                                                   id="height" required
                                                   placeholder="height">
                                        </div>  
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">Customer Packing</label>
                                            <input type="text" name="value" value="" class="form-control"
                                                   id="value" required
                                                   placeholder="value">
                                        </div>  
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">Cargo Packing</label>
                                            <input type="text" name="cargo_packing" value="" class="form-control"
                                                   id="cargo_packing" required
                                                   placeholder="cargo_packing">
                                        </div>  
                                    </div>

                                    <!-- end col -->
                                </div> 
                                 

                                <div class="text-center"> 
                          
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{url('super-admin/boxdimensionList')}}" type="button"
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

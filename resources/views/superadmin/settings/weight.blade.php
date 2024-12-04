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
                                Weight
                            </div>
                            <h4 class="page-title">Weight</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                            <form action="{{route('super-admin.booking.storeweight')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">Weight</label>
                                            <input type="text" name="weight" value="{{ !empty($weight)?$weight->weight:'' }}" class="form-control"
                                                   id="weight" required
                                                   placeholder="Weight">
                                        </div>  
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">Default Electronics Weight</label>
                                            <input type="text" name="electronics_weight" value="{{ !empty($weight->electronics_weight)?$weight->electronics_weight:'' }}" class="form-control"
                                                   id="electronics_weight" required
                                                   placeholder="Default Electronics Weight">
                                        </div>  
                                    </div>
                                   
                                    <!-- end col -->
                                </div> 
                                

                                <div class="text-center">

                                <input type="hidden" name="id" value="{{!empty($weight)?$weight->id:null}}" />
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{url('super-admin/dashboard')}}" type="button"
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

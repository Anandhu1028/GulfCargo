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
                                Discount
                            </div>
                            <h4 class="page-title">Discount</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                            <form action="{{route('super-admin.booking.storediscount')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">Discount amount</label>
                                            <input type="text" name="discount" value="{{ !empty($discount)?$discount->discount:'' }}" class="form-control"
                                                   id="discount" required
                                                   placeholder="Discount amount">
                                        </div>  
                                    </div>
                                   
                                    <!-- end col -->
                                </div>  


                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">Document Charge</label>
                                            <input type="text" name="document_charge" value="{{ !empty($discount)?$discount->document_charge:'' }}" class="form-control"
                                                   id="document_charge" required
                                                   placeholder="Document Charge">
                                        </div>  
                                    </div>
                                   
                                    <!-- end col -->
                                </div> 

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">Other Packing Charge</label>
                                            <input type="text" name="other_packing_charge" value="{{ !empty($discount)?$discount->other_packing_charge:'' }}" class="form-control"
                                                   id="other_packing_charge" required
                                                   placeholder="Other Packing Charge">
                                        </div>  
                                    </div>
                                   
                                    <!-- end col -->
                                </div>
                                

                                

                                <div class="text-center">

                                <input type="hidden" name="id" value="{{!empty($discount)?$discount->id:null}}" />
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

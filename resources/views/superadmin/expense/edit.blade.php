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
                            <form action="{{ update_url($expense->id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                                @csrf



                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Particulars</label>
                                                <input type="text" name="particulars" value="{{ $expense->particulars}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter particulars">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Total amount</label>
                                                <input type="test" name="total_amount" value="{{ $expense->total_amount}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter total amount">
                                            </div>
                                        </div> 

                                </div>
                                 
                                <div class="row">
                                    <div class="col-lg-6">
                                            <div class="form-group">  
                                            <label for="propertyname">Cheque valid till</label>
                                                <input type="test" name="chq_valid_till" value="{{ $expense->chq_valid_till}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter cheque  valid till">
                                                                                                     
                                            </div>
                                        </div>   

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                            <label for="propertyname">Remarks</label>
                                                <input type="test" name="remarks" value="{{ $expense->remarks}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter remarks"> 
                                                                                       
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

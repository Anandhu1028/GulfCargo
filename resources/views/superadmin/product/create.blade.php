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
                            <form action="{{store_url()}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label for="product_name">Product Name</label>
                                                <input type="text" name="product_name" value="{{old('product_name')}}" class="form-control"
                                                    id="product_name" required
                                                    placeholder="Enter Product Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="uom">UOM</label>
                                                <select name="uom" value="{{old('email')}}" class="form-control"
                                                    id="uom" required
                                                    placeholder="Enter UOM">
                                                    <option value="">Select Option</option>
                                                    <option value="kg">Kg</option>
                                                    <option value="Pcs">Pcs</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label for="logo">Select Branch</label>
                                                <select class="form-control" name="branch_id" required>
                                                    <option value>Select Branch</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        

                                </div>
                                
                                <div class="row">

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="opening_stock">Opening Stock</label>
                                                <input type="text" name="opening_stock" value="" class="form-control"
                                                    id="opening_stock" placeholder="Enter Opening Stock">
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="closing_stock">Closing Stock </label>
                                                <input type="text" name="closing_stock" value="{{old('closing_stock')}}" class="form-control"
                                                    id="closing_stock" required
                                                    placeholder="Enter Closing Stock"> 
                                            </div> 
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="unit_rate">Unit Rate</label>
                                                <input type="text" name="unit_rate" value="{{old('unit_rate')}}" class="form-control"
                                                    id="unit_rate" required
                                                    placeholder="Enter Unit Rate"> 
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="body" id="boxDimension1">
                                                <div class="row">
                                                    <div class="col-md-2 box-title"> 
                                                        <h6>Dimension</h6>
                                                    </div>
                                                </div>
                                                <div class="row">                                        
                                                    <div class="col-md-2">  
                                                        <div class="form-group">
                                                            <label>Length</label>
                                                            <input type="text" name="length" value="" class="form-control box-length">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">  
                                                        <div class="form-group">
                                                            <label>Width</label>
                                                            <input type="text" name="width" value="" class="form-control box-width">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">  
                                                        <div class="form-group">
                                                            <label>Height</label>
                                                            <input type="text" name="height" value="" class="form-control box-height">
                                                        </div>
                                                    </div>
                                            
                                        </div>
                                </div>
                                <!-- end row -->

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
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
        $(document).on('keyup','#opening_stock', function(event) {
            var openingstock = $(this).val();
            $("#closing_stock").val(openingstock);
        });
    </script>
@endsection

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
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Agency Name</label>
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Agency Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                <label for="propertyname">Email</label>
                                                <input type="email" name="email" value="{{old('email')}}" class="form-control"
                                                    id="agencyEmail" required
                                                    placeholder="Enter Email">
                                                @error('email')
                                                <ul class="parsley-errors-list filled" id="parsley-id-45">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                                @enderror
                                            </div>
                                        </div>  

                                </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="address">Password </label> 
                                                <input type="password" name="password" value="" class="form-control"
                                                    id="password" required
                                                    placeholder="Enter password">
                                            </div> 
                                        </div>
                                       
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Contact number</label>
                                                <input type="text" name="contact_no" value="{{old('contact_no')}}" class="form-control"
                                                    id="contact_no" required
                                                    placeholder="Enter contact number">
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="gst_no">GST no </label>
                                                <input type="text" name="gst_no" value="{{old('gst_no')}}" class="form-control"
                                                    id="gst_no" required
                                                    placeholder="Enter GST number"> 
                                            </div> 
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="agency_code">Agency Code</label>
                                                <input type="text" name="agency_code" value="{{old('agency_code')}}" class="form-control"
                                                    id="agency_code" required
                                                    placeholder="Enter Agency Code"> 
                                            </div> 
                                        </div>
                                       
                                </div>                                       
                                <div class="row">

                                    <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="address">Location </label> 
                                                <textarea rows="3" class="form-control" name="address" id="address" placeholder="Location"> {{old('name')}}</textarea>
                                            </div> 
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="logo">Logo</label>
                                                <input type="file" name="logo"  class="form-control"
                                                    id="logo" required >
                                            </div>
                                        </div>

                                </div>
                                <!-- end row -->


                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="country">Country </label>
                                                <input type="text" name="country" value="{{old('country')}}" class="form-control"
                                                    id="country" placeholder="Enter Country"> 
                                            </div> 
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="state">Emirates/ State</label>
                                                <input type="text" name="state" value="{{old('state')}}" class="form-control"
                                                    id="state" placeholder="Enter Emirates/ State"> 
                                            </div> 
                                        </div>
                                       
                                </div>   

                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="district">District </label>
                                                <input type="text" name="district" value="{{old('district')}}" class="form-control"
                                                    id="district" placeholder="Enter District"> 
                                            </div> 
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="post">Post</label>
                                                <input type="text" name="post" value="{{old('post')}}" class="form-control"
                                                    id="post"  placeholder="Enter Post"> 
                                            </div> 
                                        </div>
                                       
                                </div>   

                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="pincode">Pincode </label>
                                                <input type="text" name="pincode" value="{{old('pincode')}}" class="form-control"
                                                    id="pincode" 
                                                    placeholder="Enter Pincode"> 
                                            </div> 
                                        </div>

                                     
                                       
                                </div>   


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

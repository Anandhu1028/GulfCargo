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
                                                <label for="propertyname">Driver Name</label>
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Driver Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Email</label>
                                                <input type="text" name="email" value="{{old('email')}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Email id">
                                            </div>
                                        </div>


                                </div>

                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="propertyname">Contact number</label>
                                                <input type="text" name="mobile" value="{{old('mobile')}}" class="form-control"
                                                    id="mobile" required
                                                    placeholder="Enter contact number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password">Password </label>
                                                <input type="password" name="password" value="" class="form-control"
                                                    id="" required
                                                    placeholder="**********">
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-lg-6">
                                            <div class="">
                                                <div class="form-group">
                                                    <label for="vehicle_number">Vehicle no </label>
                                                    <input type="text" name="vehicle_number" value="{{old('vehicle_number')}}" class="form-control"
                                                        id="vehicle_number" required
                                                        placeholder="Enter Vehicle number">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="logo">Selct Branch</label>
                                                <select class="form-control" name="branch_id" required>
                                                <option value>Selct Branch</option>
                                                @foreach(\App\Models\Branches::all() as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="location">Location </label>
                                                <textarea rows="4" class="form-control" name="location"  id="location" placeholder="Location"> {{old('location')}}</textarea>
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

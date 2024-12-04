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
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="propertyname">Name</label>
                                                <input type="text" name="name" value="{{old('name')}}" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Name">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="propertyname">Email</label>
                                                <input type="text" name="email"  id="email" class="form-control"
                                                    id="propertyname" required
                                                    placeholder="Enter Email id">
                                            </div>
                                        </div> 
 
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="mobile">Mobile</label> 
                                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile Number">                                      
                                            </div>
                                        </div> 

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="logo">Location</label> 
                                                <input type="text" class="form-control" name="location" id="location" placeholder="Location">                                      
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="person">Authorized Person</label> 
                                                <input type="text" class="form-control" name="authorized_person" id="authorized_person" placeholder="Authorized">                                      
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="propertyname">Status</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="1">Active</option>
                                                <option value="0">Inative</option>
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
    <script>
    $('#country_id').change(function () {
                var country_id = $(this).val();
                $('#loader').removeClass('d-none');
                const url = "{{route('states')}}?country_id=" + country_id;
                console.log(url);
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        // when call is sucessfull
                        console.log(result);
                        $('#loader').addClass('d-none');
                        let option = ``;
                        $('#state_id').html('<option value="">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });

                    }, error: function (er) {
                        console.log(er);
                    }

                }); // ajax call closing
            })


    </script>
@endsection

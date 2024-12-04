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
                                City
                            </div>
                            <h4 class="page-title">City </h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                            <form action="{{route('super-admin.city.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">State name</label> 
                                                   <select name='state_id'  class='form-control' >
                                                    @foreach( $states as $val )
                                                        <option value='{{$val->id}}'>{{$val->name}} </option> 
                                                    @endforeach 
                                                    </select>

                                        </div>  
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">City name</label>
                                            <input type="text" name="name" value="" class="form-control"
                                                   id="name" required
                                                   placeholder="name">
                                        </div>  
                                    </div>
                                    

                                    <!-- end col -->
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
<script>
$(document).ready(function(){
    $('input.timepicker').timepicker({});
});
</script>
@endsection

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
                                Profile
                            </div>
                            <h4 class="page-title">Edit Profile</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                            <form action="{{route('super-admin.user.profileupdate')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="propertyname">Name</label>
                                            <input type="text" name="name" value="{{ !empty($user)?$user->name:'' }}" class="form-control"
                                                   id="name" required
                                                   placeholder="Name"> 
                                        </div>  
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="propertyname">Email</label>
                                            <input type="text" name="email" value="{{ !empty($user)?$user->email:'' }}" class="form-control"
                                                   id="email" required readonly
                                                   placeholder="Email"> 
                                        </div>  
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Upload Photo</label>
                                            <input type="file" class="form-control" name="profile_photo" id="profile_photo" placeholder="document">
                                        </div> 
                                    </div> 
                                  
                               
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        @if(!empty($user_details->profile_photo))
                                                <img src="{{ url($user_details->profile_photo) }}"  style="padding-left:100px; height:160px;"/>
                                                @endif
                                             
                                        </div>  
                                    </div> 

                                </div>  

                                
                                

                                <div class="text-center">

                                <input type="hidden" name="user_id" value="{{$user->id }}" />
                                <input type="hidden" name="staff_id" value="{{$user_details->id }}" />
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

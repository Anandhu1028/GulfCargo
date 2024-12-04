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

                            <form action="{{update_url($attendance->id)}}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="propertyname">Staff Name</label>
                                            <input readonly type="text" value="{{$attendance->staff->full_name}}"
                                                   class="form-control" id="propertyname"
                                                   placeholder="Enter title">
                                        </div>

                                    </div>

                                    <div class="col-lg-4">
                                        <div class="p-2">
                                            <div class="form-group">
                                                <label class="mb-2">Attendance</label>
                                                <br/>
                                                <div class="radio radio-info form-check-inline">
                                                    <input type="radio" id="attendance1" value="1"
                                                           name="attendance"
                                                           @if($attendance->present==1) checked @endif

                                                    >
                                                    <label for="attendance1">Present</label>
                                                </div>
                                                <div class="radio radio-info form-check-inline">
                                                    <input type="radio" id="attendance2"
                                                           value="0" @if($attendance->present==0) checked @endif
                                                           name="attendance">
                                                    <label for="attendance2">Absent</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="p-2">
                                            <div class="form-group">
                                                <label class="mb-2">Late</label>
                                                <br/>
                                                <div class="radio radio-info form-check-inline">
                                                    <input type="radio" id="lateyes" value="1"
                                                           name="late" @if($attendance->late==1) checked @endif
                                                    >
                                                    <label for="lateyes">Yes </label>
                                                </div>
                                                <div class="radio radio-info form-check-inline">
                                                    <input type="radio" id="lateno" value="0"
                                                           name="late" @if($attendance->late==0) checked @endif>
                                                    <label for="lateno">No</label>
                                                </div>
                                            </div>
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
@endsection

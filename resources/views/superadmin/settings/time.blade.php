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

                            <div class="fa-pull-left pb-3">
                                <a href="{{route('super-admin.staffs.index')}}" class="btn btn-primary">Staff List</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.index')}}" class="btn btn-primary">Attendence List</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.markAttendence')}}" class="btn btn-primary">Mark Attendence</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.report')}}" class="btn btn-primary">Attendence Report</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.time')}}" class="btn btn-primary">Attendence Time</a>&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                         
                            <form action="{{route('super-admin.attendence.storetime')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">CheckIn time from</label>
                                            <input type="text" name="checkin_from" value="{{ !empty($attendence)?$attendence->checkin_from:'' }}" class="timepicker form-control"
                                                   id="propertyname" required
                                                   placeholder="Check in from">
                                        </div>  
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">CheckIn time To</label>
                                            <input type="text" name="checkin_to" value="{{ !empty($attendence)?$attendence->checkin_to:'' }}" class="timepicker form-control"
                                                   id="propertyname" required
                                                   placeholder="Check in To">
                                        </div>  
                                    </div>
                                    <!-- end col -->
                                </div>


                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">CheckOut time from</label>
                                            <input type="text" name="checkout_from" value="{{!empty($attendence)?$attendence->checkout_from:'' }}" class="timepicker form-control"
                                                   id="propertyname" required
                                                   placeholder="Checkout From">
                                        </div>  
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="propertyname">CheckOut time To</label>
                                            <input type="text" name="checkout_to" value="{{!empty($attendence)?$attendence->checkout_to:'' }}" class="timepicker form-control"
                                                   id="propertyname" required
                                                   placeholder="Checkout To">
                                        </div>  
                                    </div>
                                    <!-- end col -->
                                </div>

                                <div class="text-center">

                                <input type="hidden" name="id" value="{{!empty($attendence)?$attendence->id:null}}" />
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
<script>
$(document).ready(function(){
    $('input.timepicker').timepicker({
    timeFormat: 'h:mm p',
    interval: 5,   
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
});
</script>
@endsection

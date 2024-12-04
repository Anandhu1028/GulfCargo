@extends('layouts.app')

@section('content')

session('timezone')


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
                <form  action="{{ url('super-admin/markAttendence') }}" method="get">
                @csrf
                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group"> 
                                                <input type="text" value="{{ isset($search_user)? $search_user:'' }}" class="form-control" id="propertyname" name="search_user"
                                                    placeholder="Enter user name">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Search
                                        </button>
                                    </div>
                            </div> 
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
CheckIn Time : {{$attend_time->checkin_from}} To {{$attend_time->checkin_to}} | 
Checkout Time : {{ $attend_time->checkout_from}} To {{$attend_time->checkout_to}}
 
                         
                             
                                <div class="form-group text-center">
                                    <label for="propertyname">Attendance Date</label>
                                   <input type="text"  readonly value="{{date('Y-m-d')}}"  name="date" class="form-control " id="propertyname"   placeholder="Enter title"> 
                                </div>
                                @foreach($staffs as $staff)
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                
                                                <input readonly type="text" value="{{$staff->full_name}}"
                                                       class="form-control" id="propertyname"
                                                       placeholder="Enter title">
                                            </div>

                                        </div>

                                      
                                        <div class="col-lg-3">
                                         
                                            <div class="form-group"> 

                                            <form id="form{{$staff->id}}" action="{{route('super-admin.attendence.markPresent')}}" method="POST">@csrf
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                    <!-- <input type="date" value="{{date('Y-m-d')}}"  name="date" class="form-control " id="propertyname"   placeholder="Enter title">  -->
                                                    <input type="hidden" value="{{ $staff->id }}"  name="employ_id" class="form-control " id="employ_id"   >  
                                                    
                                                    </div>

                                                    <div class="col-lg-4">
                                                    <input type="submit"    class="btn btn-success   @if(is_marked_present($staff))btn-disabled @endif "    name="submit" value="Mark as present"  onclick="return confirm('Are you sure you want  mark present ?');" />
                                                    </div>
                                                </div>                                                
                                            </form>
 
                                            </div>
                                           
                                        </div>

                                        <div class="col-lg-3">
                                         
                                            <div class="form-group"> 

                                            <form id="form{{$staff->id}}" action="{{route('super-admin.attendence.markAbsent')}}" method="POST">@csrf
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                    <!-- <input type="date" value="{{date('Y-m-d')}}"  name="date" class="form-control " id="propertyname"   placeholder="Enter title">  -->
                                                    <input type="hidden" value="{{ $staff->id }}"  name="employ_id" class="form-control " id="employ_id"   >  
                                                    
                                                    </div>

                                                    <div class="col-lg-4">
                                                    <input type="submit"    class="btn btn-danger   @if(is_marked_absent($staff))btn-disabled @endif "    name="submit" value="Mark as absent"  onclick="return confirm('Are you sure you want  mark absent ?');" />
                                                    </div>
                                                </div>                                                
                                            </form>
 
                                            </div>
                                           
                                        </div>
                                        <!-- end col -->

                                    </div>
                                @endforeach
                                <!-- <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>
                                </div> -->
                         
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


        <!-- Modal -->


        
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div id="message"> Please add the finger print </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



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
    <style>
        .btn-disabled,
        .btn-disabled[disabled] {
            opacity: .4;
            cursor: default !important;
            pointer-events: none;
        }
    </style>
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')

    
<script language="javascript" type="text/javascript">


var quality = 60; //(1 to 100) (recommanded minimum 55)
var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0 )
var flag = 0;

// Function used to match fingerprint using jason object 

function Match(fp, staff_id, type) {
     alert("Please place the finger on the device");
    try {
      //fingerprint stored as isotemplate
      
        var isotemplate = fp ;
        var res = MatchFinger(quality, timeout, isotemplate);

        if (res.httpStaus) {
            if (res.data.Status) {
                alert("Finger matched");
                attendenceMark(staff_id, type); 
                flag=1;
            }
            else {
                if (res.data.ErrorCode != "0") {
                    alert(res.data.ErrorDescription);
                }
                else {
                    alert("Finger not matched");
                }
            }
        }
        else {
            alert(res.err);
        }
    }
    catch (e) {
        alert(e);
    }
    return false;

}

function attendenceMark(staff_id, type){ 

                $.ajax({
                    headers: {
                        "content-type" : "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url:  `{{ route('branch.attendancefp.clockInOutfp') }}`,
                    type: "POST", 
                    async:false,
                    data: JSON.stringify({"employ_id":staff_id, "type":type }), 
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {  
                        // $("#message").html("<i class='fa fa-check-circle' style='color:green'></i>"+result);
                        toastr.success(result)
                        location.reload();
                     },
                    error: function (err) {
                     
                        console.log(err);
                       
                    }
                }); // ajax call closing
}

//function to redirect to next page upon fingerprint matching

function redirect(){


if(flag){ 
window.location.assign("url"); 
}
else{
alert("Scan Your Finger");
}

return false;
}

</script>

@endsection

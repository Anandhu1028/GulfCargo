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
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <form  action="{{ url('branch/attendance/create') }}" method="get">
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
                            <div class="row">
                                <div class="col-md-8">  
                                    CheckIn Time : {{$attend_time->checkin_from}} To {{$attend_time->checkin_to}} | 
                                    Checkout Time : {{ $attend_time->checkout_from}} To {{$attend_time->checkout_to}} 
                                </div> 
                                <div class="col-md-4">
                                    <a href="{{index_url()}}" type="button"
                                    class="btn btn-primary waves-effect waves-light" style="float:right;">Back
                                    </a>
                                </div>
                            </div>
 
                            <form action="{{store_url()}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group text-center">
                                    <label for="propertyname">Attendance Date</label>
                                    <input readonly type="text" value="{{date('Y-m-d')}}"
                                           class="form-control" id="propertyname"
                                           placeholder="Enter title">
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

                                         
                                        <div class="col-lg-6">
                                         
                                            <div class="form-group">
                                            @if($staff->fingerprint_mandatory == 'yes')
                                                <button type="input" onclick="return Match({{ json_encode($staff->fingerprint)}}, {{$staff->id}}, 'clockin')" class="btn btn-primary  @if(is_clocked($staff,'in'))btn-disabled @endif "   > {{date('h:i a')}} Clock
                                                    In </button>
                                            @else

                                                <a href="{{route('branch.attendance.clockInOut')}}?employ_id={{$staff->id}}&type=clockin"
                                                   class="btn btn-primary @if(is_clocked($staff,'in'))btn-disabled @endif"   onclick="return confirm('Are you sure you want to Check in?');">{{date('h:i a')}} Clock
                                                    In</a>
                                            @endif

                                            @if($staff->fingerprint_mandatory == 'yes')
                                                <button type="input" onclick="return Match({{ json_encode($staff->fingerprint)}}, {{$staff->id}}, 'clockout')" class="btn btn-secondary @if(is_clocked($staff,'out'))btn-disabled @endif ">{{date('h:i a')}} Clock
                                                    Out</button>
                                            @else
                                                <a href="{{route('branch.attendance.clockInOut')}}?employ_id={{$staff->id}}&type=clockout"
                                                   class="btn btn-secondary @if(is_clocked($staff,'out'))btn-disabled @endif"  onclick="return confirm('Are you sure you want to Check out?');">{{date('h:i a')}} Clock
                                                    Out</a>
                                            @endif
                                                 
                                            </div>
                                           
                                        </div>
                                        <!-- end col -->

                                    </div>
                                @endforeach
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

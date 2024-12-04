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
                                 Attencedence
                            </div>
                            <h4 class="page-title">Attendence</h4>
                            @can(permission_create())
                                <div class="fa-pull-right pb-3"><a href="{{create_url()}}"
                                                                   class="btn btn-success">Add New</a></div>
                            @endcan

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


                <div class="row">
                        <div class="col-sm-6">
                            <table style="font-size:20px;">
                                <tr>
                                    <th>Total Present</th><th>:</th><th><span id="total_present_label"></span> &nbsp;&nbsp;&nbsp; (special attendence + checked in)</th>
                                </tr>
                                <tr>
                                    <th>Total Absent</th><th>:</th><th><span id="total_absent_label"></span></th>
                                </tr>
                                <tr>
                                    <th>Total Partial</th><th>:</th><th><span id="total_partial_label"></span></th>
                                </tr>
                            </table> 
                        </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <div class="card-box table-responsive">
                            <form action="" method="get">

                            <div class="row">
                                <div class="col-sm-2">Date From</div>
                                <div class="col-sm-2">Date To</div>
                                <div class="col-sm-2">Select Status</div>
                                <!-- <div class="col-sm-2">Special Attendence</div> -->

                                <div class="col-sm-4"></div>
                            </div>  
                            <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group"> 
                                                <input type="date" value="{{ isset($date_from) ? $date_from : ''}}" max="{{date('Y-m-d')}}"
                                                    class="form-control" id="propertyname" name="date_from"
                                                    placeholder="Enter title">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="date" value="{{ isset($date) ? $date : ''}}" max="{{date('Y-m-d')}}"
                                                    class="form-control" id="propertyname" name="date"
                                                    placeholder="Enter title">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> 
                                            <select name="status" id="status" class="form-control">
                                                    <option   {{ ($selected_status == "" ) ? "selected" : "" }}  value="">All</option>
                                                    <option   {{ ($selected_status == "Present" ) ? "selected" : "" }}  value="Present">Present</option>
                                                    <option  {{ ($selected_status == "absent" ) ? "selected" : "" }}   value="absent">Absent</option>
                                                    <option    {{ ($selected_status == "Partial" ) ? "selected" : "" }} value="Partial">Partial</option>
                                                    <option    {{ ($selected_status == "Checked In" ) ? "selected" : "" }} value="Checked In">Checked In</option>
                                                    <option    {{ ($selected_status == "today_present" ) ? "selected" : "" }} value="today_present">Todays Present</option>
                                                    <option    {{ ($selected_status == "today_absent" ) ? "selected" : "" }} value="today_absent">Todays Absent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-2">
                                        <div class="form-group"> 
                                            <select name="special_attendence" id="special_attendence" class="form-control">
                                                    <option   {{ ($selected_status_special == "" ) ? "selected" : "" }}  value="">Select</option>
                                                    <option   {{ ($selected_status_special == 1 ) ? "selected" : "" }}  value="1">True</option>                                              
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                        </button>
                                    </div>
                            </div> 
                            <?php if( $date_from == null){
                                 $date_from =  $date;

                                 $date_from = date('Y-m-d');
                                 $date = date('Y-m-d');
                            } 
                            ?>


                                <!-- <div class="row justify-content-center">
                                    <div class="form-group">
                                        <input type="date" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}"
                                               class="form-control" id="propertyname" name="date"
                                               placeholder="Enter title">
                                    </div>
                                    <div class="pl-1 pt-1  " style="vertical-align:bottom"> 

                                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                        </button>
                                    </div>

                                </div> -->
                            </form>
                            <table id="datatable_attandence"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>

                                <tr>
                                    <th>Sl No</th>
                                    <th>Staff Name</th> 
                                    <!-- <th>Staff Status</th>  -->
                                    <th>Branch</th>
                                    <th>Date</th>
                                    <th>Staff ID</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Attendance</th>
{{--                                    <th>Late</th>--}}
                                    <th width="5%">Actions</th>
                                </tr>

                                </thead>

                                <tbody>
                                <?php
                                    $total_present  = 0;
                                    $total_partial  = 0;
                                    $total_absent   = 0;
                                ?>
                                
                                @foreach($attendances as $key=> $attendance)

                                <?php 
                                    if($attendance->status == ""  || $attendance->status == 'Absent' || $attendance->status == 'Checked In' || $attendance->status == NULL) {
        
                                        if( $attendance->clock_in != '' &&  $attendance->clock_out !=''){

                                            $time_diff = $attendance->clock_out - $attendance->clock_in;
                                            $difference_in_hour = $time_diff/3600; // gmdate("H", $time_diff);

                                            if(  $attendance->clock_in <= strtotime($attend_time->checkin_to) ) {  

                                                if($difference_in_hour < 6) {
                                                    $attendance_status =  "Absent";
                                                    $style = "background-color:red;padding:5px;color:black;";
                                                    $total_absent = $total_absent+1;
                                                    update_attendence_status($attendance->id, $attendance_status );

                                                } else  if ( $difference_in_hour > 6  && $difference_in_hour < 12){
                                                    $attendance_status = "Partial";
                                                    $style = "background-color:yellow;padding:5px;color:black;";
                                                    $total_partial = $total_partial+1;
                                                    update_attendence_status($attendance->id, $attendance_status );
                                                } 
                                                else {
                                                    $attendance_status = "Present";
                                                    $style = "background-color:green;padding:5px;color:black;";
                                                    $total_present = $total_present+1;
                                                    update_attendence_status($attendance->id, $attendance_status );
                                                }          
                                            } else if(  $attendance->clock_in > strtotime($attend_time->checkin_to)) {
                                                
                                                $diff =  $attendance->clock_in - strtotime( $attend_time->checkin_to  );
                                                $diffhr =  $diff/3600; //gmdate("H", $diff);  
                                                if(  $diffhr >= 6 ){  

                                                        $attendance_status =  "Absent";
                                                        $style = "background-color:red;padding:5px;color:black;";
                                                        $total_absent = $total_absent+1;
                                                        update_attendence_status($attendance->id, $attendance_status );
                                                }else {
                                                    // $difference_in_hour = $difference_in_hour/3600; //gmdate("H", $difference_in_hour);
                                                    if($difference_in_hour >= 6) {
                                                        $attendance_status = "Partial";
                                                        $style = "background-color:yellow;padding:5px;color:black;";
                                                        $total_partial = $total_partial+1;
                                                        update_attendence_status($attendance->id, $attendance_status );

                                                    } else {
                                                        $attendance_status =  "Absent";
                                                        $style = "background-color:red;padding:5px;color:black;";
                                                        $total_absent = $total_absent+1;
                                                        update_attendence_status($attendance->id, $attendance_status );
    
                                                    } 
                                                }
                                               
                                            }  
                                        } else  if( $attendance->clock_in != '' &&  $attendance->clock_out ==''){
                                            
                                            $style ="";
                                            $attendance_status = "-";
                                            $diff =  $attendance->clock_in - strtotime( $attend_time->checkin_to  );
                                            $diffhr = $diff/3600; //gmdate("H", $diff);  
                                            if(  $diffhr >= 6 ){   
                                                $attendance_status =  "Absent";
                                                $style = "background-color:red;padding:5px;color:black;";
                                                $total_absent = $total_absent+1;
                                                update_attendence_status($attendance->id, $attendance_status );
                                            } else {
                                                    $current_time = time(); 

                                                    $time_diff = $current_time - $attendance->clock_in;
                                                    $difference_in_hour = $time_diff/3600; //gmdate("H", $time_diff); 
                                                    
                                                    if( $difference_in_hour >=12  ){
                                                        $attendance_status = "Present";
                                                        $style = "background-color:green;padding:5px;color:black;";
                                                        $total_present = $total_present+1;
                                                        update_attendence_status($attendance->id, $attendance_status );

                                                    } 
                                                    else{

                                                        if(date('d-m-Y', strtotime($attendance->date)) == date('d-m-Y')) {
                                                            $attendance_status =  "Checked In";  
                                                            $style = "background-color:#0dde0d;padding:5px;color:black;";
                                                            update_attendence_status($attendance->id, $attendance_status );

                                                        } else {
                                                            $attendance_status =  "Absent";
                                                            $style = "background-color:red;padding:5px;color:black;";
                                                            $total_absent = $total_absent+1;
                                                            update_attendence_status($attendance->id, $attendance_status );
                                                        }                                                       

                                                    }
                                            }

                                        } else {
                                                    $attendance_status =  "Absent";
                                                    $style = "background-color:red;padding:5px;color:black;";
                                                    $total_absent = $total_absent+1;
                                                    update_attendence_status($attendance->id, $attendance_status );
                                                    
                                        }
                                    } else {

                                        if($attendance->status  == "Present" || $attendance->status  ==  "present" ||  $attendance->status  ==  "Checked In"  ){
                                            $total_present = $total_present+1;
                                            $style = "background-color:green;padding:5px;color:black;";
                                        } else if($attendance->status  == "Absent" || $attendance->status  ==  "absent" ){  
                                            $style = "background-color:red;padding:5px;color:black;";
                                            $total_absent = $total_absent+1;
                                        }else if($attendance->status  == "Partial" || $attendance->status  == "partial" ){  
                                            $style = "background-color:yellow;padding:5px;color:black;";
                                            $total_partial = $total_partial+1;
                                        }else if($attendance->status  == "Checked In" || $attendance->status  == "Checked In" ){  
                                            $style = "background-color:#0dde0d;padding:5px;color:black;";
                                           // $total_partial = $total_partial+1;
                                        }

                                    }
                                    ?>
                                    <tr>
                                        <td width="10%">{{$key+1}}</td>
                                        <td>{{$attendance->staff->full_name }}</td>
                                        <!-- <td>  {{ucfirst($attendance->staff->staff_status) }} </td> -->
                                        <td> {{ucfirst($attendance->staff->branch->name) }}</td>
                                        <td>{{!empty($attendance->date) ? date('d-m-Y', strtotime($attendance->date)) :'' }}</td>
                                        
                                        <td>{{$attendance->staff->staff_id?$attendance->staff->staff_id:'-'}}</td>
                                        <td>{{$attendance->clock_in?date('h:i:a',$attendance->clock_in):"---"}}</td>
                                        <td>{{$attendance->clock_out?date('h:i:a',$attendance->clock_out):"---"}}                                        
                                        </td>
                                        <td>
                                            <span style="<?= $style??''?>">{{ $attendance_status??$attendance->status}}</span>
                                        </td>

                                        <form method="post" action="{{delete_url($attendance->id)}}">
                                            <td>
                                                <a href="{{edit_url($attendance->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <input type="hidden" id="total_present" value=" {{$total_present}}" />
                            <input type="hidden" id="total_absent" value=" {{$total_absent}}" />
                            <input type="hidden" id="total_partial" value=" {{$total_partial}}" />
                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->

@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
@include('layouts.datatables_js')
<script>
    // total_present_label
$( document ).ready(function() {
    $('#total_present_label').html( $('#total_present').val());
    $('#total_absent_label').html( $('#total_absent').val());
    $('#total_partial_label').html( $('#total_partial').val());
});

var totalPresent =  $('#total_present').val();
var totalAbsent =  $('#total_absent').val();
var totalPartial =  $('#total_partial').val();

$('#datatable_attandence').DataTable( {
    dom: 'Bfrtip',
    columnDefs: [{ 'orderable': false, 'targets': 7 }],
    buttons: [
            {
                extend: 'csv',
                messageTop: 'All Branches\r\n Attendence between <?=$date_from?>  and <?=$date?>.',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]
                    }
            },
            {
                extend: 'excel',
                messageTop: 'All Branches Attendence between <?=$date_from?>  and <?=$date?>.',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]

                    }
            },
            {
                extend: 'pdf',
                messageTop: 'All Branches\r\n Attendence between <?=$date_from?>  and <?=$date?>.',
                exportOptions: {
                        columns: [0,1,2,3,4,5,6,7]

                    },
                    customize: function ( doc ) {
                    // Splice the image in after the header, but before the table
                    doc.content.splice( 1, 0, {
                        alignment: 'right',
                        text: 'Total Present: '+ totalPresent +'\r\n Total Absent: '+ totalAbsent +'\r\n Total Partial Present: '+ totalPartial,
                    } );
                    // Data URL generated by http://dataurl.net/#dataurlmaker
                }
            }
        ]
} );

</script>
<script>
        $('#datatable').dataTable({
            'columnDefs': [{ 'orderable': false, 'targets': 5 }], // hide sort icon on header of first column
        });
    </script>
@endsection

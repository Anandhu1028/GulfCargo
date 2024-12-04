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
                                 Attencedence Reort
                            </div>
                            <h4 class="page-title">Attendence Report</h4>
                            @can(permission_create())
                                <div class="fa-pull-right pb-3"><a href="{{create_url()}}"
                                                                   class="btn btn-success"></a></div>
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
                    <div class="col-sm-12">

                        <div class="card-box table-responsive">
                            <form action="" method="get">

                            <div class="row">
                                <!-- <div class="col-sm-2"></div> -->

                                <div class="col-md-2">Select Branch</div>


                                <div class="col-sm-2">Select Month</div>
                                <div class="col-sm-2">Select Status</div>
                                <div class="col-sm-4"></div>
                            </div>                               

                            <div class="row">
                                    <!-- <div class="col-sm-2"></div> -->
                                    

                                    <div class="col-md-2">
                                        <div class="form-group"> 
                                            <select name="branch_id" id="branch_id" class="form-control">
                                            <option  value=""> Select Branch</option>
                                                @foreach ($all_branches as $branch)  
                                                    <option   {{ ($selected_branch_id ==$branch->id) ? "selected" : "" }}  value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="month" value="{{ isset($date_from) ?  date('Y-m', strtotime($date_from)) : ''}}" max="{{date('Y-m-d')}}"
                                                    class="form-control" id="date_from" name="date_from"
                                                    placeholder="Enter title">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group"> 
                                            <select name="status" id="status" class="form-control"> 
                                                    <option   {{ ($selected_status == "active" ) ? "selected" : "" }}  value="active">Active</option>
                                                    <option  {{ ($selected_status == "inactive" ) ? "selected" : "" }}   value="inactive">Inactive</option>
                                                    <option    {{ ($selected_status == "cancel" ) ? "selected" : "" }} value="cancel">Cancel</option>
                                              
                                            </select>
                                        </div>
                                    </div>


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

                            </form>
                            <table id="datatable_attandence_report"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>

                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    @for($i = 1; $i <= $days; $i++)
                                    <th style="text-align:center;">{{ $i}}</th> 
                                    @endfor
                                    <th>Tot Present</th>
                                    <th>Tot Partial</th>
                                    <th>Tot Absent</th> 
                                    <th>Generate</th> 
                                </tr>

                                </thead>

                                <tbody>
                                  
                                    @foreach($empatts as $key => $att )

                                    <?php 
                                        $total_present = 0;
                                        $total_partial = 0;
                                        $total_absent = 0;
                                    ?>

                                    <tr> 
                                        <td>{{ $key+1 }}</td>
                                        <td>{{$att->full_name }}</td>
                                            @foreach($att->attendence as $day => $val )
                                            <td style="text-align:center;"> 
                                            <?php     
                                            $attendance_status = null;
                                            if( $val->clock_in != '' &&  $val->clock_out !='') {
                                                    $time_diff          = $val->clock_out - $val->clock_in;
                                                    $difference_in_hour = $time_diff/3600; //gmdate("H", $time_diff);
                                                    if( $val->clock_in <= strtotime($attend_time->checkin_to) ) {  
                                                        if($difference_in_hour < 6) {                                                            
                                                            $total_absent       = $total_absent+1; 
                                                            $attendance_status  =  "Absent";
                                                            $style              = "background-color:red;padding:5px;color:black;";

                                                        } else if ( $difference_in_hour > 6  && $difference_in_hour < 12) {
                                                            $attendance_status  = "Partial";
                                                            $style              = "background-color:yellow;padding:5px;color:black;";
                                                            $total_partial      = $total_partial+1;
                                                        } 
                                                        else {
                                                            $attendance_status  = "Present";  
                                                            $style              = "background-color:green;padding:5px;color:black;";  
                                                            $total_present      = $total_present+1;
                                                        }          
                                                    } else if(  $val->clock_in > strtotime($attend_time->checkin_to)) {                                                       
                                                        $diff       = $val->clock_in - strtotime( $attend_time->checkin_to  );
                                                        $diffhr     = $diff/3600;  //gmdate("H", $diff);  
                                                        if( $diffhr >= 6 ) {        
                                                            $attendance_status  = "Absent";
                                                            $style              = "background-color:red;padding:5px;color:black;";
                                                            $total_absent       = $total_absent+1;
                                                        } else {
                                                           // $difference_in_hour = gmdate("H", $difference_in_hour);
                                                            if($difference_in_hour >= 6) {
                                                                $attendance_status  = "Partial";
                                                                $style              = "background-color:yellow;padding:5px;color:black;";
                                                                $total_partial      = $total_partial+1;

                                                            } else {
                                                                $attendance_status  =  "Absent";
                                                                $style              = "background-color:red;padding:5px;color:black;";
                                                                $total_absent       = $total_absent+1; 
                                                            } 
                                                        } 
                                                    }  
                                            } else  if( $val->clock_in != '' &&  $val->clock_out ==''){  
                                                $style              = "";
                                                $attendance_status  = "-";
                                                $diff               = $val->clock_in - strtotime( $attend_time->checkin_to  );
                                                $diffhr             = $diff/3600; //gmdate("H", $diff); 
                                                    if(  $diffhr >= 6 ){        
                                                        $style              = "background-color:red;padding:5px;color:black;"; 
                                                        $attendance_status  =  "Absent";
                                                        $total_absent       = $total_absent+1;
                                                    } else {         
                                                           
                                                            $current_time = time();  
                                                            $time_diff          = $current_time - $val->clock_in;
                                                            $difference_in_hour = $time_diff/3600; //gmdate("H", $time_diff); 
                                                            
                                                            if( $difference_in_hour >=12  ){
                                                                $attendance_status  = "Present";
                                                                $style              = "background-color:green;padding:5px;color:black;";
                                                                $total_present      = $total_present+1;
                                                                // update_attendence_status($attendance->id, $attendance_status );        
                                                            } 
                                                            else{
        
                                                                if(date('d-m-Y', strtotime($val->date)) == date('d-m-Y')) {
                                                                    $attendance_status  =  "Checked In";  
                                                                    $total_present      = $total_present+1;
                                                                    $style              = "background-color:#0dde0d;padding:5px;color:black;";
                                                                    // update_attendence_status($val->id, $attendance_status );
        
                                                                } else {
                                                                    $attendance_status  = "Absent";
                                                                    $style              = "background-color:red;padding:5px;color:black;";
                                                                    $total_absent       = $total_absent+1;
                                                                    // update_attendence_status($attendance->id, $attendance_status );
                                                                }        
                                                            } 
                                                    }
        
                                            } else {
                                                    $attendance_status =  "Absent";
                                                    $style = "background-color:red;padding:5px;color:black;";
                                                    $total_absent = $total_absent+1;

                                                }

                                                $style= isset($style )? $style :'';
                                                $attendance_status= isset($attendance_status )? $attendance_status :'--';
                                                
                                                echo "<span style='".$style."'>".$attendance_status."</span>";
                                            ?>
                                               
                                               <!-- {{ $val->date }} -->
                                            </td>                                              
                                            @endforeach
                                            @if(count($att->attendence) <= $days)  
                                                @for($i=count($att->attendence); $i<$days; $i++)
                                                <td> --
                                                </td>
                                                @endfor
                                            @endif
                                            
                                            <td style="text-align:center;" class="totalPresent">{{ $total_present}} </td>
                                            <td style="text-align:center;" class="partialPresent">{{ $total_partial}} </td>
                                            <td style="text-align:center;" class="totalAbsent">{{ $total_absent}} </td>  
                                            <td style="text-align:center;"><a href="{{route('super-admin.attendence.report.salary',[$att->user_id,$total_partial,$total_present,$total_absent,$date_from])}}" class="btn btn-primary salaryGenerate" >Salary</a></td>  
                                    </tr>
                                    @endforeach
                                
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->

  <!-- Modal -->
    <div class="modal fade" id="mySalary" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body tableGenerate">
            <h4 class="modal-title">Salary of the Month <span class="monthSelected"></span></h4>
                       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
            
        </div>
    </div>

@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
<style>
    .modal-lg {
        max-width: 60% !important;
    }
    .totalSalary { font-size: 18px; font-weight:bold; }
</style>
@include('layouts.datatables_js')
<script>

$('#datatable_attandence_report').DataTable( {
    dom: 'Bfrtip',
    "autoWidth": false,
    "aaSorting": [ [0,'asc'] ], 
    "scrollX": true,
    "responsive": false, 
    "buttons": [
            {
                extend: 'csv',
                messageTop: '<?=$selected_branch_name?>. \r\n <?=$title_for_pdf?>. ',
                orientation: 'landscape',
                pageSize: 'A1'
            },
            {
                extend: 'excel',
                messageTop: '<?=$selected_branch_name?>. \r\n <?=$title_for_pdf?>.',
                orientation: 'landscape',
                pageSize: 'A1'
            },
            {
                extend: 'pdf',
                messageTop: '<?=$selected_branch_name?>. \r\n <?=$title_for_pdf?>.',                
                orientation: 'landscape',
                pageSize: 'A1'
            }
        ]
} );

</script>
@endsection

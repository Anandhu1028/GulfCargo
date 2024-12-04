@extends('layouts.app')

@section('content')

    <div class="content-page" id="content-page" id="content-page">
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
                            <h4 class="page-title">Staff List</h4>
                            <div class="fa-pull-right pb-3">
                                <a href="{{create_url()}}" class="btn btn-success">Add New</a>
                            </div>
                            <div class="fa-pull-left pb-3">
                                {{-- <a href="{{route('super-admin.staffs.index')}}" class="btn btn-primary">Staff List</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.index')}}" class="btn btn-primary">Attendence List</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.markAttendence')}}" class="btn btn-primary">Mark Attendence</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.report')}}" class="btn btn-primary">Attendence Report</a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('super-admin.attendence.time')}}" class="btn btn-primary">Attendence Time</a>&nbsp;&nbsp;&nbsp; --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">


                        <form action="" method="get">

                            <div class="row">
                                <div class="col-sm-2"></div>
                                <!-- <div class="col-sm-2">Date From</div>
                                <div class="col-sm-2">Date To</div> -->
                                <div class="col-sm-2">Select Status</div>

                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row">
                                    <div class="col-sm-2"></div>
                                    <?php /*
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
                                    */ ?>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="status" id="status" class="form-control">
                                                    <option   {{ ($selected_status == "" ) ? "selected" : "" }}  value="">All</option>
                                                    <option   {{ ($selected_status == "active" ) ? "selected" : "" }}  value="active">Active</option>
                                                    <option  {{ ($selected_status == "inactive" ) ? "selected" : "" }}   value="inactive">Inactive</option>
                                                    <option  {{ ($selected_status == "cancel" ) ? "selected" : "" }}   value="cancel">Cancel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                        </button>
                                    </div>
                            </div>


                            </form>



                            <table id="datatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>

                                <tr>
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Staff ID</th>
                                    <th>Email</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th width="20%">Actions</th>
                                </tr>

                                </thead>

                                <tbody>
                                @foreach($staffs as $key=> $staff)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$staff->user->name}}</td>
                                        <td>{{ isset($staff->staff_id)? $staff->staff_id :''}}</td>
                                        <td>{{$staff->user->email}}</td>
                                        <td>{{$staff->branch->name}}</td>
                                        <td>{{$staff->staff_status?$staff->staff_status:''}}</td>
                                        <form method="post" action="{{delete_url($staff->id)}}">
                                            <td>
                                                <a href="{{edit_url($staff->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @method('DELETE')
                                                @csrf
                                                <!-- <button href="{{edit_url($staff->id)}}"
                                                        class="btn btn-icon waves-effect waves-light btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button> -->

                                                <button type="submit" class="btn btn-danger delete-user del">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>


                                                <a href="{{show_url($staff->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-success">
                                                <i class="fas fa-eye"></i>
                                                </a>

<!--
                                                <a href="{{url('super-admin/staff_attendence_export/'.$staff->id)}}"
                                                        class="btn btn-icon waves-effect waves-light btn-primary">
                                                    <i class="fas fa-file-export"></i>
                                                </a> -->
                                            </td>
                                        </form>
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

@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script>
        // $('#datatable').dataTable({
        //     'columnDefs': [{ 'orderable': false, 'targets': 5 }], // hide sort icon on header of first column
        // });


$('#datatable').DataTable( {
    dom: 'Bfrtip',
    columnDefs: [{ 'orderable': false, 'targets': 5 }],
    buttons: [
            {
                extend: 'csv',
                messageTop: 'Staff List.',
                exportOptions: {
                        columns: [0,1,2,3,4,5]
                    }
            },
            {
                extend: 'excel',
                messageTop: 'Staff List',
                exportOptions: {
                        columns: [0,1,2,3,4,5]

                    }
            },
            {
                extend: 'pdf',
                messageTop: 'Staff List',
                exportOptions: {
                        columns: [0,1,2,3,4,5]

                    },
            }
        ]
} );


    </script>

<script>
$(document).on('click','.del',function(){
        if (!confirm("Do you want to delete")){
        return false;
    }
});

</script>
@endsection

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
                                 Salary Slip
                            </div>
                            <h4 class="page-title">Salary Slip</h4>
                            @can(permission_create())
                                <div class="fa-pull-right pb-3"><a href="{{create_url()}}"
                                                                   class="btn btn-success"></a></div>
                            @endcan
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4>{{$getData->title_for_pdf}}</h4> 
                            <a href="{{route('super-admin.attendence.report')}}" class="btn btn-primary" style="float:right;">Back</a>
                            <table id="datatable_attandence_report"
                                   class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Staff Name</td>
                                        <td>{{$getData->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Staff Email</td>
                                        <td>{{$getData->user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Daily Wage</td>
                                        <td>{{$getData->daily_wage}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Present</td>
                                        <td>{{$getData->present}}</td>
                                    </tr>
                                    <tr>
                                        <td>Partial Present</td>
                                        <td>{{$getData->partial_present}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Absent</td>
                                        <td>{{$getData->total_absent}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Salary</b></td>
                                        <td><b>{{$getData->salary}}</b></td>
                                    </tr>
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
<style>
    .modal-lg {
        max-width: 60% !important;
    }
    .totalSalary { font-size: 18px; font-weight:bold; }
    .buttons-print {margin-bottom:20px;}
</style>
@include('layouts.datatables_js')
<script>

$('#datatable_attandence_report').DataTable( {
    ordering: false,
    "searching": false, "paging": false, "info": false,
    dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: '<?=$getData->title_for_pdf?>',
                
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            }
        ]
} );

</script>
@endsection

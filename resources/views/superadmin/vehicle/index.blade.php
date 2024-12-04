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
                            <div class="fa-pull-right pb-3"><a href="{{create_url()}}"
                                                               class="btn btn-success">Add New</a></div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <table id="datatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Vehicle Name</th>
                                    <th>Driver Name</th>
                                    <th>Reg Date</th>
                                    <th>Reg Expiry</th>
                                    <th>Next Passing</th>
                                    <th>Sticker Permission Expiry</th>
                                    <th>Insurance Expiry</th>
                                    <th>Traffic No</th>
                                    <th>Gps Permit Expiry</th>
                                    <th>Vehicle Number</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($vehicles))
                                @foreach($vehicles as $i=> $vehicle)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$vehicle->name}}</td>
                                        <td>{{$vehicle->driver_name}}</td>
                                        <td>{{$vehicle->reg_date }}</td>
                                        <td>{{$vehicle->reg_expiry}}</td>
                                        <td>{{$vehicle->next_passing}}</td>
                                        <td>{{$vehicle->sticker_permission_expiry}}</td>
                                        <td>{{$vehicle->insurance_expiry}}</td>
                                        <td>{{$vehicle->traffic_no}}</td>
                                        <td>{{$vehicle->gps_permit_expiry}}</td>
                                        <td>{{$vehicle->vehicle_no}}</td>
                                        <td>{{$vehicle->status}}</td>                                        
                                        <form method="post" action="{{delete_url($vehicle->id)}}">
                                            <td>
                                                <a href="{{edit_url($vehicle->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @method('DELETE')
                                                @csrf 
                                                <button type="submit" class="btn btn-danger delete-user del">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>  
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                                @endif
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
        @if(isset($vehicle))
        <form action="{{url('super-admin/vehicle/'.$vehicle->id)}}" method="post">
        
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <h5 class="text-center">Are you sure you want to delete  {{$vehicle->name}}?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>     
        @endif               
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
    @include('layouts.datatables_js')

    <script>
     /*
        function showDtails(driverName){ 

           $('.modal-body').html("Do you really want to delete" + driverName+ " ?")
 
        } */
   
    </script>
    <script>
        $('#datatable').dataTable({
            'columnDefs': [{ 'orderable': false, 'targets': 5 }], // hide sort icon on header of first column
        });
    </script>

<script> 
$(document).on('click','.del',function(){ 
        if (!confirm("Do you want to delete")){
        return false;
    }
});

</script>
@endsection

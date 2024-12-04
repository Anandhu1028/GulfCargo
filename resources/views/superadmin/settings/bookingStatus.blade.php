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
                            <h4 class="page-title">
                                Booking Status
                            </h4>

                            <div class="fa-pull-right pb-3"><a href="{{route('super-admin.bookingStatus.create')}}"
                                                               class="btn btn-success">Add New</a></div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

              

                             
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <table id="datatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>View</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statuses as $i=> $status)
                                <tr>
                                    <td>{{ $status->name}} </td>
                                    <td>@if($status->view == '1')
                                        <button class="btn btn-icon waves-effect waves-light ">Admin</button>
                                        @else
                                        <button class="btn btn-icon waves-effect waves-light  ">Front</button>
                                        @endif
                                    </td> 
                                    <td>@if($status->status == '1')
                                        <button class="btn btn-icon waves-effect waves-light btn-success">Active</button>
                                        @else
                                        <button class="btn btn-icon waves-effect waves-light btn-warning">Inactive</button>
                                        @endif
                                    </td> 
                                    
                                    <form action="{{route('super-admin.bookingStatus.delete')}}" method="post">                                  
                                    <td> 
                                    <a href="{{route('super-admin.bookingStatus.edit',$status->id)}}" class="btn btn-icon waves-effect waves-light btn-warning">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                            @csrf  
                                            <input type="hidden" name="statusId" value="{{$status->id}}"/>
                                            <button type="submit" class="btn btn-danger delete-user del">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>  
                                     </td>
                                    </form>  
                                </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                @if(isset($status))
                <form action="{{route('super-admin.bookingStatus.delete')}}" method="post">
                
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="statusId" id="statusId">
                                <h5 class="text-center">Are you sure you want to delete?</h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </form>     
                @endif               
                </div>
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
$(document).ready(function(){
    $('input.timepicker').timepicker({});
});

    $('document').ready(function() {
        $(document).on('click', ".deleteBtn", function(){
            var id = $(this).attr("data-id");
            $("#myModal").modal("show");
            $("#statusId").val(id);
        });
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

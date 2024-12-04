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
                                    <th>Driver Name</th>
                                    <th>Branch</th>                                    
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Vehicle Number</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($drivers))
                                @foreach($drivers as $i=> $driver)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$driver->name}}</td>
                                        <td>{{$driver->branch->name??'-'}}</td>                                        
                                        <td>{{$driver->user->email}}</td>
                                        <td>{{$driver->mobile}}</td>
                                        <td>{{$driver->vehicle_number}}</td>
                                        <form method="POST"  action="{{delete_url($driver->id)}}">

                                            <td>
                                                <a href="{{edit_url($driver->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>  
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}  
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
        @if(isset($driver))
        <form action="{{url('super-admin/driver/'.$driver->id)}}" method="post">
        
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <h5 class="text-center">Are you sure you want to delete  {{$driver->name}}?</h5>
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

$(document).on('click','.del',function(){
           if (!confirm("Do you want to delete")){
            return false;
        }
        }); 


 
   
    </script>
    <script>
        $('#datatable').dataTable({
            'columnDefs': [{ 'orderable': false, 'targets': 5 }], // hide sort icon on header of first column
        });
    </script>
@endsection

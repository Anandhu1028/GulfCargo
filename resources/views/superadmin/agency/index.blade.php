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
                                    <th>Agency Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($agencies as $i=> $agency)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$agency->name}}</td>
                                        <td>{{$agency->email}}</td>
                                        <td>{{$agency->contact_no}}</td>
                                        <form method="post" action="{{delete_url($agency->id)}}">
                                            <td>
                                                <a href="{{edit_url($agency->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @method('DELETE')
                                                @csrf 
                                                <button type="submit" class="btn btn-danger delete-user del">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button> 
                                                <!-- <button type="button"   class="btn btn-icon waves-effect waves-light btn-danger"  data-toggle="modal" data-target="#myModal" onclick="showDtails({{ $agency->id}})"> <i class="fas fa-trash-alt"></i></button> -->

 

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
    
        function showDtails(agencyId){
            
            $.ajax({
                        url : '{{ route("super-admin.agency-getdata") }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data:{agencyId: agencyId },
                        success:function(data){

                            $('.modal-body').html(data)

                        },

                    });
        }
   
    
        $('#datatable').dataTable({
            'columnDefs': [{ 'orderable': false, 'targets': 4 }], // hide sort icon on header of first column
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

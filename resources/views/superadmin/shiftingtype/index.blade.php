@extends('layouts.app')

@section('content')

    <div class="content-page">
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
                                    <th>Shifting Type</th>                                    
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody> 

                                
                                @foreach($shifting_type as $i=> $shifting_type)
                                <tr> 
                                    <td>{{ $i+1}}</td>
                                    <td>{{ $shifting_type->name }}</td>  

                                    <form method="post" action="{{delete_url($shifting_type->id)}}">
                                            <td>
                                            <a href=" {{edit_url($shifting_type->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
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

$(document).on('click','.del',function(){
           if (!confirm("Do you want to delete")){
            return false;
        }
        }); 
    
$(document).on('click','.delete',function(){
        let id = $(this).attr('data-id');
        $('#id').val(id);
});
 
 </script>

@endsection

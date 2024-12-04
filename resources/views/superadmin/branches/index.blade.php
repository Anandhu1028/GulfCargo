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
                                    <th>Sl No</th>
                                    <th>Name</th>
                                    <th>Branch Code</th>
                                    <th>Location</th>
                                    <th width="20%">Actions</th>
                                </tr>

                                </thead>

                                <tbody>
                                @foreach($branches as $key=> $branch)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$branch->name}}</td>
                                        <td>{{ $branch->branch_code? $branch->branch_code : '-' }}</td>
                                        <td>{{$branch->location}}</td>
                                        <form method="post" action="{{delete_url($branch->id)}}">
                                            <td>
                                                <a href="{{edit_url($branch->id)}}"
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

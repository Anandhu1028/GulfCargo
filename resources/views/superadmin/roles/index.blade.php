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
                                    <th>Role Name</th>
                                        <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $i=> $role)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$role->name}}</td>
                                        <form method="post" action="{{delete_url($role->id)}}">
                                            <td>
                                                <a href="{{edit_url($role->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @method('DELETE')
                                                @csrf
                                                <button href="{{edit_url($role->id)}}"
                                                        class="btn btn-icon waves-effect waves-light btn-danger">
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
            'columnDefs': [{ 'orderable': false, 'targets': 2 }], // hide sort icon on header of first column
        });
    </script>
@endsection

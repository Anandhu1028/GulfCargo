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
                            <div class="fa-pull-right pb-3"><a href="{{create_url()}}" class="btn btn-success">Add New</a></div>

                            @can(permission_create())
                                
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">  
                            <table id="movingdatatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                 
                                    <th style="text-align: center">Action</th>                                   
                                    <th>Book<br>No</th>
                                    <th>Sender<br>Name</th>
                                    <th>Source</th>
                                    <th>Destination</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                                                   
                                </tr>
                                </thead>
                                <tbody>

                                 
                                @foreach($couriers as $key=> $courier)
                                 <tr>
                                         <td>                                 
                                        <a href="{{edit_url($courier->id)}}"
                                            class="btn btn-xs btn-icon waves-effect waves-light btn-warning">
                                            <i class="fas  fa-lg fa-pencil-alt"></i>
                                        </a>                                   
                               
                                        <!-- <a href="{{show_url($courier->id)}}"
                                            class="btn btn-xs btn-icon waves-effect waves-light btn-success">
                                            <i class="fas  fa-lg fa-eye"></i>
                                        </a>   -->

                                    </td>
                                        <td>{{ $courier->courier_number }}</td>
                                        <td>{{ $courier->sender->name }}</td>
                                        <td>{{ $courier->sourcecity->name??""}}</td>
                                        <td>{{ $courier->destinationcity->name??""}}</td> 
                                        <td>{{ $courier->statusVal->name}}</td>
                                        <td>{{ !empty($courier->created_date)? date('d-m-Y', strtotime($courier->created_date)):''  }}</td>

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

$(document).ready(function () {
    $('#movingdatatable').DataTable({  
        "autoWidth": false,
        "aaSorting": [ [0,'desc'] ], 
        "scrollX": true,
        "responsive": false
    });  

}); 

    </script>
@endsection

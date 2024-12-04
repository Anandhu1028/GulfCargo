@extends('layouts.appagency')

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

                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form action="{{store_url()}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12"> 

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Booking No</label>
                                                <select name="booking_no" class="form-control">
                                                    <option value="">1234566</option>
                                                    <option value="">4545454</option>
                                                </select>
                                                 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shipment ID</label>
                                                <select name="booking_no" class="form-control">
                                                    <option value="">shipment 212</option>
                                                    <option value="">shipment 454</option>
                                                </select>
                                            </div>
                                        </div> 
                                    </div> 
                                </div> 
                            </form>
                            <!-- end form -->

                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>




                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="body">  
                                <div class="table-responsive">
                                    <table class="table center-aligned-table">
                                       

                                    </table>


                                </div>
                            </div>
                            <div class="body">
                                <div class="header">
                                    <h4>Assigned Shipments</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th>Booking No</th>
                                            <th>Shipment name</th>
                                            <th>No of Pcs</th>
                                            <th>Total value</th>
                                            <th>Total Weight</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>4545454</td>
                                                <td>Shipment 112</td>
                                                <td>3</td>
                                                <td>10</td>
                                                <td>25</td>
                                                <td>Shipment Forwarded</td>
                                                <td> 
                                                @can(permission_edit())
                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan
                                                    @can(permission_view())
                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-success">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('shipment-print')
                                                    <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-warning">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-success">
                                                            <i class="fas fa-print"></i>
                                                        </a>                                                        

                                                        <a href="#"
                                                           class="btn btn-icon waves-effect waves-light btn-dark">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                    @endcan

                                                </td>
                                            </tr>
                                       

                                        </tbody>
                                    </table>
                                </div>

                            </div>
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
@endsection

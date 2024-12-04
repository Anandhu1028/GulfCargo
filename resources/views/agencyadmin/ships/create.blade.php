@extends('layouts.appagency')

@section('content')
<style>
.boxContainer{
    border:1px solid black;
    padding:5px;
    margin-top:5px;
}
</style>
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
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">

                            <form action="{{store_url()}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <div class="header">
                                        <h4>Basic Info</h4>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment ID.</label>
                                                <input type="text" name="shipment_id"
                                                       value= "" class="form-control"
                                                       required >
                                                @error('shipment_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Shipment Name</label>
                                                <input type="text" name="shipment_name"
                                                       value= "" class="form-control"
                                                       required >
                                                @error('shipment_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror 
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group"> 
                                            <label>Date</label>
                                                    <input type="date" value="{{ isset($ships->created_date) ? date('Y-m-d', strtotime($ships->created_date)) : ''}}" max=""
                                                        class="form-control" id="propertyname" name="created_date"
                                                        placeholder="Enter title">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Created by</label>
                                                <select name="created_by" id="created_by" class="form-control" required>
                                                    @foreach($staffs as $staff)
                                                    <option value="{{$staff->id}}">{{$staff->full_name}}</option> 
                                                    @endforeach 
                                                </select>  
                                            </div>
                                        </div>  
                                    </div> 
                                </div> 
 

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                    </button>
                                    <a href="{{index_url()}}" type="button"
                                       class="btn btn-danger waves-effect waves-light">Cancel
                                    </a>
                                </div>
                            </form>
                            <!-- end form -->

                        </div>
                        <!-- end card-box -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->



                <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box">

                            <table id="datatable1"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th style="display:none;">Ship ID </th>
                                    <th>Shipment Id</th>
                                    <th>Shipment Name</th>
                                    <th>Created by</th> 
                                    <th>Shipment Status</th>                                    
                                    <th>Date</th>                                    
                                    @canany([permission_edit(),permission_view(),'shipment-show'])
                                        <th style="text-align: center" colspan="">Action</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach( $ships as $ship)
                                    
                                    <tr>
                                        <td style="display:none;">{{$ship->id}}</td>
                                        <td>{{$ship->shipment_id}}</td>
                                        <td>{{$ship->shipment_name}}</td>
                                        <td>{{$ship->createdBy->full_name}}</td>
                                        <td>{{ (!empty($ship->shipmentStatus->name))? $ship->shipmentStatus->name : ''}}</td>
                                        <td>{{ !empty($ship->created_date) ? date('Y-m-d',strtotime($ship->created_date)) : '' }}</td>
                                        <td>  
                                            <a href="{{route('branch.ships.addbookingtoship', array('ship_id' => $ship->id))}}"
                                                class="btn btn-icon waves-effect waves-light btn-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>                                       
                                        </td>                                       
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



    </div>
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
@include('layouts.datatables_js')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
        $('#datatable1').DataTable({
              "aaSorting": [ [0,'desc'] ],
              'columnDefs' : [
                //hide the second & fourth column
                { 'visible': false, 'targets': [0] }
            ]
        }); 
    }); 
</script>
@endsection

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
                            <h4 class="page-title">Transferred Goods </h4>

                        </div>
                    </div>

                </div>

 



                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="body p-5">
                                <div class="header">
                                    <h4>Transferred Goods</h4>
                                </div>
                                <div class="col-md-12 text-right ">   
                                    <!-- <form action="http://127.0.0.1:8000/branch/ship/printall" method="post" target="_blank">  -->
                                            <!-- <button type="submit" class="btn btn-icon waves-effect waves-light btn-success" style="margin-bottom:10px;" form="form1" value="Submit"> <i class="fas fa-print"> Print all</i></button>  -->
                                    <!-- </form>                                     -->
                                </div>
                                <div class="table-responsive">
                                    <table id="shipsTable" class="table center-aligned-table">
                                        <thead>
                                        <tr>
                                            <th>Booking No</th> 
                                            <th>Tracking Number</th>
                                            <th>Transferred From</th>
                                            <th>Transferred To</th>
                                            <th>Transfer Status</th> 
                                           
                                        </tr>
                                        </thead>
                                        <tbody  id="bookingData1">
                                            @foreach( $goods as $goods)
                                                @foreach($goods->boxTransfer as $goods )
                                                <tr id="bookingData">
                                                    <td>{{$goods->invoice_number }}</td> 
                                                    <td>{{ $goods->tracking_number}}</td>
                                                    <td>{{isset($goods->transferFrom)?Str::title($goods->transferFrom->name):'-'}}</td>
                                                    <td>{{isset($goods->transferTo)?Str::title($goods->transferTo->name):'-'}}</td>
                                                    <td>{{  Str::title($goods->transferred_status)}}</td>

                                                <?php /*  <td>{{ Str::title($goods->shipmentTransfer->transferFrom->name)}}</td>
                                                    <td>{{  Str::title($goods->transfer_status)}}</td> */ ?>
                                                
                                                
                                                </tr>
                                                @endforeach
                                            @endforeach
                                       

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

<script>
$(function () {    
    
});

$(document) .ready(function() {     

});

</script>

@endsection

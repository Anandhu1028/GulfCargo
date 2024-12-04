@extends('layouts.app')

@section('content')
<style>

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
                                <div style="" >
                                    <div id="newBoxContainer" class="boxcount">
                                            
                                        <div class="package col-md-12"  id="package_ID" >
                                            <div class="header">
                                                <div class="col-md-2"  style="float:left">  
                                                    <h5 class="packageinfo-head">Report</h5>
                                                </div> 

                                                <div class="col-md-3" style="float:left">  
                                                    <select name="product_name" id="product_name" class="form-control product_name">
                                                        <option value="0">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> 

                                                <div class="col-md-2" style="float:left">  
                                                    <div class="form-group">
                                                        <input type="date" max=""
                                                                class="form-control" id="from_date" value="{{date('Y-m-d')}}" name="from_date"
                                                                placeholder="Enter From Date">
                                                    </div>
                                                </div> 

                                                <div class="col-md-2" style="float:left">  
                                                    <div class="form-group">
                                                        <input type="date" max=""
                                                                class="form-control" id="to_date" value="{{date('Y-m-d')}}" name="to_date"
                                                                placeholder="Enter To Date">
                                                    </div>
                                                </div> 

                                                <div class="col-md-3" style="float:left">  
                                                    <div class="form-group">
                                                        <input type="text" id="closingStock" readonly value="Closing Stock: " class="form-control" >
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="body" id="packageinfo">
                                                <table class="table table-bordered reportinfo">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Transaction</th>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Opening Stock</th>
                                                            <th>Closing Stock</th>
                                                            <th>UOM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fetchData">
                                                        @foreach($datas as $data)
                                                        <tr>
                                                            <td>{{$data->transaction_date}}</td>
                                                            <td>{{$data->transaction_type}}</td>
                                                            <td>{{$data->product->product_name}} </td>
                                                            <td>{{$data->quantity}} </td>
                                                            <td>{{$data->opening_stock}}</td>
                                                            <td>{{$data->closing_stock}}</td>
                                                            <td>{{$data->UOM}} </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                            
                                        </div>
                                    </div>
                                </div> 
                        </div>
                    </div>
                            <!-- end form -->

                </div>
                        <!-- end card-box -->
            </div>
                    <!-- end col -->
        </div>
                <!-- end row -->

    </div>
            <!-- end container-fluid -->


@endsection
@section('styles')
    @include('layouts.datatables_style')
    <style>
        #closingStock {font-weight:bold; color:green;}
    </style>
@endsection

@section('scripts')
    <script>
    $(document) .ready(function() {
        $("#product_name").change(function(){
            var product = $(this).val();
            var fromDate = $("#from_date").val();
            var toDate = $("#to_date").val();
            var url = "{{route('branch.reports.viewData')}}/"+product+"/"+fromDate+"/"+toDate;
            viewData(url);
            
        });

        $("#from_date").change(function(){
            var fromDate = $(this).val();
            var product = $("#product_name").val();
            var toDate = $("#to_date").val();
            console.log(product);
            if(product == 0) {
                alert("Please select a Product!");
                return false;
            } else {
                if(new Date(fromDate) > new Date(toDate))
                {
                    alert("Please check the Dates!");
                    return false;
                }
            }
            var url = "{{route('branch.reports.viewData')}}/"+product+"/"+fromDate+"/"+toDate;
            viewData(url);
        });

        $("#to_date").change(function(){
            var toDate = $(this).val();
            var product = $("#product_name").val();
            var fromDate = $("#from_date").val();
            console.log(product);
            if(product == 0) {
                alert("Please select a Product!");
                return false;
            } else {
                if(new Date(fromDate) > new Date(toDate))
                {
                    alert("Please check the Dates!");
                    return false;
                }
            }
            var url = "{{route('branch.reports.viewData')}}/"+product+"/"+fromDate+"/"+toDate;
            viewData(url);
        });

        function viewData(url){
            $("#closingStock").val("Closing Stock: ");
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    var html = [];
                    $('.fetchData').html('');
                    $.each(response, function (key, value) {
                        console.log(response);
                        html += '<tr>'+
                                    '<td>'+value.transaction_date+'</td>'+
                                    '<td>'+value.transaction_type+'</td>'+
                                    '<td>'+value.product.product_name+'</td>'+
                                    '<td>'+value.quantity+'</td>'+
                                    '<td>'+value.opening_stock+'</td>'+
                                    '<td>'+value.closing_stock+'</td>'+
                                    '<td>'+value.UOM+'</td>'+
                                '</tr>';
                        $("#closingStock").val("Closing Stock: "+value.closing_stock);
                        
                    });
                    $('.fetchData').html(html);
                    
                } 
            });
        }
    });
        
        

    </script>

@endsection

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
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <form action="{{ update_url($stock->id) }}" method="post" enctype="multipart/form-data">
                                @csrf 
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="stock_date">Stock Transfer Date</label>
                                            <input type="date" max=""
                                                    class="form-control" id="stock_date" value="{{date('Y-m-d', strtotime($stock->stock_date))}}" name="stock_date"
                                                    placeholder="Enter Purchase Date">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="stock_number">Stock Transfer Number</label>
                                            <input type="text" name="stock_number" value="{{$stock->stock_number}}" class="form-control"
                                                id="stock_number" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row"> 
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="branch_id_from">Select Branch From</label>
                                            <select class="form-control" name="branch_id_from" required>
                                                <option value>Select Branch</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}" @if($branch->id == $stock->branch_id_from) selected @endif>{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="branch_id_to">Select Branch To</label>
                                            <select class="form-control" name="branch_id_to" required>
                                                <option value>Select Branch To</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}" @if($branch->id == $stock->branch_id_to) selected @endif>{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div style="" >
                                    <div id="newBoxContainer" class="boxcount" data-count="{{$i=1}}">
                                            
                                        <div class="package col-md-12"  id="package_ID" >
                                            <div class="header">
                                                <div class="col-md-6"  style="float:left">  
                                                <h5 class="packageinfo-head">&nbsp;</h5>
                                                </div> 
                                                <div class="col-md-6 text-right pb-2" style="float:left">  
                                                    <button type="button" id="addpackage{{$i+1}}" data-myattri="{{$i+1}}"  class="btn btn-success addpackage">Add Items</button> 
                                                    <button type="button" id="removeBox{{$i+1}}" data-myattri="{{$i+1}}"  class="btn btn-danger removeBox">Delete Box</button> 
                                                </div> 
                                            </div>
                                            <div class="body" id="packageinfo">
                                                <table class="table table-bordered packageinfo">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl</th>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Unit rate</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                    </thead>
                                                    @foreach($stockProducts as $i => $stockProduct)
                                                    <?php  
                                                        $j = $i+1;
                                                    ?>
                                                    <tr count="{{$i+1}}">
                                                        <td width="2%"><span class="form-control border-0">{{$j}}</span></td>
                                                        <td width="40%">
                                                            <select name="product_name[]" id="product_name{{$i+1}}" class="form-control product_name"  data-myattri="{{$i+1}}">
                                                                <option>Select Product</option>
                                                                @foreach($products as $product)
                                                                    <option value="{{$product->id}}" @if($product->id == $stockProduct->product_id) selected @endif data-price="{{$product->unit_rate}}">{{$product->product_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td> 
                                                            <input type="text" placeholder="Enter quantity" name="qty[]" id="product_qty{{$i+1}}" value="{{$stockProduct->quantity}}" price="{{$stockProduct->amount}}" class="form-control product_qty" data-myattri="{{$i+1}}"> 
                                                        </td>
                                                        <td>
                                                            <input type="text" placeholder="Enter unit price" name="unit[]" id="unit_price{{$i+1}}" value="{{$stockProduct->amount}}" readonly class="form-control unit_price" data-myattri="{{$i+1}}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="subtotal[]" id="subtotal{{$i+1}}" value="{{$stockProduct->amount * $stockProduct->quantity}}" readonly class="form-control value sub_total" data-myattri="{{$i+1}}">
                                                        </td>
                                                        <td>
                                                            <button type="button"  name="remove[]" class="remove btn btn-danger" data-remove="{{$i+1}}" data-myAttri="{{$i+1}}">X</button>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </table>

                                            </div>

                                            <div class="body">
                                                <table class="table table-bordered">
                                                    <tr> 
                                                        <td width="20%"> </td>
                                                        <td width="20%"><h6>Total Quantity: </h6></td>
                                                        <td width="20%"><h6><span id="totalqty">{{$stock->total_quantity }}</span></h6></td>
                                                        <td width="20%" class="total"><h6>Total Amount : </h6></td>
                                                        <td width="20%"><h6><span id="totalAmt" class="package-total-amount totalAmt">{{$stock->total_amount }}</span></h6></td>                                                           
                                                    </tr>
                                                </table>

                                            </div> 

                                        </div>
                                    </div>
                                </div> 

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
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

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content -->


        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        2018 - 2020 &copy; Zircos theme by <a href="#">Coderthemes</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
@endsection
@section('styles')
    @include('layouts.datatables_style')
@endsection

@section('scripts')
    <script>
        $(function () {
            var grandTotal = $('.totalAmt').text();
            var qty = $('.totalqty').text();
            totals();

            $(document).on("change", ".product_name", function (event) {
                var total = $("#totalAmt").text();
                var id = $(this).data('myattri');
                var price = $(this).find(":selected").data('price');
                var subtotal = $("#subtotal"+id).val();

                $("#unit_price"+id).val(price);
                var qty = $("#product_qty"+id).val();
                if(qty!=''){
                    var subTotal = price * qty;
                    $("#subtotal"+id).val(subTotal);
                    total += +parseFloat(subTotal);
                } else {
                    $("#subtotal"+id).val(price);
                }
                $("#product_qty"+id).attr('price',price);
                totals();
            });

            $(document).on("keyup", ".product_qty", function (event) {
                var id = $(this).data('myattri');
                var price = $(this).attr('price');
                var qty = $(this).val();
                var subTotal = price * qty;
                $("#subtotal"+id).val(subTotal);
                totals();
            });

            //Total Calculation
            function totals() {
                var totalQty = 0;
                $('.product_qty').each(function(){
                    totalQty += parseFloat($(this).val());  
                });
                $('#totalqty').text(totalQty);

                var totalAmt = 0;
                $('.sub_total').each(function(){
                    totalAmt += parseFloat($(this).val());  
                });
                $('.totalAmt').text(totalAmt);
            }

            $('.remove').click(function(){ 
                addremoveClass();
            });
            
            function addremoveClass() {  
                $('.remove').click(function(){                   

                    var no_of_box = $('.body .boxcount').length;

                    var boxNo = $(this).attr("data-myAttri");
                    var totalRowCount = $(".packageinfo"+boxNo+" tr").length;  
                    if(totalRowCount == 1) {  
                        $(this).closest("div #newBoxContainer"+boxNo).remove();
                    }

                    if(no_of_box == 1 ){
                        $('#total-package').css({'display':'none'}); 
                    }


                    $(this).closest("tr").remove(); 
                    var rm_id = $(this).attr("data-remove");
                    var sum = 0;
                    $("input[name='subtotal"+rm_id+"[]']").each(function () {
                        sum += +$(this).val();
                    });
                    $("#totalAmt"+rm_id+"").text(sum);

                    var qtysum = 0;
                    $("input[name='qty"+rm_id+"[]']").each(function () {
                        qtysum += +$(this).val();
                    });
                    $("#totalqty"+rm_id+"").text(qtysum);                    

                    var rtotamtsum =0;
                    $(".rtotamt").each(function () {
                        rtotamtsum += parseFloat($(this).text());
                        
                    });

                    $("#totalPackageAmt").text(rtotamtsum);  
                    $("input[name='package_total_amount']").val(rtotamtsum);

                    var rtotqtysum = 0;
                    $(".rtotqty").each(function () {
                        rtotqtysum += parseFloat($(this).text());
                    });
                    $("#totalPackageqty").text(rtotqtysum); 
                    $("input[name='package_total_quantity']").val(rtotqtysum);                         

                });
            }

            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    $('.addpackage').click();
                    return false;
                }
            });

            $(document).on("click", ".addpackage", function (event) {     
                var rowCount = $("#packageinfo tr").length;
                var old = $(this).attr("data-myattri"); 
                i = parseInt(rowCount);
                var si = parseInt(i)+1;
                var tr = $('#tr').html();
                        var html = `<tr>
                                    <td style="padding:10px" width="2%"><span class="form-control border-0">`+si+`</span></td>
                                    <td style="padding:10px" width="40%"><select data-myAttri="`+i+`" name="product_name[]" id="product_name`+i+`" class="form-control product_name">`+
                                    `</select></td>
                                        <td style="padding:10px"><input data-myAttri="`+i+`" placeholder="Enter quantity" type="text" name="qty[]"  class="form-control product_qty" id="product_qty`+i+`"></td>
                                        <td style="padding:10px"><input type="text"  data-myAttri="`+i+`" readonly placeholder="Enter unit price" name="unit[]" class="form-control unit_price" id="unit_price`+i+`"></td>
                                        <td style="padding:10px"><input type="text" data-myAttri="`+i+`" readonly name="subtotal[]" class="form-control value sub_total" id="subtotal`+i+`"></td>
                                        <td>
                                        <button type="button"  name="remove`+i+`[]" class="remove btn btn-danger" data-remove="`+i+`">X</button>
                                        </td>
                                    </tr>`;
                                    $(".product_name").select();
                        $('#packageinfo table').append(html);
                        addremoveClass();
                        $("input[name='description"+i+"[]']").focus();
                        // $(this).attr("data-myattri",si);
                        $(".boxcount").data('count',i);
                        var htmlOpt = [];
                        var values = $("#product_name1 option").map(function() {
                            var price = $(this).attr('data-price');
                            htmlOpt += "<option data-price="+price+" value="+ this.value+">"+ this.text+"</option>";
                        }).get();
                        $("#product_name"+i).html(htmlOpt);
            });

        });

        $('.btnAction').click(function () {
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            $(this).attr('disabled', true);
            $('#basic-form').submit();
        });


    </script>

@endsection


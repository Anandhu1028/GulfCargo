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
                                    <th>Product Name</th>
                                    <th>Branch Name</th>
                                    <th>UOM</th>
                                    <th>Opening Stock</th>
                                    <th>Closing Stock</th>
                                    <th>Unit Rate</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($products))
                                @foreach($products as $i=> $product)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->branch->name}}</td>
                                        <td>{{$product->UOM}}</td>
                                        <td>{{$product->opening_stock}}</td>
                                        <td>{{$product->closing_stock}}</td>
                                        <td>{{$product->unit_rate}}</td>
                                        <td>
                                            <a href="{{edit_url($product->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @method('DELETE')
                                            @csrf 
                                            
                                            <button  data-id="{{$product->id}}"
                                                    class="btn btn-icon waves-effect waves-light btn-danger deleteBtn" data-toggle="modal" data-target="#myModal">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
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
        @if(isset($product))
        <form action="{{url('super-admin/product/'.$product->id)}}" method="post">
        
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="productId" id="productId">
                        <h5 class="text-center">Are you sure you want to delete?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>     
        @endif               
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
    <script type="text/javascript">
        $(document).ready(function(){    
            $(document).on("click", ".deleteBtn", function(event){ 
                var id = $(this).attr("data-id");
                $("#productId").val(id);
                $("#myModal").modal("show");
            });
        });


        $('#datatable').dataTable({
            'columnDefs': [{ 'orderable': false, 'targets': 7 }], // hide sort icon on header of first column
        });
    </script>
@endsection

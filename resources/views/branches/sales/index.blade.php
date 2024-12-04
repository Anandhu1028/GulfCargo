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
                                    <th>Sale Date</th>
                                    <th>Sale Number</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($sales))
                                @foreach($sales as $i=> $sale)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{ date('d-m-Y', strtotime($sale->sale_date))}}</td>
                                        <td>{{$sale->sale_number}}</td>
                                        <!-- <td>
                                                <a href="{{edit_url($sale->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @method('DELETE')
                                                @csrf 
                                                <button  data-id="{{$sale->id}}"
                                                        class="btn btn-icon waves-effect waves-light btn-danger deleteBtn">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                            </td> -->
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
 

        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
        @if(isset($sale))
        <form action="{{url('branch/sales/'.$sale->id)}}" method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="saleId" id="saleId">
                <h5 class="text-center">Are you sure you want to delete this?</h5>
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
    <script>
    $('document').ready(function() {
        $(document).on('click', ".deleteBtn", function(){
            var id = $(this).attr("data-id");
            $("#myModal").modal("show");
            $("#saleId").val(id);
        });
    });
    </script>
@endsection
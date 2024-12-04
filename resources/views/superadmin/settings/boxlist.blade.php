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
                                <!-- {!! breadcrumbs() !!} -->
                                Box Dimensions
                            </div>
                            <h4 class="page-title">
                                <!-- {{page_title()}} -->
                                Box Dimensions
                            </h4>

                            <div class="fa-pull-right pb-3"><a href="{{route('super-admin.boxdimension.create')}}"
                                                               class="btn btn-success">Add New</a></div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

              

                             
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">

                            <table id="datatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th> Box Dimensions</th>
                                    <th>Customer Packing</th>
                                    <th>Cargo Packing</th>                                    
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($boxdimensions as $i=> $box)
                                <tr>
                                    <td>{{ $box->length}} x {{ $box->width}} x {{ $box->height}}</td>
                                    <td>{{ $box->value}} </td>
                                    <td>{{ $box->cargo_packing}} </td>  
                                    <form action="{{route('super-admin.boxdimension.del')}}" method="post">                                  
                                    <td> 
                                            <a href="{{url('super-admin/boxdimensionList/'.$box->id)}}"
                                                class="btn btn-icon waves-effect waves-light btn-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a> 
                                            @csrf  
                                            <input type="hidden" name="id" value="{{$box->id}}"/>
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
    @include('layouts.datatables_js')
<script>
$(document).ready(function(){
    $('input.timepicker').timepicker({});
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

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
                                Cities
                            </div>
                            <h4 class="page-title">
                                <!-- {{page_title()}} -->
                                Cities
                            </h4>

                            <div class="fa-pull-right pb-3"><a href="{{route('super-admin.city.create')}}"
                                                               class="btn btn-success">Add New</a></div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <form action="" method="get">

                <div class="row mb-5">
                        <div class="col-sm-2"> 
                            
                        </div>
                        <div class="col-sm-4">  
                                <select name="state_id" id="state_id" class="form-control">
                                <option value="">--Select State--</option> 

                                @foreach($states as $state)
                                <option value="{{$state->id}}" {{ ($selected_state_id == $state->id) ? 'selected' : "" }} >{{ $state->name}} </option>

                                
                                @endforeach
                                </select>
                        </div>                        
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Search
                            </button>
                        </div>
                </div>
                </form>
                             
                <div class="row">

                <div class="col-sm-12">


                        <div class="card-box table-responsive">

                            <table id="citydatatable"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>Country</th>            
                                    <th>State</th>            
                                    <th>City</th>            
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($cities as $i=> $city)
                                <tr>
                                    <td>{{ $city->state->country->name }}</td>
                                    <td>{{ $city->state->name }}</td>
                                    <td>{{ $city->name}} </td>
                                    <td> 
                                    <form method="post" action="{{delete_url($city->id)}}">
                                    <a href=" {{edit_url($city->id)}}"
                                                   class="btn btn-icon waves-effect waves-light btn-warning">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                @method('DELETE')
                                                @csrf 
                                              
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
    $('#citydatatable').DataTable({}); 

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

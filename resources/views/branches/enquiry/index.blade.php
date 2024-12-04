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
                            
                        
                        <form action="" method="get">

                                <div class="row mb-2">
                                   
                                    <div class="col-sm-4">
                                       <b> 
                                        Total Booking : {{$book_cnt}} <br>
                                        Total Enquiry :  {{$enquiry_cnt}}<br>
                                        Total Cancel :  {{$cancel_cnt}}<br>
                                        </b> 
                                    </div> 

                                    <div class="col-sm-4"></div>
                                </div>  


                                <div class="row">
                                  
                                    <div class="col-sm-4">Select Status</div>

                                    <div class="col-sm-4"></div>
                                </div>  
                                <div class="row"> 
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <select name="status" id="status" class="form-control">
                                                        <option   {{ ($selected_status == "" ) ? "selected" : "" }}  value="">All</option>
                                                        <option   {{ ($selected_status == "book" ) ? "selected" : "" }}  value="book">Book</option>
                                                        <option  {{ ($selected_status == "enquiry" ) ? "selected" : "" }}   value="enquiry">Enquiry</option>
                                                        <option    {{ ($selected_status == "cancel" ) ? "selected" : "" }} value="cancel">Cancel</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Submit
                                            </button>
                                        </div>
                                </div> 
                               
                                </form>


                            <table id="movingdatatable11"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                 
                                    <th style="text-align: center">Action</th>                                   
                                    <th>Code<br>No</th>
                                    <th>Enquiry Type</th>
                                    <th>Customer<br>Name</th>
                                    <th>Customer<br>Mobile</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date-Time</th>
                                                                   
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($enquiries  as $enquiry) 
                                    <tr>
                                        <td>   
                                            <a href="{{edit_url($enquiry->id)}}" class="btn btn-xs btn-icon waves-effect waves-light btn-warning"><i class="fas  fa-lg fa-pencil-alt"></i></a>   
                                            <a href="#" id="{{$enquiry->id}}" class="btn btn-xs btn-icon waves-effect waves-light btn-primary changeStatus"><i class="fa  fa-lg fa-circle "></i></a>   
                                        </td>
                                        <td> @if($enquiry->enquiry_type == 'enquiry')
                                             E-{{$enquiry->code}}
                                             @else 
                                             B-{{$enquiry->code}}
                                             @endif
                                        </td>
                                        <td>{{$enquiry->enquiry_type}}</td>
                                        <td>{{$enquiry->customer_name}}</td>
                                        <td>{{$enquiry->customer_mobile}}</td>
                                        <td>{{$enquiry->type}}</td>
                                        <td>{{ Str::title($enquiry->status) }}</td>
                                        <td>{{$enquiry->date_time}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>    
                            <div class="d-flex justify-content-center">
                                {!! $enquiries->links() !!}
                            </div>                 
                        </div>
                    </div>
                   
                </div>
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end content -->

 
@include('branches.modals.changeStatusEnquiry')

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
        $('#comment_section').hide();

    }); 

    $('.changeStatus').click(function () {
        
        var enquiry_id = $(this).attr('id');   
        $('#msg').html( ); //clear msg div
        $("#sel_enquiry_id").val(enquiry_id); 
        $('#changeStatusEnquiryModal').modal('show'); 

    });


    $('#enquiry_status').change(function () {
     
        if( $(this).val() == 'cancel') { 
            $('#comment_section').show();
        } else {
            $('#comment_section').hide();

        }
 
        // var enquiry_id = $(this).attr('id');   
        // $('#msg').html( ); //clear msg div
        // $("#sel_enquiry_id").val(enquiry_id); 
        // $('#changeStatusEnquiryModal').modal('show'); 

    });



    $('#update_status_enquiry').click(function (e) {

    var sel_enquiry_id = $("#sel_enquiry_id").val();
    var enquiry_status = $("#enquiry_status").val();   
    var comment = $("#comment").val();   


    $.ajax({
        headers: {
            "content-type" : "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url:  `{{ route('branch.enquiry.updateStatus') }}`,
        type: "POST", 
        async:false,
        data: JSON.stringify({ "sel_enquiry_id":sel_enquiry_id,  "enquiry_status":enquiry_status ,  "comment":comment  }), 
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {  
            console.log( result );
            $('#msg').html( result );
            location.reload().delay(3000);
            },
        error: function (err) {            
            console.log(err);            
        }
    }); // ajax call closing
    })



</script>
@endsection

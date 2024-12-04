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


                




                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table center-aligned-table">
                                        <thead>
                                        <tr >
                                            <td width="20%" style="font-weight:bold;">Name :</td><td width="25%">{{ Str::title($staff->full_name) }}</td>
                                            <td width="20%"></td><td width="25%" rowspan="4">
                                                @if(!empty($staff->profile_photo))
                                                <img src="{{ url($staff->profile_photo) }}"  style="padding-left:100px; height:160px;"/>
                                                @endif
                                            </td>
                                        </tr> 
                                        <tr>
                                        <td style="font-weight:bold;">Email : </td><td width="25%">{{ Str::lower($staff->user->email) }}</td><td width="20%"></td>

                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Id : </td><td width="25%">{{ $staff->staff_id ?? "" }}</td>     <td width="20%"></td>                                      

                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Role : </td><td width="25%">{{ Str::title($staff->role) }}</td>   <td width="20%"></td>                                        
                                        </tr>
                                       
                                        <tr>
                                            <td style="font-weight:bold;">Branch : </td><td width="25%">{{ Str::title($staff->branch->name) }}</td><td width="20%"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Status : </td><td width="25%">{{ Str::title($staff->staff_status) }}</td>
                                            <td style="font-weight:bold;">Visa Status  : </td><td width="25%">{{ ($staff->visa_status==1)?'Active':'Inactive' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Visa Type : </td><td width="25%">{{ Str::title($staff->visaType->name) }}</td>
                                            <td style="font-weight:bold;">Document Type Id  : </td><td width="25%">{{ Str::title($staff->documentType->name??'') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Document Number : </td><td width="25%">{{ $staff->document_number }}</td>
                                            <td style="font-weight:bold;">Document  : </td><td width="25%"><a href="{{!empty($staff->document_path)?url($staff->document_path):'#' }}" target="_blank">
                                                {{ !empty($staff->document_path)?'View':'' }}</a></td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight:bold;">Daily Wage : </td><td width="25%">{{ $staff->daily_wage }}</td>
                                            <td style="font-weight:bold;">Visa Expiry Date : </td><td width="25%">{{  date('d-m-Y', strtotime($staff->visa_expiry_date)) }}</td>
                                        </tr>

                                        <tr>
                                            <td style="font-weight:bold;">Appointment date : </td><td width="25%">{{ date('d-m-Y', strtotime($staff->appointment_date)) }}</td> 
                                        </tr>
                                        </thead>

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

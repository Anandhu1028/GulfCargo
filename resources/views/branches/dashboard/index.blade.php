@extends('layouts.app')


@section('content')
    {{-- <div class="content-page" id="content-page">
        <div class="content dashDiv">

            <!-- Start Content-->
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-3 divBox">
                                <!-- small box -->
                                <a href="{{route('branch.attendance.index')}}">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h4>{{count($staffs)}}</h4>
                                            <p>Total Staffs</p>
                                            <div class="iconDiv"><i class="nav-icon fas fa-users iconFont"></i></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-3 divBox">
                                <a href="{{route('branch.attendance.index')}}">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h4>92</h4>
                                            <p>Total Present</p>
                                            <div class="iconDiv"><i class="nav-icon fas fa-users iconFont"></i></div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-6 divBox">
                                <a href="#">
                                    <div class="small-box bgPurple">
                                        <div class="inner">
                                            <h4>&nbsp;</h4>
                                            <p class="font-22">Products Stock</p>
                                            <div class="iconDiv"><img src="{{asset('assets/images/icons/stock.png')}}"></i></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 divBox div-m-t">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h4>8</h4>
                                        <p>Total Absent</p>
                                        <div class="iconDiv"><i class="nav-icon fas fa-user iconFont"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 divBox div-m-t">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h4>30</h4>
                                        <p>Total Partial Present</p>
                                        <div class="iconDiv"><i class="nav-icon fas fa-user iconFont"></i></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 divBox div-m-t">
                                <a href="{{route('branch.ship.create')}}" >
                                    <div class="small-box bg-secondary">
                                        <div class="inner">
                                            <h4>{{count($receivers)}}</h4>
                                            <p class="font-18">Shipment</p>
                                            <div class="iconDiv"><img src="{{asset('assets/images/icons/shipping.png')}}"></i></div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 divBox p-r-15">
                                <a href="{{route('branch.reports.view',[0,date('Y-m-d'),date('Y-m-d')])}}">
                                    <div class="small-box bgPurple">
                                        <div class="inner">
                                            <h4>&nbsp;</h4>
                                            <p class="font-22">Report</p>
                                            <div class="iconDiv"><img src="{{asset('assets/images/icons/stock.png')}}"></i></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 divBox p-r-15">
                                <a href="{{route('branch.sales.index')}}">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h4>{{count($branches)}}</h4>
                                            <p class="font-18">Sales</p>
                                            <div class="iconDiv"><img src="{{asset('assets/images/icons/branch.png')}}"></i></div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6 divBox">
                                <!-- small box -->
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h4>{{count($enqCollected)}}</h4>
                                        <p class="font-15">Cargo Enquiry Collected</p>
                                        <div class="iconDiv"><img src="{{asset('assets/images/icons/collection.png')}}"></i></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 divBox">
                                <!-- small box -->
                                <div class="small-box bg-dark">
                                    <div class="inner">
                                        <h4>{{count($pendings)}}</h4>
                                        <p class="font-15 m-b-40">Cargo Pending</p>
                                        <div class="iconDiv"><img src="{{asset('assets/images/icons/pending.png')}}"></i></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 divBox">
                                <!-- small box -->
                                <div class="small-box bgPurple">
                                    <div class="inner">
                                        <h4>{{count($outDelivery)}}</h4>
                                        <p class="font-15">Cargo Out for Delivery</p>
                                        <div class="iconDiv"><img src="{{asset('assets/images/icons/delivery.png')}}"></i></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 divBox">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h4>{{count($clearance)}}</h4>
                                        <p class="font-15">Cargo Waiting for Clearance</p>
                                        <div class="iconDiv"><img src="{{asset('assets/images/icons/waiting.png')}}"></i></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 divBox">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h4>{{count($movingEnq)}}</h4>
                                        <p class="font-15">Moving Enquiry Collected</p>
                                        <div class="iconDiv"><img src="{{asset('assets/images/icons/collection.png')}}"></i></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 divBox">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h4>{{count($movingPending)}}</h4>
                                        <p class="font-15">Moving Pending</p>
                                        <div class="iconDiv"><img src="{{asset('assets/images/icons/pending.png')}}"></i></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                <!-- ./col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- end container-fluid -->

        </div>
        <!-- end content --> --}}



@endsection



        <!-- Sidebar Menu -->
        <nav id="mySidenav" class="sidebar sidenav">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-item">
                    <a href="{{route('branch.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{route('branch.enquiry.index')}}" class="nav-link  {{ (request()->is('branch/enquiry')) || (request()->is('branch/enquiry/create')) || (request()->is('branch/enquiry/*/edit')) ? 'menu-active' :'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Enquiry or Booking</p>
                    </a>
                </li> --}}

                <li class="nav-item {{ (request()->is('branch/shipment*')) ||  (request()->is('branch/moving*')) ||  (request()->is('branch/courier*')) ? 'menu-is-opening menu-open' : '' }} ">
                    {{-- <a href="#" class="nav-link active">
                    <i class="mdi mdi-book-multiple"></i>
                    <p>
                        Invoice
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a> --}}
                    <ul class="nav "    >
                        <li class="nav-item">
                            <a href="{{route('branch.shipment.index')}}" class="nav-link   {{ (request()->is('branch/shipment')) || (request()->is('branch/shipment/create')) || (request()->is('branch/shipment/*/edit')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cargo</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('branch.moving.index')}}" class="nav-link   {{ (request()->is('branch/moving*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Moving</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('branch.courier.index')}}" class="nav-link   {{ (request()->is('branch/courier*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Courier</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Travels</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Logistics</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                  <li class="nav-item   {{ (request()->is('branch/ship/create'))|| (request()->is('branch/shipment/list/report')) ||  (request()->is('branch/shipment/transferredGoods')) || (request()->is('branch/shipment/pendingGoods'))  || (request()->is('branch/ships/addMoreBookingtoship*'))  ||  (request()->is('branch/shipment/list/viewManifesto/*'))  ||
                    (request()->is('branch/tripsheet'))  ||    (request()->is('branch/tripsheet/*')) ||    (request()->is('branch/goodsdetails/*'))? 'menu-is-opening menu-open' : '' }} ">



                    {{-- <a href="#" class="nav-link active">
                        <i class="mdi mdi-book-multiple"></i>
                        <p>
                            Shipment
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a> --}}
                    <ul class="nav ">
                        <li class="nav-item">
                            <a href="{{route('branch.ship.create')}}" class="nav-link   {{ (request()->is('branch/ship/create*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipment List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('branch.shipment.list.report')}}" class="nav-link   {{ (request()->is('branch/shipment/list/report')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipment Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('branch.customer.index')}}" class="nav-link  {{ (request()->is('branch/customer*')) ? 'menu-active' :'' }}">
                            <i class="mdi mdi-account-multiple-check"></i>
                                <p>Sender/Receiver</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{route('branch.shipment.shipmentlist.report')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipment List Report</p>
                            </a>
                        </li> -->

                        {{-- <li class="nav-item">
                            <a href="{{route('branch.goodsdetails.index')}}" class="nav-link   {{ (request()->is('branch/goodsdetails/index')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Goods</p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="{{route('branch.shipment.transferredGoods')}}" class="nav-link   {{ (request()->is('branch/shipment/transferredGoods*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Transferred Goods</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('branch.shipment.pendingGoods')}}" class="nav-link   {{ (request()->is('branch/shipment/pendingGoods*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pending Goods</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('branch.tripsheet.index')}}" class="nav-link   {{ (request()->is('branch/tripsheet*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Trip sheet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('branch.goodsdetails.inTripsheet')}}" class="nav-link   {{ (request()->is('branch/goodsdetails/inTripsheet*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Goods In Trip sheet</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('branch.goodsdetails.notInTripsheet')}}" class="nav-link   {{ (request()->is('branch/goodsdetails/notInTripsheet*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Goods Not In Trip sheet</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{route('branch.sales.index')}}" class="nav-link   {{ (request()->is('branch/sales*')) ? 'menu-active' :'' }}">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Sales</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{route('branch.reports.view',[0,date('Y-m-d'),date('Y-m-d')])}}" class="nav-link   {{ (request()->is('branch/reports*')) ? 'menu-active' :'' }}">
                    <i class="mdi mdi-account-multiple-check"></i>
                        <p>Report</p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{route('branch.attendance.index')}}" class="nav-link  {{ (request()->is('branch/attendance*')) ? 'menu-active' :'' }}">
                        <i class="nav-icon fas fa-user-alt"></i>
                        <p>Attendance</p>
                    </a>
                </li> --}}


            </ul>
        </nav>
        <!-- /.sidebar-menu -->


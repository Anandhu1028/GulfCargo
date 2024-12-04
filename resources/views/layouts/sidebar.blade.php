

        <!-- Sidebar Menu -->
        <nav id="mySidenav" class="sidebar sidenav">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-item">
                    <a href="{{route('super-admin.dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item  {{ (request()->is('super-admin/branches*')) ||  (request()->is('super-admin/shipment*')) ? 'menu-is-opening menu-open' : '' }}  ">
                    <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        Branches
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('super-admin.branches.index')}}"  class="nav-link   {{ (request()->is('super-admin/branches'))  ||  (request()->is('super-admin/branches/create'))  ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Branches</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.shipment.index')}}" class="nav-link  {{ (request()->is('super-admin/shipment'))  ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Invoices</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.shipment.report')}}" class="nav-link  {{ (request()->is('super-admin/shipment/list/report'))  ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipments Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/super-admin/ship/create" class="nav-link  {{ (request()->is('super-admin/shipment/list/report'))  ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipment List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item  {{ (request()->is('super-admin/staffs*')) ||  (request()->is('super-admin/attendence*'))  ||  (request()->is('super-admin/markAttendence*')) ||  (request()->is('super-admin/time*'))||  (request()->is('super-admin/attendenceReport*'))||  (request()->is('super-admin/vehicle*')) ||  (request()->is('super-admin/salesman*')) ||  (request()->is('super-admin/expense*'))  ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link active">
                    <i class="mdi mdi-account-multiple-plus"></i>
                    <p>
                        HR
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('super-admin.staffs.index')}}" class="nav-link {{ (request()->is('super-admin/staffs*'))  ||  (request()->is('super-admin/time'))  ||  (request()->is('super-admin/attendenceReport'))   ||  (request()->is('super-admin/markAttendence')) ||  (request()->is('super-admin/attendence')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Staff List</p>
                            </a>
                        </li>
                        <?php /*
                        <li class="nav-item">
                            <a href="{{route('super-admin.attendence.index')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Attendance</p>
                            </a>
                        </li>

                         <li class="nav-item">
                         <a href="{{route('super-admin.attendence.markAttendence')}}" class="nav-link">
                         <i class="far fa-circle nav-icon"></i>
                         <p>Mark Attendance</p>
                         </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.attendence.time')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Attendance Time</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.attendence.report')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Attendance Report</p>
                            </a>
                        </li>
                        */?>
                        {{-- <li class="nav-item">
                            <a href="{{route('super-admin.vehicle.index')}}" class="nav-link {{ (request()->is('super-admin/vehicle*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Vehicles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.salesman.index')}}" class="nav-link {{ (request()->is('super-admin/salesman*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Salesman</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('super-admin.expense.index')}}" class="nav-link {{ (request()->is('super-admin/expense*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Expense</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{route('super-admin.roles.index')}}" class="nav-link  {{ (request()->is('super-admin/roles*')) ? 'menu-active' :'' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Roles & Permission</p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{route('super-admin.agency.index')}}" class="nav-link  {{ (request()->is('super-admin/agency*')) ? 'menu-active' :'' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Agency</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('super-admin.driver.index')}}" class="nav-link  {{ (request()->is('super-admin/driver*')) ? 'menu-active' :'' }}">
                    <i class="mdi mdi-account-multiple-check"></i>
                        <p>Driver</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{route('super-admin.customer.index')}}" class="nav-link  {{ (request()->is('super-admin/customer*')) ? 'menu-active' :'' }}">
                    <i class="mdi mdi-account-multiple-check"></i>
                        <p>Sender/Receiver</p>
                    </a>
                </li>

                {{-- <li class="nav-item {{ (request()->is('super-admin/product*')) ||  (request()->is('super-admin/purchase*')) ||  (request()->is('super-admin/stock*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link active">
                    <i class="mdi mdi-content-duplicate"></i>
                    <p>
                        Products
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('super-admin.product.index')}}" class="nav-link  {{ (request()->is('super-admin/product*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.purchase.index')}}" class="nav-link  {{ (request()->is('super-admin/purchase*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Purchase</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.stock.index')}}" class="nav-link  {{ (request()->is('super-admin/stock*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Stock Transfer</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-item {{(request()->is('super-admin/boxdimension*')) || (request()->is('super-admin/discount*')) || (request()->is('super-admin/weight*')) || (request()->is('super-admin/city*')) || (request()->is('super-admin/shiptype*')) ||  (request()->is('super-admin/bookingStatus*')) || (request()->is('super-admin/movingStatus*')) ||  (request()->is('super-admin/visaType*'))|| (request()->is('super-admin/shipmentType*')) || (request()->is('super-admin/clearingAgent*')) || (request()->is('super-admin/portOfOrigin*')) || (request()->is('super-admin/documentType*')) || (request()->is('super-admin/vendors*')) || (request()->is('super-admin/district*')) || (request()->is('super-admin/movingTypes*')) ? 'menu-is-opening menu-open' : '' }} ">
                    <a href="#" class="nav-link active">
                    <i class="mdi mdi-settings"></i>
                    <p>
                        Settings
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="{{route('super-admin.boxdimension.list')}}" class="nav-link  {{ (request()->is('super-admin/boxdimensionList*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List Dimensions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.booking.discount')}}" class="nav-link  {{ (request()->is('super-admin/discount*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Charges</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.booking.weight')}}" class="nav-link  {{ (request()->is('super-admin/weight*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Weight</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{route('super-admin.city.index')}}" class="nav-link  {{ (request()->is('super-admin/city*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>City</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('super-admin.district.index')}}" class="nav-link  {{ (request()->is('super-admin/district*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>District</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('super-admin.shiptype.index')}}" class="nav-link  {{ (request()->is('super-admin/shiptype*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipping Method</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.booking.status')}}" class="nav-link  {{ (request()->is('super-admin/bookingStatus*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Booking Status</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('super-admin.moving.status')}}" class="nav-link  {{ (request()->is('super-admin/movingStatus*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Moving Status</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{route('super-admin.visa.type')}}" class="nav-link  {{ (request()->is('super-admin/visaType*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Visa Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.shipment.type')}}" class="nav-link  {{ (request()->is('super-admin/shipmentType*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Shipment Type</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('super-admin.clearing.agent')}}" class="nav-link  {{ (request()->is('super-admin/clearingAgent*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Clearing Agent</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="{{route('super-admin.port.origin')}}" class="nav-link  {{ (request()->is('super-admin/portOfOrigin*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Port Of Origin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.document.type')}}" class="nav-link  {{ (request()->is('super-admin/documentType*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Document Type</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('super-admin.vendors.index')}}" class="nav-link  {{ (request()->is('super-admin/vendors*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Vendors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('super-admin.movingTypes.index')}}" class="nav-link  {{ (request()->is('super-admin/movingTypes*')) ? 'menu-active' :'' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Moving Types</p>
                            </a>
                        </li> --}}

                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->


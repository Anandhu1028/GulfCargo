<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="{{route('branch.dashboard')}}"> <i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                </li>
                <li class="has-submenu">
                    <a href="{{route('branch.attendance.index')}}"> <i class="mdi mdi-fingerprint"></i>Attendance</a>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle " data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                       <i class="mdi mdi-account-multiple-check"></i>Booking
                    </a>
                    <div class="dropdown-menu dropdown-menu-right   profile-dropdown ">
                        <a   class="dropdown-item" href="{{route('branch.shipment.index')}}"> <i class="mdi mdi-truck-delivery"></i>Cargo</a>
                        <a   class="dropdown-item" href="{{route('branch.moving.index')}}"> <i class="mdi mdi-truck-delivery"></i>Moving</a>  
                        <a   class="dropdown-item" href="{{route('branch.courier.index')}}"> <i class="mdi mdi-truck-delivery"></i>Courier</a>  
                        <div class="dropdown-divider"></div> 
                    </div>
                </li>
                <li class="has-submenu">
                    <a href="{{route('branch.ship.create')}}"> <i class="mdi mdi-truck-delivery"></i>Shipment</a>
                </li>
                <li class="has-submenu">
                    <a href="{{route('branch.sales.index')}}"> <i class="mdi mdi-account-multiple-check"></i>Sales</a>
                </li>
                <li class="has-submenu">
                    <a href="{{route('branch.reports.view',[0,date('Y-m-d'),date('Y-m-d')])}}"> <i class="mdi mdi-account-multiple-check"></i>Report</a>
                </li>
            </ul>
            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>

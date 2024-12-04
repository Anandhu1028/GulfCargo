<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">

                <li class="has-submenu">
                    <a href="{{route('super-admin.dashboard')}}"> <i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                </li>
                <!-- <li class="has-submenu">
                    <a href="{{route('super-admin.branches.index')}}"> <i class="mdi mdi-source-branch"></i>Branches</a>
                </li> -->
                <!-- <li class="has-submenu">
                    <a href="{{route('super-admin.staffs.index')}}"> <i class="mdi mdi-account-multiple-check"></i>Staffs</a>
                </li> -->

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle " data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                       <i class="mdi mdi-account-multiple-check"></i>Branches
                    </a>
                    <div class="dropdown-menu dropdown-menu-right   profile-dropdown ">  
                        <a  class="dropdown-item" href="{{route('super-admin.branches.index')}}"> <i class="mdi mdi-account-multiple-check"></i>List Branches</a>
                        <a  class="dropdown-item" href="{{route('super-admin.shipment.index')}}"> <i class="mdi mdi-account-multiple-check"></i>List Bookings</a> 
                        <div class="dropdown-divider"></div> 
                    </div>
                </li>


                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle " data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                       <i class="mdi mdi-account-multiple-check"></i>Staffs
                    </a>
                    <div class="dropdown-menu dropdown-menu-right   profile-dropdown ">  
                        <a  class="dropdown-item" href="{{route('super-admin.staffs.index')}}"> <i class="mdi mdi-account-multiple-check"></i>List Staffs</a>
                        <a  class="dropdown-item" href="{{route('super-admin.attendence.index')}}"> <i class="mdi mdi-account-multiple-check"></i>List Attendence</a> 
                        <a  class="dropdown-item" href="{{route('super-admin.attendence.time')}}"> <i class="mdi mdi-account-multiple-check"></i>Attendence Time</a> 
                        <a  class="dropdown-item" href="{{route('super-admin.attendence.report')}}"> <i class="mdi mdi-account-multiple-check"></i>Attendence Report</a> 
                        <div class="dropdown-divider"></div> 
                    </div>
                </li>

                <li class="has-submenu">
                    <a href="{{route('super-admin.roles.index')}}"> <i class="mdi mdi-account-lock"></i>Roles & Permissions</a>
                </li>
                 <li class="has-submenu">
                    <a href="{{route('super-admin.agency.index')}}"> <i class="mdi mdi-account-child-outline"></i>Agency</a>
                </li>
                <li class="has-submenu">
                    <a href="{{route('super-admin.driver.index')}}"> <i class="mdi mdi-account-child-outline"></i>Driver</a>
                </li>
                <li class="has-submenu">
                    <a href="{{route('super-admin.customer.index')}}"> <i class="mdi mdi-account-child-outline"></i>Sender/ Receiver</a>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle " data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                       <i class="mdi mdi-account-multiple-check"></i>Settings
                    </a>
                    <div class="dropdown-menu dropdown-menu-right   profile-dropdown ">
                        <a   class="dropdown-item" href="{{route('super-admin.boxdimension.list')}}"> <i class="mdi mdi-account-child-outline"></i>List Dimensions</a>
                        <a   class="dropdown-item" href="{{route('super-admin.booking.discount')}}"> <i class="mdi mdi-account-child-outline"></i>Charges</a> 
                        <a   class="dropdown-item" href="{{route('super-admin.booking.weight')}}"> <i class="mdi mdi-account-child-outline"></i>Weight</a>
                        <a   class="dropdown-item" href="{{route('super-admin.city.index')}}"> <i class="mdi mdi-account-child-outline"></i>City</a>
                        <a   class="dropdown-item" href="{{route('super-admin.shiptype.index')}}"> <i class="mdi mdi-account-child-outline"></i>Ship Type</a>
                        <a   class="dropdown-item" href="{{route('super-admin.shiftingtype.index')}}"> <i class="mdi mdi-account-child-outline"></i>Shifting Type</a>

                        <div class="dropdown-divider"></div> 
                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle " data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                       <i class="mdi mdi-account-multiple-check"></i>Products
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <a class="dropdown-item" href="{{route('super-admin.product.index')}}"> <i class="mdi mdi-account-child-outline"></i>Product</a>
                        <a class="dropdown-item" href="{{route('super-admin.purchase.index')}}"> <i class="mdi mdi-account-child-outline"></i>Purchase</a> 
                        <a class="dropdown-item" href="{{route('super-admin.stock.index')}}"> <i class="mdi mdi-account-child-outline"></i>Stock Transfer</a>

                        <div class="dropdown-divider"></div> 
                    </div>
                </li>
            </ul>
            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>

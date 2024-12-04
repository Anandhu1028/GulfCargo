<!-- Navigation Bar-->
<header id="topnav">
    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle nav-link">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>


                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{asset('assets/images/users/avatar-1.png')}}" alt="user-image" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-outline"></i>
                            <span>Profile</span>
                        </a>


                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="{{route('logout')}}" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>


            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="{{route('root')}}" class="logo text-center">
                                    <span class="logo-lg">
                                        <img src="{{asset('assets/images/best_express_cargo_logo.png')}}" alt="" height="50">
                                        <!-- <span class="logo-lg-text-light">Zircos</span> -->
                                    </span>
                    <span class="logo-sm">
                                        <!-- <span class="logo-sm-text-dark">Z</span> -->
                                        <img src="{{asset('assets/images/best_express_cargo_logo.png')}}" alt="" height="22">
                                    </span>
                </a>
            </div>


            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">

                <li class="d-none d-sm-block">
                    <form class="app-search">
                        <div class="app-search-box">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>

            <ul class="list-unstyled topnav-menu topnav-menu-right m-0"> 
                <li class="d-none d-sm-block"> 
                        <div class="branch-name " style="padding: 10px; margin-left: 200px; margin-top: 10px;
                        color: #fff;font-size: 25px;"> 
                             
                        </div> 
                </li>
            </ul>


            <div class="clearfix" >   </div>
            <div  class="clearfix"></div>
        </div>
    </div>
    <!-- end Topbar -->
    @if(is_superadmin())
        @include('layouts.navigation')
    @elseif(is_agencyadmin())
        @include('layouts.agency_navigation')
    @else
        @include('layouts.branch_navigation')
    @endif
    <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->

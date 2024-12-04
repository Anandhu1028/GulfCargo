<!-- Navigation Bar-->
<header id="topnav">
    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="">

                </li>
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="false" aria-expanded="false">
<?php /*
                       @if(!empty(get_profile_picture()))
                                <img src="{{ url(get_profile_picture()) }}"  alt="user-image" class="rounded-circle" style="height:32px;"/>
                        @else
                            <img src="{{asset('assets/images/users/avatar-1.png')}}" alt="user-image" class="rounded-circle">
                        @endif
                        */ ?>
                        <img src="{{asset('assets/images/users/avatar-1.png')}}" alt="user-image" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>

                        </div>
                        <a href="javascript:void(0);" class="dropdown-item notify-item" style="text-align:center;">
                        @if(!is_superadmin())
                            <h5>{{ Str::title(branch()->name)}}</h5>
                            <h6>Role: <i>{{ Str::title( auth()->user()->staff->role )}}</i></h6>

                            <div class="dropdown-divider"></div>
                            <!-- item-->
                            <a href="{{route('branch.user.profile')}}" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-outline"></i>
                                <span>Profile</span>
                            </a>


                        @else
                        <h5>{{ Str::title( auth()->user()->name)}}</h5>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="{{route('super-admin.user.profile')}}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-outline"></i>
                                    <span>Profile</span>
                                </a>
                        @endif
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

        </div>

        <div class="" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 10px; color:#000;font-size: 25px;">
                              @if(!is_superadmin()){{ branch()->name  }} @endif
        </div>
        <!--Navbar-->
        <div class="row">
            <nav class="navbar navbar-light bg-light">
            <!-- Collapse button -->
            <button class="navbar-toggler hamburger-button" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation" onclick="Nav()" style="z-index: 2">
                <div class="animated-icon"><span></span><span></span><span></span></div>
            </button>
            </nav>
            <!--<img src="{{asset('assets/images/best_express_cargo_logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" >-->
            <img src="{{asset('assets/images/logo-dark1.png')}}" alt="Logo"  style="    padding-top: 10px;
    height: 60px;"    >

        </div>
        <!--/.Navbar-->
    </div>
    <!-- Toggler -->

<!-- Toggler -->
</header>
<!-- End Navigation Bar-->

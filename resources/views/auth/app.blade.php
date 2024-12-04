<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>Login |{{ config('app.name', 'Arafa Cargo') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name', 'Arafa Cargo') }}" name="description" />
    <meta content="aju" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    @include('layouts.styles')

</head>

<body>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        @yield('content')
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8 col-lg-6 col-xl-5">--}}
{{--                <div class="card">--}}

{{--                    <div class="text-center account-logo-box">--}}
{{--                        <div class="mt-2 mb-2">--}}
{{--                            <a href="index-2.html" class="text-success">--}}
{{--                                <span><img src="assets/images/logo.png" alt="" height="36"></span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}

{{--                        <form action="#">--}}

{{--                            <div class="form-group">--}}
{{--                                <input class="form-control" type="text" id="username" required="" placeholder="Username">--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <input class="form-control" type="password" required="" id="password" placeholder="Password">--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <div class="custom-control custom-checkbox checkbox-success">--}}
{{--                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>--}}
{{--                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group text-center mt-4 pt-2">--}}
{{--                                <div class="col-sm-12">--}}
{{--                                    <a href="page-recoverpw.html" class="text-muted"><i class="fa fa-lock mr-1"></i> Forgot your password?</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group account-btn text-center mt-2">--}}
{{--                                <div class="col-12">--}}
{{--                                    <button class="btn width-md btn-bordered btn-danger waves-effect waves-light" type="submit">Log In</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}

{{--                    </div>--}}
{{--                    <!-- end card-body -->--}}
{{--                </div>--}}
{{--                <!-- end card -->--}}

{{--                <div class="row mt-5">--}}
{{--                    <div class="col-sm-12 text-center">--}}
{{--                        <p class="text-muted">Don't have an account? <a href="page-register.html" class="text-primary ml-1"><b>Sign Up</b></a></p>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <!-- end col -->--}}
{{--        </div>--}}
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- Vendor js -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>

<!-- App js -->
<script src="{{asset('assets/js/app.min.js')}}"></script>

<script>
    // Get the browser timezone using JavaScript
    var browserTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    // Send the timezone to the server using AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log(browserTimezone)

    $.ajax({
        url: '{{route('timezone')}}',
        method: 'POST',
        data: {
            timezone: browserTimezone
        },
        success: function(response) {
            // Handle successful response from the server
            console.log(response)
        },
        error: function(xhr, textStatus, error) {
            // Handle error response from the server
            console.log(xhr);
            console.log(textStatus);
            console.log(error);
        }
    });

</script>


</body>


</html>

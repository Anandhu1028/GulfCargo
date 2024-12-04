<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Arafa Cargo') }} | {{page_title()}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    @include('layouts.styles')
</head>

<body data-layout="horizontal">

<!-- Begin page -->
<div id="wrapper">

    @include('layouts.header')

    @if(is_superadmin())
        @include('layouts.sidebar')
    @else
        @include('layouts.branch_sidebar')
    @endif

    @yield('content')
</div>
@include('layouts.footer')
@include('layouts.scripts')
</body>


</html>


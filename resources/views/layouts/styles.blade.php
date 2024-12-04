<!-- App css -->
<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet"/>
<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-stylesheet"/>
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" id="app-stylesheet"/>
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <style>
        body[data-layout=horizontal] .content-page { margin-top:70px!important;}
        .dashDiv {margin-top:70px!important;}
        .small-box>.inner {height:150px !important;}
        .main-sidebar {background-color:#36404e !important;}
        .navbar-custom {background-color:#fff!important;}
        body[data-layout=horizontal]
        .divBox { margin:-5px!important;}
        .div-m-t {margin-top:-18px!important;}
        .p-r-15 {padding-right:15px!important;}
        .p-l-0 {padding-left:0px!important;}
        .sideHead {background-color: #fff; color: #857373 !important; height: 70px!important; padding-top: 20px;}
        .bgPurple {background-color: #800080 !important; color:#fff !important;}
        .bgOrange {background-color: #FFA500 !important; color:#fff !important;}
        .bg-warning {color:#fff!important;}
        .iconFont {font-size:50px; }
        .iconDiv {text-align:right!important; margin-top: -5px;}
        .font-15 {font-size:15px!important;}
        .font-18 {font-size:18px!important;}
        .font-22 {font-size:22px!important;}
        .m-b-40 {margin-bottom:40px !important;}
        .m-20 { margin:20px !important;}
        .content-page {width:85%; float:right;}
        .nav-pillss {background-color: #858585!important;}
        .brand-image {opacity: .8;
            height: 60px;
            margin-top: 4px;
          }
.navbar{ width: 75px; margin-top:15px!important;}
.nav-link {color:#fff!important;}
.table-bordered, .table-bordered td, .table-bordered th {border: 1px solid #020304;}
.sidenav {
  margin-top:15px;
  height: 100%;
  width: 250px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #da1b37!important;
  color:#fff!important;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  box-shadow: 0px 0px 8px #888888;
}

.sidenav a {
  padding: 8px 8px 8px 16px;
  text-decoration: none;
  color: #fff;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #fff;
}

.sidenav::-webkit-scrollbar {
  display: none;
}


  .animated-icon {
  width: 30px;
  height: 20px;
  position: relative;
  margin: 0px;
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  -o-transform: rotate(0deg);
  transform: rotate(0deg);
  -webkit-transition: .5s ease-in-out;
  -moz-transition: .5s ease-in-out;
  -o-transition: .5s ease-in-out;
  transition: .5s ease-in-out;
  cursor: pointer;
  }

  .animated-icon span {
  display: block;
  position: absolute;
  height: 3px;
  width: 100%;
  border-radius: 9px;
  opacity: 1;
  left: 0;
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  -o-transform: rotate(0deg);
  transform: rotate(0deg);
  -webkit-transition: .25s ease-in-out;
  -moz-transition: .25s ease-in-out;
  -o-transition: .25s ease-in-out;
  transition: .25s ease-in-out;
  }

  .animated-icon span {
  background: #102784;
  }

  .animated-icon span:nth-child(1) {
  top: 0px;
  -webkit-transform-origin: left center;
  -moz-transform-origin: left center;
  -o-transform-origin: left center;
  transform-origin: left center;
  }

  .animated-icon span:nth-child(2) {
  top: 10px;
  -webkit-transform-origin: left center;
  -moz-transform-origin: left center;
  -o-transform-origin: left center;
  transform-origin: left center;
  }

  .animated-icon span:nth-child(3) {
  top: 20px;
  -webkit-transform-origin: left center;
  -moz-transform-origin: left center;
  -o-transform-origin: left center;
  transform-origin: left center;
  }


  button {border:none !important;}
  button:focus{outline: none;}

  .center {
    left: 50%;
    -webkit-transform: translateX(-50%);
    transform: translateX(-50%);
    text-align: center;
    vertical-align: middle;
  }
  .bg-light  { background-color:#ffffff!important;}

  .form-control:focus {
    box-shadow: 0 0 5px rgba(81, 203, 238, 1);
    border: 4px solid rgba(81, 203, 238, 1);
  }
/*
  .select2-container *:focus {
      border: 4px solid rgba(81, 203, 238, 1)!important ;
  } */

.menu-active {
  background:darkblue;
}

</style>
@yield('styles')

<!-- Vendor js -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
{{-- <script src="{{asset('assets/libs/morris-js/morris.min.js')}}"></script> --}}
<script src="{{asset('assets/libs/raphael/raphael.min.js')}}"></script>
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>

{{-- <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- App js -->
<script src="{{asset('assets/js/app.min.js')}}"></script>
<script src="{{asset('assets/js/mfs100-9.0.2.6.js')}}"></script>
<script src="{{asset('assets/js/finger_print.js')}}"></script>
<script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script>
function Nav() {
  var width = document.getElementById("mySidenav").style.width;
  if (width === "0px" || width == "") {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("content-page").style.width = "85%";
    document.getElementById("content-page").style.float = "right";
    $('.animated-icon').toggleClass('open');
  }
  else {
    document.getElementById("mySidenav").style.width = "0px";
    document.getElementById("content-page").style.width = "100%";
    document.getElementById("content-page").style.float = "right";
    $('.animated-icon').toggleClass('open');
  }
}
</script>
@yield('scripts')

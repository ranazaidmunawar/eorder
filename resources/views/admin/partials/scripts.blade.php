<script>
  "use strict";
  var mainurl =  "{{url('/')}}";
  var imgupload = "{{route('admin.summernote.upload')}}";
  var storeUrl = "";
  var removeUrl = "";
  var rmvdbUrl = "";
  var audio = new Audio("{{asset('assets/front/files/new-order-notification.mp3')}}");
  var waiterCallAudio = new Audio("{{asset('assets/front/files/call-waiter.mp3')}}");
  var pusherAppKey = "{{$be->pusher_app_key ?? ''}}";
  var pusherCluster = "{{$be->pusher_app_cluster ?? ''}}";
  var demo_mode = "{{ env('DEMO_MODE') }}";
</script>

<script src="{{asset('assets/admin/js/core/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/vue/vue.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/vue/axios.js')}}"></script>
<script src="{{asset('assets/admin/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>

<script src="{{asset('assets/admin/js/plugin/jquery-ui-1.13.2.custom/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery.timepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/dropzone/jquery.dropzone.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jscolor/jscolor.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/fontawesome-iconpicker/fontawesome-iconpicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/admin/js/atlantis.min.js')}}"></script>

@if(!is_null($be->pusher_app_key) && !is_null($be->pusherCluster))
 <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
@endif

<script src="{{ asset('assets/admin/js/plugin/webfont/webfont.min.js') }}"></script>
<script src="{{asset('assets/admin/js/custom.js')}}"></script>

@yield('variables')

<script src="{{asset('assets/admin/js/misc.js')}}"></script>

@yield('scripts')

@yield('vuescripts')

@if (session()->has('success'))
<script>
  "use strict";
  var content = {};

  content.message = '{{session('success')}}';
  content.title = 'Success';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'success',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif

@if (session()->has('warning'))
<script>
  "use strict";
  var content = {};

  content.message = '{{session('warning')}}';
  content.title = 'Warning!';
  content.icon = 'fa fa-bell';

  $.notify(content,{
    type: 'warning',
    placement: {
      from: 'top',
      align: 'right'
    },
    showProgressbar: true,
    time: 1000,
    delay: 4000,
  });
</script>
@endif

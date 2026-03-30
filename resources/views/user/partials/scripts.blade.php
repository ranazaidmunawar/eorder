<script>
  "use strict";
  var mainurl =  "{{url('/')}}";
  var imgupload = "{{route('admin.summernote.upload')}}";
  var storeUrl = "";
  var removeUrl = "";
  var rmvdbUrl = "";
  var loadImgs = "";
  var audio = new Audio("{{asset('assets/front/files/new-order-notification.mp3')}}");
  var waiterCallAudio = new Audio("{{asset('assets/front/files/call-waiter.mp3')}}");
  var pusherAppKey = "{{$userBe->pusher_app_key ?? ''}}";
  var pusherCluster = "{{$userBe->pusher_app_cluster ?? ''}}";
  var userStatusRoute = "{{route('user.status')}}";
  var timezone = "{{$userBe->timezone ?? ''}}";
 var demo_mode = "{{ env('DEMO_MODE') }}";

</script>

<script src="{{asset('assets/admin/js/core/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/vue/vue.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/vue/axios.js')}}"></script>
<script src="{{asset('assets/admin/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/admin/js/core/bootstrap.min.js')}}"></script>

<script src="{{ asset('assets/tenant/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery-ui-1.13.2.custom/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery.timepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/mdtimepicker/mdtimepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/dropzone/jquery.dropzone.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jquery.dm-uploader/jquery.dm-uploader.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/jscolor/jscolor.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/fontawesome-iconpicker/fontawesome-iconpicker.min.js')}}"></script>
<script src="{{asset('assets/admin/js/plugin/lazyload.min.js')}}"></script>
<script src="{{asset('assets/admin/js/pusher.js')}}"></script>
<script src="{{asset('assets/admin/js/atlantis.min.js')}}"></script>

<script>
    var sessionSubcategory = "{{ session()->get('subcategory') }}";
</script>

<script src="{{asset('assets/tenant/js/custom.js')}}"></script>
@if(!empty($packagePermissions) &&  in_array('Live Orders',$packagePermissions ))
  <script src="{{asset('assets/front/js/realtime.js')}}"></script>
@elseif(  in_array('Call Waiter',$packagePermissions ))
  <script src="{{asset('assets/front/js/realtime.js')}}"></script>
@endif

@yield('variables')

<script src="{{asset('assets/admin/js/misc.js')}}"></script>

<script>
    $("#toggle-btn").on('change', function() {
        var value= null;
        if(this.checked){
            value = this.getAttribute('data-on');
        }else{
            value =this.getAttribute('data-off');
        }
        $.post(userStatusRoute,
            {
                value: value
            },
            function(data){
                history.go(0);
            });
    });
</script>

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

@if (session()->has('error'))
    <script>
        "use strict";
        toastr["error"]("{{ __(session('error')) }}");
    </script>
@endif

    <!--====== jquery js ======-->
    <script src="{{ asset('assets/front/js/vendor/jquery.3.2.1.min.js') }}"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/front/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/whatsapp.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pusher.js') }}"></script>
    @if (!empty($packagePermissions) && in_array('Live Orders', $packagePermissions))
        <script src="{{ asset('assets/front/js/realtime.js') }}"></script>
    @elseif(in_array('Call Waiter', $packagePermissions))
        <script src="{{ asset('assets/front/js/realtime.js') }}"></script>
    @endif

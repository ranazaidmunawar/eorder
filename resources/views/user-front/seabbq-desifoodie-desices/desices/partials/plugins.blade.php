    @if ($userBs->is_whatsapp == 1)
        <script type="text/javascript">
            "use strict";
            var whatsapp_popup = {{ $userBs->whatsapp_popup }};
            var whatsappImg = "{{ asset('assets/front/img/whatsapp.svg') }}";
            $(function() {
                $('#WAButton').floatingWhatsApp({
                    phone: "{{ $userBs->whatsapp_number }}", //WhatsApp Business phone number
                    headerTitle: "{{ $userBs->whatsapp_header_title }}", //Popup Title
                    popupMessage: `{!! !empty($userBs->whatsapp_popup_message) ? nl2br($userBs->whatsapp_popup_message) : '' !!}`, //Popup Message
                    showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
                    buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
                    position: "left" //Position: left | right

                });
            });
        </script>
    @endif

    @if ($userBs->is_tawkto == 1)
        <!--Start of Tawk.to Script-->
        @php
            $directLink = str_replace('tawk.to', 'embed.tawk.to', $userBs->tawkto_direct_chat_link);
            $directLink = str_replace('chat/', '', $directLink);
        @endphp
        <script type="text/javascript">
            "use strict";
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = '{{ $directLink }}';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>

        <!--End of Tawk.to Script-->
    @endif

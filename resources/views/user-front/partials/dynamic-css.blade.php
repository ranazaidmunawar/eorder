    @if (count($allLanguageInfos) == 0)
        <style media="screen">
            .support-bar-area ul.social-links li:last-child {
                margin-right: 0;
            }

            .support-bar-area ul.social-links::after {
                display: none;
            }
        </style>
    @endif
    @if ($userBs->feature_section == 0)
        <style media="screen">
            .hero-txt {
                padding-bottom: 160px;
            }
        </style>
    @endif
    @if ($userBs->is_tawkto == 1 || $userBs->is_whatsapp == 1)
        <style>
            .go-top-area .go-top.active {
                right: auto;
                left: 20px;
            }
        </style>
    @endif
    @if ($rtl == 0)
        <style>
            .navigation .cart a::before {
                left: 17px;
            }

            .navigation .navbar .navbar-nav .nav-item {
                position: relative;
                margin: 0 15px;
            }
        </style>
    @else
        <style>
            .navigation .cart a::before {
                right: -29px;
            }

            .navigation .navbar .navbar-nav .nav-item {
                position: relative;
                margin: 0 20px;
            }

            .field-input.cross i.fa-times-circle {
                position: absolute;
                color: #000;
                left: 8px;
                top: 16px;
                cursor: pointer;
                text-align: left
            }

            .cart-total-table {
                border: 1px solid #e8e6f4;
                border-radius: 6px;
                margin-bottom: 30px;
                text-align: right
            }

            .cart-total-table li {
                direction: rtl
            }
        </style>
    @endif

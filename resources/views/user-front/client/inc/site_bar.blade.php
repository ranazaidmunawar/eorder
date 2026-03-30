<div class="col-lg-3">
    <div class="user-sidebar">
        <ul class="links">
            <li><a class="@if(request()->routeIs('user.client.dashboard')) active @endif"
                   href="{{route('user.client.dashboard',getParam())}}">{{$keywords['Dashboard'] ?? __('Dashboard')}}</a>
            </li>
            <li><a class="
                @if(request()->routeIs('user.client.orders')) active
                @elseif(request()->routeIs('user.client.orders.details')) active
                 @endif"
                   href="{{route('user.client.orders',getParam())}}">{{$keywords['My Orders'] ?? __('My Orders')}} </a>
            </li>

            <li><a class=" @if(request()->routeIs('user.client.profile')) active @endif"
                   href="{{route('user.client.profile',getParam())}}">{{$keywords['Edit Profile'] ?? __('Edit Profile')}} </a>
            </li>
             @if(!empty($packagePermissions) && in_array('Home Delivery', $packagePermissions))
            <li><a class=" @if(request()->routeIs('user.client.shipping.details')) active @endif"
                   href="{{route('user.client.shipping.details',getParam())}}">{{$keywords['Shipping Details'] ?? __('Shipping Details')}} </a>
            </li>
            @endif
            <li><a class=" @if(request()->routeIs('user.client.billing.details')) active @endif"
                   href="{{route('user.client.billing.details',getParam())}}">{{$keywords['Billing Details'] ?? __('Billing Details')}} </a>
            </li>
            <li><a class=" @if(request()->routeIs('user.client.reset')) active @endif"
                   href="{{route('user.client.reset',getParam())}}">{{$keywords['Change Password'] ?? __('Change Password')}} </a>
            </li>
            <li><a href="{{route('user.client.logout',getParam())}}">{{$keywords['Logout'] ?? __('Logout')}} </a></li>
        </ul>
    </div>
</div>

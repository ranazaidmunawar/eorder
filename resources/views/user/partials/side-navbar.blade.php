@php
  use App\Constants\Constant;
  use App\Http\Helpers\Uploader;
  use App\Http\Helpers\UserPermissionHelper;
  use App\Models\User\BasicSetting;
  use App\Models\User\Language;
  use Illuminate\Support\Facades\Auth;
    $user = getRootUser();
    $default = Language::query()
                        ->where('is_default', 1)
                        ->where('user_id', $user->id)
                        ->first();
    $package = UserPermissionHelper::currentPackage($user->id);
    if (!empty($user)) {
        $permissions = UserPermissionHelper::packagePermission($user->id);
        $permissions = json_decode($permissions, true);
        $packagePermissions = $permissions;
        $userBs = BasicSetting::query()->where('user_id', $user->id)->first();
    }
    $roleBasedPermission = [];
   
    if (!is_null(Auth::guard('web')->user()->admin_id)){
       $roleBasedPermission = json_decode(Auth::guard('web')->user()->role->permissions, true);
    }


@endphp


<div class="sidebar sidebar-style-2" @if (request()->cookie('user-theme') == 'dark') data-background-color="dark2" @endif>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          <img
            src="{{ Uploader::getImageUrl(Constant::WEBSITE_TENANT_USER_IMAGE, Auth::guard('web')->user()->image, $userBs, 'assets/tenant/image/user.jpg') }}"
            alt="..." class="avatar-img rounded">
        </div>
        <div class="info">
          <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
             @if(is_null(Auth::guard('web')->user()->admin_id))
            <span>
              {{ Auth::guard('web')->user()->username }}
              <span class="user-level">Admin</span>
              <span class="caret"></span>
            </span>
            @else
             <span>
              {{ Auth::guard('web')->user()->first_name }}
              <span class="user-level">Staff</span>
              <span class="caret"></span>
            </span>
            @endif
          </a>
          <div class="clearfix"></div>

          <div class="collapse in" id="collapseExample">
            <ul class="nav">
              <li>
                <a href="{{ route('user.edit.profile') }}">
                  <span class="link-collapse">{{ __('Edit Profile') }}</span>
                </a>
              </li>
              <li>
                <a href="{{ route('user.change.password') }}">
                  <span class="link-collapse">{{ __('Change Password') }}</span>
                </a>
              </li>
              <li>
                <a href="{{ route('user.logout') }}">
                  <span class="link-collapse">{{ __('Logout') }}</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <ul class="nav nav-primary">
        <div class="row mb-2">
          <div class="col-12">
           
              <div class="form-group py-0">
                <input name="term" type="text" class="form-control  sidebar-search" 
                  placeholder="Search Menu Here...">
              </div>
          
          </div>
        </div>
    
        <li class="nav-item @if (request()->path() == 'user/dashboard') active @endif">
          <a href="{{ route('user.dashboard') }}">
            <i class="la flaticon-paint-palette"></i>
            <p>{{ __('Dashboard') }}</p>
          </a>
        </li>
        @if (!is_null($package) && (in_array('Subdomain', $permissions) || in_array('Custom Domain', $permissions)) && (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission)&& in_array('Domains & URLs',$roleBasedPermission))))
          <li
            class="nav-item
            @if (request()->path() == 'user/domains') active
            @elseif(request()->path() == 'user/subdomain') active @endif">
            <a data-toggle="collapse" href="#domains">
              <i class="fas fa-link"></i>
              <p>{{ __('Domains & URLs') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
                @if (request()->path() == 'user/domains') show
                @elseif(request()->path() == 'user/subdomain') show @endif"
              id="domains">
              <ul class="nav nav-collapse">
                @if (!empty($permissions) && in_array('Custom Domain', $permissions))
                  <li class="
                        @if (request()->path() == 'user/domains') active @endif">
                    <a href="{{ route('user.domains') }}">
                      <span class="sub-item">{{ __('Custom Domain') }}</span>
                    </a>
                  </li>
                @endif
                @if (!empty($permissions) && in_array('Subdomain', $permissions))
                  <li class="
                        @if (request()->path() == 'user/subdomain') active @endif">
                    <a href="{{ route('user.subdomain') }}">
                      <span class="sub-item">{{ __('Subdomain & Path URL') }}</span>
                    </a>
                  </li>
               
                @endif
              </ul>
            </div>
          </li>
        @endif
      
        @if (
            !is_null($package) &&
                (!empty($permissions) && in_array('POS', $permissions)) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('POS', $roleBasedPermission))))
          <li
            class="nav-item
          @if (request()->path() == 'user/pos') active
          @elseif(request()->path() == 'user/pos/payment-methods') active @endif">
            <a data-toggle="collapse" href="#pos">
              <i class="fas fa-cart-plus"></i>
              <p>POS</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
            @if (request()->path() == 'user/pos') show
            @elseif(request()->path() == 'user/pos/payment-methods') show @endif"
              id="pos">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/pos') active @endif">
                  <a href="{{ route('user.pos') }}">
                    <span class="sub-item">{{ __('POS') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/pos/payment-methods') active @endif">
                  <a href="{{ route('user.pos.pmethod.index') }}">
                    <span class="sub-item">{{ __('Payment Methods') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (
            (!is_null($package) && in_array('POS', $permissions) ||
                in_array('Online Order', $permissions)) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Order Management', $roleBasedPermission)))
               
            )
         
          <li
            class="nav-item
          @if (request()->path() == 'user/product/orders') active
          @elseif(request()->path() == 'user/order/settings') active
          @elseif(request()->is('user/product/orders/details/*')) active
          @elseif(request()->is('user/product/order/serving-methods')) active
          @elseif(request()->routeIs('user.postalcode.index')) active
          @elseif(request()->path() == 'user/shipping') active
          @elseif(request()->routeIs('user.shipping.edit')) active
          @elseif(request()->path() == 'user/coupon') active
          @elseif(request()->routeIs('user.coupon.edit')) active
          @elseif(request()->path() == 'user/ordertime') active
          @elseif(request()->path() == 'user/orders/sales-report') active
          @elseif(request()->path() == 'user/orders/sales-report/export') active
          @elseif(request()->path() == 'user/deliverytime') active
          @elseif(request()->path() == 'user/t/timeframes') active @endif">
            <a data-toggle="collapse" href="#orderManagement">
              <i class="fas fa-box"></i>
              <p>{{ __('Order Management') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
            @if (request()->path() == 'user/product/orders') show
            @elseif(request()->path() == 'user/order/settings') show
            @elseif(request()->is('user/product/orders/details/*')) show
            @elseif(request()->is('user/product/order/serving-methods')) show
            @elseif(request()->routeIs('user.postalcode.index')) show
            @elseif(request()->path() == 'user/shipping') show
            @elseif(request()->routeIs('user.shipping.edit')) show
            @elseif(request()->path() == 'user/coupon') show
            @elseif(request()->routeIs('user.coupon.edit')) show
            @elseif(request()->path() == 'user/ordertime') show
            @elseif(request()->path() == 'user/deliverytime') show
            @elseif(request()->path() == 'user/orders/sales-report') show
            @elseif(request()->path() == 'user/orders/sales-report/export') show
            @elseif(request()->path() == 'user/t/timeframes') show @endif"
              id="orderManagement">
              <ul class="nav nav-collapse">
                <li class="
                @if (request()->path() == 'user/order/settings') active @endif">
                  <a href="{{ route('user.order.settings') }}">
                    <span class="sub-item">{{ __('Settings') }}</span>
                  </a>
                </li>

                <li
                  class="
                @if (request()->path() == 'user/product/orders') active
                @elseif(request()->is('user/product/orders/details/*')) active @endif">
                  <a href="{{ route('user.product.orders') }}">
                    <span class="sub-item">{{ __('Orders') }}</span>
                  </a>
                </li>

                <li class="
                  @if (request()->is('user/orders/sales-report')) active @endif">
                  <a href="{{ route('user.sales.report') }}">
                    <span class="sub-item">{{ __('Sales Reports') }}</span>
                  </a>
                </li>

                <li class="
                  @if (request()->is('user/product/order/serving-methods')) active @endif">
                  <a href="{{ route('user.product.servingMethods') }}">
                    <span class="sub-item">{{ __('Serving Methods') }}</span>
                  </a>
                </li>

                @if (
                    !empty($packagePermissions) &&
                        in_array('Home Delivery', $packagePermissions) &&
                        in_array('Postal Code Based Delivery Charge', $packagePermissions))
                  <li class="
                                    @if (request()->routeIs('user.postalcode.index')) active @endif">
                    <a href="{{ route('user.postalcode.index') . '?language=' . $default->code }}">
                      <span class="sub-item">{{ __('Postal Codes') }}</span>
                    </a>
                  </li>
                @elseif(!empty($packagePermissions) && in_array('Postal Code Based Delivery Charge', $packagePermissions))
                @endif

                @if (!empty($packagePermissions) && in_array('Home Delivery', $packagePermissions))
                  <li
                    class="
                @if (request()->path() == 'user/shipping') active
                @elseif(request()->routeIs('user.shipping.edit')) active @endif">
                    <a href="{{ route('user.shipping.index') . '?language=' . $default->code }}">
                      <span class="sub-item">{{ __('Shipping Charges') }}</span>
                    </a>
                  </li>
                @endif

                @if (!empty($permissions) && in_array('Coupon', $permissions) && in_array('Online Order', $packagePermissions))
                  <li
                    class="
                @if (request()->path() == 'user/coupon') active
                @elseif(request()->routeIs('user.coupon.edit')) active @endif">
                    <a href="{{ route('user.coupon.index') }}">
                      <span class="sub-item">{{ __('Coupons') }}</span>
                    </a>
                  </li>
                @endif
                @if (!empty($packagePermissions) && in_array('Online Order', $packagePermissions))
                  <li class="
                @if (request()->path() == 'user/ordertime') active @endif">
                    <a href="{{ route('user.ordertime') }}">
                      <span class="sub-item">{{ __('Order Time Management') }}</span>
                    </a>
                  </li>
                @endif
              
                @if (!empty($packagePermissions) && in_array('Home Delivery', $packagePermissions))
                  <li
                    class="
                @if (request()->path() == 'user/deliverytime') active
                @elseif(request()->path() == 'user/t/timeframes') active @endif">
                    <a href="{{ route('user.deliverytime') }}">
                      <span class="sub-item">{{ __('Delivery Time Frames Management') }}</span>
                    </a>
                  </li>
                @endif
              </ul>
            </div>
          </li>
        @endif
 
        
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Items Management', $roleBasedPermission))))
          <li
            class="nav-item
                        @if (request()->path() == 'user/category') active
                        @elseif (request()->path() == 'user/subcategory') active
                        @elseif (request()->path() == 'user/subcategory/*') active
                        @elseif(request()->path() == 'user/product') active
                        @elseif(request()->path() == 'user/product/create') active
                        @elseif(request()->is('user/product/*/edit')) active
                        @elseif(request()->is('user/category/*/edit')) active >
                        @elseif(request()->is('user/subcategory/*/edit')) active @endif">
            <a data-toggle="collapse" href="#category">
              <i class="fas fa-list"></i>
              <p>{{ __('Items Management') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
                        @if (request()->path() == 'user/category') show
                        @elseif (request()->path() == 'user/subcategory') show
                        @elseif (request()->path() == 'user/subcategory/*') show
                        @elseif(request()->path() == 'user/product/create') show
                        @elseif(request()->is('user/category/*/edit')) show
                        @elseif(request()->is('user/subcategory/*/edit')) show
                        @elseif(request()->path() == 'user/product') show
                        @elseif(request()->is('user/product/*/edit')) show @endif"
              id="category">
              <ul class="nav nav-collapse">
                <li
                  class="
                @if (request()->path() == 'user/category') active
                @elseif(request()->is('user/category/*/edit')) active @endif">
                  <a href="{{ route('user.category.index') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Category & Tax') }}</span>
                  </a>
                </li>
                <li
                  class=" @if (request()->path() == 'user/subcategory') active
                                @elseif(request()->is('user/subcategory/*/edit')) active @endif">
                  <a href="{{ route('user.subcategory.index') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Subcategories') }}</span>
                  </a>
                </li>

                <li
                  class="
                @if (request()->path() == 'user/product') active
                @elseif(request()->is('user/product/*/edit')) active
                @elseif(request()->path() == 'user/product/create') active @endif">
                  <a href="{{ route('user.product.index') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Items') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

     
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) &&
                in_array('QR Menu', $packagePermissions))  ||
                (in_array('QR Menu', $packagePermissions) && is_array($roleBasedPermission) && in_array('QR Code Builder', $roleBasedPermission))
            )
          <li class="nav-item
                        @if (request()->path() == 'user/qr-code') active @endif">
            <a href="{{ route('user.qrcode') }}">
              <i class="fas fa-qrcode"></i>
              <p>{{ __('QR Code Builder') }}</p>
            </a>
          </li>
        @endif

        @if (
            !is_null($package) &&
                !empty($permissions) &&
                in_array('Table Reservation', $permissions) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Reservation Settings', $roleBasedPermission))))
          <li
            class="nav-item
                          @if (request()->path() == 'user/reservations/visibility') active
                          @elseif(request()->path() == 'user/reservation/form') active
                          @elseif(request()->is('user/reservation/*/inputEdit')) active
                          @elseif(request()->path() == 'user/table/section') active @endif">
            <a data-toggle="collapse" href="#reserveSet">
              <i class="fas fa-backward"></i>
              <p>{{ __('Reservation Settings') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
                            @if (request()->path() == 'user/reservations/visibility') show
                            @elseif(request()->path() == 'user/reservation/form') show
                            @elseif(request()->is('user/reservation/*/inputEdit')) show
                            @elseif(request()->path() == 'user/table/section') show @endif"
              id="reserveSet">
              <ul class="nav nav-collapse">
                <li class="
                                @if (request()->path() == 'user/reservations/visibility') active @endif">
                  <a href="{{ route('user.reservations.visibility') }}">
                    <span class="sub-item">{{ __('Visibility') }}</span>
                  </a>
                </li>
                <li class="
                                @if (request()->path() == 'user/table/section') active @endif">
                  <a href="{{ route('user.table.section.index') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Text & Image') }}</span>
                  </a>
                </li>
                <li
                  class="
                                @if (request()->path() == 'user/reservation/form') active
                                @elseif(request()->is('user/reservation/*/inputEdit')) active @endif">
                  <a href="{{ route('user.reservation.form') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Form Builder') }}</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
        @endif

        @if (
            !is_null($package) &&
                !empty($permissions) &&
                in_array('Table Reservation', $permissions) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Table Reservations', $roleBasedPermission))))
          <li class="nav-item  @if (request()->is('user/table/reservations/*')) active @endif">
            <a data-toggle="collapse" href="#table">
              <i class="fas fa-utensils"></i>
              <p>{{ __('Table Reservations') }}</p>
              <span class="caret"></span>
            </a>
            <div class="collapse  @if (request()->is('user/table/reservations/*')) show @endif" id="table">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/table/reservations/create') active @endif">
                  <a href="{{ route('user.table.reservations.new') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('New Reservation') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/table/reservations/all') active @endif">
                  <a href="{{ route('user.all.table.reservations') }}">
                    <span class="sub-item">{{ __('All Reservations') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/table/reservations/pending') active @endif">
                  <a href="{{ route('user.pending.table.reservations') }}">
                    <span class="sub-item">{{ __('Pending Reservations') }}</span>
                  </a>
                </li>

                <li class="@if (request()->path() == 'user/table/reservations/accepted') active @endif">
                  <a href="{{ route('user.accepted.table.reservations') }}">
                    <span class="sub-item">{{ __('Accepted Reservations') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/table/reservations/rejected') active @endif">
                  <a href="{{ route('user.rejected.table.reservations') }}">
                    <span class="sub-item">{{ __('Rejected Reservations') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

          @if (
            !is_null($package) &&
                !empty($permissions) &&
                in_array('Table QR Builder', $permissions) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Tables & QR Builder', $roleBasedPermission))))
                
          <li class="nav-item
                    @if (request()->path() == 'user/tables') active @endif">
            <a href="{{ route('user.table.index') }}">
              <i class="fas fa-table"></i>
              <p>{{ __('Tables & QR Builder') }}</p>

            </a>
          </li>
        @elseif(is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Tables & QR Builder', $roleBasedPermission)))
     
          <li class="nav-item
                    @if (request()->path() == 'user/tables') active @endif">
            <a href="{{ route('user.table.index') }}">
              <i class="fas fa-table"></i>
              <p>{{ __('Tables') }}</p>

            </a>
          </li>
        @endif
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Drag & Drop Menu Builder', $roleBasedPermission))))
        
          <li class="nav-item
                 @if (request()->path() == 'user/menu-builder') active @endif">
            <a href="{{ route('user.menu_builder.index') . '?language=' . $default->code }}">
              <i class="fas fa-bars"></i>
              <p>{{ __('Drag & Drop Menu Builder') }}</p>
            </a>
          </li>
        @endif
        @if (
            !is_null($package) &&
                !empty($permissions) &&
                in_array('Custom Page', $permissions) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Custom Pages', $roleBasedPermission))))
          <li
            class="nav-item @if (request()->routeIs('user.custom_pages')) active
                @elseif (request()->routeIs('user.custom_pages.create_page')) active
                @elseif (request()->routeIs('user.custom_pages.edit_page')) active @endif">
            <a href="{{ route('user.custom_pages', ['language' => $default->code]) }}">
              <i class="la flaticon-file"></i>
              <p>{{ __('Custom Pages') }}</p>
            </a>
          </li>
        @endif
     
        @if (
            !is_null($package) &&
                !is_null($packagePermissions) &&
                in_array('Blog', $packagePermissions) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Blog Management', $roleBasedPermission))))
          <li
            class="nav-item @if (request()->routeIs('user.blog_management.categories')) active
                @elseif (request()->routeIs('user.blog_management.blogs')) active
                @elseif (request()->routeIs('user.blog_management.create_blog')) active
                @elseif (request()->routeIs('user.blog_management.edit_blog')) active @endif">
            <a data-toggle="collapse" href="#blog">
              <i class="fas fa-book"></i>
              <p>{{ __('Blog Management') }}</p>
              <span class="caret"></span>
            </a>
            <div id="blog"
              class="collapse
                    @if (request()->routeIs('user.blog_management.categories')) show
                    @elseif (request()->routeIs('user.blog_management.blogs')) show
                    @elseif (request()->routeIs('user.blog_management.create_blog')) show
                    @elseif (request()->routeIs('user.blog_management.edit_blog')) show @endif">
              <ul class="nav nav-collapse">
                <li class="{{ request()->routeIs('user.blog_management.categories') ? 'active' : '' }}">
                  <a href="{{ route('user.blog_management.categories', ['language' => $default->code]) }}">
                    <span class="sub-item">{{ __('Categories') }}</span>
                  </a>
                </li>
                <li
                  class="@if (request()->routeIs('user.blog_management.blogs')) active
                            @elseif (request()->routeIs('user.blog_management.create_blog')) active
                            @elseif (request()->routeIs('user.blog_management.edit_blog')) active @endif">
                  <a href="{{ route('user.blog_management.blogs', ['language' => $default->code]) }}">
                    <span class="sub-item">{{ __('Blog') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif
    
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Language Management', $roleBasedPermission))))
          <li
            class="nav-item
                @if (request()->path() == 'user/languages') active
                @elseif(request()->is('user/language/*/edit')) active
                @elseif(request()->is('user/language/*/edit/keyword')) active @endif">
            <a href="{{ route('user.language.index') }}">
              <i class="fas fa-language"></i>
              <p>{{ __('Language Management') }}</p>
            </a>
          </li>
        @endif
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Payment Gateways', $roleBasedPermission))))
          <li
            class="nav-item
                @if (request()->path() == 'user/gateways') active
                @elseif(request()->path() == 'user/offline/gateways') active @endif">
            <a data-toggle="collapse" href="#gateways">
              <i class="la flaticon-paypal"></i>
              <p>{{ __('Payment Gateways') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
                    @if (request()->path() == 'user/gateways') show
                    @elseif(request()->path() == 'user/offline/gateways') show @endif"
              id="gateways">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/gateways') active @endif">
                  <a href="{{ route('user.gateway.index') }}">
                    <span class="sub-item">{{ __('Online Gateways') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/offline/gateways') active @endif">
                  <a href="{{ route('user.gateway.offline') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Offline Gateways') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif
      
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Website Pages', $roleBasedPermission))))
          @includeIf('user.partials.website-pages')
        @endif
      
       
        @if (!is_null($package) && is_null(Auth::guard('web')->user()->admin_id)  && (is_array($roleBasedPermission) && in_array('Table QR Builder', $roleBasedPermission) || (is_array($roleBasedPermission) && in_array('Settings', $roleBasedPermission))))
      
          <li
            class="nav-item
          @if (request()->path() == 'user/favicon') active
          @elseif(request()->path() == 'user/logo') active
          @elseif(request()->path() == 'user/preloader') active
          @elseif(request()->path() == 'user/basic-info') active
          @elseif(request()->path() == 'user/support') active
          @elseif(request()->path() == 'user/social') active
          @elseif(request()->is('user/social/*')) active
          @elseif(request()->path() == 'user/basic_settings/seo') active
          @elseif(request()->path() == 'user/breadcrumb') active
          @elseif(request()->path() == 'user/heading') active
          @elseif(request()->path() == 'user/plugins') active
          @elseif(request()->path() == 'user/seo') active
          @elseif(request()->path() == 'user/pwa') active
          @elseif(request()->path() == 'user/maintenance') active
          @elseif(request()->path() == 'user/cookie-alert') active
          @elseif(request()->path() == 'user/call-waiter') active
          @elseif(request()->path() == 'user/mail/information') active
          @elseif(request()->path() == 'user/email-templates') active
          @elseif(request()->routeIs('user.product.tags')) active
          @elseif(request()->routeIs('user.email.editTemplate')) active @endif">
            <a data-toggle="collapse" href="#basic">
              <i class="la flaticon-settings"></i>
              <p>{{ __('Settings') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
            @if (request()->path() == 'user/favicon') show
            @elseif(request()->path() == 'user/logo') show
            @elseif(request()->path() == 'user/preloader') show
            @elseif(request()->path() == 'user/basic-info') show
            @elseif(request()->path() == 'user/support') show
            @elseif(request()->path() == 'user/social') show
            @elseif(request()->is('user/social/*')) show
            @elseif(request()->path() == 'user/basic_settings/seo') show
            @elseif(request()->path() == 'user/breadcrumb') show
            @elseif(request()->path() == 'user/heading') show
            @elseif(request()->path() == 'user/plugins') show
            @elseif(request()->path() == 'user/seo') show
            @elseif(request()->path() == 'user/pwa') show
            @elseif(request()->path() == 'user/maintenance') show
            @elseif(request()->path() == 'user/cookie-alert') show
            @elseif(request()->path() == 'user/call-waiter') show
            @elseif(request()->path() == 'user/mail/information') show
            @elseif(request()->path() == 'user/email-templates') show
            @elseif(request()->routeIs('user.product.tags')) show
            @elseif(request()->routeIs('user.email.editTemplate')) show @endif"
              id="basic">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/favicon') active @endif">
                  <a href="{{ route('user.favicon') }}">
                    <span class="sub-item">{{ __('Favicon') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/logo') active @endif">
                  <a href="{{ route('user.logo') }}">
                    <span class="sub-item">{{ __('Logo') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/preloader') active @endif">
                  <a href="{{ route('user.preloader') }}">
                    <span class="sub-item">{{ __('Preloader') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/basic-info') active @endif">
                  <a href="{{ route('user.basic.info') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('General Settings') }}</span>
                  </a>
                </li>

                <li class="submenu">
                  <a data-toggle="collapse" href="#emailset"
                    aria-expanded="{{ request()->path() == 'user/mail/information' ||
                    request()->path() == 'user/email-templates' ||
                    request()->routeIs('user.email.editTemplate')
                        ? 'true'
                        : 'false' }}">
                    <span class="sub-item">{{ __('Email Settings') }}</span>
                    <span class="caret"></span>
                  </a>
                  <div
                    class="collapse {{ request()->path() == 'user/mail/information' ||
                    request()->path() == 'user/email-templates' ||
                    request()->routeIs('user.email.editTemplate')
                        ? 'show'
                        : '' }}"
                    id="emailset">
                    <ul class="nav nav-collapse subnav">
                        
                      <li class="@if (request()->path() == 'user/mail/information') active @endif">
                        <a href="{{ route('user.mail.info') }}">
                          <span class="sub-item">{{ __('Mail Information') }}</span>
                        </a>
                      </li>
                      <li
                        class="@if (request()->path() == 'user/email-templates') active
                                                @elseif(request()->routeIs('user.email.editTemplate')) active @endif">
                        <a href="{{ route('user.email.templates') }}">
                          <span class="sub-item">{{ __('Email Templates') }}</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                @if (!is_null($package) && !empty($permissions) && in_array('Call Waiter', $permissions))
                  <li class="@if (request()->path() == 'user/call-waiter') active @endif">
                    <a href="{{ route('user.call.waiter') }}">
                      <span class="sub-item">{{ __('Call Waiter') }}</span>
                    </a>
                  </li>
                @endif
                <li class="@if (request()->path() == 'user/support') active @endif">
                  <a href="{{ route('user.support') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Support Informations') }}</span>
                  </a>
                </li>
                <li
                  class="@if (request()->path() == 'user/social') active
                                    @elseif(request()->is('user/social/*')) active @endif">
                  <a href="{{ route('user.social.index') }}">
                    <span class="sub-item">{{ __('Social Links') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/breadcrumb') active @endif">
                  <a href="{{ route('user.breadcrumb') }}">
                    <span class="sub-item">{{ __('Breadcrumb') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/heading') active @endif">
                  <a href="{{ route('user.heading') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Page Headings') }}</span>
                  </a>
                </li>
                @if(!is_null($package) && !empty($permissions) && in_array('PWA Installability', $permissions))
                <li class="@if (request()->path() == 'user/pwa') active @endif">
                  <a href="{{ route('user.pwa') }}">
                    <span class="sub-item">{{ __('PWA Settings') }}</span>
                  </a>
                </li>
                @endif
                <li class="@if (request()->path() == 'user/plugins') active @endif">
                  <a href="{{ route('user.plugins') }}">
                    <span class="sub-item">{{ __('Plugins') }}</span>
                  </a>
                </li>

                <li class="@if (request()->path() == 'user/basic_settings/seo') active @endif">
                  <a href="{{ route('user.basic_settings.seo', ['language' => $default->code]) }}">
                    <span class="sub-item">{{ __('SEO Information') }}</span>
                  </a>
                </li>

                <li class="@if (request()->path() == 'user/maintenance') active @endif">
                  <a href="{{ route('user.maintenance') }}">
                    <span class="sub-item">{{ __('Maintenance Mode') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/cookie-alert') active @endif">
                  <a href="{{ route('user.cookie.alert') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Cookie Alert') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          @elseif(!is_null($package) && (is_null(Auth::guard('web')->user()->admin_id)  || (is_array($roleBasedPermission) && in_array('Settings',$roleBasedPermission))))
           <li
            class="nav-item
          @if (request()->path() == 'user/favicon') active
          @elseif(request()->path() == 'user/logo') active
          @elseif(request()->path() == 'user/preloader') active
          @elseif(request()->path() == 'user/themes') active
          @elseif(request()->path() == 'user/basic-info') active
          @elseif(request()->path() == 'user/support') active
          @elseif(request()->path() == 'user/social') active
          @elseif(request()->is('user/social/*')) active
          @elseif(request()->path() == 'user/basic_settings/seo') active
          @elseif(request()->path() == 'user/breadcrumb') active
          @elseif(request()->path() == 'user/heading') active
          @elseif(request()->path() == 'user/plugins') active
          @elseif(request()->path() == 'user/seo') active
          @elseif(request()->path() == 'user/pwa') active
          @elseif(request()->path() == 'user/maintenance') active
          @elseif(request()->path() == 'user/cookie-alert') active
          @elseif(request()->path() == 'user/call-waiter') active
          @elseif(request()->path() == 'user/mail/information') active
          @elseif(request()->path() == 'user/email-templates') active
          @elseif(request()->routeIs('user.product.tags')) active
          @elseif(request()->routeIs('user.email.editTemplate')) active @endif">
            <a data-toggle="collapse" href="#basic">
              <i class="la flaticon-settings"></i>
              <p>{{ __('Settings') }} </p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
            @if (request()->path() == 'user/favicon') show
            @elseif(request()->path() == 'user/logo') show
            @elseif(request()->path() == 'user/themes') show
            @elseif(request()->path() == 'user/preloader') show
            @elseif(request()->path() == 'user/basic-info') show
            @elseif(request()->path() == 'user/support') show
            @elseif(request()->path() == 'user/social') show
            @elseif(request()->is('user/social/*')) show
            @elseif(request()->path() == 'user/basic_settings/seo') show
            @elseif(request()->path() == 'user/breadcrumb') show
            @elseif(request()->path() == 'user/heading') show
            @elseif(request()->path() == 'user/plugins') show
            @elseif(request()->path() == 'user/seo') show
            @elseif(request()->path() == 'user/pwa') show
            @elseif(request()->path() == 'user/maintenance') show
            @elseif(request()->path() == 'user/cookie-alert') show
            @elseif(request()->path() == 'user/call-waiter') show
            @elseif(request()->path() == 'user/mail/information') show
            @elseif(request()->path() == 'user/email-templates') show
            @elseif(request()->routeIs('user.product.tags')) show
            @elseif(request()->routeIs('user.email.editTemplate')) show @endif"
              id="basic">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/favicon') active @endif">
                  <a href="{{ route('user.favicon') }}">
                    <span class="sub-item">{{ __('Favicon') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/logo') active @endif">
                  <a href="{{ route('user.logo') }}">
                    <span class="sub-item">{{ __('Logo') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/preloader') active @endif">
                  <a href="{{ route('user.preloader') }}">
                    <span class="sub-item">{{ __('Preloader') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/basic-info') active @endif">
                  <a href="{{ route('user.basic.info') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('General Settings') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/themes') active @endif">
                  <a href="{{ route('user.themes') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Themes') }}</span>
                  </a>
                </li>

                <li class="submenu">
                  <a data-toggle="collapse" href="#emailset"
                    aria-expanded="{{ request()->path() == 'user/mail/information' ||
                    request()->path() == 'user/email-templates' ||
                    request()->routeIs('user.email.editTemplate')
                        ? 'true'
                        : 'false' }}">
                    <span class="sub-item">{{ __('Email Settings') }}</span>
                    <span class="caret"></span>
                  </a>
                  <div
                    class="collapse {{ request()->path() == 'user/mail/information' ||
                    request()->path() == 'user/email-templates' ||
                    request()->routeIs('user.email.editTemplate')
                        ? 'show'
                        : '' }}"
                    id="emailset">
                    <ul class="nav nav-collapse subnav">
                       
                      <li class="@if (request()->path() == 'user/mail/information') active @endif">
                        <a href="{{ route('user.mail.info') }}">
                          <span class="sub-item">{{ __('Mail Information') }}</span>
                        </a>
                      </li>
                      <li
                        class="@if (request()->path() == 'user/email-templates') active
                                                @elseif(request()->routeIs('user.email.editTemplate')) active @endif">
                        <a href="{{ route('user.email.templates') }}">
                          <span class="sub-item">{{ __('Email Templates') }}</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                @if (!is_null($package) && !empty($permissions) && in_array('Call Waiter', $permissions))
                  <li class="@if (request()->path() == 'user/call-waiter') active @endif">
                    <a href="{{ route('user.call.waiter') }}">
                      <span class="sub-item">{{ __('Call Waiter') }}</span>
                    </a>
                  </li>
                @endif
                <li class="@if (request()->path() == 'user/support') active @endif">
                  <a href="{{ route('user.support') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Support Informations') }}</span>
                  </a>
                </li>
                <li
                  class="@if (request()->path() == 'user/social') active
                                    @elseif(request()->is('user/social/*')) active @endif">
                  <a href="{{ route('user.social.index') }}">
                    <span class="sub-item">{{ __('Social Links') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/breadcrumb') active @endif">
                  <a href="{{ route('user.breadcrumb') }}">
                    <span class="sub-item">{{ __('Breadcrumb') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/heading') active @endif">
                  <a href="{{ route('user.heading') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Page Headings') }}</span>
                  </a>
                </li>
                @if(!is_null($package) && !empty($permissions) && in_array('PWA Installability', $permissions))
                <li class="@if (request()->path() == 'user/pwa') active @endif">
                  <a href="{{ route('user.pwa') }}">
                    <span class="sub-item">{{ __('PWA Settings') }}</span>
                  </a>
                </li>
                @endif

                <li class="@if (request()->path() == 'user/plugins') active @endif">
                  <a href="{{ route('user.plugins') }}">
                    <span class="sub-item">{{ __('Plugins') }}</span>
                  </a>
                </li>

                <li class="@if (request()->path() == 'user/basic_settings/seo') active @endif">
                  <a href="{{ route('user.basic_settings.seo', ['language' => $default->code]) }}">
                    <span class="sub-item">{{ __('SEO Information') }}</span>
                  </a>
                </li>

                <li class="@if (request()->path() == 'user/maintenance') active @endif">
                  <a href="{{ route('user.maintenance') }}">
                    <span class="sub-item">{{ __('Maintenance Mode') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/cookie-alert') active @endif">
                  <a href="{{ route('user.cookie.alert') . '?language=' . $default->code }}">
                    <span class="sub-item">{{ __('Cookie Alert') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif
   

        @if (
            (!is_null($package) &&
                !empty($permissions) &&
               ( is_null(Auth::guard('web')->user()->admin_id)) || (is_array($roleBasedPermission) && in_array('Push Notification', $roleBasedPermission)))
              )
          <li
            class="nav-item
          @if (request()->path() == 'user/pushnotification/settings') active
          @elseif(request()->path() == 'user/pushnotification/send') active @endif">
            <a data-toggle="collapse" href="#pushNotification">
              <i class="far fa-bell"></i>
              <p>{{ __('Push Notification') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
            @if (request()->path() == 'user/pushnotification/settings') show
            @elseif(request()->path() == 'user/pushnotification/send') show @endif"
              id="pushNotification">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/pushnotification/settings') active @endif">
                  <a href="{{ route('user.pushnotification.settings') }}">
                    <span class="sub-item">{{ __('Settings') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/pushnotification/send') active @endif">
                  <a href="{{ route('user.pushnotification.send') }}">
                    <span class="sub-item">{{ __('Send Notification') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif
      
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Subscribers', $roleBasedPermission))))
          <li
            class="nav-item
                @if (request()->path() == 'user/subscribers') active
                @elseif(request()->path() == 'user/mail/subscriber') active @endif">
            <a data-toggle="collapse" href="#subscribers">
              <i class="la flaticon-envelope"></i>
              <p>{{ __('Subscribers') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
                    @if (request()->path() == 'user/subscribers') show
                    @elseif(request()->path() == 'user/mail/subscriber') show @endif"
              id="subscribers">
              <ul class="nav nav-collapse">
                <li class="@if (request()->path() == 'user/subscribers') active @endif">
                  <a href="{{ route('user.subscriber.index') }}">
                    <span class="sub-item">{{ __('Subscribers') }}</span>
                  </a>
                </li>
                <li class="@if (request()->path() == 'user/mail/subscriber') active @endif">
                  <a href="{{ route('user.mail.subscriber') }}">
                    <span class="sub-item">{{ __('Mail to Subscribers') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif
        @if (
            !is_null($package) &&
                (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Announcement Popups', $roleBasedPermission))))
         
          <li
            class="nav-item @if (request()->routeIs('user.announcement_popups')) active
                    @elseif (request()->routeIs('user.announcement_popups.select_popup_type')) active
                    @elseif (request()->routeIs('user.announcement_popups.create_popup')) active
                    @elseif (request()->routeIs('user.announcement_popups.edit_popup')) active @endif">
            <a href="{{ route('user.announcement_popups', ['language' => $default->code]) }}">
              <i class="fas fa-bullhorn"></i>
              <p>{{ __('Announcement Popups') }}</p>
            </a>
          </li>
        @endif
      
        @if (
            !is_null($package) &&
                ((is_null(Auth::guard('web')->user()->admin_id) && in_array('Staffs', $permissions)) ||
                    (is_array($roleBasedPermission) && in_array('Staffs Management', $roleBasedPermission))))
          <li
            class="nav-item
          @if (request()->path() == 'user/roles') active
          @elseif(request()->is('user/role/*/permissions/manage')) active
          @elseif(request()->path() == 'user/admins') active
          @elseif(request()->is('user/admin/*/edit')) active @endif">
            <a data-toggle="collapse" href="#adminsManagement">
              <i class="fas fa-users-cog"></i>
              <p>{{ __('Staffs Management') }}</p>
              <span class="caret"></span>
            </a>
            <div
              class="collapse
            @if (request()->path() == 'user/roles') show
            @elseif(request()->is('user/role/*/permissions/manage')) show
            @elseif(request()->path() == 'user/admins') show
            @elseif(request()->is('user/admin/*/edit')) show @endif"
              id="adminsManagement">
              <ul class="nav nav-collapse">
                <li
                  class="
                @if (request()->path() == 'user/roles') active
                @elseif(request()->is('user/role/*/permissions/manage')) active @endif">
                  <a href="{{ route('user.role.index') }}">
                    <span class="sub-item">{{ __('Role Management') }}</span>
                  </a>
                </li>
                <li
                  class="
                @if (request()->path() == 'user/admins') active
                @elseif(request()->is('user/admin/*/edit')) active @endif">
                  <a href="{{ route('user.admin.index') }}">
                    <span class="sub-item">{{ __('Staffs') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif


        @if (!is_null($package) && (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Customers', $roleBasedPermission))))
        <li
          class="nav-item
          @if (request()->path() == 'user/customers')  active
          @elseif(request()->path() == 'user/registered-client') active @endif">
          <a data-toggle="collapse" href="#customers">
            <i class="la flaticon-users"></i>
            <p>{{ __('Customers') }}</p>
            <span class="caret"></span>
          </a>
          <div
            class="collapse
            @if (request()->path() == 'user/customers') show
            @elseif(request()->path() == 'user/registered-client') show
            @endif"
            id="customers">
            <ul class="nav nav-collapse">
              <li class="nav-item
                @if (request()->path() == 'user/customers') active @endif">
                <a href="{{ route('user.customer.index') }}">
                  <p>{{ __('Customers') }}</p>
                </a>
              </li>
              @if(in_array('Online Order',$packagePermissions))
              <li class="nav-item
            @if (request()->path() == 'user/registered-client') active @endif">
                <a href="{{ route('user.registered_clients') }}">
                  <p>{{ __('Registered Customers') }}</p>
                </a>
              </li>
               @endif
            </ul>
          </div>
        </li>
       @endif

    
        @if (!is_null($package) && (is_null(Auth::guard('web')->user()->admin_id) || (is_array($roleBasedPermission) && in_array('Sitemap', $roleBasedPermission))))
          <li class="nav-item
                    @if (request()->path() == 'user/sitemap') active @endif">
            <a href="{{ route('user.sitemap.index') . '?language=' . $default->code }}">
              <i class="fa fa-sitemap"></i>
              <p>{{ __('Sitemap') }}</p>
            </a>
          </li>
        @endif
        @if (is_null(Auth::guard('web')->user()->admin_id))
          <li
            class="nav-item
                    @if (request()->path() == 'user/package-list') active
                    @elseif(request()->is('user/package/checkout/*')) active @endif">
            <a href="{{ route('user.plan.extend.index') }}">
              <i class="fas fa-file-invoice-dollar"></i>
              <p>{{ __('Buy Plan') }}</p>
            </a>
          </li>
        @endif
        @if (is_null(Auth::guard('web')->user()->admin_id))
          <li class="nav-item
                    @if (request()->path() == 'user/payment-log') active @endif">
            <a href="{{ route('user.payment-log.index') }}">
              <i class="fas fa-list-ol"></i>
              <p>{{ __('Payment Logs') }}</p>
            </a>
          </li>
        @endif
        @if (!is_null($package))
          <li class="nav-item
                @if (request()->path() == 'user/profile/edit') active @endif">
            <a href="{{ route('user.edit.profile') }}">
              <i class="far fa-user-circle"></i>
              <p>{{ __('Edit Profile') }}</p>
            </a>
          </li>
          <li class="nav-item @if (request()->path() == 'user/change-password') active @endif">
            <a href="{{ route('user.change.password') }}">
              <i class="fas fa-key"></i>
              <p>{{ __('Change Password') }}</p>
            </a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</div>

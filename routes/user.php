<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\QrController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\JobController;
use App\Http\Controllers\User\PosController;
use App\Http\Controllers\User\PushController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\BasicController;
use App\Http\Controllers\User\BlinkController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\PopupController;
use App\Http\Controllers\User\TableController;
use App\Http\Controllers\User\UlinkController;
use App\Http\Controllers\User\BannerController;
use App\Http\Controllers\User\CouponController;
use App\Http\Controllers\User\DomainController;
use App\Http\Controllers\User\FooterController;
use App\Http\Controllers\User\MemberController;
use App\Http\Controllers\User\SliderController;
use App\Http\Controllers\User\SocialController;
use App\Http\Controllers\User\BuyPlanController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\FeatureController;
use App\Http\Controllers\User\GalleryController;
use App\Http\Controllers\User\GatewayController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReportsController;
use App\Http\Controllers\User\SitemapController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\HomePageController;
use App\Http\Controllers\User\LanguageController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\JcategoryController;
use App\Http\Controllers\User\SubdomainController;
use App\Http\Controllers\User\TopHeaderController;
use App\Http\Controllers\User\CustomPageController;
use App\Http\Controllers\User\IntroPointController;
use App\Http\Controllers\User\PaymentLogController;
use App\Http\Controllers\User\PostalCodeController;
use App\Http\Controllers\User\SubscriberController;
use App\Http\Controllers\User\BlogsectionController;
use App\Http\Controllers\User\HerosectionController;
use App\Http\Controllers\User\MenuBuilderController;
use App\Http\Controllers\User\ShopSettingController;
use App\Http\Controllers\User\TestimonialController;
use App\Http\Controllers\User\IntrosectionController;
use App\Http\Controllers\User\Journal\BlogController;
use App\Http\Controllers\User\ProductOrderController;
use App\Http\Controllers\User\ReservationsController;
use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\User\AffordableDealController;
use App\Http\Controllers\User\SectionHeadingController;
use App\Http\Controllers\User\ProductCategoryController;
use App\Http\Controllers\User\ReservationFormController;
use App\Http\Controllers\User\FeaturedCategoryController;
use App\Http\Controllers\User\Journal\CategoryController;
use App\Http\Controllers\User\ProductSubCategoryController;


Route::middleware(['banStaff', 'Demo'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('user.dashboard');


    Route::get('/change-theme', [DashboardController::class, 'changeTheme'])->name('user.theme.change');
    Route::post('/change-status', [DashboardController::class, 'status'])->name('user.status');

    Route::get('/rtl-check/{langid}', [LanguageController::class, 'rtlCheck'])->name('user.rtl.check');

    Route::get('/change-password', [ProfileController::class, 'changePass'])->name('user.change.password');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('user.update.password');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('user.edit.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.update.profile');


    Route::get('/payment-log', [PaymentLogController::class, 'index'])->name('user.payment-log.index');


    Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');

    Route::group(['middleware' => ['checkUserPermission:Custom Domain', 'checkAdminHasPermission:Domains & URLs']], function () {
        Route::get('/domains', [DomainController::class, 'domains'])->name('user.domains');
        Route::post('/request/domain', [DomainController::class, 'domainRequest'])->name('user.domain.request');
    });


    Route::group(['middleware' => ['checkUserPermission:Subdomain', 'checkAdminHasPermission:Domains & URLs']], function () {
        Route::get('/subdomain', [SubdomainController::class, 'subdomain'])->name('user.subdomain');
    });

    Route::group(['middleware' => ['checkUserPermission:POS', 'checkAdminHasPermission:POS']], function () {

        Route::get('/pos', [PosController::class, 'index'])->name('user.pos');
        Route::get('/cart/add-to-cart/{id}', [PosController::class, 'addToCart'])->name('user.add.cart');
        Route::get('/cart/updateQty/{key}/{qty}', [PosController::class, 'updateQty'])->name('user.cart.quantity');
        Route::get('/cart/items/remove/{id}', [PosController::class, 'cartItemRemove'])->name('user.cart.item.remove');
        Route::get('/cart/clear', [PosController::class, 'cartClear'])->name('user.cart.clear');
        Route::get('/print/customer-copy', [PosController::class, 'customerCopy'])->name('user.customer.copy');
        Route::get('/print/kitchen-copy', [PosController::class, 'kitchenCopy'])->name('user.kitchen.copy');
        Route::get('/print/token-no', [PosController::class, 'tokenNo'])->name('user.token.no');
        Route::get('/load/{phone}/customer-name', [PosController::class, 'customerName'])->name('user.customer.name');
        Route::post('/pos/placeorder', [PosController::class, 'placeOrder'])->name('user.pos.placeOrder');
        Route::get('/pos/shipping-charge', [PosController::class, 'shippingCharge'])->name('user.pos.shippingCharge');


        Route::get('/pos/payment-methods', [PosController::class, 'paymentMethods'])->name('user.pos.pmethod.index');
        Route::post('/pos/payment-method/store', [PosController::class, 'paymentMethodStore'])->name('user.pos.pmethod.store');
        Route::post('/pos/payment-method/update', [PosController::class, 'paymentMethodUpdate'])->name('user.pos.pmethod.update');
        Route::post('/pos/payment-method/delete', [PosController::class, 'paymentMethodDelete'])->name('user.pos.pmethod.delete');
    });



    Route::post('/add/customer/post', 'User\RegisteredUserController@addClient')->name('user.add.customer')->middleware('checkUserPermission:Online Order');
    Route::post('/change/customer/password', 'User\RegisteredUserController@changeClientPassword')->name('user.change.customer.password')->middleware('checkUserPermission:Online Order');

    Route::post('/user/update-account-status', 'User\RegisteredUserController@clientban')->name('register.client.ban');

    Route::post('register/client/email', 'User\RegisteredUserController@emailStatus')->name('register.client.email');

    Route::get('register/client/{id}/detials', 'User\RegisteredUserController@clientDetails')->name('register.client.details');

    Route::post('/user/register/client/delete', 'User\RegisteredUserController@destroy')->name('register.client.delete');

    Route::get('/user/{id}/details', 'User\RegisteredUserController@show')->name('user.user_details');

    Route::post('/bulk-delete-user', 'User\RegisteredUserController@bulkDestroy')->name('user.bulk_delete_user');

    Route::post('/registered-client/secret/login', 'User\RegisteredUserController@secretLogin')->name('user.registered_clients.secret.login')->withoutMiddleware('Demo');

    Route::group(['middleware' => 'checkUserPermission:Online Order,POS', 'checkAdminHasPermission:Order Management'], function () {
        Route::get('/product/order/serving-methods', [ProductOrderController::class, 'servingMethods'])->name('user.product.servingMethods');

        Route::post('/product/order/serving-method/status', [ProductOrderController::class, 'servingMethodStatus'])->name('user.product.servingMethodStatus');
        Route::post('/product/order/serving-method/gateways', [ProductOrderController::class, 'servingMethodGateways'])->name('user.product.servingMethodGateways');
        Route::post('/product/order/serving-method/qrpayment', [ProductOrderController::class, 'qrPayment'])->name('user.product.qrPayment');
        Route::post('/product/order/serving-method/update', [ProductOrderController::class, 'servingMethodUpdate'])->name('user.product.servingMethodUpdate');
        Route::post('/user/mail', [ProductOrderController::class, 'userMail'])->name('user.user.mail');

        Route::group(['middleware' => 'checkUserPermission:Online Order'], function () {
            Route::get('/coupon', [CouponController::class, 'index'])->name('user.coupon.index')->middleware('checkUserPermission:Coupon');
            Route::post('/coupon/store', [CouponController::class, 'store'])->name('user.coupon.store')->middleware('checkUserPermission:Coupon');
            Route::get('/coupon/{id}/edit', [CouponController::class, 'edit'])->name('user.coupon.edit')->middleware('checkUserPermission:Coupon');
            Route::post('/coupon/update', [CouponController::class, 'update'])->name('user.coupon.update')->middleware('checkUserPermission:Coupon');
            Route::post('/coupon/delete', [CouponController::class, 'delete'])->name('user.coupon.delete');
        });

        Route::middleware('checkUserPermission:Online Order')->group(function () {
            Route::post('/orderclose', [ProductOrderController::class, 'orderclose'])->name('user.orderclose');
            Route::get('/ordertime', [ProductOrderController::class, 'ordertime'])->name('user.ordertime');
            Route::post('/ordertime/update', [ProductOrderController::class, 'updateOrdertime'])->name('user.ordertime.update');
        });


        Route::group(['middleware' => 'checkUserPermission:Home Delivery'], function () {
            Route::get('/deliverytime', [ProductOrderController::class, 'deliveryTime'])->name('user.deliverytime');
            Route::post('/deliverytime/status', [ProductOrderController::class, 'deliveryStatus'])->name('user.deliveryStatus');
        });

        Route::get('/t/timeframes', [ProductOrderController::class, 'timeFrames'])->name('user.timeframes');
        Route::post('/timeframe/store', [ProductOrderController::class, 'timeFrameStore'])->name('user.timeframe.store');
        Route::post('/timeframe/update', [ProductOrderController::class, 'timeFrameUpdate'])->name('user.timeframe.update');
        Route::post('/timeframe/delete', [ProductOrderController::class, 'timeFrameDelete'])->name('user.timeframe.delete');


        Route::get('/pos/timeframes', [ProductController::class, 'timeFrames'])->name('user.pos.timeframes');


        Route::middleware('checkUserPermission:Online Order,POS')->group(function () {
            Route::get('/product/orders', [ProductOrderController::class, 'index'])->name('user.product.orders');
            Route::get('/order/settings', [ProductOrderController::class, 'settings'])->name('user.order.settings');
            Route::post('/order/update/settings', [ProductOrderController::class, 'updateSettings'])->name('user.order.update.settings');
            Route::post('/reset/token', [ProductOrderController::class, 'resetToken'])->name('user.reset.token');
            Route::post('/product/order/completed', [ProductOrderController::class, 'completed'])->name('user.product.order.completed');
            Route::post('/product/order/payment', [ProductOrderController::class, 'payment'])->name('user.product.order.payment');
            Route::post('/product/orders/status', [ProductOrderController::class, 'status'])->name('user.product.orders.status');
            Route::get('/product/orders/details/{id}', [ProductOrderController::class, 'details'])->name('user.product.orders.details');
            Route::post('/product/order/delete', [ProductOrderController::class, 'orderDelete'])->name('user.product.order.delete');
            Route::post('/product/order/bulk-delete', [ProductOrderController::class, 'bulkOrderDelete'])->name('user.product.order.bulk.delete');
            Route::post('/product/order/qrprint', [ProductOrderController::class, 'qrPrint'])->name('user.product.order.qrprint');

            Route::get('/orders/sales-report', [ReportsController::class, 'index'])->name('user.sales.report');
            Route::get('/orders/sales-report/export', [ReportsController::class, 'exportReport'])->name('user.salesReport.export');
        });


        Route::group(['middleware' => 'checkUserPermission:Postal Code Based Delivery Charge'], function () {
            Route::get('/postalcodes', [PostalCodeController::class, 'index'])->name('user.postalcode.index');
            Route::get('/postalcode/create', [PostalCodeController::class, 'create'])->name('user.postalcode.create');
            Route::post('/postalcode/store', [PostalCodeController::class, 'store'])->name('user.postalcode.store');
            Route::post('/postalcode/update', [PostalCodeController::class, 'update'])->name('user.postalcode.update');
            Route::post('/postalcode/delete', [PostalCodeController::class, 'delete'])->name('user.postalcode.delete');
            Route::post('/postalcode/bulk-delete', [PostalCodeController::class, 'bulkDelete'])->name('user.postalcode.bulk.delete');
        });


        Route::group(['middleware' => 'checkUserPermission:Home Delivery'], function () {
            Route::get('/shipping', [ShopSettingController::class, 'index'])->name('user.shipping.index');
            Route::post('/shipping/store', [ShopSettingController::class, 'store'])->name('user.shipping.store');
            Route::get('/shipping/{id}/edit', [ShopSettingController::class, 'edit'])->name('user.shipping.edit');
            Route::post('/shipping/update', [ShopSettingController::class, 'update'])->name('user.shipping.update');
            Route::post('/shipping/delete', [ShopSettingController::class, 'delete'])->name('user.shipping.delete');
        });
    });

    Route::group(['middleware' => 'checkAdminHasPermission:Items Management'], function () {
        Route::get('/category', [ProductCategoryController::class, 'index'])->name('user.category.index');
        Route::post('/category/store', [ProductCategoryController::class, 'store'])->name('user.category.store')->middleware('limitCheck:categories,store');
        Route::get('/category/{id}/edit', [ProductCategoryController::class, 'edit'])->name('user.category.edit');
        Route::post('/category/update', [ProductCategoryController::class, 'update'])->name('user.category.update')->middleware('limitCheck:categories,update');
        Route::post('/category/delete', [ProductCategoryController::class, 'delete'])->name('user.category.delete');
        Route::post('/category/bulk-delete', [ProductCategoryController::class, 'bulkDelete'])->name('user.pcategory.bulk.delete');
        Route::post('/category/remove/image', [ProductCategoryController::class, 'removeImage'])->name('user.pcategory.rmv.img');

        Route::post('/pcategory/feature', [ProductCategoryController::class, 'featureCheck'])->name('user.pcategory.feature');

        Route::get('/subcategory', [ProductSubCategoryController::class, 'index'])->name('user.subcategory.index');
        Route::post('/subcategory/store', [ProductSubCategoryController::class, 'store'])->name('user.subcategory.store')->middleware('limitCheck:subcategories,store');
        Route::get('/subcategory/{id}/edit', [ProductSubCategoryController::class, 'edit'])->name('user.subcategory.edit');
        Route::post('/subcategory/update', [ProductSubCategoryController::class, 'update'])->name('user.subcategory.update')->middleware('limitCheck:subcategories,update');
        Route::post('/subcategory/delete', [ProductSubCategoryController::class, 'delete'])->name('user.subcategory.delete');
        Route::post('/subcategory/bulk-delete', [ProductSubCategoryController::class, 'bulkDelete'])->name('user.subcategory.bulk.delete');
        Route::post('/subcategory/feature', [ProductSubCategoryController::class, 'featureCheck'])->name('user.subcategory.feature');


        Route::get('/product', [ProductController::class, 'index'])->name('user.product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('user.product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('user.product.store')->middleware('limitCheck:products,store');
        Route::get('/product/{id}/variants', [ProductController::class, 'variants'])->name('user.product.variants');
        Route::get('/product/{id}/addons', [ProductController::class, 'addons'])->name('user.product.addons');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('user.product.edit');
        Route::post('/product/update', [ProductController::class, 'update'])->name('user.product.update')->middleware('limitCheck:products,update');
        Route::post('/product/delete', [ProductController::class, 'delete'])->name('user.product.delete');


        Route::post('/product/feature', [ProductController::class, 'featureCheck'])->name('user.product.feature');


        Route::post('/product/special', [ProductController::class, 'specialCheck'])->name('user.product.special');

        Route::post('/product/slider-store', [ProductController::class, 'sliderStore'])->name('user.product.slider.store');
        Route::post('/product/slider-rmv', [ProductController::class, 'sliderRemove'])->name('user.product.slider.rmv');
        Route::get('/product/{id}/getcategory', [ProductController::class, 'getCategory'])->name('user.product.getcategory');
        Route::get('/product/{id}/getSubcategory/{langId}', [ProductController::class, 'getSubcategory'])->name('user.product.getSubcategory');
        Route::post('/product/delete', [ProductController::class, 'delete'])->name('user.product.delete');
        Route::post('/product/bulk-delete', [ProductController::class, 'bulkDelete'])->name('user.product.bulk.delete');
        Route::post('/product/slider-update', [ProductController::class, 'sliderUpdate'])->name('user.product.slider.update');
        Route::post('/product/update', [ProductController::class, 'update'])->name('user.product.update')->middleware('limitCheck:products,update');
        Route::get('/product/{id}/images', [ProductController::class, 'images'])->name('user.product.images');
    });

    Route::group(['middleware' => ['checkUserPermission:Table Reservation', 'checkAdminHasPermission:Reservation Settings']], function () {

        Route::get('/reservations/visibility', [ReservationsController::class, 'visibility'])->name('user.reservations.visibility');
        Route::post('/reservations/visibility/update', [ReservationsController::class, 'updateVisibility'])->name('user.reservations.visibility.update');

        Route::post('/table/book/{lang}', [ReservationsController::class, 'tableBook'])->name('user.table.book')->middleware('limitCheck:reservations,store');

        Route::get('/table/section', [BasicController::class, 'tableSection'])->name('user.table.section.index');
        Route::post('/table/section/{langid}/update', [BasicController::class, 'tableSectionUpdate'])->name('user.table.section.update');
        Route::post('/table/section/remove/image', [BasicController::class, 'removeImage'])->name('user.table.section.rmv.img');

        Route::get('/reservation/form', [ReservationFormController::class, 'form'])->name('user.reservation.form');
        Route::post('/reservation/form/store', [ReservationFormController::class, 'formStore'])->name('user.reservation.form.store');
        Route::post('/reservation/inputDelete', [ReservationFormController::class, 'inputDelete'])->name('user.reservation.inputDelete');
        Route::get('/reservation/{id}/inputEdit', [ReservationFormController::class, 'inputEdit'])->name('user.reservation.inputEdit');
        Route::get('/reservation/{id}/options', [ReservationFormController::class, 'options'])->name('user.reservation.options');
        Route::post('/reservation/inputUpdate', [ReservationFormController::class, 'inputUpdate'])->name('user.reservation.inputUpdate');
        Route::post('/reservation/orderUpdate', [ReservationFormController::class, 'orderUpdate'])->name('user.reservation.orderUpdate');
    });

    Route::group(['middleware' => ['checkUserPermission:Table Reservation', 'checkAdminHasPermission:Table Reservations'], 'prefix' => 'table/reservations'], function () {

        Route::get('/all', [ReservationsController::class, 'index'])->name('user.all.table.reservations');
        Route::get('/pending', [ReservationsController::class, 'pending'])->name('user.pending.table.reservations');
        Route::get('/accepted', [ReservationsController::class, 'accepted'])->name('user.accepted.table.reservations');
        Route::get('/rejected', [ReservationsController::class, 'rejected'])->name('user.rejected.table.reservations');
        Route::post('/status', [ReservationsController::class, 'status'])->name('user.status.table.reservations');
        Route::post('/delete', [ReservationsController::class, 'delete'])->name('user.delete.table.reservations');
        Route::post('/bulk/delete', [ReservationsController::class, 'bulkTableDelete'])->name('user.bulk.delete.table.reservations');
        Route::get('/create', [ReservationsController::class, 'create'])->name('user.table.reservations.new');
    });

    Route::group(['middleware' => 'checkAdminHasPermission:Payment Gateways'], function () {

        Route::get('/gateways', [GatewayController::class, 'index'])->name('user.gateway.index');
        Route::post('/stripe/update', [GatewayController::class, 'stripeUpdate'])->name('user.stripe.update');
        Route::post('/paypal/update', [GatewayController::class, 'paypalUpdate'])->name('user.paypal.update');
        Route::post('/paystack/update', [GatewayController::class, 'paystackUpdate'])->name('user.paystack.update');
        Route::post('/paytm/update', [GatewayController::class, 'paytmUpdate'])->name('user.paytm.update');
        Route::post('/flutterwave/update', [GatewayController::class, 'flutterwaveUpdate'])->name('user.flutterwave.update');
        Route::post('/instamojo/update', [GatewayController::class, 'instamojoUpdate'])->name('user.instamojo.update');
        Route::post('/mollie/update', [GatewayController::class, 'mollieUpdate'])->name('user.mollie.update');
        Route::post('/razorpay/update', [GatewayController::class, 'razorpayUpdate'])->name('user.razorpay.update');
        Route::post('/mercadopago/update', [GatewayController::class, 'mercadopagoUpdate'])->name('user.mercadopago.update');
        Route::post('/anet/update', [GatewayController::class, 'anetUpdate'])->name('user.anet.update');
        Route::post('/yoco/update', [GatewayController::class, 'yocoUpdate'])->name('user.yoco.update');
        Route::post('/xendit/update', [GatewayController::class, 'xenditUpdate'])->name('user.xendit.update');
        Route::post('/perfect_money/update', [GatewayController::class, 'perfect_moneyUpdate'])->name('user.perfect_money.update');
        Route::post('/perfect_money/update', [GatewayController::class, 'perfect_moneyUpdate'])->name('user.perfect_money.update');
        Route::post('/myfatoorah/update', [GatewayController::class, 'myfatoorahUpdate'])->name('user.myfatoorah.update');
        Route::post('/midtrans/update', [GatewayController::class, 'midtransUpdate'])->name('user.midtrans.update');
        Route::post('/toyyibpay/update', [GatewayController::class, 'toyyibpayUpdate'])->name('user.toyyibpay.update');
        Route::post('/iyzico/update', [GatewayController::class, 'iyzicoUpdate'])->name('user.iyzico.update');
        Route::post('/paytabs/update', [GatewayController::class, 'paytabsUpdate'])->name('user.paytabs.update');
        Route::post('/phonepe/update', [GatewayController::class, 'phonepeUpdate'])->name('user.phonepe.update');


        Route::get('/offline/gateways', [GatewayController::class, 'offline'])->name('user.gateway.offline');
        Route::post('/offline/gateway/store', [GatewayController::class, 'store'])->name('user.gateway.offline.store');
        Route::post('/offline/gateway/update', [GatewayController::class, 'update'])->name('user.gateway.offline.update');
        Route::post('/offline/status', [GatewayController::class, 'status'])->name('user.offline.status');
        Route::post('/offline/gateway/delete', [GatewayController::class, 'delete'])->name('user.offline.gateway.delete');
    });

    Route::group(['middleware' =>  'checkAdminHasPermission:Settings'], function () {

        Route::get('/favicon', [BasicController::class, 'favicon'])->name('user.favicon');
        Route::post('/favicon/post', [BasicController::class, 'updateFav'])->name('user.favicon.update');

        Route::get('/logo', [BasicController::class, 'logo'])->name('user.logo');
        Route::post('/logo/post', [BasicController::class, 'updateLogo'])->name('user.logo.update');

        Route::get('/preloader', [BasicController::class, 'preloader'])->name('user.preloader');
        Route::post('/preloader/post', [BasicController::class, 'updatePreloader'])->name('user.preloader.update');

        Route::post('/progress/image/upload', 'User\BasicController@progressView')->name('user.image.progress');

        Route::get('/basic-info', [BasicController::class, 'basicInfo'])->name('user.basic.info');
        Route::post('/basic-info/{langid}/post', [BasicController::class, 'updateBasicInfo'])->name('user.basic.info.update');

        Route::get('/pwa', [BasicController::class, 'pwa'])->name('user.pwa')->middleware('checkUserPermission:PWA Installability');
        Route::post('/pwa/post', [BasicController::class, 'updatePwa'])->name('user.pwa.update')->middleware('checkUserPermission:PWA Installability');


        Route::get('/mail-to-user', [EmailController::class, 'mailToAdmin'])->name('user.mailToAdmin');
        Route::post('/mail-to-user/update', [EmailController::class, 'updateMailToAdmin'])->name('user.mailtoadmin.update');

        Route::get('/mail/information', [BasicController::class, 'getMailInformation'])->name('user.mail.info');
        Route::post('/store/mail/information', [BasicController::class, 'storeMailInformation'])->name('user.mail.info.update');

        Route::get('/email-templates', [EmailController::class, 'templates'])->name('user.email.templates');
        Route::get('/email-template/{id}/edit', [EmailController::class, 'editTemplate'])->name('user.email.editTemplate');
        Route::post('/email-template/{id}/update', [EmailController::class, 'templateUpdate'])->name('user.email.templateUpdate');


        Route::get('/support', [BasicController::class, 'support'])->name('user.support');
        Route::post('/support/{langid}/post', [BasicController::class, 'updateSupport'])->name('user.support.update');


        Route::get('/breadcrumb', [BasicController::class, 'breadcrumb'])->name('user.breadcrumb');
        Route::post('/breadcrumb/update', [BasicController::class, 'updateBreadcrumb'])->name('user.breadcrumb.update');


        Route::get('/heading', [BasicController::class, 'heading'])->name('user.heading');
        Route::post('/heading/{langid}/update', [BasicController::class, 'updateHeading'])->name('user.heading.update');

        Route::get('/section/heading', [SectionHeadingController::class, 'sectionHeading'])->name('user.section.heading');
        Route::post('/section/heading/{langid}/update', [SectionHeadingController::class, 'updateSectionHeading'])->name('user.section.heading.update');


        Route::get('/plugins', [BasicController::class, 'plugins'])->name('user.plugins');
        Route::post('/pusher/update', [BasicController::class, 'updatepusher'])->name('user.pusher.update');
        Route::post('/fblogin/update', [BasicController::class, 'updatefblogin'])->name('user.fblogin.update');
        Route::post('/googlelogin/update', [BasicController::class, 'updategooglelogin'])->name('user.googlelogin.update');
        Route::post('/twilio/update', [BasicController::class, 'updateTwilio'])->name('user.twilio.update');

        Route::post('/whatsapp/update', [BasicController::class, 'updateWhatsapp'])->name('user.whatsapp.update');
        Route::post('/tawk/update', [BasicController::class, 'updateTawk'])->name('user.tawk.update');
        Route::post('/disqus/update', [BasicController::class, 'updateDisqus'])->name('user.disqus.update');
        Route::post('/ga/update', [BasicController::class, 'updatega'])->name('user.ga.update');
        Route::post('/appzi/update', [BasicController::class, 'updateAppzi'])->name('user.appzi.update');
        Route::post('/addthis/update', [BasicController::class, 'updateaddthis'])->name('user.addthis.update');
        Route::post('/recaptcha/update', [BasicController::class, 'updaterecaptcha'])->name('user.recaptcha.update');
        Route::post('/pixel/update', [BasicController::class, 'updatepixel'])->name('user.pixel.update');


        Route::get('/social', [SocialController::class, 'index'])->name('user.social.index');
        Route::post('/social/store', [SocialController::class, 'store'])->name('user.social.store');
        Route::get('/social/{id}/edit', [SocialController::class, 'edit'])->name('user.social.edit');
        Route::post('/social/update', [SocialController::class, 'update'])->name('user.social.update');
        Route::post('/social/delete', [SocialController::class, 'delete'])->name('user.social.delete');


        Route::get('/maintenance', [BasicController::class, 'maintenance'])->name('user.maintenance');
        Route::post('/maintenance/update', [BasicController::class, 'updateMaintenance'])->name('user.maintenance.update');


        Route::get('/cookie-alert', [BasicController::class, 'cookieAlert'])->name('user.cookie.alert');
        Route::post('/cookie-alert/{langid}/update', [BasicController::class, 'updateCookie'])->name('user.cookie.update');


        Route::middleware(['checkUserPermission:Online Order,Call Waiter'])->group(function () {
            Route::get('/call-waiter', [BasicController::class, 'callWaiter'])->name('user.call.waiter')->middleware('checkUserPermission:Call Waiter');
            Route::post('/call-waiter/post', [BasicController::class, 'updateCallWaiter'])->name('user.call.waiter.update')->middleware('checkUserPermission:Call Waiter');
        });


        Route::get('/basic_settings/seo', [BasicController::class, 'seo'])->name('user.basic_settings.seo');
        Route::post('/basic_settings/update_seo_informations', [BasicController::class, 'updateSEO'])->name('user.basic_settings.update_seo_informations');

        Route::get('/themes', [BasicController::class, 'themes'])->name('user.themes');
        Route::post('/themes/update', [BasicController::class, 'updateTheme'])->name('user.theme.update');
    });

    Route::group(['middleware' => 'checkAdminHasPermission:Drag & Drop Menu Builder'], function () {
        Route::get('/menu-builder', [MenuBuilderController::class, 'index'])->name('user.menu_builder.index');
        Route::post('/menu-builder/update', [MenuBuilderController::class, 'update'])->name('user.menu_builder.update');
    });

    Route::group(['middleware' => ['checkUserPermission:Custom Page', 'checkAdminHasPermission:Custom Pages'], 'prefix' => '/custom-pages'], function () {
        Route::get('', [CustomPageController::class, 'index'])->name('user.custom_pages');
        Route::get('/create-page', [CustomPageController::class, 'create'])->name('user.custom_pages.create_page');
        Route::post('/store-page', [CustomPageController::class, 'store'])->name('user.custom_pages.store_page');
        Route::get('/edit-page/{id}', [CustomPageController::class, 'edit'])->name('user.custom_pages.edit_page');
        Route::post('/update-page/{id}', [CustomPageController::class, 'update'])->name('user.custom_pages.update_page');
        Route::post('/delete-page/{id}', [CustomPageController::class, 'destroy'])->name('user.custom_pages.delete_page');
        Route::post('/bulk-delete-page', [CustomPageController::class, 'bulkDestroy'])->name('user.custom_pages.bulk_delete_page');
    });

    Route::group(['middleware' => 'checkAdminHasPermission:Language Management'], function () {
        Route::get('/languages', [LanguageController::class, 'index'])->name('user.language.index');
        Route::get('/language/{id}/edit', [LanguageController::class, 'edit'])->name('user.language.edit');
        Route::get('/language/{id}/edit/keyword', [LanguageController::class, 'editKeyword'])->name('user.language.editKeyword');
        Route::post('/language/{id}/update/keyword', [LanguageController::class, 'updateKeyword'])->name('user.language.updateKeyword')->middleware('limitCheck:languages,update');
        Route::post('/language/store', [LanguageController::class, 'store'])->name('user.language.store')->middleware('limitCheck:languages,store');
        Route::post('/language/upload', [LanguageController::class, 'upload'])->name('user.language.upload');
        Route::post('/language/{id}/uploadUpdate', [LanguageController::class, 'uploadUpdate'])->name('user.language.uploadUpdate');
        Route::post('/language/{id}/default', [LanguageController::class, 'default'])->name('user.language.default');
        Route::post('/language/{id}/delete', [LanguageController::class, 'delete'])->name('user.language.delete');
        Route::post('/language/update', [LanguageController::class, 'update'])->name('user.language.update')->middleware('limitCheck:languages,update');
    });

    Route::group(['middleware' => 'checkAdminHasPermission:Website Pages'], function () {

        Route::get('/herosection/sliders', [SliderController::class, 'index'])->name('user.slider.index');
        Route::post('/herosection/slider/store', [SliderController::class, 'store'])->name('user.slider.store');
        Route::get('/herosection/slider/{id}/edit', [SliderController::class, 'edit'])->name('user.slider.edit');
        Route::post('/herosection/slider/update', [SliderController::class, 'update'])->name('user.slider.update');
        Route::post('/herosection/slider/delete', [SliderController::class, 'delete'])->name('user.slider.delete');
        Route::post('/slider/{langid}/update', [BasicController::class, 'updateSlider'])->name('user.slider.image.update');
        Route::post('/slider/rmv-img', [BasicController::class, 'removeSliderImage'])->name('user.slider.image.remove');


        Route::get('/herosection/imgtext', [HerosectionController::class, 'imgText'])->name('user.herosection.imgtext');
        Route::post('/herosection/remove/image', [HerosectionController::class, 'removeImage'])->name('user.herosection.rmv.img');
        Route::post('/herosection/{langid}/update', [HerosectionController::class, 'update'])->name('user.herosection.update');


        Route::get('/herosection/video', [HerosectionController::class, 'video'])->name('user.herosection.video');
        Route::post('/hero/video/update', [HerosectionController::class, 'videoUpdate'])->name('user.herosection.video.update');


        Route::get('/banner-section', [BannerController::class, 'index'])->name('user.bannersection.index');
        Route::post('/banner/store', [BannerController::class, 'store'])->name('user.banner.store');
        Route::get('/banner/edit/{id}', [BannerController::class, 'edit'])->name('user.banner.edit');
        Route::post('/banner/update', [BannerController::class, 'update'])->name('user.banner.update');
        Route::post('/banner/delete', [BannerController::class, 'delete'])->name('user.banner.delete');
        Route::post('/banner-section/update', [BannerController::class, 'updateBannerSection'])->name('user.banner.update_section');

        Route::get('/top-heaer-section', [TopHeaderController::class, 'index'])->name('user.topheader.index');
        Route::post('/update/top-header', [TopHeaderController::class, 'update'])->name('user.topheader.update');

        Route::get('/featured-category-sectoin', [FeaturedCategoryController::class, 'index'])->name('user.fcategory_section.index');
        Route::post('/update/fcategory-section', [FeaturedCategoryController::class, 'update'])->name('user.fcategory_section.update');

        Route::get('/features', [FeatureController::class, 'index'])->name('user.feature.index');
        Route::post('/feature/store', [FeatureController::class, 'store'])->name('user.feature.store');
        Route::get('/feature/{id}/edit', [FeatureController::class, 'edit'])->name('user.feature.edit');
        Route::post('/feature/update', [FeatureController::class, 'update'])->name('user.feature.update');
        Route::post('/feature/delete', [FeatureController::class, 'delete'])->name('user.feature.delete');
        Route::post('/feature/remove/image', [FeatureController::class, 'removeImage'])->name('user.feature.rmv.img');
        Route::post('/feature/shape/remove/image', [FeatureController::class, 'featuresSectionRmvImg'])->name('user.feature_shape.rmv.img');
        Route::post('/feature-section/title/{langid}/update', [FeatureController::class, 'featureSection'])->name('user.featureSection.update');


        Route::get('/introsection', [IntrosectionController::class, 'index'])->name('user.introsection.index');
        Route::post('/introsection/{langid}/update', [IntrosectionController::class, 'update'])->name('user.introsection.update');
        Route::post('/introsection/remove/image', [IntrosectionController::class, 'removeImage'])->name('user.introsection.img.rmv');

        Route::get('intro/points', [IntroPointController::class, 'index'])->name('user.intro.points.index');
        Route::post('intro/point/store', [IntroPointController::class, 'store'])->name('user.intro.point.store');

        Route::get('intro/point/{id}/edit', [IntroPointController::class, 'edit'])->name('user.intro.point.edit');
        Route::post('intro/point/update', [IntroPointController::class, 'update'])->name('user.intro.point.update');
        Route::post('intro/point/delete', [IntroPointController::class, 'delete'])->name('user.intro.point.delete');
        Route::post('intro/point/remove/image', [IntroPointController::class, 'removeImage'])->name('user.intro.point.rmv.img');


        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('user.testimonial.index');
        Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('user.testimonial.create');
        Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('user.testimonial.store');
        Route::get('/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('user.testimonial.edit');
        Route::post('/testimonial/update', [TestimonialController::class, 'update'])->name('user.testimonial.update');
        Route::post('/testimonial/delete', [TestimonialController::class, 'delete'])->name('user.testimonial.delete');
        Route::post('/testimonialtext/{langid}/update', [TestimonialController::class, 'textUpdate'])->name('user.testimonialtext.update');

        Route::post('/testimonial-side-content/{langid}/update', [TestimonialController::class, 'sideContent'])->name('user.testimonialSideContent.update');
        Route::post('/testimonials/side-img/remove', [TestimonialController::class, 'removeImage'])->name('user.testimonial.rmvimg');

        Route::get('/instagram/section', [BasicController::class, 'instagramsection'])->name('user.instagramsection.index');
        Route::post('/instagram/section/{langid}/update', [BasicController::class, 'instagramsectionUpdate'])->name('user.instagramsection.update');


        Route::get('/special-section', [BasicController::class, 'specialSection'])->name('user.special.section.index');
        Route::post('/special-section/{langid}/update', [BasicController::class, 'specialSectionUpdate'])->name('user.special.section.update');

        Route::get('/featured/section', [BasicController::class, 'featuredSection'])->name('user.featured.section.index');
        Route::post('/featured/section/{langid}/update', [BasicController::class, 'featuredSectionUpdate'])
            ->name('user.featured.section.update');

        Route::get('/affordable-deals', [AffordableDealController::class, 'index'])->name('user.affordableDeal.section.index');
        Route::post('/affordable-deals/{langid}/update', [AffordableDealController::class, 'update'])
            ->name('user.affordableDeal.section.update');


        Route::get('/blogsection', [BlogsectionController::class, 'index'])->name('user.blogsection.index');
        Route::post('/blogsection/{langid}/update', [BlogsectionController::class, 'update'])->name('user.blogsection.update');

        Route::get('/menu/section', [BasicController::class, 'menusection'])->name('user.menusection.index');
        Route::post('/menu/section/{langid}/update', [BasicController::class, 'menusectionUpdate'])->name('user.menusection.update');
        Route::post('/menu/section/remove/image', [BasicController::class, 'removeImage'])->name('user.menusection.rmv.img');


        Route::get('/members', [MemberController::class, 'index'])->name('user.member.index');
        Route::post('/team/{langid}/upload', [MemberController::class, 'teamUpload'])->name('user.team.upload');
        Route::post('/member/upload', [MemberController::class, 'upload'])->name('user.member.upload');
        Route::get('/member/create', [MemberController::class, 'create'])->name('user.member.create');
        Route::post('/member/store', [MemberController::class, 'store'])->name('user.member.store');
        Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('user.member.edit');
        Route::post('/member/update', [MemberController::class, 'update'])->name('user.member.update');
        Route::post('/member/{id}/uploadUpdate', [MemberController::class, 'uploadUpdate'])->name('user.member.uploadUpdate');
        Route::post('/member/delete', [MemberController::class, 'delete'])->name('user.member.delete');

        Route::post('/member/feature', [MemberController::class, 'feature'])->name('user.member.feature');


        Route::get('/sections', [BasicController::class, 'sections'])->name('user.sections.index');
        Route::post('/sections/{langid}/update', [BasicController::class, 'updateSections'])->name('user.sections.update');


        Route::get('/footers', [FooterController::class, 'index'])->name('user.footer.index');
        Route::post('/footer/{langid}/update', [FooterController::class, 'update'])->name('user.footer.update');
        Route::post('/footer/remove/image', [FooterController::class, 'removeImage'])->name('user.footer.rmv.img');


        Route::get('/ulinks', [UlinkController::class, 'index'])->name('user.ulink.index');
        Route::get('/ulink/create', [UlinkController::class, 'create'])->name('user.ulink.create');
        Route::post('/ulink/store', [UlinkController::class, 'store'])->name('user.ulink.store');
        Route::get('/ulink/{id}/edit', [UlinkController::class, 'edit'])->name('user.ulink.edit');
        Route::post('/ulink/update', [UlinkController::class, 'update'])->name('user.ulink.update');
        Route::post('/ulink/delete', [UlinkController::class, 'delete'])->name('user.ulink.delete');


        Route::get('/bottom/links', [BlinkController::class, 'index'])->name('user.blink.index');
        Route::get('/bottom/link/create', [BlinkController::class, 'create'])->name('user.blink.create');
        Route::post('/bottom/link/store', [BlinkController::class, 'store'])->name('user.blink.store');
        Route::get('/bottom/link/{id}/edit', [BlinkController::class, 'edit'])->name('user.blink.edit');
        Route::post('/bottom/link/update', [BlinkController::class, 'update'])->name('user.blink.update');
        Route::post('/bottom/link/delete', [BlinkController::class, 'delete'])->name('user.blink.delete');


        Route::get('/gallery', [GalleryController::class, 'index'])->name('user.gallery.index');
        Route::post('/gallery/store', [GalleryController::class, 'store'])->name('user.gallery.store');
        Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('user.gallery.edit');
        Route::post('/gallery/update', [GalleryController::class, 'update'])->name('user.gallery.update');
        Route::post('/gallery/delete', [GalleryController::class, 'delete'])->name('user.gallery.delete');
        Route::post('/gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('user.gallery.bulk.delete');


        Route::get('/faqs', [FaqController::class, 'index'])->name('user.faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('user.faq.create');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('user.faq.store');
        Route::post('/faq/update', [FaqController::class, 'update'])->name('user.faq.update');
        Route::post('/faq/delete', [FaqController::class, 'delete'])->name('user.faq.delete');
        Route::post('/faq/bulk-delete', [FaqController::class, 'bulkDelete'])->name('user.faq.bulk.delete');

        Route::get('/jcategorys', [JcategoryController::class, 'index'])->name('user.jcategory.index');
        Route::post('/jcategory/store', [JcategoryController::class, 'store'])->name('user.jcategory.store');
        Route::get('/jcategory/{id}/edit', [JcategoryController::class, 'edit'])->name('user.jcategory.edit');
        Route::post('/jcategory/update', [JcategoryController::class, 'update'])->name('user.jcategory.update');
        Route::post('/jcategory/delete', [JcategoryController::class, 'delete'])->name('user.jcategory.delete');
        Route::post('/jcategory/bulk-delete', [JcategoryController::class, 'bulkDelete'])->name('user.jcategory.bulk.delete');


        Route::get('/jobs', [JobController::class, 'index'])->name('user.job.index');
        Route::get('/job/create', [JobController::class, 'create'])->name('user.job.create');
        Route::post('/job/store', [JobController::class, 'store'])->name('user.job.store');
        Route::get('/job/{id}/edit', [JobController::class, 'edit'])->name('user.job.edit');
        Route::post('/job/update', [JobController::class, 'update'])->name('user.job.update');
        Route::post('/job/delete', [JobController::class, 'delete'])->name('user.job.delete');
        Route::post('/job/bulk-delete', [JobController::class, 'bulkDelete'])->name('user.job.bulk.delete');
        Route::get('/job/{langid}/getcats', [JobController::class, 'getcats'])->name('user.job.getcats');


        Route::get('/contact', [ContactController::class, 'index'])->name('user.contact.index');
        Route::post('/contact/{langid}/post', [ContactController::class, 'update'])->name('user.contact.update');


        //Admin  Section Background Image Change

        Route::get('/testimonial-section/background-image', [HomePageController::class, 'backgroundImage'])->name('user.testimonialSection.backgroundImage');
        Route::get('/intro-section/background-image', [HomePageController::class, 'backgroundImage'])->name('user.introSection.backgroundImage');

        Route::get('/feature-section/background-image', [HomePageController::class, 'backgroundImage'])->name('user.featureSection.backgroundImage');
        Route::get('/special-section/background-image', [HomePageController::class, 'backgroundImage'])->name('user.SpacailSection.backgroundImage');
        Route::get('/footer-section/background-image', [HomePageController::class, 'backgroundImage'])->name('user.footerSection.backgroundImage');
        Route::get('/blog-section/background-image', [HomePageController::class, 'backgroundImage'])->name('user.blogSection.backgroundImage');

        Route::post('/background-image/{langid}/update', [HomePageController::class, 'backgroundImageUpdate'])->name('user.backgroundImage.update');
        Route::post('/background-image/remove/image', [HomePageController::class, 'removeImage'])->name('user.backgroundimage.rmvimg');
    });


    Route::group(['middleware' => ['checkUserPermission:Blog', 'checkAdminHasPermission:Blog Management'], 'prefix' => '/blog-management'], function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('user.blog_management.categories');
        Route::post('/store-category', [CategoryController::class, 'store'])->name('user.blog_management.store_category');
        Route::put('/update-category', [CategoryController::class, 'update'])->name('user.blog_management.update_category');
        Route::post('/delete-category/{id}', [CategoryController::class, 'destroy'])->name('user.blog_management.delete_category');
        Route::post('/bulk-delete-category', [CategoryController::class, 'bulkDestroy'])->name('user.blog_management.bulk_delete_category');

        Route::get('/blog', [BlogController::class, 'index'])->name('user.blog_management.blogs');
        Route::get('/create-blog', [BlogController::class, 'create'])->name('user.blog_management.create_blog');
        Route::post('/store-blog', [BlogController::class, 'store'])->name('user.blog_management.store_blog');
        Route::get('/edit-blog/{id}', [BlogController::class, 'edit'])->name('user.blog_management.edit_blog');
        Route::post('/update-blog/{id}', [BlogController::class, 'update'])->name('user.blog_management.update_blog');
        Route::post('/delete-blog/{id}', [BlogController::class, 'destroy'])->name('user.blog_management.delete_blog');
        Route::post('/bulk-delete-blog', [BlogController::class, 'bulkDestroy'])->name('user.blog_management.bulk_delete_blog');
    });

    Route::group(['middleware' => ['checkAdminHasPermission:Announcement Popups'], 'prefix' => '/announcement-popups'], function () {
        Route::get('', [PopupController::class, 'index'])->name('user.announcement_popups');
        Route::get('/select-popup-type', [PopupController::class, 'popupType'])->name('user.announcement_popups.select_popup_type');
        Route::get('/create-popup/{type}', [PopupController::class, 'create'])->name('user.announcement_popups.create_popup');
        Route::post('/store-popup', [PopupController::class, 'store'])->name('user.announcement_popups.store_popup');
        Route::post('/popup/{id}/update-status', [PopupController::class, 'updateStatus'])->name('user.announcement_popups.update_popup_status');
        Route::get('/edit-popup/{id}', [PopupController::class, 'edit'])->name('user.announcement_popups.edit_popup');
        Route::post('/update-popup/{id}', [PopupController::class, 'update'])->name('user.announcement_popups.update_popup');
        Route::post('/delete-popup/{id}', [PopupController::class, 'destroy'])->name('user.announcement_popups.delete_popup');
        Route::post('/bulk-delete-popup', [PopupController::class, 'bulkDestroy'])->name('user.announcement_popups.bulk_delete_popup');
    });


    Route::get('/package-list', [BuyPlanController::class, 'index'])->name('user.plan.extend.index');
    Route::get('/package/checkout/{package_id}', [BuyPlanController::class, 'checkout'])->name('user.plan.extend.checkout');
    Route::post('/package/checkout', [UserCheckoutController::class, 'checkout'])->name('user.plan.checkout');

    Route::group(['middleware' => ['checkUserPermission:Live Orders', 'checkAdminHasPermission:Push Notification']], function () {

        Route::get('/pushnotification/settings', [PushController::class, 'settings'])->name('user.pushnotification.settings');
        Route::post('/pushnotification/update/settings', [PushController::class, 'updateSettings'])->name('user.pushnotification.updateSettings');
        Route::get('/pushnotification/send', [PushController::class, 'send'])->name('user.pushnotification.send');
        Route::post('/push', [PushController::class, 'push'])->name('user.pushnotification.push');
    });

    Route::group(['middleware' => ['checkAdminHasPermission:Subscribers']], function () {

        Route::get('/subscribers', [SubscriberController::class, 'index'])->name('user.subscriber.index');
        Route::get('/mail/subscriber', [SubscriberController::class, 'mailSubscriber'])->name('user.mail.subscriber');
        Route::post('/subscribers/sendmail', [SubscriberController::class, 'subsSendMail'])->name('user.subscribers.sendmail');
        Route::post('/subscriber/delete', [SubscriberController::class, 'delete'])->name('user.subscriber.delete');
        Route::post('/subscriber/bulk-delete', [SubscriberController::class, 'bulkDelete'])->name('user.subscriber.bulk.delete');
    });

    Route::get('/tables', [TableController::class, 'index'])->name('user.table.index');
    Route::post('/table/store', [TableController::class, 'store'])->name('user.table.store');
    Route::post('/table/update', [TableController::class, 'update'])->name('user.table.update');
    Route::post('/table/delete', [TableController::class, 'delete'])->name('user.table.delete');

    Route::group(['middleware' => ['checkUserPermission:Table QR Builder', 'checkAdminHasPermission:Tables & QR Builder']], function () {

        Route::get('/table/{tableId}/qr/builder', [TableController::class, 'qrBuilder'])->name('user.table.qr.builder');
        Route::post('/table/qr/generate', [TableController::class, 'qrGenerate'])->name('user.table.qr.generate');
        Route::get('/qr-table/download/{name?}', [TableController::class, 'download'])->name('user.table.qr.download');
    });

    Route::group(['middleware' => ['checkUserPermission:QR Menu', 'checkAdminHasPermission:QR Code Builder']], function () {

        Route::get('/qr-code', [QrController::class, 'qrCode'])->name('user.qrcode');
        Route::post('/qr-code/generate', [QrController::class, 'generate'])->name('user.qrcode.generate');
        Route::get('/qr-code/download/{name?}', [QrController::class, 'download'])->name('user.qr.download');
    });

    Route::group(['middleware' => ['checkUserPermission:Staffs', 'checkAdminHasPermission:Admins Management']], function () {

        Route::get('/admins', [AdminController::class, 'index'])->name('user.admin.index');
        Route::post('/admin/upload', [AdminController::class, 'upload'])->name('user.admin.upload');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('user.admin.store')->middleware('limitCheck:staffs,store');
        Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('user.admin.edit');
        Route::post('/admin/update', [AdminController::class, 'update'])->name('user.admin.update')->middleware('limitCheck:staffs,update');
        Route::post('/admin/{id}/uploadUpdate', [AdminController::class, 'uploadUpdate'])->name('user.admin.uploadUpdate');
        Route::post('/admin/delete', [AdminController::class, 'delete'])->name('user.admin.delete');
        Route::get('/admins/change-password', [AdminController::class, 'change_password'])->name('user.admin.change.password');
        Route::post('/admins/change-password/submit', [AdminController::class, 'updatePassword'])->name('user.admin.change.submit')->middleware('limitCheck:staffs,update');
        Route::post('/admin/secret/login', [AdminController::class, 'secretLogin'])->name('user.admin.secretLogin')->withoutMiddleware('Demo');


        Route::get('/roles', [RoleController::class, 'index'])->name('user.role.index');
        Route::post('/role/store', [RoleController::class, 'store'])->name('user.role.store');
        Route::post('/role/update', [RoleController::class, 'update'])->name('user.role.update');
        Route::post('/role/delete', [RoleController::class, 'delete'])->name('user.role.delete');
        Route::get('/role/{id}/permissions/manage', [RoleController::class, 'managePermissions'])->name('user.role.permissions.manage');
        Route::post('/role/permissions/update', [RoleController::class, 'updatePermissions'])->name('user.role.permissions.update');
    });
    Route::group(['middleware' => 'checkAdminHasPermission:Sitemap'], function () {
        Route::get('/sitemap', [SitemapController::class, 'index'])->name('user.sitemap.index');
        Route::post('/sitemap/store', [SitemapController::class, 'store'])->name('user.sitemap.store');
        Route::get('/sitemap/{id}/update', [SitemapController::class, 'update'])->name('user.sitemap.update');
        Route::post('/sitemap/{id}/delete', [SitemapController::class, 'delete'])->name('user.sitemap.delete');
        Route::post('/sitemap/download', [SitemapController::class, 'download'])->name('user.sitemap.download');
    });

    Route::group(['middleware' => ['checkAdminHasPermission:Customers']], function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('user.customer.index');
        Route::post('/customer/store', [CustomerController::class, 'store'])->name('user.customer.store');
        Route::post('/customer/update', [CustomerController::class, 'update'])->name('user.customer.update');
        Route::post('/customer/delete', [CustomerController::class, 'delete'])->name('user.customer.delete');
        Route::post('/customer/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('user.customer.bulk.delete');
        Route::get('/registered-client', 'User\RegisteredUserController@registerClient')->name('user.registered_clients')->middleware('checkUserPermission:Online Order');
    });
});

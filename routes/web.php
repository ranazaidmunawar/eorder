<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Payment\YocoController;
use App\Http\Controllers\Client\ForgotController;
use App\Http\Controllers\Payment\PaytmController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\Payment\IyzicoController;
use App\Http\Controllers\Payment\MollieController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\XenditController;
use App\Http\Controllers\UserFront\PushController;
use App\Http\Controllers\Payment\PaytabsController;
use App\Http\Controllers\Payment\PhonePeController;
use App\Http\Controllers\Payment\MidtransController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\UserFront\QrMenuController;
use App\Http\Controllers\UserFront\ReviewController;
use App\Http\Controllers\Payment\InstamojoController;
use App\Http\Controllers\Payment\ToyyibpayController;
use App\Http\Controllers\UserFront\ProductController;
use App\Http\Controllers\Front\renter\LoginController;
use App\Http\Controllers\Payment\MyFatoorahController;
use App\Http\Controllers\Front\renter\ForgetController;
use App\Http\Controllers\Payment\FlutterWaveController;
use App\Http\Controllers\Payment\MercadopagoController;
use App\Http\Controllers\Payment\AuthorizenetController;
use App\Http\Controllers\Payment\PerfectMoneyController;
use App\Http\Controllers\Payment\product\OfflineController;
use App\Http\Controllers\Payment\product\PaymentController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\ForgetController as AdminForgetController;
use App\Http\Controllers\Client\LoginController as ClientLoginController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Client\RegisterController as ClientRegisterController;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\UserFront\FrontendController as UserFrontendController;
use App\Http\Controllers\Payment\product\YocoController as ProductYocoController;
use App\Http\Controllers\Payment\product\PaytmController as ProductPaytmController;
use App\Http\Controllers\User\Auth\ForgotPasswordController as UserForgetController;
use App\Http\Controllers\Payment\product\IyzicoController as ProductIyzicoController;
use App\Http\Controllers\Payment\product\MollieController as ProductMollieController;
use App\Http\Controllers\Payment\product\PaypalController as ProductPaypalController;
use App\Http\Controllers\Payment\product\StripeController as ProductStripeController;
use App\Http\Controllers\Payment\product\XenditController as ProductXenditController;
use App\Http\Controllers\Payment\product\PaytabsController as ProductPaytabsController;
use App\Http\Controllers\Payment\product\PhonePeController as ProductPhonePeController;
use App\Http\Controllers\Payment\product\MidtransController as ProductMidtransController;

use App\Http\Controllers\Payment\product\PaystackController as ProductPaystackController;
use App\Http\Controllers\Payment\product\RazorpayController as ProductRazorpayController;
use App\Http\Controllers\Payment\product\InstamojoController as ProductInstamojoController;
use App\Http\Controllers\Payment\product\ToyyibpayController as ProductToyyibpayController;
use App\Http\Controllers\Payment\product\MyFatoorahController as ProductMyFatoorahController;
use App\Http\Controllers\Payment\product\FlutterWaveController as ProductFlutterWaveController;
use App\Http\Controllers\Payment\product\MercadopagoController as ProductMercadopagoController;
use App\Http\Controllers\Payment\product\AuthorizenetController as ProductAuthorizenetController;
use App\Http\Controllers\Payment\product\PerfectMoneyController as ProductPerfectMoneyController;

$domain = env('WEBSITE_HOST');

if (!app()->runningInConsole()) {
    if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
        $domain = 'www.' . env('WEBSITE_HOST');
    }
}

Route::fallback(function () {
    return view('errors.user-404');
});

Route::get('/subcheck', 'CronJobController@expired')->name('cron.expired');

Route::get('/myfatoorah/callback', 'MyFatoorahController@callback')->name('myfatoorah.success');
Route::get('myfatoorah/cancel', 'MyFatoorahController@cancel')->name('myfatoorah.cancel');
Route::get('/midtrans/bank-notify', 'MidtransBankNotifyController@bank_notify')->name('midtrans.bank_notify');
Route::get('/midtrans/cancel', 'MidtransBankNotifyController@cancel')->name('midtrans.cancel');


Route::domain($domain)->group(function () {

    Route::group(['middleware' => ['setlang', 'Demo']], function () {
        Route::get('/', [FrontendController::class, 'index'])->name('front.index');
        Route::get('/templates', [FrontendController::class, 'templates'])->name('front.templates');

        Route::get('/listings', [FrontendController::class, 'users'])->name('front.user.view');
        Route::get('/registration/step-1/{status}/{id}', [FrontendController::class, 'step1'])->name('front.register.view');
        Route::get('/registration/final-step', [FrontendController::class, 'step2'])->name('front.registration.step2');
        Route::get('/blog', [FrontendController::class, 'blogs'])->name('front.blogs');
        Route::get('/blog-details/{slug}/{id}', [FrontendController::class, 'blogDetails'])->name('front.blog.details');
        Route::get('/p/{slug}', [FrontendController::class, 'dynamicPage'])->name('front.dynamic.page');
        Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('front.subscribe')->withoutMiddleware('Demo');
        Route::get('/change-language/{lang}', [FrontendController::class, 'changeLanguage'])->name('changeLanguage');
        Route::post('/checkout', [FrontendController::class, 'checkout'])->name('front.checkout.view');
        Route::post('/membership/checkout', [CheckoutController::class, 'checkout'])->name('front.membership.checkout');
        Route::post('/coupon', [CheckoutController::class, 'coupon'])->name('front.membership.coupon');
        Route::post('/payment/instructions', [FrontendController::class, 'paymentInstruction'])->name('front.payment.instructions');
        Route::get('/pricing', [FrontendController::class, 'pricing'])->name('front.pricing');
        Route::get('/contact', [FrontendController::class, 'contact'])->name('front.contact');
        Route::get('/about_us', [FrontendController::class, 'about_us'])->name('front.about_us');
        Route::post('/admin/contact-msg', [FrontendController::class, 'adminContactMessage'])->name('front.admin.contact.message');
        Route::get('/faq', [FrontendController::class, 'faqs'])->name('front.faq');
        Route::view('/success', 'front.success')->name('success.page');
        Route::get('/check/{username}/username', [FrontendController::class, 'checkUsername'])->name('front.username.check');

        Route::prefix('membership')->group(function () {
            Route::get('/paypal/success', [PaypalController::class, 'successPayment'])->name('membership.paypal.success');
            Route::get('/paypal/cancel', [PaypalController::class, 'cancelPayment'])->name('membership.paypal.cancel');
            Route::get('/stripe/cancel', [StripeController::class, 'cancelPayment'])->name('membership.stripe.cancel');
            Route::post('/paytm/payment-status', [PaytmController::class, 'paymentStatus'])->name('membership.paytm.status');
            Route::get('/paystack/success', [PaystackController::class, 'successPayment'])->name('membership.paystack.success');
            Route::post('/mercadopago/cancel', [MercadopagoController::class, 'cancelPayment'])->name('membership.mercadopago.cancel');
            Route::get('/mercadopago/success', [MercadopagoController::class, 'successPayment'])->name('membership.mercadopago.success');
            Route::post('/razorpay/success', [RazorpayController::class, 'successPayment'])->name('membership.razorpay.success');
            Route::post('/razorpay/cancel', [RazorpayController::class, 'cancelPayment'])->name('membership.razorpay.cancel');
            Route::get('/instamojo/success', [InstamojoController::class, 'successPayment'])->name('membership.instamojo.success');
            Route::post('/instamojo/cancel', [InstamojoController::class, 'cancelPayment'])->name('membership.instamojo.cancel');
            Route::post('/flutterwave/success', [FlutterWaveController::class, 'successPayment'])->name('membership.flutterwave.success');
            Route::post('/flutterwave/cancel', [FlutterWaveController::class, 'cancelPayment'])->name('membership.flutterwave.cancel');
            Route::get('/mollie/success', [MollieController::class, 'successPayment'])->name('membership.mollie.success');
            Route::post('/mollie/cancel', [MollieController::class, 'cancelPayment'])->name('membership.mollie.cancel');

            Route::get('/yoco/success', [YocoController::class, 'successPayment'])->name('membership.yoco.success');
            Route::get('/xendit/success', [XenditController::class, 'successPayment'])->name('membership.xendit.success');
            Route::get('/perfect-money/success', [PerfectMoneyController::class, 'successPayment'])->name('membership.perfect_money.success');
            Route::get('/midtrans/success', [MidtransController::class, 'successPayment'])->name('membership.midtrans.success');
            Route::get('/myfatoorah/success', [MyFatoorahController::class, 'successPayment'])->name('membership.myfatoorah.success');
            Route::post('/iyzico/success', [IyzicoController::class, 'successPayment'])->name('membership.iyzico.success');
            Route::get('/toyyibpay/success', [ToyyibpayController::class, 'successPayment'])->name('membership.toyyibpay.success');
            Route::post('/paytabs/success', [PaytabsController::class, 'successPayment'])->name('membership.paytabs.success');
            Route::post('/phonepe/success', [PhonePeController::class, 'successPayment'])->name('membership.phonepe.success');

            Route::get('/anet/cancel', [AuthorizenetController::class, 'cancelPayment'])->name('membership.anet.cancel');
            Route::get('/offline/success', [CheckoutController::class, 'offlineSuccess'])->name('membership.offline.success');
            Route::get('/trial/success', [CheckoutController::class, 'trialSuccess'])->name('membership.trial.success');

            Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('membership.cancel');
        });
    });
});


Route::group(['prefix' => 'admin', 'middleware' => ['guest:admin', "Demo"]], function () {
    Route::get('/', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.login.submit')->withoutMiddleware('Demo');
    Route::get('/mail-form', [AdminForgetController::class, 'mailForm'])->name('admin.forget.form');
    Route::get('/create/password-form', [AdminForgetController::class, 'passwordCreateForm'])->name('admin.create.pasword.form');
    Route::post('/create/password-form/submit', [AdminForgetController::class, 'createNewPassword'])->name('admin.create.password.submit');
    Route::post('/sendmail', [AdminForgetController::class, 'sendmail'])->name('admin.forget.mail');
});

Route::group(['prefix' => 'user', 'middleware' => ['guest:web', 'setlang', 'Demo']], function () {
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('user.login.submit')->withoutMiddleware('Demo');
    Route::get('/password/reset', [UserForgetController::class, 'showLinkRequestForm'])->name('user.forgot.password.form');
    Route::get('/password/reset/form', [UserForgetController::class, 'passwordCreateForm'])->name('user.reset.password.form');
    Route::post('/password/reset/submit', [UserForgetController::class, 'createNewPassword'])->name('user.reset.password.submit');
    Route::post('/password/email', [UserForgetController::class, 'sendResetLinkEmail'])->name('user.forgot.password.submit');
    Route::get('/register/mode/{mode}/verify/{token}', [UserRegisterController::class, 'token'])->name('user.register.token');
});

$parsedUrl = parse_url(url()->current());
$host = str_replace("www.", "", $parsedUrl['host']);
$prefix = '';
if (array_key_exists('host', $parsedUrl)) {
    $websiteHost = trim(env('WEBSITE_HOST'));
    if ($host == $websiteHost) {
        $prefix = '/{username}';
    } else {
        if (!app()->runningInConsole()) {
            if (str_starts_with($_SERVER['HTTP_HOST'], 'www.')) {
                $domain = 'www.{domain}';
            } else {
                $domain = '{domain}';
            }
        }
    }
}

Route::group(['domain' => $domain, 'prefix' => $prefix, 'middleware' => ['userMaintenance', 'packageExpiryCheck', 'Demo']], function () {
    Route::get('/', [UserFrontendController::class, 'index'])->name('user.front.index');
    Route::get('/ajax/search-products', [UserFrontendController::class, 'ajaxSearchProducts'])->name('user.front.ajax.search');

    Route::get('/order/event', [UserFrontendController::class, 'orderEvent'])->name('orderEvent');
    Route::get('/change-language/{lang}/{type?}', [UserFrontendController::class, 'changeLanguage'])->name('user.front.change.language');
    Route::get('/offline', [UserFrontendController::class, 'offlinePWA']);
    Route::group(['prefix' => 'customer', 'middleware' => ['client.guest']], function () {
        Route::get('/login', [ClientLoginController::class, 'showLoginForm'])->name('user.client.login');
        Route::post('/login', [ClientLoginController::class, 'login'])->name('user.client.login.submit')->withoutMiddleware('Demo');

        Route::get('/login/facebook', [ClientLoginController::class, 'redirectToFacebook'])->name('user.client.facebook.login')->middleware('Demo');
        Route::get('/login/facebook/callback', [ClientLoginController::class, 'handleFacebookCallback'])->name('user.client.facebook.callback');

        Route::get('/login/google', [ClientLoginController::class, 'redirectToGoogle'])->name('user.client.google.login');
        Route::get('/login/google/callback', [ClientLoginController::class, 'handleGoogleCallback'])->name('user.client.google.callback');

        Route::get('/register', [ClientRegisterController::class, 'registerPage'])->name('user.client.register');
        Route::post('/register/submit', [ClientRegisterController::class, 'register'])->name('user.client.register.submit');
        Route::get('/register/verify/{token}', [ClientRegisterController::class, 'token'])->name('user.client.register.token');
        Route::get('/register/resend/{email}', [ClientRegisterController::class, 'resend'])->name('user.client.register.resend');
        Route::get('/forgot', [ForgotController::class, 'showForgotForm'])->name('user.client.forgot');
        Route::get('/password/create/form', [ForgotController::class, 'passwordCreateForm'])->name('client.create.password.form');
        Route::post('/forgot', [ForgotController::class, 'forgot'])->name('user.client.forgot.submit');
        Route::post('/password/create/submit', [ForgotController::class, 'createNewPassword'])->name('user.client.password.create.submit');
    });

    Route::group(['prefix' => 'customer', 'middleware' => ['packageHasPermission:Online Order', 'client']], function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('user.client.dashboard');
        Route::get('/reset', [UserController::class, 'resetForm'])->name('user.client.reset');
        Route::post('/reset', [UserController::class, 'reset'])->name('user.client.reset.submit');
        Route::get('/profile', [UserController::class, 'profile'])->name('user.client.profile');
        Route::post('/profile', [UserController::class, 'profileUpdate'])->name('user.client.profile.update');
        Route::get('/logout', [ClientLoginController::class, 'logout'])->name('user.client.logout');
        Route::get('/shipping/details', [UserController::class, 'shippingDetails'])->name('user.client.shipping.details');
        Route::post('/shipping/details/update', [UserController::class, 'shippingUpdate'])->name('user.client.shipping.update');
        Route::get('/billing/details', [UserController::class, 'billingDetails'])->name('user.client.billing.details');
        Route::post('/billing/details/update', [UserController::class, 'billingUpdate'])->name('user.client.billing.update');
        Route::get('/orders', [OrderController::class, 'index'])->name('user.client.orders');
        Route::get('/order/{id}', [OrderController::class, 'orderDetails'])->name('user.client.orders.details');

        Route::post('/order/invoice/download-file', [OrderController::class, 'downloadFile'])->name('user.client.order.download');
    });

    Route::group(['prefix' => 'user'], function () {

        Route::get('/login', [LoginController::class, 'login'])->name('renter.login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('renter.login.submit')->withoutMiddleware('Demo');
        Route::get('/mail-form', [ForgetController::class, 'mailForm'])->name('renter.forget.form');
        Route::post('/sendmail', [ForgetController::class, 'sendMail'])->name('renter.forget.mail');
        Route::get('/create-password-form', [ForgetController::class, 'passwordCreateForm'])->name('renter.create.password.form');
        Route::post('/create-password-form/submit', [ForgetController::class, 'createNewPassword'])->name('renter.create.password.form.submit');
    });

    Route::get('/call/waiter', [UserFrontendController::class, 'callWaiter'])->name('user.front.call.waiter')->middleware('packageHasPermission:Call Waiter');

    Route::middleware('packageHasPermission:Table Reservation')->group(function () {
        Route::get('/reservations/form', [UserFrontendController::class, 'reservationForm'])->name('user.front.reservation');
        Route::post('/table/book', [UserFrontendController::class, 'tableBook'])->name('user.front.table.book');
    });

    Route::middleware('packageHasPermission:Blog')->group(function () {
        Route::get('/blog', [UserFrontendController::class, 'blogs'])->name('user.front.blogs');
        Route::get('/blog-details/{slug}/{id}', [UserFrontendController::class, 'blogDetails'])->name('user.front.blog.details');
    });

    Route::get('/contact', [UserFrontendController::class, 'contact'])->name('user.front.contact');
    Route::post('/sendmail', [UserFrontendController::class, 'sendmail'])->name('user.front.sendmail');
    Route::post('/subscribe', [UserFrontendController::class, 'subscribe'])->name('user.front.subscribe')->withoutMiddleware('Demo');
    Route::get('/gallery', [UserFrontendController::class, 'gallery'])->name('user.front.gallery');
    Route::get('/checkout/payment/{slug1}/{slug2}', [UserFrontendController::class, 'loadPayment'])->name('user.front.load.payment');

    Route::get('/team', [UserFrontendController::class, 'team'])->name('user.front.team');
    Route::get('/career', [UserFrontendController::class, 'career'])->name('user.front.career');
    Route::get('/career-details/{slug}/{id}', [UserFrontendController::class, 'careerDetails'])->name('user.front.career.details');
    Route::get('/gallery', [UserFrontendController::class, 'gallery'])->name('user.front.gallery');
    Route::get('/faq', [UserFrontendController::class, 'faq'])->name('user.front.faq');
    Route::get('/about_us', [UserFrontendController::class, 'about_us'])->name('user.front.about_us');


    Route::get('/qr/{orderNum}/payment/return', [PaymentController::class, 'qrPayReturn'])->name('user.qr.payment.return');
    Route::get('/qr/payment/cancel', [PaymentController::class, 'qrPayCancel'])->name('user.qr.payment.cancel');

    Route::prefix('qr-menu')->group(function () {
        Route::middleware(['packageHasPermission:QR Menu'])->group(function () {
            Route::get('/', [QrMenuController::class, 'qrMenu'])->name('user.front.qrmenu');
            Route::post('/qty-change', [QrMenuController::class, 'qtyChange'])->name('user.front.qr.qtyChange')->withoutMiddleware('Demo');
            Route::post('/remove', [QrMenuController::class, 'remove'])->name('user.front.qr.remove')->withoutMiddleware('Demo');
            Route::get('/checkout', [QrMenuController::class, 'checkout'])->name('user.front.qrmenu.checkout');
        });
        Route::middleware(['packageHasPermission:Online Order', 'client.guest'])->group(function () {
            Route::get('/login', [QrMenuController::class, 'login'])->name('user.front.qrmenu.login');
        });
        Route::middleware(['packageHasPermission:Online Order', 'client'])->group(function () {
            Route::get('/qr-menu/logout', [QrMenuController::class, 'logout'])->name('user.front.qrmenu.logout');
        });
    });


    Route::get('/timeframes', [ProductController::class, 'timeFrames'])->name('user.front.timeframes');
    Route::get('/menus', [ProductController::class, 'product'])->name('user.front.product');
    Route::get('/items', [ProductController::class, 'items'])->name('user.front.items');
    Route::get('/{slug}/{id}/item', [ProductController::class, 'productDetails'])->name('user.front.product.details');

    Route::get('/cart', [ProductController::class, 'cart'])->name('user.front.cart');
    Route::get('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('user.front.add.cart');
    Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('user.front.cart.update');
    Route::get('/cart/item/remove/{id}', [ProductController::class, 'cartItemRemove'])->name('user.front.cart.item.remove');
    Route::get('/cart/item/add/quantity/{id}', [ProductController::class, 'cartItemAddQuantity'])->name('user.front.cart.item.add.quantity');
    Route::get('/cart/item/less/quantity/{id}', [ProductController::class, 'cartItemLessQuantity'])->name('user.front.cart.item.less.quantity');

    Route::get('/checkout', [ProductController::class, 'checkout'])->name('user.product.front.checkout');
    Route::get('/checkout/{slug}', [ProductController::class, 'productCheckout'])->name('user.front.product.checkout');

    Route::middleware('packageHasPermission:Online Order')->group(function () {
        Route::post('product/review/submit', [ReviewController::class, 'reviewSubmit'])->name('user.product.review.submit');
    });

    Route::middleware('packageHasPermission:Coupon')->group(function () {
        Route::post('/coupon', [ProductController::class, 'coupon'])->name('user.front.coupon');
    });

    Route::get('/product/{orderNum}/payment/return', [PaymentController::class, 'payReturn'])->name('product.payment.return');
    Route::get('/product/payment/cancel', [PaymentController::class, 'payCancel'])->name('product.payment.cancel');

    Route::post('/product/paypal/submit', [ProductPaypalController::class, 'store'])->name('product.paypal.submit');
    Route::get('/product/paypal/{orderId}/apiRequest', [ProductPaypalController::class, 'apiRequest'])->name('product.paypal.apiRequest');
    Route::get('/product/payment/notify', [ProductPaypalController::class, 'notify'])->name('product.paypal.notify');

    Route::post('/product/stripe/submit', [ProductStripeController::class, 'store'])->name('product.stripe.submit');
    Route::get('/product/stripe/{orderId}/apiRequest', [ProductStripeController::class, 'apiRequest'])->name('product.stripe.apiRequest');

    Route::post('/product/offline/{gatewayid}/submit', [OfflineController::class, 'store'])->name('product.offline.submit');

    Route::post('/product/flutterwave/submit', [ProductFlutterWaveController::class, 'store'])->name('product.flutterwave.submit');
    Route::get('/product/flutterwave/{orderId}/apiRequest', [ProductFlutterWaveController::class, 'apiRequest'])->name('product.flutterwave.apiRequest');
    Route::post('/product/flutterwave/notify', [ProductFlutterWaveController::class, 'notify'])->name('product.flutterwave.notify');
    Route::get('/product/flutterwave/notify', [ProductFlutterWaveController::class, 'success'])->name('product.flutterwave.success');

    Route::post('/product/paystack/submit', [ProductPaystackController::class, 'store'])->name('product.paystack.submit');
    Route::get('/product/paystack/{orderId}/apiRequest', [ProductPaystackController::class, 'apiRequest'])->name('product.paystack.apiRequest');
    Route::get('/product/paystack/notify', [ProductPaystackController::class, 'notify'])->name('product.paystack.notify');


    Route::post('/product/razorpay/submit', [ProductRazorpayController::class, 'store'])->name('product.razorpay.submit');
    Route::get('/product/razorpay/{orderId}/apiRequest', [ProductRazorpayController::class, 'apiRequest'])->name('product.razorpay.apiRequest');
    Route::post('/product/razorpay/notify', [ProductRazorpayController::class, 'notify'])->name('product.razorpay.notify');

    Route::post('/product/instamojo/submit', [ProductInstamojoController::class, 'store'])->name('product.instamojo.submit');
    Route::get('/product/instamojo/{orderId}/apiRequest', [ProductInstamojoController::class, 'apiRequest'])->name('product.instamojo.apiRequest');
    Route::get('/product/instamojo/notify', [ProductInstamojoController::class, 'notify'])->name('product.instamojo.notify');

    Route::post('/product/paytm/submit', [ProductPaytmController::class, 'store'])->name('product.paytm.submit');
    Route::get('/product/paytm/{orderId}/apiRequest', [ProductPaytmController::class, 'apiRequest'])->name('product.paytm.apiRequest');
    Route::post('/product/paytm/notify', [ProductPaytmController::class, 'notify'])->name('product.paytm.notify');

    Route::post('/product/mollie/submit', [ProductMollieController::class, 'store'])->name('product.mollie.submit');
    Route::get('/product/mollie/{orderId}/apiRequest', [ProductMollieController::class, 'apiRequest'])->name('product.mollie.apiRequest');
    Route::get('/product/mollie/notify', [ProductMollieController::class, 'notify'])->name('product.mollie.notify');

    Route::post('/product/mercadopago/submit', [ProductMercadopagoController::class, 'store'])->name('product.mercadopago.submit');
    Route::get('/product/mercadopago/{orderId}/apiRequest', [ProductMercadopagoController::class, 'apiRequest'])->name('product.mercadopago.apiRequest');
    Route::get('/product/mercadopago/notify', [ProductMercadopagoController::class, 'notify'])->name('product.mercadopago.notify');

    Route::post('/product/anet/submit', [ProductAuthorizenetController::class, 'store'])->name('product.anet.submit');
    Route::get('/product/anet/{orderId}/apiRequest', [ProductAuthorizenetController::class, 'apiRequest'])->name('product.anet.apiRequest');

    Route::post('/product/yoco/submit', [ProductYocoController::class, 'store'])->name('product.yoco.submit');
    Route::get('/product/yoco/notify', [ProductYocoController::class, 'notify'])->name('product.yoco.notify');

    Route::post('/product/xendit/submit', [ProductXenditController::class, 'store'])->name('product.xendit.submit');
    Route::get('/product/xendit/notify', [ProductXenditController::class, 'notify'])->name('product.xendit.notify');

    Route::post('/product/phonepe/submit', [ProductPhonePeController::class, 'store'])->name('product.phonepe.submit');
    Route::post('/product/phonepe/notify', [ProductPhonePeController::class, 'notify'])->name('product.phopepe.notify');

    Route::post('/product/perfect_money/submit', [ProductPerfectMoneyController::class, 'store'])->name('product.perfect_money.submit');
    Route::get('/product/perfect_money/notify', [ProductPerfectMoneyController::class, 'notify'])->name('product.perfect_money.notify');

    Route::post('/product/midtrans/submit', [ProductMidtransController::class, 'store'])->name('product.midtrans.submit');
    Route::get('/product/midtrans/notify', [ProductMidtransController::class, 'notify'])->name('product.midtrans.notify');

    Route::post('/product/myfatoorah/submit', [ProductMyFatoorahController::class, 'store'])->name('product.myfatoorah.submit');
    Route::get('/product/myfatoorah/notify', [ProductMyFatoorahController::class, 'notify'])->name('product.myfatoorah.notify');

    Route::post('/product/toyyibpay/submit', [ProductToyyibpayController::class, 'store'])->name('product.toyyibpay.submit');
    Route::get('/product/toyyibpay/notify', [ProductToyyibpayController::class, 'notify'])->name('product.toyyibpay.notify');

    Route::post('/product/paytabs/submit', [ProductPaytabsController::class, 'store'])->name('product.paytabs.submit');
    Route::post('/product/paytabs/notify', [ProductPaytabsController::class, 'notify'])->name('product.paytabs.notify');

    Route::post('/product/iyzico/submit', [ProductIyzicoController::class, 'store'])->name('product.iyzico.submit');
    Route::post('/product/iyzico/notify', [ProductIyzicoController::class, 'notify'])->name('product.iyzico.notify');

    Route::middleware('packageHasPermission:Custom Page')->group(function () {
        Route::get('/{slug}', [UserFrontendController::class, 'dynamicPage'])->name('user.front.cpage');
    });

    Route::post('/push/store', [PushController::class, 'store']);
    Route::get('/offline', [PushController::class, 'offline']);
});

Route::fallback(function () {
    return view('errors.user-404');
});

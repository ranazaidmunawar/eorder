<?php

use App\Http\Controllers\Admin\BasicController;
use App\Http\Controllers\Admin\BcategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomDomainController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\GatewayController;
use App\Http\Controllers\Admin\HerosectionController;
use App\Http\Controllers\Admin\HomePageTextController;
use App\Http\Controllers\Admin\IntrosectionController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MailTemplateController;
use App\Http\Controllers\Admin\MenuBuilderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PaymentLogController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RegisterUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\SubdomainController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UlinkController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'Demo'], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/change-theme', [DashboardController::class, 'changeTheme'])->name('admin.theme.change');

    Route::get('/rtlcheck/{langid}', [LanguageController::class, 'rtlcheck'])->name('admin.rtlcheck');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/edit/profile', [ProfileController::class, 'editProfile'])->name('admin.edit.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.update.profile');
    Route::get('/changePassword', [ProfileController::class, 'changePass'])->name('admin.change.password');
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('admin.update.password');


    Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('admin.summernote.upload');


    Route::group(['middleware' => 'checkpermission:Custom Domains'], function () {
        Route::get('/domains', [CustomDomainController::class, 'index'])->name('admin.custom-domain.index');
        Route::get('/domain/texts', [CustomDomainController::class, 'texts'])->name('admin.custom-domain.texts');
        Route::post('/domain/texts', [CustomDomainController::class, 'updateTexts'])->name('admin.custom-domain.texts');
        Route::post('/domain/status', [CustomDomainController::class, 'status'])->name('admin.custom-domain.status');
        Route::post('/domain/mail', [CustomDomainController::class, 'mail'])->name('admin.custom-domain.mail');
        Route::post('/domain/delete', [CustomDomainController::class, 'delete'])->name('admin.custom-domain.delete');
        Route::post('/domain/bulk-delete', [CustomDomainController::class, 'bulkDelete'])->name('admin.custom-domain.bulk.delete');
    });


    Route::group(['middleware' => 'checkpermission:Subdomains'], function () {
        Route::get('/subdomains', [SubdomainController::class, 'index'])->name('admin.subdomain.index');
        Route::post('/subdomain/status', [SubdomainController::class, 'status'])->name('admin.subdomain.status');
        Route::post('/subdomain/mail', [SubdomainController::class, 'mail'])->name('admin.subdomain.mail');
    });

    Route::group(['middleware' => 'checkpermission:Packages'], function () {

        Route::get('/package/settings', [PackageController::class, 'settings'])->name('admin.package.settings');
        Route::post('/package/settings', [PackageController::class, 'updateSettings'])->name('admin.package.settings');

        Route::get('/package/features', [PackageController::class, 'features'])->name('admin.package.features');
        Route::post('/package/features', [PackageController::class, 'updateFeatures'])->name('admin.package.features');

        Route::get('packages', [PackageController::class, 'index'])->name('admin.package.index');
        Route::post('package/upload', [PackageController::class, 'upload'])->name('admin.package.upload');
        Route::post('package/store', [PackageController::class, 'store'])->name('admin.package.store');
        Route::get('package/{id}/edit', [PackageController::class, 'edit'])->name('admin.package.edit');
        Route::post('package/update', [PackageController::class, 'update'])->name('admin.package.update');
        Route::post('package/{id}/uploadUpdate', [PackageController::class, 'uploadUpdate'])->name('admin.package.uploadUpdate');
        Route::post('package/delete', [PackageController::class, 'delete'])->name('admin.package.delete');
        Route::post('package/bulk-delete', [PackageController::class, 'bulkDelete'])->name('admin.package.bulk.delete');

        Route::get('/coupon', [CouponController::class, 'index'])->name('admin.coupon.index');
        Route::post('/coupon/store', [CouponController::class, 'store'])->name('admin.coupon.store');
        Route::get('/coupon/{id}/edit', [CouponController::class, 'edit'])->name('admin.coupon.edit');
        Route::post('/coupon/update', [CouponController::class, 'update'])->name('admin.coupon.update');
        Route::post('/coupon/delete', [CouponController::class, 'delete'])->name('admin.coupon.delete');
    });
    Route::group(['middleware' => 'checkpermission:Menu Builder'], function () {
        Route::get('/menu-builder', [MenuBuilderController::class, 'index'])->name('admin.menu_builder.index');
        Route::post('/menu-builder/update', [MenuBuilderController::class, 'update'])->name('admin.menu_builder.update');
    });
    Route::group(['middleware' => 'checkpermission:Home Page'], function () {


        Route::get('/herosection/imgtext', [HerosectionController::class, 'imgtext'])->name('admin.herosection.imgtext');
        Route::post('/herosection/{langid}/update', [HerosectionController::class, 'update'])->name('admin.herosection.update');

        Route::get('/features', [FeatureController::class, 'index'])->name('admin.feature.index');
        Route::post('/feature/store', [FeatureController::class, 'store'])->name('admin.feature.store');
        Route::get('/feature/{id}/edit', [FeatureController::class, 'edit'])->name('admin.feature.edit');
        Route::post('/feature/update', [FeatureController::class, 'update'])->name('admin.feature.update');
        Route::post('/feature/delete', [FeatureController::class, 'delete'])->name('admin.feature.delete');

        Route::get('/process', [ProcessController::class, 'index'])->name('admin.process.index');
        Route::post('/process/store', [ProcessController::class, 'store'])->name('admin.process.store');
        Route::get('/process/{id}/edit', [ProcessController::class, 'edit'])->name('admin.process.edit');
        Route::post('/process/update', [ProcessController::class, 'update'])->name('admin.process.update');
        Route::post('/process/delete', [ProcessController::class, 'delete'])->name('admin.process.delete');

        Route::get('/introsection', [IntrosectionController::class, 'index'])->name('admin.introsection.index');
        Route::post('/introsection/{langid}/update', [IntrosectionController::class, 'update'])->name('admin.introsection.update');
        Route::post('/introsection/remove/image', [IntrosectionController::class, 'removeImage'])->name('admin.introsection.img.rmv');

        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonial.index');
        Route::get('/testimonial/create', [TestimonialController::class, 'create'])->name('admin.testimonial.create');
        Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('admin.testimonial.store');
        Route::post('/testimonial/sideImageStore', [TestimonialController::class, 'sideImageStore'])->name('admin.testimonial.sideImageStore');
        Route::get('/testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('admin.testimonial.edit');
        Route::post('/testimonial/update', [TestimonialController::class, 'update'])->name('admin.testimonial.update');
        Route::post('/testimonial/delete', [TestimonialController::class, 'delete'])->name('admin.testimonial.delete');
        Route::post('/testimonialtext/{langid}/update', [TestimonialController::class, 'textupdate'])->name('admin.testimonialtext.update');


        Route::get('/home-page-text-section', [HomePageTextController::class, 'index'])->name('admin.home.page.text.index');
        Route::post('/home-page-text-section/{langid}/update', [HomePageTextController::class, 'update'])->name('admin.home.page.text.update');


        Route::get('/partners', [PartnerController::class, 'index'])->name('admin.partner.index');
        Route::post('/partner/store', [PartnerController::class, 'store'])->name('admin.partner.store');
        Route::post('/partner/upload', [PartnerController::class, 'upload'])->name('admin.partner.upload');
        Route::get('/partner/{id}/edit', [PartnerController::class, 'edit'])->name('admin.partner.edit');
        Route::post('/partner/update', [PartnerController::class, 'update'])->name('admin.partner.update');
        Route::post('/partner/{id}/uploadUpdate', [PartnerController::class, 'uploadUpdate'])->name('admin.partner.uploadUpdate');
        Route::post('/partner/delete', [PartnerController::class, 'delete'])->name('admin.partner.delete');


        Route::get('/sections', [BasicController::class, 'sections'])->name('admin.sections.index');
        Route::post('/sections/update', [BasicController::class, 'updateSections'])->name('admin.sections.update');
    });

    Route::group(['middleware' => 'checkpermission:Footer'], function () {

        Route::get('/footers', [FooterController::class, 'index'])->name('admin.footer.index');
        Route::post('/footer/{langid}/update', [FooterController::class, 'update'])->name('admin.footer.update');
        Route::post('/footer/remove/image', [FooterController::class, 'removeImage'])->name('admin.footer.rmvimg');


        Route::get('/ulinks', [UlinkController::class, 'index'])->name('admin.ulink.index');
        Route::get('/ulink/create', [UlinkController::class, 'create'])->name('admin.ulink.create');
        Route::post('/ulink/store', [UlinkController::class, 'store'])->name('admin.ulink.store');
        Route::get('/ulink/{id}/edit', [UlinkController::class, 'edit'])->name('admin.ulink.edit');
        Route::post('/ulink/update', [UlinkController::class, 'update'])->name('admin.ulink.update');
        Route::post('/ulink/delete', [UlinkController::class, 'delete'])->name('admin.ulink.delete');
    });

    Route::group(['middleware' => 'checkpermission:Pages'], function () {
        Route::get('/pages', [PageController::class, 'index'])->name('admin.page.index');
        Route::get('/page/create', [PageController::class, 'create'])->name('admin.page.create');
        Route::post('/page/store', [PageController::class, 'store'])->name('admin.page.store');
        Route::get('/page/{pageId}/edit', [PageController::class, 'edit'])->name('admin.page.edit');
        Route::post('/page/update', [PageController::class, 'update'])->name('admin.page.update');
        Route::post('/page/delete', [PageController::class, 'delete'])->name('admin.page.delete');
        Route::post('/page/bulk-delete', [PageController::class, 'bulkDelete'])->name('admin.page.bulk.delete');
    });

    Route::group(['middleware' => 'checkpermission:Blogs'], function () {

        Route::get('/bcategorys', [BcategoryController::class, 'index'])->name('admin.bcategory.index');
        Route::post('/bcategory/store', [BcategoryController::class, 'store'])->name('admin.bcategory.store');
        Route::post('/bcategory/update', [BcategoryController::class, 'update'])->name('admin.bcategory.update');
        Route::post('/bcategory/delete', [BcategoryController::class, 'delete'])->name('admin.bcategory.delete');
        Route::post('/bcategory/bulk-delete', [BcategoryController::class, 'bulkDelete'])->name('admin.bcategory.bulk.delete');

        Route::get('/blog-lists', [BlogController::class, 'index'])->name('admin.blog.index');
        Route::post('/blog-list/upload', [BlogController::class, 'upload'])->name('admin.blog.upload');
        Route::post('/blog-list/store', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/blog-list/{id}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/blog-list/update', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::post('/blog-list/{id}/uploadUpdate', [BlogController::class, 'uploadUpdate'])->name('admin.blog.uploadUpdate');
        Route::post('/blog-list/delete', [BlogController::class, 'delete'])->name('admin.blog.delete');
        Route::post('/blog-list/bulk-delete', [BlogController::class, 'bulkDelete'])->name('admin.blog.bulk.delete');
        Route::get('/blog/{langid}/getcats', [BlogController::class, 'getcats'])->name('admin.blog.getcats');
    });

    Route::group(['middleware' => 'checkpermission:FAQ Management'], function () {
        Route::get('/faqs', [FaqController::class, 'index'])->name('admin.faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('admin.faq.create');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('admin.faq.store');
        Route::post('/faq/update', [FaqController::class, 'update'])->name('admin.faq.update');
        Route::post('/faq/delete', [FaqController::class, 'delete'])->name('admin.faq.delete');
        Route::post('/faq/bulk-delete', [FaqController::class, 'bulkDelete'])->name('admin.faq.bulk.delete');
    });

    Route::group(['middleware' => 'checkpermission:Contact Page'], function () {
        Route::get('/contact-page', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::post('/contact-page/{langid}/post', [ContactController::class, 'update'])->name('admin.contact.update');
    });

    Route::group(['middleware' => 'checkpermission:Announcement Popup'], function () {
        Route::get('popups', [PopupController::class, 'index'])->name('admin.popup.index');
        Route::get('popup/types', [PopupController::class, 'types'])->name('admin.popup.types');
        Route::get('popup/{id}/edit', [PopupController::class, 'edit'])->name('admin.popup.edit');
        Route::get('popup/create', [PopupController::class, 'create'])->name('admin.popup.create');
        Route::post('popup/store', [PopupController::class, 'store'])->name('admin.popup.store');
        Route::post('popup/delete', [PopupController::class, 'delete'])->name('admin.popup.delete');
        Route::post('popup/bulk-delete', [PopupController::class, 'bulkDelete'])->name('admin.popup.bulk.delete');
        Route::post('popup/status', [PopupController::class, 'status'])->name('admin.popup.status');
        Route::post('popup/update', [PopupController::class, 'update'])->name('admin.popup.update');
    });

    Route::group(['middleware' => 'checkpermission:Subscribers'], function () {
        Route::get('/subscribers', [SubscriberController::class, 'index'])->name('admin.subscriber.index');
        Route::get('/mail-subscriber', [SubscriberController::class, 'mailSubscriber'])->name('admin.mail.subscriber');
        Route::post('/subscribers/sendmail', [SubscriberController::class, 'subSendMail'])->name('admin.subscribers.sendmail');
        Route::post('/subscriber/delete', [SubscriberController::class, 'delete'])->name('admin.subscriber.delete');
        Route::post('/subscriber/bulk-delete', [SubscriberController::class, 'bulkDelete'])->name('admin.subscriber.bulk.delete');
    });

    Route::group(['middleware' => 'checkpermission:Payment Gateways'], function () {

        Route::get('/gateways', [GatewayController::class, 'index'])->name('admin.gateway.index');
        Route::post('/stripe/update', [GatewayController::class, 'stripeUpdate'])->name('admin.stripe.update');
        Route::post('/anet/update', [GatewayController::class, 'anetUpdate'])->name('admin.anet.update');
        Route::post('/paypal/update', [GatewayController::class, 'paypalUpdate'])->name('admin.paypal.update');
        Route::post('/paystack/update', [GatewayController::class, 'paystackUpdate'])->name('admin.paystack.update');
        Route::post('/paytm/update', [GatewayController::class, 'paytmUpdate'])->name('admin.paytm.update');
        Route::post('/flutterwave/update', [GatewayController::class, 'flutterwaveUpdate'])->name('admin.flutterwave.update');
        Route::post('/instamojo/update', [GatewayController::class, 'instamojoUpdate'])->name('admin.instamojo.update');
        Route::post('/mollie/update', [GatewayController::class, 'mollieUpdate'])->name('admin.mollie.update');
        Route::post('/razorpay/update', [GatewayController::class, 'razorpayUpdate'])->name('admin.razorpay.update');
        Route::post('/mercadopago/update', [GatewayController::class, 'mercadopagoUpdate'])->name('admin.mercadopago.update');

        Route::post('/yoco/update', [GatewayController::class, 'yocoUpdate'])->name('admin.yoco.update');
        Route::post('/xendit/update', [GatewayController::class, 'xenditUpdate'])->name('admin.xendit.update');
        Route::post('/perfect_money/update', [GatewayController::class, 'perfect_moneyUpdate'])->name('admin.perfect_money.update');
        Route::post('/midtrans/update', [GatewayController::class, 'midtransUpdate'])->name('admin.midtrans.update');
        Route::post('/myfatoorah/update', [GatewayController::class, 'myfatoorahUpdate'])->name('admin.myfatoorah.update');
        Route::post('/iyzico/update', [GatewayController::class, 'iyzicoUpdate'])->name('admin.iyzico.update');
        Route::post('/toyyibpay/update', [GatewayController::class, 'toyyibpayUpdate'])->name('admin.toyyibpay.update');
        Route::post('/paytabs/update', [GatewayController::class, 'paytabsUpdate'])->name('admin.paytabs.update');
        Route::post('/phonepe/update', [GatewayController::class, 'phonepeUpdate'])->name('admin.phonepe.update');


        Route::get('/offline/gateways', [GatewayController::class, 'offline'])->name('admin.gateway.offline');
        Route::post('/offline/gateway/store', [GatewayController::class, 'store'])->name('admin.gateway.offline.store');
        Route::post('/offline/gateway/update', [GatewayController::class, 'update'])->name('admin.gateway.offline.update');
        Route::post('/offline/status', [GatewayController::class, 'status'])->name('admin.offline.status');
        Route::post('/offline/gateway/delete', [GatewayController::class, 'delete'])->name('admin.offline.gateway.delete');
    });

    Route::group(['middleware' => 'checkpermission:Settings'], function () {

        Route::get('/favicon', [BasicController::class, 'favicon'])->name('admin.favicon');
        Route::post('/favicon/post', [BasicController::class, 'updateFav'])->name('admin.favicon.update');

        Route::get('/logo', [BasicController::class, 'logo'])->name('admin.logo');
        Route::post('/logo/post', [BasicController::class, 'updateLogo'])->name('admin.logo.update');

        Route::get('/preloader', [BasicController::class, 'preloader'])->name('admin.preloader');
        Route::post('/preloader/post', [BasicController::class, 'updatePreloader'])->name('admin.preloader.update');

        Route::get('/basicinfo', [BasicController::class, 'basicinfo'])->name('admin.basicinfo');
        Route::post('/basicinfo/post', [BasicController::class, 'updateBasicInfo'])->name('admin.basicinfo.update');

        Route::get('/mail-from-admin', [EmailController::class, 'mailFromAdmin'])->name('admin.mailFromAdmin');
        Route::post('/mail-from-admin/update', [EmailController::class, 'updateMailFromAdmin'])->name('admin.mailfromadmin.update');
        Route::get('/mail-to-admin', [EmailController::class, 'mailToAdmin'])->name('admin.mailToAdmin');
        Route::post('/mail-to-admin/update', [EmailController::class, 'updateMailToAdmin'])->name('admin.mailtoadmin.update');
        Route::get('/mail_templates', [MailTemplateController::class, 'mailTemplates'])->name('admin.mail_templates');
        Route::get('/edit_mail_template/{id}', [MailTemplateController::class, 'editMailTemplate'])->name('admin.edit_mail_template');
        Route::post('/update_mail_template/{id}', [MailTemplateController::class, 'updateMailTemplate'])->name('admin.update_mail_template');


        Route::get('/breadcrumb', [BasicController::class, 'breadcrumb'])->name('admin.breadcrumb');
        Route::post('/breadcrumb/update', [BasicController::class, 'updateBreadcrumb'])->name('admin.breadcrumb.update');

        Route::get('/script', [BasicController::class, 'script'])->name('admin.script');
        Route::post('/script/update', [BasicController::class, 'updateScript'])->name('admin.script.update');

        Route::get('/social', [SocialController::class, 'index'])->name('admin.social.index');
        Route::post('/social/store', [SocialController::class, 'store'])->name('admin.social.store');
        Route::get('/social/{id}/edit', [SocialController::class, 'edit'])->name('admin.social.edit');
        Route::post('/social/update', [SocialController::class, 'update'])->name('admin.social.update');
        Route::post('/social/delete', [SocialController::class, 'delete'])->name('admin.social.delete');

        Route::get('/maintenance', [BasicController::class, 'maintenance'])->name('admin.maintainance');
        Route::post('/maintenance/update', [BasicController::class, 'updateMaintenance'])->name('admin.maintainance.update');

        Route::get('/sections', [BasicController::class, 'sections'])->name('admin.sections.index');
        Route::post('/sections/update', [BasicController::class, 'updatesections'])->name('admin.sections.update');

        Route::get('/cookie-alert', [BasicController::class, 'cookieAlert'])->name('admin.cookie.alert');
        Route::post('/cookie-alert/{langid}/update', [BasicController::class, 'updateCookie'])->name('admin.cookie.update');

        Route::get('/seo', [BasicController::class, 'seo'])->name('admin.seo');
        Route::post('/seo/update', [BasicController::class, 'updateSEO'])->name('admin.seo.update');
    });

    Route::group(['middleware' => 'checkpermission:Language Management'], function () {

        Route::get('/languages', [LanguageController::class, 'index'])->name('admin.language.index');
        Route::get('/language/{id}/edit', [LanguageController::class, 'edit'])->name('admin.language.edit');
        Route::get('/language/{id}/edit/keyword', [LanguageController::class, 'editKeyword'])->name('admin.language.editKeyword');
        Route::post('/language/store', [LanguageController::class, 'store'])->name('admin.language.store');
        Route::post('/language/upload', [LanguageController::class, 'upload'])->name('admin.language.upload');
        Route::post('/language/{id}/uploadUpdate', [LanguageController::class, 'uploadUpdate'])->name('admin.language.uploadUpdate');
        Route::post('/language/{id}/default', [LanguageController::class, 'default'])->name('admin.language.default');
        Route::post('/language/{id}/delete', [LanguageController::class, 'delete'])->name('admin.language.delete');
        Route::post('/language/update', [LanguageController::class, 'update'])->name('admin.language.update');
        Route::post('/language/{id}/update/keyword', [LanguageController::class, 'updateKeyword'])->name('admin.language.updateKeyword');
        Route::post('/language/add/keywords', [LanguageController::class, 'addKeyword'])->name('admin.language_management.add_keyword');
    });

    Route::group(['middleware' => 'checkpermission:Role Management'], function () {

        Route::get('/roles', [RoleController::class, 'index'])->name('admin.role.index');
        Route::post('/role/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::post('/role/update', [RoleController::class, 'update'])->name('admin.role.update');
        Route::post('/role/delete', [RoleController::class, 'delete'])->name('admin.role.delete');
        Route::get('role/{id}/permissions/manage', [RoleController::class, 'managePermissions'])->name('admin.role.permissions.manage');
        Route::post('role/permissions/update', [RoleController::class, 'updatePermissions'])->name('admin.role.permissions.update');
    });

    Route::group(['middleware' => 'checkpermission:Admins Management'], function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');
        Route::post('/user/upload', [UserController::class, 'upload'])->name('admin.user.upload');
        Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::post('/user/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::post('/user/{id}/uploadUpdate', [UserController::class, 'uploadUpdate'])->name('admin.user.uploadUpdate');
        Route::post('/user/delete', [UserController::class, 'delete'])->name('admin.user.delete');
    });

    Route::group(['middleware' => 'checkpermission:Sitemap'], function () {
        Route::get('/sitemap', [SitemapController::class, 'index'])->name('admin.sitemap.index');
        Route::post('/sitemap/store', [SitemapController::class, 'store'])->name('admin.sitemap.store');
        Route::get('/sitemap/{id}/update', [SitemapController::class, 'update'])->name('admin.sitemap.update');
        Route::post('/sitemap/{id}/delete', [SitemapController::class, 'delete'])->name('admin.sitemap.delete');
        Route::post('/sitemap/download', [SitemapController::class, 'download'])->name('admin.sitemap.download');
    });

    Route::get('/cache-clear', [CacheController::class, 'clear'])->name('admin.cache.clear');

    Route::group(['middleware' => 'checkpermission:Registered Users'], function () {

        Route::get('register/users', [RegisterUserController::class, 'index'])->name('admin.register.user');
        Route::post('register/user/store', [RegisterUserController::class, 'store'])->name('register.user.store');
        Route::post('register/users/ban', [RegisterUserController::class, 'userban'])->name('register.user.ban');
        Route::post('register/users/featured', [RegisterUserController::class, 'userFeatured'])->name('register.user.featured');
        Route::post('register/users/email', [RegisterUserController::class, 'emailStatus'])->name('register.user.email');
        Route::get('register/user/details/{id}', [RegisterUserController::class, 'view'])->name('register.user.view');
        Route::post('/user/current-package/remove', [RegisterUserController::class, 'removeCurrPackage'])->name('user.currPackage.remove');
        Route::post('/user/current-package/change', [RegisterUserController::class, 'changeCurrPackage'])->name('user.currPackage.change');
        Route::post('/user/current-package/add', [RegisterUserController::class, 'addCurrPackage'])->name('user.currPackage.add');
        Route::post('/user/next-package/remove', [RegisterUserController::class, 'removeNextPackage'])->name('user.nextPackage.remove');
        Route::post('/user/next-package/change', [RegisterUserController::class, 'changeNextPackage'])->name('user.nextPackage.change');
        Route::post('/user/next-package/add', [RegisterUserController::class, 'addNextPackage'])->name('user.nextPackage.add');
        Route::post('register/user/delete', [RegisterUserController::class, 'delete'])->name('register.user.delete');
        Route::post('register/user/bulk-delete', [RegisterUserController::class, 'bulkDelete'])->name('register.user.bulk.delete');
        Route::get('register/user/{id}/changePassword', [RegisterUserController::class, 'changePass'])->name('register.user.changePass');
        Route::post('register/user/updatePassword', [RegisterUserController::class, 'updatePassword'])->name('register.user.updatePassword');

        Route::post('register/users/template', [RegisterUserController::class, 'userTemplate'])->name('register.user.template');
        Route::post('register/users/template/update', [RegisterUserController::class, 'userUpdateTemplate'])->name('register.user.updateTemplate');

        Route::post('secret/user/login', [RegisterUserController::class, 'secretLogin'])->name('register.user.secretLogin')->withoutMiddleware('Demo');
    });
    Route::group(['middleware' => 'checkpermission:Payment Log'], function () {

        Route::get('/payment-log', [PaymentLogController::class, 'index'])->name('admin.payment-log.index');
        Route::post('/payment-log/update', [PaymentLogController::class, 'update'])->name('admin.payment-log.update');
    });
});

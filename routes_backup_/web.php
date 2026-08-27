<?php

use App\Http\Controllers\Admin\AdminSupportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ManagerSupportController;
use App\Http\Controllers\Admin\ModController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\ApostilController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BlackFridayController;
use App\Http\Controllers\BMETController;
use App\Http\Controllers\BmetEcController;
use App\Http\Controllers\BmetPdfController;
use App\Http\Controllers\BMETUpdateController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\IpBanController;
use App\Http\Controllers\LdTaxController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\NagorikSonodController;
use App\Http\Controllers\NidController;
use App\Http\Controllers\PaymentRequestController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SmartCardController;
use App\Http\Controllers\TradeVerificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User\BkashController;
use App\Http\Controllers\User\ZinipayController;
use App\Http\Controllers\User\DrivingLicenseApplicationController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LandController;
use App\Http\Controllers\User\NagorikSonodController as UserNagorikSonodController;
use App\Http\Controllers\User\NidCardController;
use App\Http\Controllers\User\NidOrderController;
use App\Http\Controllers\User\NidToTinController;
use App\Http\Controllers\User\PassportOrderController;
use App\Http\Controllers\User\PassportSearchController;
use App\Http\Controllers\User\PdoController;
use App\Http\Controllers\User\ReturnMakeController;
use App\Http\Controllers\User\SignCopyOrderController;
use App\Http\Controllers\User\SignToServerController;
use App\Http\Controllers\User\SscCertificateController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\SurokkhaController;
use App\Http\Controllers\User\TinCertificateController;
use App\Http\Controllers\User\TradeController;
use App\Http\Controllers\UttoradhikarSonodController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// ─────────────────────────────────────────────
// PUBLIC / MISC ROUTES
// ─────────────────────────────────────────────

// Public Apostil (Application Details) Verification Route
Route::get('/application-details/{apostil_no}', [ApostilController::class, 'publicVerifyByApostilNo'])->name('application-details.public.verify');

Route::get('/v/bmet/{token}', [BMETController::class, 'serveFileByToken'])
    ->name('bmet.serve')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->withoutMiddleware(\App\Http\Middleware\Authenticate::class)
    ->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

Route::get('/ldt-search', [LdTaxController::class, 'index']);
Route::post('/ldt-search', [LdTaxController::class, 'search'])->name('ldt.search');
Route::get('/ldt-search/get-districts', [LdTaxController::class, 'getDistricts']);
Route::get('/ldt-search/get-upazilas', [LdTaxController::class, 'getUpazilas']);
Route::get('/ldt-search/get-mozas', [LdTaxController::class, 'getMozas']);

Route::get('/payment-request', function () {
    return view('payment_request');
});
Route::post('/payment-request', [PaymentRequestController::class, 'makePaymentRequest'])->name('payment-request.store');

Route::get('/user/passport-search', [PassportSearchController::class, 'index'])->name('passport.search');
Route::post('/user/passport-search', [PassportSearchController::class, 'searchPassport'])->name('passport.search.submit');

Route::get('/ipban', [IpBanController::class, 'index'])->name('ipban.index');
Route::post('/ipban/ban', [IpBanController::class, 'ban'])->name('ipban.ban');
Route::post('/ipban/unban', [IpBanController::class, 'unban'])->name('ipban.unban');

Route::get('admin/verify2fa', [LoginController::class, 'verify2fa'])->name('admin.verify2fa');
Route::post('admin/verify2fa', [LoginController::class, 'postVerify2fa'])->name('admin.postVerify2fa');
Route::get('admin/2fa/setup', function () {
    return view('admin.auth.2fa', [
        'QRImage' => session('qr_code'),
        'secret' => session('secret'),
    ]);
})->name('admin.2fa.setup');

Route::get('user/nid-to-tin', [NidToTinController::class, 'index'])->name('nid-to-tin');
Route::post('user/nid-to-tin', [NidToTinController::class, 'nidToTinPost'])->name('nid-to-tin.submit');

// ─────────────────────────────────────────────
// USER PREFIX GROUP (ssc_certificate, death, nibondon, soudi-sonod, NID)
// ─────────────────────────────────────────────

Route::prefix('user')->name('user.')->group(function () {

    // NID Routes
    Route::prefix('nid')->name('nid.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\NidController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\NidController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\User\NidController::class, 'store'])->name('store');
        Route::get('/{nid}', [App\Http\Controllers\User\NidController::class, 'show'])->name('show');
        Route::get('/{nid}/edit', [App\Http\Controllers\User\NidController::class, 'edit'])->name('edit');
        Route::put('/{nid}', [App\Http\Controllers\User\NidController::class, 'update'])->name('update');
        Route::delete('/{nid}', [App\Http\Controllers\User\NidController::class, 'destroy'])->name('destroy');
        Route::post('/extract', [App\Http\Controllers\User\NidController::class, 'extractNidData'])->name('extract');
    });


    // Death Certificate Routes
    Route::prefix('death_certificate')->name('death_certificate.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\DeathCertificateController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\DeathCertificateController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\User\DeathCertificateController::class, 'store'])->name('store');
        Route::get('/{deathCertificate}', [App\Http\Controllers\User\DeathCertificateController::class, 'show'])->name('show');
        Route::get('/{deathCertificate}/edit', [App\Http\Controllers\User\DeathCertificateController::class, 'edit'])->name('edit');
        Route::put('/{deathCertificate}', [App\Http\Controllers\User\DeathCertificateController::class, 'update'])->name('update');
        Route::delete('/{deathCertificate}', [App\Http\Controllers\User\DeathCertificateController::class, 'destroy'])->name('destroy');
    });

    // Nibondon (Birth Certificate) Routes
    Route::prefix('nibondon')->name('nibondon.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\NibondonController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\NibondonController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\User\NibondonController::class, 'store'])->name('store');
        Route::get('/{nibondon}', [App\Http\Controllers\User\NibondonController::class, 'show'])->name('show');
        Route::get('/{nibondon}/edit', [App\Http\Controllers\User\NibondonController::class, 'edit'])->name('edit');
        Route::put('/{nibondon}', [App\Http\Controllers\User\NibondonController::class, 'update'])->name('update');
        Route::delete('/{nibondon}', [App\Http\Controllers\User\NibondonController::class, 'destroy'])->name('destroy');
    });

    // Soudi Sonod Routes
    Route::prefix('soudi-sonod')->name('soudi-sonod.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\SoudiSonodController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\SoudiSonodController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\User\SoudiSonodController::class, 'store'])->name('store');
        Route::get('/{soudiSonod}', [App\Http\Controllers\User\SoudiSonodController::class, 'show'])->name('show');
        Route::get('/{soudiSonod}/edit', [App\Http\Controllers\User\SoudiSonodController::class, 'edit'])->name('edit');
        Route::put('/{soudiSonod}', [App\Http\Controllers\User\SoudiSonodController::class, 'update'])->name('update');
        Route::delete('/{soudiSonod}', [App\Http\Controllers\User\SoudiSonodController::class, 'destroy'])->name('destroy');
    });

});

// ─────────────────────────────────────────────
// SIGN TO SERVER ROUTES
// ─────────────────────────────────────────────

Route::get('user.sign-to-server', [SignToServerController::class, 'index'])->name('user.sign-to-server.index');
Route::get('user.sign-to-server/create', [SignToServerController::class, 'create'])->name('user.sign-to-server.create');
Route::post('user.sign-to-server', [SignToServerController::class, 'store'])->name('user.sign-to-server.store');
Route::get('sign-to-server/{signToServer}', [SignToServerController::class, 'show'])->name('sign-to-server.show');
Route::get('user.sign-to-server/{signToServer}/edit', [SignToServerController::class, 'edit'])->name('user.sign-to-server.edit');
Route::put('user.sign-to-server/{signToServer}', [SignToServerController::class, 'update'])->name('user.sign-to-server.update');
Route::delete('user.sign-to-server/{signToServer}', [SignToServerController::class, 'destroy'])->name('user.sign-to-server.destroy');
Route::get('user.sign-to-server/{signToServer}/v1', [SignToServerController::class, 'show'])->name('user.sign-to-server.show-v1');
Route::get('user.sign-to-server/{signToServer}/v2', [SignToServerController::class, 'showV2'])->name('user.sign-to-server.show-v2');
Route::get('user.sign-to-server/{signToServer}/v3', [SignToServerController::class, 'showV3'])->name('user.sign-to-server.show-v3');
Route::post('sign-to-server/extract-pdf', [SignToServerController::class, 'extractPdf'])->name('sign-to-server.extract-pdf');
Route::get('sign-to-server/verify/{signToServer}', [SignToServerController::class, 'verify'])->name('sign-to-server.verify');

// ─────────────────────────────────────────────
// TRADE VERIFICATION
// ─────────────────────────────────────────────

Route::match(['get', 'post'], '/verify', [TradeVerificationController::class, 'verify'])->name('trade.verify.form');
Route::get('/trade/verify/{id}', function ($id) {
    return redirect("https://upsheba.xyz/user/trade/verify/$id");
})->name('trade.verify');

// ─────────────────────────────────────────────
// ADMIN / CONTROL ROUTES
// ─────────────────────────────────────────────

Route::prefix('control')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('supports', [AdminSupportController::class, 'index'])->name('admin.supports');
    Route::get('supports/{id}', [AdminSupportController::class, 'show'])->name('admin.support-detail');
    Route::post('supports/{id}/reply', [AdminSupportController::class, 'reply'])->name('admin.reply-to-support');
    Route::post('supports/{id}/mark-solved', [AdminSupportController::class, 'markSolved'])->name('admin.mark-support-solved');
    Route::post('supports/{id}/update-status', [AdminSupportController::class, 'updateStatus'])->name('admin.update-support-status');
});

Route::get('/admin/monitor', [MonitorController::class, 'index'])->name('admin.monitor');

Route::get('/black-friday', [BlackFridayController::class, 'index']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('promo-codes', [PromoCodeController::class, 'index'])->name('promo_codes.index');
    Route::get('promo-codes/create', [PromoCodeController::class, 'create'])->name('promo_codes.create');
    Route::post('promo-codes', [PromoCodeController::class, 'store'])->name('promo_codes.store');
    Route::get('promo-codes/{promoCode}/edit', [PromoCodeController::class, 'edit'])->name('promo_codes.edit');
    Route::put('promo-codes/{promoCode}', [PromoCodeController::class, 'update'])->name('promo_codes.update');
    Route::delete('promo-codes/{promoCode}', [PromoCodeController::class, 'destroy'])->name('promo_codes.destroy');
});

Route::get('/cache-clear', function () {
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array(), $output);
    return $output->fetch();
})->name('/clear');

Route::get('/about-us', [\App\Http\Controllers\PageController::class, 'aboutUs'])->name('about-us');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/support-tickets', [SupportController::class, 'index'])->name('support-tickets');
});

Route::post('/register/nid/verify', [\App\Http\Controllers\Auth\RegisterController::class, 'verifyNID'])->name('register.nid.verify');
Route::get('/terms-and-conditions', [\App\Http\Controllers\PageController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/telegram/subscribe', [SubscriptionController::class, 'subscribe'])->name('telegram.subscribe');
Route::get('/privacy-policy', [\App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/cron-jobs', [\App\Http\Controllers\FrontendController::class, 'api'])->name('cron-jobs');

Auth::routes(['verify' => false]);

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/login', [FrontendController::class, 'login'])->name('login.submit');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');
Route::post('/check-user', [\App\Http\Controllers\Auth\RegisterController::class, 'check'])->name('check-user');
Route::post('/check-promo', [\App\Http\Controllers\Auth\RegisterController::class, 'checkPromo'])->name('check-promo');

Route::get('/check-data', [\App\Http\Controllers\FrontendController::class, 'api'])->name('home-api');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('register/pay-fee', [\App\Http\Controllers\Auth\BkashController::class, 'index'])->name('register.pay');
Route::post('register/pay-fee', [\App\Http\Controllers\Auth\BkashController::class, 'pay'])->name('register.bkash-pay');
Route::get('register/callback', [\App\Http\Controllers\Auth\BkashController::class, 'callback'])->name('register.bkash-callback');

Route::post('/check-promo', [RegisterController::class, 'checkPromo'])->name('check-promo');

Route::get('/inactive-account', [App\Http\Controllers\User\InactiveAccountController::class, 'showInactiveMessage'])->name('inactive.account');

Route::post('/success', [\App\Http\Controllers\User\AamarpayController::class, 'success'])->name('success');
Route::post('/fail', [\App\Http\Controllers\User\AamarpayController::class, 'fail'])->name('fail');
Route::get('/cancel', [\App\Http\Controllers\User\AamarpayController::class, 'cancel'])->name('cancel');

Route::get('public/{filename}', [SignCopyOrderController::class, 'downloadPDFPublic'])
    ->middleware(['auth', 'userCheck'])
    ->name('pdf.download')
    ->where('filename', '.*');

// ─────────────────────────────────────────────
// AUTHENTICATED USER ROUTES  (sidebar order)
// ─────────────────────────────────────────────

Route::group(['middleware' => ['auth', 'userCheck'], 'prefix' => 'user', 'as' => 'user.'], function () {


    // 1. Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/updateProfile', [HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/updatePassword', [HomeController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/updatePassword', [HomeController::class, 'updatePassword_p'])->name('updatePassword');
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

    // 2. Recharge
    Route::get('/recharge', [HomeController::class, 'recharge'])->name('recharge');
    Route::get('/recharge/bkash', [BkashController::class, 'index'])->name('bkash');
    Route::post('/recharge/bkash', [BkashController::class, 'pay'])->name('bkash');
    Route::get('/recharge/bkash-callback', [BkashController::class, 'callback'])->name('bkash-callback');
    Route::get('/bkash-test', [BkashController::class, 'test'])->name('test');

    Route::get('/recharge/zinipay', [ZinipayController::class, 'index'])->name('zinipay');
    Route::post('/recharge/zinipay', [ZinipayController::class, 'pay'])->name('zinipay');
    Route::get('/recharge/zinipay-callback', [ZinipayController::class, 'callback'])->name('zinipay-callback');
    Route::post('/recharge/zinipay-webhook', [ZinipayController::class, 'webhook'])->name('zinipay-webhook')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    Route::get('/recharge/ssl-commerz', 'User\SslCommerzController@index')->name('ssl-commerz');
    Route::post('/recharge/ssl-commerz', 'User\SslCommerzController@pay')->name('ssl-commerz');
    Route::post('recharge/ssl-commerz/success', 'User\SslCommerzController@success')->name('ssl-payment-success')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    Route::post('recharge/ssl-commerz/failed', 'User\SslCommerzController@failed')->name('ssl-payment-failed')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    Route::get('/recharge/aamarpay', [\App\Http\Controllers\User\AamarpayController::class, 'index'])->name('aamarpay');
    Route::post('/recharge/aamarpay', [\App\Http\Controllers\User\AamarpayController::class, 'pay'])->name('aamarpay');
    Route::get('payment', [\App\Http\Controllers\User\AamarpayController::class, 'payment'])->name('payment');
    Route::post('/aamarpay/success', [\App\Http\Controllers\User\AamarpayController::class, 'success'])->name('aamarpay.success');
    Route::post('/aamarpay/fail', [\App\Http\Controllers\User\AamarpayController::class, 'fail'])->name('aamarpay.fail');
    Route::get('/aamarpay/cancel', [\App\Http\Controllers\User\AamarpayController::class, 'cancel'])->name('aamarpay.cancel');
    Route::get('/recharge/{gateway}', 'User\HomeController@recharge_form')->name('recharge-form');
    Route::post('/recharge/{gateway}', 'User\HomeController@recharge_form_p')->name('recharge-form');

    // 3. Transaction Details
    Route::get('/transactions', [HomeController::class, 'transactions'])->name('transactions');

    // 4. Vaccine Entry (Surokkha)
    Route::prefix('surokkha')->name('surokkha.')->group(function () {
        Route::get('/', [SurokkhaController::class, 'index'])->name('index');
        Route::get('/create', [SurokkhaController::class, 'create'])->name('create');
        Route::post('/', [SurokkhaController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SurokkhaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SurokkhaController::class, 'update'])->name('update');
        Route::delete('/{id}', [SurokkhaController::class, 'destroy'])->name('destroy');
        Route::get('/print/{id}', [SurokkhaController::class, 'print'])->name('print');
        Route::get('/verify/{id}', [SurokkhaController::class, 'verify'])
            ->name('verify')
            ->withoutMiddleware(\App\Http\Middleware\Authenticate::class)
            ->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    });

    // 5. Training Certificate (PDO)
    Route::prefix('pdo')->name('pdo.')->group(function () {
        Route::get('/', [PdoController::class, 'index'])->name('index');
        Route::get('/create', [PdoController::class, 'create'])->name('create');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [PdoController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PdoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PdoController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [PdoController::class, 'delete'])->name('delete');
        Route::get('/print/{id}', [PdoController::class, 'print'])->name('print');
        Route::get('/verify/{id}', [PdoController::class, 'verify'])->name('verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    });
    // 6. Land Development

    Route::get('/land', [LandController::class, 'index'])->name('land.index');
    Route::get('/land/create', [LandController::class, 'create'])->name('land.create');
    Route::post('/land/create', [LandController::class, 'store'])->name('land.create');
    Route::get('/land/edit/{id}', [LandController::class, 'edit'])->name('land.update');
    Route::post('/land/edit/{id}', [LandController::class, 'update'])->name('land.update');
    Route::post('/land/delete/{id}', [LandController::class, 'delete'])->name('land.delete');
    Route::get('/land/print/{id}', [LandController::class, 'print'])->name('land.print');
    Route::get('/dakhila-print/{id}', [LandController::class, 'verify'])->name('land.verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

    // Namjari Khatian
    Route::get('/khatian/create', [\App\Http\Controllers\User\KhatianController::class, 'create'])->name('khatian.create');
    Route::post('/khatian/store', [\App\Http\Controllers\User\KhatianController::class, 'store'])->name('khatian.store');

    // Online DCR
    Route::get('/dcr/create', [\App\Http\Controllers\User\DcrController::class, 'create'])->name('dcr.create');
    Route::post('/dcr/store', [\App\Http\Controllers\User\DcrController::class, 'store'])->name('dcr.store');
    Route::get('/dcr/view/{id}', [\App\Http\Controllers\User\DcrController::class, 'view'])->name('dcr.view');
    Route::get('/dcr/logs', [\App\Http\Controllers\User\DcrController::class, 'logs'])->name('dcr.logs');

    // 7. Police Verification
    Route::prefix('police')->name('police.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\PoliceController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\PoliceController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\User\PoliceController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\User\PoliceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\User\PoliceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\User\PoliceController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [App\Http\Controllers\User\PoliceController::class, 'delete'])->name('delete');
        Route::get('/{id}/print', [App\Http\Controllers\User\PoliceController::class, 'print'])->name('print');
        Route::get('/{id}/verify', [App\Http\Controllers\User\PoliceController::class, 'verify'])->name('verify');
    });

    // 8. Trade License
    Route::get('/trade', [TradeController::class, 'index'])->name('trade.index');
    Route::get('/trade/create', [TradeController::class, 'create'])->name('trade.create');
    Route::post('/trade/create', [TradeController::class, 'store'])->name('trade.create');
    Route::get('/trade/edit/{id}', [TradeController::class, 'edit'])->name('trade.update');
    Route::post('/trade/edit/{id}', [TradeController::class, 'update'])->name('trade.update');
    Route::post('/trade/delete/{id}', [TradeController::class, 'delete'])->name('trade.delete');
    Route::get('/trade/print/{id}', [TradeController::class, 'print'])->name('trade.print');
    Route::get('/trade/verify/{id}', [TradeController::class, 'verify'])->name('trade.verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

    // 9. Nagorik Sonod
    Route::prefix('nagorik-sonod')->name('nagorik-sonod.')->group(function () {
        Route::get('/', [UserNagorikSonodController::class, 'index'])->name('index');
        Route::get('/create', [UserNagorikSonodController::class, 'create'])->name('create');
        Route::post('/', [UserNagorikSonodController::class, 'store'])->name('store');
        Route::get('/{nagorikSonod}', [UserNagorikSonodController::class, 'show'])->name('show');
        Route::delete('/{nagorikSonod}', [UserNagorikSonodController::class, 'destroy'])->name('destroy');
    });

    // 10. Uttoradhikar Sonod
    Route::prefix('uttoradhikarsonod')->name('uttoradhikarsonod.')->group(function () {
        Route::get('/', [UttoradhikarSonodController::class, 'index'])->name('index');
        Route::get('/create', [UttoradhikarSonodController::class, 'create'])->name('create');
        Route::post('/', [UttoradhikarSonodController::class, 'store'])->name('store');
        Route::get('/{id}', [UttoradhikarSonodController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UttoradhikarSonodController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UttoradhikarSonodController::class, 'update'])->name('update');
    });

    // 11. Apostil (Application Details)
    Route::prefix('application-details')->name('application-details.')->group(function () {
        Route::get('/', [ApostilController::class, 'index'])->name('index');
        Route::get('/create', [ApostilController::class, 'create'])->name('create');
        Route::post('/', [ApostilController::class, 'store'])->name('store');
        Route::get('/{apostil}', [ApostilController::class, 'show'])->name('show');
        Route::get('/{apostil}/edit', [ApostilController::class, 'edit'])->name('edit');
        Route::put('/{apostil}', [ApostilController::class, 'update'])->name('update');
        Route::delete('/{apostil}', [ApostilController::class, 'destroy'])->name('destroy');
    });

    // 12. Visa Application
    Route::prefix('visa-applications')->name('visa-applications.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\VisaApplicationController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\User\VisaApplicationController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\User\VisaApplicationController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\User\VisaApplicationController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\User\VisaApplicationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\User\VisaApplicationController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\User\VisaApplicationController::class, 'destroy'])->name('destroy');
    });

    // 13. eVisa
    Route::resource('evisas', \App\Http\Controllers\EVisaController::class);

    // 14. BMET Update
    Route::prefix('bmet-update')->group(function () {
        Route::get('/', [BMETUpdateController::class, 'index'])->name('bmet-update.index');
        Route::get('/create', [BMETUpdateController::class, 'create'])->name('bmet-update.create');
        Route::post('/', [BMETUpdateController::class, 'store'])->name('bmet-update.store');
        Route::get('/{id}', [BMETUpdateController::class, 'show'])->name('bmet-update.show');
        Route::get('/{id}/edit', [BMETUpdateController::class, 'edit'])->name('bmet-update.edit');
        Route::put('/{id}', [BMETUpdateController::class, 'update'])->name('bmet-update.update');
        Route::delete('/{id}', [BMETUpdateController::class, 'destroy'])->name('bmet-update.destroy');
        Route::get('/check-storage/{id}', [BMETUpdateController::class, 'checkStorage'])->name('bmet-update.check-storage');
        Route::get('/verify/{id}', [BMETUpdateController::class, 'verify'])->name('bmet-update.verify');
        Route::get('/file/{id}', [BMETUpdateController::class, 'serveFile'])->name('bmet-update.serve-file');
        Route::get('/file/token/{token}', [BMETUpdateController::class, 'serveFileByToken'])->name('bmet-update.serve-file-by-token');
        Route::get('/bmet-clearance/{clearanceId}', [BMETUpdateController::class, 'showByClearanceId'])->name('bmet-update.show-by-clearance');
    });

    // 15. BMET (bmet.index)
    Route::prefix('bmets')->group(function () {
        Route::get('/', [BmetController::class, 'index'])->name('bmets.index');
        Route::get('/create', [BmetController::class, 'create'])->name('bmets.create');
        Route::post('/create', [BmetController::class, 'store'])->name('bmets.store');
        Route::get('/edit/{id}', [BmetController::class, 'edit'])->name('bmets.edit');
        Route::post('/edit/{id}', [BmetController::class, 'update'])->name('bmets.update');
        Route::post('/delete/{id}', [BmetController::class, 'delete'])->name('bmets.delete');
        Route::get('/print/{id}', [BmetController::class, 'print'])->name('bmets.print');
        Route::get('/verify/{id}', [BmetController::class, 'verify'])
            ->name('bmets.verify')
            ->withoutMiddleware(\App\Http\Middleware\Authenticate::class)
            ->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    });

    // 16. BMET EC
    Route::prefix('bmet-ec')->group(function () {
        Route::get('/', [BmetEcController::class, 'index'])->name('bmet-ec.index');
        Route::get('/create', [BmetEcController::class, 'create'])->name('bmet-ec.create');
        Route::post('/', [BmetEcController::class, 'store'])->name('bmet-ec.store');
        Route::get('/{id}', [BmetEcController::class, 'show'])->name('bmet-ec.show');
        Route::get('/{id}/edit', [BmetEcController::class, 'edit'])->name('bmet-ec.edit');
        Route::put('/{id}', [BmetEcController::class, 'update'])->name('bmet-ec.update');
        Route::delete('/{id}', [BmetEcController::class, 'destroy'])->name('bmet-ec.destroy');
        Route::get('/{id}/print', [BmetEcController::class, 'print'])->name('bmet-ec.print');
        Route::get('/verify/{id}', [BmetEcController::class, 'verify'])->name('bmet-ec.verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    });

    // 17. SSC Certificate
    Route::prefix('ssc_certificate')->name('ssc_certificate.')->group(function () {
        Route::get('/', [SscCertificateController::class, 'index'])->name('index');
        Route::get('/create', [SscCertificateController::class, 'create'])->name('create');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [SscCertificateController::class, 'store'])->name('store');
        Route::get('/{ssc_certificate}/show', [SscCertificateController::class, 'show'])->name('show');
        Route::get('/{ssc_certificate}/edit', [SscCertificateController::class, 'edit'])->name('edit');
        Route::put('/{ssc_certificate}/update', [SscCertificateController::class, 'update'])->name('update');
        Route::delete('/{ssc_certificate}/delete', [SscCertificateController::class, 'destroy'])->name('destroy');
    });
    // 17.5. Mark Sheet
    Route::prefix('mark_sheet')->name('mark_sheet.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\MarkSheetController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\MarkSheetController::class, 'create'])->name('create');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [App\Http\Controllers\User\MarkSheetController::class, 'store'])->name('store');
        Route::get('/cost', [App\Http\Controllers\User\MarkSheetController::class, 'getCost'])->name('cost');
        Route::get('/subjects', [App\Http\Controllers\User\MarkSheetController::class, 'getSubjects'])->name('subjects');
        Route::get('/{mark_sheet}/show', [App\Http\Controllers\User\MarkSheetController::class, 'show'])->name('show');
        Route::get('/{mark_sheet}/edit', [App\Http\Controllers\User\MarkSheetController::class, 'edit'])->name('edit');
        Route::put('/{mark_sheet}/update', [App\Http\Controllers\User\MarkSheetController::class, 'update'])->name('update');
        Route::delete('/{mark_sheet}/delete', [App\Http\Controllers\User\MarkSheetController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('cv-maker')->name('cv-maker.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\CvMakerController::class, 'index'])->name('index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [App\Http\Controllers\User\CvMakerController::class, 'store'])->name('store');
    });


        // 17.6. Electricity Bill (DPDC)
    Route::prefix("electricity_bill")->name("electricity_bill.")->group(function () {
        Route::get("/", [\App\Http\Controllers\User\ElectricityBillController::class, "index"])->name("index");
        Route::get("/create", [\App\Http\Controllers\User\ElectricityBillController::class, "create"])->name("create");
        Route::post("/store", [\App\Http\Controllers\User\ElectricityBillController::class, "store"])->name("store");
        Route::get("/{electricity_bill}/show", [\App\Http\Controllers\User\ElectricityBillController::class, "show"])->name("show");
        Route::get("/{electricity_bill}/edit", [\App\Http\Controllers\User\ElectricityBillController::class, "edit"])->name("edit");
        Route::put("/{electricity_bill}/update", [\App\Http\Controllers\User\ElectricityBillController::class, "update"])->name("update");
        Route::delete("/{electricity_bill}/delete", [\App\Http\Controllers\User\ElectricityBillController::class, "destroy"])->name("destroy");
    });
// 18. Death Certificate
    Route::prefix('death_certificate')->name('death_certificate.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\DeathCertificateController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\DeathCertificateController::class, 'create'])->name('create');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [App\Http\Controllers\User\DeathCertificateController::class, 'store'])->name('store');
        Route::get('/{deathCertificate}/show', [App\Http\Controllers\User\DeathCertificateController::class, 'show'])->name('show');
        Route::get('/{deathCertificate}/edit', [App\Http\Controllers\User\DeathCertificateController::class, 'edit'])->name('edit');
        Route::put('/{deathCertificate}/update', [App\Http\Controllers\User\DeathCertificateController::class, 'update'])->name('update');
        Route::delete('/{deathCertificate}/delete', [App\Http\Controllers\User\DeathCertificateController::class, 'destroy'])->name('destroy');
    });

    // 19. Birth Certificate (Nibondon)
    Route::prefix('nibondon')->name('nibondon.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\NibondonController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\NibondonController::class, 'create'])->name('create');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [App\Http\Controllers\User\NibondonController::class, 'store'])->name('store');
        Route::get('/{nibondon}/show', [App\Http\Controllers\User\NibondonController::class, 'show'])->name('show');
        Route::get('/{nibondon}/edit', [App\Http\Controllers\User\NibondonController::class, 'edit'])->name('edit');
        Route::put('/{nibondon}/update', [App\Http\Controllers\User\NibondonController::class, 'update'])->name('update');
        Route::delete('/{nibondon}/delete', [App\Http\Controllers\User\NibondonController::class, 'destroy'])->name('destroy');
    });

    // 20. Soudi Sonod
    Route::prefix('soudi-sonod')->name('soudi-sonod.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\SoudiSonodController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\SoudiSonodController::class, 'create'])->name('create');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [App\Http\Controllers\User\SoudiSonodController::class, 'store'])->name('store');
        Route::get('/{soudiSonod}/show', [App\Http\Controllers\User\SoudiSonodController::class, 'show'])->name('show');
        Route::get('/{soudiSonod}/edit', [App\Http\Controllers\User\SoudiSonodController::class, 'edit'])->name('edit');
        Route::put('/{soudiSonod}/update', [App\Http\Controllers\User\SoudiSonodController::class, 'update'])->name('update');
        Route::delete('/{soudiSonod}/delete', [App\Http\Controllers\User\SoudiSonodController::class, 'destroy'])->name('destroy');
    });

    // 21. TIN Certificate
    Route::prefix('tin')->as('tin.')->group(function () {
        Route::get('/create', [TinCertificateController::class, 'create'])->name('index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [TinCertificateController::class, 'store'])->name('store');
        Route::get('/success/{id}', [TinCertificateController::class, 'success'])->name('success');
    });

    // 22. Return Make
    Route::prefix('return')->as('return.')->group(function () {
        Route::get('/reate', [ReturnMakeController::class, 'create'])->name('index');
        Route::post('/check-tin', [ReturnMakeController::class, 'checkTin'])->name('check-tin');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [ReturnMakeController::class, 'store'])->name('store');
        Route::get('/{id}/view', [ReturnMakeController::class, 'view'])->name('view');
    });

    // 23. Driving Licenses
    Route::prefix('driving-licenses')->as('driving-licenses.')->group(function () {
        Route::get('/', [DrivingLicenseApplicationController::class, 'index'])->name('index');
        Route::get('/create', [DrivingLicenseApplicationController::class, 'create'])->name('create');
        Route::post('/', [DrivingLicenseApplicationController::class, 'store'])->name('store');
        Route::get('/{drivingLicense}', [DrivingLicenseApplicationController::class, 'show'])->name('show');
        Route::get('/{drivingLicense}/edit', [DrivingLicenseApplicationController::class, 'edit'])->name('edit');
        Route::put('/{drivingLicense}', [DrivingLicenseApplicationController::class, 'update'])->name('update');
        Route::delete('/{drivingLicense}', [DrivingLicenseApplicationController::class, 'destroy'])->name('destroy');
    });

    // 24. Smart Card
    Route::group(['prefix' => 'smartcard', 'as' => 'smartcard.'], function () {
        Route::get('', [SmartCardController::class, 'index'])->name('index');
        Route::get('/create', [SmartCardController::class, 'create'])->name('create');
        Route::post('/parse-pdf', [SmartCardController::class, 'parsePdf'])->name('parsePdf');
        Route::get('/{id}', [SmartCardController::class, 'show'])->name('show');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [SmartCardController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SmartCardController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SmartCardController::class, 'update'])->name('update');
        Route::delete('/{id}', [SmartCardController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/print', [SmartCardController::class, 'print'])->name('print');
        Route::get('/{id}/verify', [SmartCardController::class, 'verify'])->name('verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
    });

    // 25. Nid Card
    Route::group(['prefix' => 'nid-card', 'as' => 'nid-card.'], function () {
        Route::get('', [NidCardController::class, 'index'])->name('index');
        Route::get('/create', [NidCardController::class, 'create'])->name('create');
        Route::post('/parse-pdf/{type?}', [NidCardController::class, 'parsePdf'])->name('parsePdf');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [NidCardController::class, 'store'])->name('store');
        Route::get('/{id}/view/{type}', [NidCardController::class, 'view'])->name('view');
        Route::get('/{id}/print', [NidCardController::class, 'print'])->name('print');
        Route::get('/{id}/verify', [NidCardController::class, 'verify'])->name('verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);
        Route::get('/{id}/edit', [NidCardController::class, 'edit'])->name('edit');
        Route::put('/{id}', [NidCardController::class, 'update'])->name('update');
        Route::delete('/{id}', [NidCardController::class, 'destroy'])->name('destroy');
    });

    //26. auto sign
    Route::get('auto/search', [SearchController::class, 'index'])->name('search');
    Route::post('auto/search', [SearchController::class, 'search'])->name('search.submit');
    Route::get('auto/{id}/download', [SearchController::class, 'downloadPdf'])->name('search.download');
});
Route::group(['middleware' => ['auth', 'userCheck'], 'prefix' => 'user', 'as' => 'user.'], function () {

    // ── Other authenticated user routes ──────────────────────

    Route::get('/sign-copy-order/download/{filename}', function ($filename) {
        $filepath = public_path($filename);
        if (!file_exists($filepath)) {
            return response()->json(['error' => 'File not found at: ' . $filepath], 404);
        }
        return response()->download($filepath);
    })->name('sign.copy.order.download')->where('filename', '.*');

    Route::prefix('sign-copy-order')->name('sign.copy.')->group(function () {
        Route::get('/', [SignCopyOrderController::class, 'index'])->name('order.index');
        Route::post('/', [SignCopyOrderController::class, 'store'])->name('order.store');
        Route::get('{order}', [SignCopyOrderController::class, 'show'])->name('order.show')->where('order', '[0-9]+');
    });
    Route::prefix('id-card-order')->name('nid.order.')->group(function () {
        Route::get('/', [NidOrderController::class, 'index'])->name('index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [NidOrderController::class, 'store'])->name('store');
        Route::get('/list', [NidOrderController::class, 'list'])->name('list');
        Route::get('/show/{order}', [NidOrderController::class, 'show'])->name('show');
    });


    Route::prefix('passport-order')->name('passport.')->group(function () {
        Route::get('/', [PassportOrderController::class, 'index'])->name('order.index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [PassportOrderController::class, 'store'])->name('order.store');
        Route::get('/{order}', [PassportOrderController::class, 'show'])->name('order.show');
        Route::get('/{order}/download', [PassportOrderController::class, 'download'])->name('order.download');
    });

    Route::prefix('sim-conversion')->name('sim.conversion.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\SimConversionController::class, 'index'])->name('index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [\App\Http\Controllers\User\SimConversionController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\User\SimConversionController::class, 'view'])->name('view');
        Route::get('/download-pdf/{id}', [\App\Http\Controllers\User\SimConversionController::class, 'downloadPdf'])->name('download-pdf');
    });

    Route::prefix('sim-network')->name('sim.network.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\SimNetworkController::class, 'index'])->name('index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [\App\Http\Controllers\User\SimNetworkController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\User\SimNetworkController::class, 'view'])->name('view');
        Route::get('/{id}/download-pdf', [\App\Http\Controllers\User\SimNetworkController::class, 'downloadPdf'])->name('download-pdf');
    });

    Route::prefix('tin-order')->name('tin.order.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\TinOrderController::class, 'index'])->name('index');
        Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [\App\Http\Controllers\User\TinOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\User\TinOrderController::class, 'view'])->name('view');
        Route::get('/{id}/download', [\App\Http\Controllers\User\TinOrderController::class, 'downloadPdf'])->name('download');
    });

    Route::get('/nid-pass', function () {
        return view('user.nid_pass');
    })->name('nid-pass');

    Route::get('/support-tickets', [HomeController::class, 'support_tickets'])->name('support-tickets');
    Route::get('/create-support-ticket', [HomeController::class, 'create_support_ticket'])->name('create-support-ticket');
    Route::post('/create-support-ticket', [HomeController::class, 'store_ticket'])->name('create-support-ticket');

    Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications');

    Route::get('/applications', [HomeController::class, 'applications'])->name('applications');
    Route::get('/new-application', [HomeController::class, 'new_application'])->name('new-application');
    Route::post('/new-application', [HomeController::class, 'new_application_p'])->name('new-application');
    Route::get('/new-application-advanced', [HomeController::class, 'new_application_advanced'])->name('new-application-advanced');
    Route::post('/new-application-advanced', [HomeController::class, 'new_application_advanced_p'])->name('new-application-advanced');
    Route::post('/delete-application/{id}', 'User\HomeController@deleteApplication')->name('delete-application');
    Route::post('/confirm-application', 'User\HomeController@confirm_application')->name('confirm-application');

    Route::get('/convert-17-digit', 'User\HomeController@convert_17_digit')->name('convert-17-digit');
    Route::post('/convert-17-digit', 'User\HomeController@convert_17_digit_post')->name('convert-17-digit');

    Route::get('/nid-auto-make', [HomeController::class, 'nid_auto_make'])->name('nid-auto-make');
    Route::post('/nid-auto-make', [HomeController::class, 'nid_auto_make_post'])->name('nid-auto-make');
    Route::get('/nid-print', [HomeController::class, 'nid_print'])->name('nid-print');
    Route::get('/nid-17-make', [HomeController::class, 'nid_17_make'])->name('user.nid-17-make');
    Route::post('/nid-17-make', [HomeController::class, 'nid_17_make_post'])->name('user.nid-17-make.submit');
    Route::get('/nid-manual', [HomeController::class, 'nid_manual'])->name('nid-manual');
    Route::post('/nid-manual', [HomeController::class, 'nid_manual_post'])->name('nid-manual');

    Route::get('/server-copy', [HomeController::class, 'server_copy'])->name('server-copy');
    Route::post('/server-copy', [HomeController::class, 'server_copy_post'])->name('server-copy');
    Route::get('/server-copy-view', [HomeController::class, 'server_copy_view'])->name('server-copy-view');
    Route::get('user/server-copy/view/{token}', [HomeController::class, 'server_copy_view'])->name('user.server-copy-view');

    Route::get('/server2', 'User\Server2Controller@index')->name('server2.index');
    Route::get('/server2/create', 'User\Server2Controller@create')->name('server2.create');
    Route::post('/server2/create', 'User\Server2Controller@store')->name('server2.create');
    Route::get('/server2/edit/{id}', 'User\Server2Controller@edit')->name('server2.update');
    Route::post('/server2/edit/{id}', 'User\Server2Controller@update')->name('server2.update');
    Route::post('/server2/delete/{id}', 'User\Server2Controller@delete')->name('server2.delete');
    Route::get('/server2/print/{id}', 'User\Server2Controller@print')->name('server2.print');
    Route::get('/server2/verify/{id}', 'User\Server2Controller@verify')->name('server2.verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

    Route::get('/old-birth', 'User\HomeController@old_birth')->name('old-birth');
    Route::post('/old-birth-bn', 'User\HomeController@old_birth_bn_post')->name('old-birth-bn');
    Route::get('/old-birth-view-bn', 'User\HomeController@old_birth_view_bn')->name('old-birth-view-bn');
    Route::post('/old-birth-en', 'User\HomeController@old_birth_en_post')->name('old-birth-en');
    Route::get('/old-birth-view-en', 'User\HomeController@old_birth_view_en')->name('old-birth-view-en');

    Route::get('/new-birth', 'User\HomeController@new_birth')->name('new-birth');
    Route::post('/new-birth', 'User\HomeController@new_birth_post')->name('new-birth');
    Route::post('/new-birth-api', 'User\HomeController@new_birth_api')->name('new-birth-api');
    Route::get('/new-birth-view', 'User\HomeController@new_birth_view')->name('new-birth-view');

    Route::get('/nidmanuall', [\App\Http\Controllers\User\nidmanuallController::class, 'index'])->name('nidmanuall.index');
    Route::get('/nidmanuall/create', [\App\Http\Controllers\User\nidmanuallController::class, 'create'])->name('nidmanuall.create');
    Route::post('/nidmanuall/create', [\App\Http\Controllers\User\nidmanuallController::class, 'store'])->name('nidmanuall.create');
    Route::get('/nidmanuall/edit/{id}', [\App\Http\Controllers\User\nidmanuallController::class, 'edit'])->name('nidmanuall.update');
    Route::post('/nidmanuall/edit/{id}', [\App\Http\Controllers\User\nidmanuallController::class, 'update'])->name('nidmanuall.update');
    Route::post('/nidmanuall/delete/{id}', [\App\Http\Controllers\User\nidmanuallController::class, 'delete'])->name('nidmanuall.delete');
    Route::get('/nidmanuall/print/{id}', [\App\Http\Controllers\User\nidmanuallController::class, 'print'])->name('nidmanuall.print');
    Route::get('/nidmanuall/verify/{id}', [\App\Http\Controllers\User\nidmanuallController::class, 'verify'])->name('nidmanuall.verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

    Route::get('/uttoradikar', [\App\Http\Controllers\User\UttoradikarController::class, 'index'])->name('uttoradikar.index');
    Route::get('/uttoradikar/create', [\App\Http\Controllers\User\UttoradikarController::class, 'create'])->name('uttoradikar.create');
    Route::post('/uttoradikar/create', [\App\Http\Controllers\User\UttoradikarController::class, 'store'])->name('uttoradikar.create');
    Route::get('/uttoradikar/edit/{id}', [\App\Http\Controllers\User\UttoradikarController::class, 'edit'])->name('uttoradikar.update');
    Route::post('/uttoradikar/edit/{id}', [\App\Http\Controllers\User\UttoradikarController::class, 'update'])->name('uttoradikar.update');
    Route::post('/uttoradikar/delete/{id}', [\App\Http\Controllers\User\UttoradikarController::class, 'delete'])->name('uttoradikar.delete');
    Route::get('/uttoradikar/print/{id}', [\App\Http\Controllers\User\UttoradikarController::class, 'print'])->name('uttoradikar.print');
    Route::get('/uttoradikar/verify/{id}', [\App\Http\Controllers\User\UttoradikarController::class, 'verify'])->name('uttoradikar.verify')->withoutMiddleware(\App\Http\Middleware\Authenticate::class)->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

    Route::get('/tin', 'User\HomeController@tin')->name('tin');
    Route::post('/tin', [HomeController::class, 'tin_post'])->name('user.tin_post');
    Route::get('/tin-view', [HomeController::class, 'tin_view'])->name('user.tin-view');
    Route::post('/download_html', [HomeController::class, 'download_html'])->name('user.download_html');

    Route::get('/bio', 'User\NagadBioController@index')->name('nagad-bio');
    Route::post('/bio', 'User\NagadBioController@view_api')->name('nagad-bio');
    Route::get('/sim', 'User\BioController@index')->name('sim');
    Route::post('/sim', 'User\BioController@view_api')->name('sim');

    Route::get('/verify-robot', 'User\HomeController@verify_robot')->name('verify-robot');
    Route::post('/verify-robot', 'User\HomeController@verify_robot_post')->name('verify-robot');
    Route::post('/verify-robot-refresh', 'User\HomeController@verify_robot_refresh')->name('verify-robot-refresh');


});

// ─────────────────────────────────────────────
// APPLICATIONS
// ─────────────────────────────────────────────

Route::post('/applications/{id}/make-pending', [ApplicationController::class, 'makePending'])->name('applications.makePending');

// ─────────────────────────────────────────────
// ADMIN CONTROL PANEL
// ─────────────────────────────────────────────

Route::group(['prefix' => 'control', 'as' => 'admin.'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [\App\Http\Controllers\Admin\LoginController::class, 'login'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');
    Route::get('/403', [\App\Http\Controllers\Admin\DashboardController::class, 'forbidden'])->name('403');

    Route::group(['middleware' => ['auth:admin', 'permission']], function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/login-logs', [\App\Http\Controllers\Admin\DashboardController::class, 'viewLoginLogs'])->name('login.logs');

        Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
            Route::resource('promo_codes', 'PromoCodeController');
        });

        Route::get('/users', 'Admin\DashboardController@users')->name('users');
        Route::post('/users/{id}/reset-password', 'Admin\DashboardController@resetPassword')->name('reset-password');
        Route::get('/user-add', 'Admin\DashboardController@user_add')->name('user-add');
        Route::post('/user-add', 'Admin\DashboardController@user_store')->name('user-add');
        Route::get('/applications', 'Admin\DashboardController@applications')->name('applications');
        Route::post('/delete-application/{id}', 'Admin\DashboardController@delete_application')->name('delete-application');
        Route::post('/user-delete/{id}', 'Admin\DashboardController@user_delete')->name('user-delete');
        Route::get('/user-edit/{id}', 'Admin\DashboardController@user_edit')->name('user-edit');
        Route::post('/user-update/{id}', 'Admin\DashboardController@user_update')->name('user-update');
        Route::post('/recharge-user', 'Admin\DashboardController@user_recharge')->name('user-recharge');
        Route::post('/ban-user/{id}', 'Admin\DashboardController@ban_user')->name('ban-user');
        Route::post('/unban-user/{id}', 'Admin\DashboardController@unban_user')->name('unban-user');
        Route::post('/login-as-user/{id}', 'Admin\DashboardController@login_as_user')->name('login-as-user');
        Route::post('/delete-inactive-users', 'Admin\DashboardController@delete_inactive_users')->name('delete-inactive-users');
        Route::get('/transactions', 'Admin\DashboardController@transactions')->name('transactions');
        Route::get('/moderators', 'Admin\DashboardController@moderators')->name('moderators');
        Route::get('/add-moderator', 'Admin\DashboardController@add_moderator')->name('add-moderator');
        Route::post('/add-moderator', 'Admin\DashboardController@add_moderator_p')->name('add-moderator');
        Route::get('/edit-moderator/{id}', 'Admin\DashboardController@edit_moderator')->name('edit-moderator');
        Route::post('/edit-moderator/{id}', 'Admin\DashboardController@edit_moderator_p')->name('edit-moderator');
        Route::post('/delete-moderator/{id}', 'Admin\DashboardController@delete_moderator')->name('delete-moderator');
        Route::get('/moderator-reports/{id}', 'Admin\DashboardController@moderator_reports')->name('moderator-reports');
        Route::get('/managers', 'Admin\DashboardController@managers')->name('managers');
        Route::get('/add-manager', 'Admin\DashboardController@add_manager')->name('add-manager');
        Route::post('/add-manager', 'Admin\DashboardController@add_manager_p')->name('add-manager');
        Route::get('/edit-manager/{id}', 'Admin\DashboardController@edit_manager')->name('edit-manager');
        Route::post('/edit-manager/{id}', 'Admin\DashboardController@edit_manager_p')->name('edit-manager');
        Route::post('/delete-manager/{id}', 'Admin\DashboardController@delete_manager')->name('delete-manager');
        Route::get('/recharges', 'Admin\DashboardController@recharges')->name('recharges');
        Route::post('/approve-recharge/{id}', 'Admin\DashboardController@approve_recharge')->name('approve-recharge');
        Route::post('/reject-recharge/{id}', 'Admin\DashboardController@reject_recharge')->name('reject-recharge');
        Route::get('/notifications', 'Admin\DashboardController@notifications')->name('notifications');
        Route::post('/delete-notification/{id}', 'Admin\DashboardController@delete_notification')->name('delete-notification');
        Route::get('/send-notification', 'Admin\DashboardController@send_notification')->name('send-notification');
        Route::post('/send-notification', 'Admin\DashboardController@send_notification_post')->name('send-notification');
        Route::get('/gateways', 'Admin\DashboardController@gateways')->name('gateways');
        Route::get('/add-gateway', 'Admin\DashboardController@add_gateway')->name('add-gateway');
        Route::post('/add-gateway', 'Admin\DashboardController@store_gateway')->name('add-gateway');
        Route::get('/edit-gateway/{id}', 'Admin\DashboardController@edit_gateway')->name('edit-gateway');
        Route::post('/edit-gateway/{id}', 'Admin\DashboardController@update_gateway')->name('edit-gateway');
        Route::post('/delete-gateway/{id}', 'Admin\DashboardController@delete_gateway')->name('delete-gateway');
        Route::get('/settings', 'Admin\DashboardController@settings')->name('settings');
        Route::post('/settings', 'Admin\DashboardController@update_settings')->name('settings');
        Route::get('/use', [TransactionController::class, 'usageHistory'])->name('admin.use');
        Route::get('/profile', 'Admin\DashboardController@profile')->name('profile');
        Route::put('/profile', 'Admin\DashboardController@profileUpdate')->name('profileUpdate');
        Route::get('/password', 'Admin\DashboardController@password')->name('password');
        Route::put('/password', 'Admin\DashboardController@passwordUpdate')->name('passwordUpdate');
    });
});

// ─────────────────────────────────────────────
// MOD ROUTES
// ─────────────────────────────────────────────

Route::group(['prefix' => 'mod', 'as' => 'mod.'], function () {
    Route::group(['middleware' => ['auth:admin', 'club_permission']], function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\ModController::class, 'index'])->name('index');
        Route::get('/logout', [App\Http\Controllers\Admin\ModController::class, 'logout'])->name('logout');
        Route::get('/profile', [App\Http\Controllers\Admin\ModController::class, 'profile'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\Admin\ModController::class, 'profileUpdate'])->name('profileUpdate');
        Route::get('/password', [App\Http\Controllers\Admin\ModController::class, 'password'])->name('password');
        Route::put('/password', [App\Http\Controllers\Admin\ModController::class, 'passwordUpdate'])->name('passwordUpdate');
        Route::get('/applications', [App\Http\Controllers\Admin\ModController::class, 'applications'])->name('applications');
        Route::get('/my-applications', [App\Http\Controllers\Admin\ModController::class, 'my_applications'])->name('my-applications');
        Route::post('/accept-application/{id}', [App\Http\Controllers\Admin\ModController::class, 'accept_application'])->name('accept-application');
        Route::post('/cancel-application', [App\Http\Controllers\Admin\ModController::class, 'cancel_application'])->name('cancel-application');
        Route::post('/deliver-application', [App\Http\Controllers\Admin\ModController::class, 'deliver_application'])->name('deliver-application');
        Route::post('/redeliver-application', [App\Http\Controllers\Admin\ModController::class, 'redeliver_application'])->name('redeliver-application');
        Route::post('/check-applications', [App\Http\Controllers\Admin\ModController::class, 'check_applications'])->name('check-applications');
        Route::post('/photo-application', [App\Http\Controllers\Admin\ModController::class, 'photo_application'])->name('photo-application');
    });
});

// ─────────────────────────────────────────────
// MANAGER ROUTES
// ─────────────────────────────────────────────

Route::group(['prefix' => 'manager', 'as' => 'manager.'], function () {
    Route::group(['middleware' => ['auth:admin', 'manager_permission']], function () {
        Route::get('/user-edit/{id}', 'Admin\ManagerController@user_edit')->name('user-edit');
        Route::post('/user-update/{id}', 'Admin\ManagerController@user_update')->name('user-update');
        Route::post('/logout', 'Admin\ManagerController@logout')->name('logout');
        Route::get('/dashboard', 'Admin\ManagerController@dashboard')->name('dashboard');
        Route::get('/transactions', 'Admin\ManagerController@transactions')->name('transactions');
        Route::get('/moderators', 'Admin\ManagerController@moderators')->name('moderators');
        Route::get('/add-moderator', 'Admin\ManagerController@add_moderator')->name('add-moderator');
        Route::post('/add-moderator', 'Admin\ManagerController@add_moderator_p')->name('add-moderator');
        Route::get('supports', [ManagerSupportController::class, 'index'])->name('manager.supports');
        Route::get('supports/{id}', [ManagerSupportController::class, 'show'])->name('manager.support-detail');
        Route::post('supports/{id}/reply', [ManagerSupportController::class, 'reply'])->name('manager.reply-to-support');
        Route::post('supports/{id}/mark-solved', [ManagerSupportController::class, 'markSolved'])->name('manager.mark-support-solved');
        Route::post('supports/{id}/update-status', [AdminSupportController::class, 'updateStatus'])->name('update-support-status');
        Route::get('/users', 'Admin\ManagerController@users')->name('users');
        Route::get('/add-user', 'Admin\ManagerController@user_add')->name('add-user');
        Route::post('/add-user', 'Admin\ManagerController@user_store')->name('add-user');
        Route::post('/user-subtract', 'Admin\ManagerController@user_subtract')->name('user-subtract');
        Route::get('/profile', 'Admin\ManagerController@profile')->name('profile');
        Route::put('/profile', 'Admin\ManagerController@profileUpdate')->name('profileUpdate');
        Route::get('/password', 'Admin\ManagerController@password')->name('password');
        Route::put('/password', 'Admin\ManagerController@passwordUpdate')->name('passwordUpdate');
    });
});

// ─────────────────────────────────────────────
// PUBLIC NID / BMET / NAGORIK / UTTORADHIKAR / VISA VERIFY ROUTES
// ─────────────────────────────────────────────

Route::get('/nid/{nid_no}', [NidController::class, 'show'])->name('nid.show');

Route::get('qr/printStatusQr2/{id}', [App\Http\Controllers\User\VisaApplicationController::class, 'verify'])
    ->name('visa-applications.verify')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->withoutMiddleware(\App\Http\Middleware\Authenticate::class)
    ->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

Route::get('/user/bmet/create', [BMETController::class, 'create'])->name('bmet.create');
Route::post('/user/bmet/store', [BMETController::class, 'store'])->name('bmet.store');
Route::get('/user/bmet', [BMETController::class, 'index'])->name('bmet.index');
Route::get('/user/bmet/{id}', [BMETController::class, 'show'])->name('bmet.show');
Route::get('/user/bmet/{id}/edit', [BMETController::class, 'edit'])->name('bmet.edit');
Route::delete('/user/bmet/{id}', [BMETController::class, 'destroy'])->name('bmet.destroy');
Route::post('/user/bmet/{id}/update', [BMETController::class, 'update'])->name('bmet.update');

Route::get('/bmet/{bmet}/pdf', [BmetPdfController::class, 'generateCard'])->name('bmet.pdf');
Route::get('/bmet/check-storage/{id}', [BMETController::class, 'checkStorage'])->name('bmet.check-storage');

Route::get('/test-qr', function () {
    return QrCode::format('svg')->size(300)->generate('test');
});

Route::get('/bmet/verify/{id}', [App\Http\Controllers\BMETController::class, 'verify'])->name('bmet.verify');
Route::get('/bmet/file/{id}', [BMETController::class, 'serveFile'])->name('bmet.serveFile');

Route::get('/verify/{certificate_number}', [NagorikSonodController::class, 'verify'])->name('verify.certificate');

Route::prefix('nagorik-sonod')->group(function () {
    Route::get('/create', [NagorikSonodController::class, 'create'])->name('nagorik-sonod.create');
    Route::post('/generate', [NagorikSonodController::class, 'generate'])->name('nagorik-sonod.generate');
    Route::get('/verify/{certificate_number}', [NagorikSonodController::class, 'verify'])->name('verify.certificate');
});

Route::prefix('uttoradhikarsonod')->group(function () {
    Route::get('/', [UttoradhikarSonodController::class, 'index'])->name('uttoradhikarsonod.index');
    Route::get('/create', [UttoradhikarSonodController::class, 'create'])->name('uttoradhikarsonod.create');
    Route::post('/preview', [App\Http\Controllers\User\CvMakerController::class, 'preview'])->name('preview');
 Route::post('/store', [UttoradhikarSonodController::class, 'store'])->name('uttoradhikarsonod.store');
    Route::get('/{id}', [UttoradhikarSonodController::class, 'show'])->name('uttoradhikarsonod.show');
    Route::get('/verify/{certificate_number}', [UttoradhikarSonodController::class, 'verify'])->name('uttoradhikarsonod.verify');
});

Route::get('/verify/uttoradhikarsonod/{certificate_number}', [UttoradhikarSonodController::class, 'verify'])
    ->name('verify.uttoradhikarsonod');

Route::get('/bmet-clearance/{clearanceId}', [BMETController::class, 'showByClearanceId'])
    ->name('bmet.clearance')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->withoutMiddleware(\App\Http\Middleware\Authenticate::class)
    ->withoutMiddleware(\App\Http\Middleware\CheckUserStatus::class);

Route::prefix('bmet')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [BMETController::class, 'index'])->name('bmet.index');
    Route::get('/create', [BMETController::class, 'create'])->name('bmet.create');
    Route::post('/', [BMETController::class, 'store'])->name('bmet.store');
    Route::get('/{id}', [BMETController::class, 'show'])->name('bmet.show');
    Route::get('/{id}/edit', [BMETController::class, 'edit'])->name('bmet.edit');
    Route::put('/{id}', [BMETController::class, 'update'])->name('bmet.update');
    Route::delete('/{id}', [BMETController::class, 'destroy'])->name('bmet.destroy');
    Route::get('/{id}/verify', [BMETController::class, 'verify'])->name('bmet.verify');
    Route::get('/file/{id}', [BMETController::class, 'serveFile'])->name('bmet.file');
    Route::get('/token/{token}', [BMETController::class, 'serveFileByToken'])->name('bmet.file.token');
});

Route::get('/bmet/check-storage/{id}', [BMETController::class, 'checkStorage'])
    ->name('bmet.check-storage')
    ->middleware('auth');

Route::prefix('bmet-update')->group(function () {
    Route::get('/', [App\Http\Controllers\BMETUpdateController::class, 'index'])->name('bmet-update.index');
    Route::get('/create', [App\Http\Controllers\BMETUpdateController::class, 'create'])->name('bmet-update.create');
    Route::post('/', [App\Http\Controllers\BMETUpdateController::class, 'store'])->name('bmet-update.store');
    Route::get('/{id}', [App\Http\Controllers\BMETUpdateController::class, 'show'])->name('bmet-update.show');
    Route::get('/{id}/edit', [App\Http\Controllers\BMETUpdateController::class, 'edit'])->name('bmet-update.edit');
    Route::put('/{id}', [App\Http\Controllers\BMETUpdateController::class, 'update'])->name('bmet-update.update');
    Route::delete('/{id}', [App\Http\Controllers\BMETUpdateController::class, 'destroy'])->name('bmet-update.destroy');
    Route::get('/check-storage/{id}', [App\Http\Controllers\BMETUpdateController::class, 'checkStorage'])->name('bmet-update.check-storage');
    Route::get('/verify/{id}', [App\Http\Controllers\BMETUpdateController::class, 'verify'])->name('bmet-update.verify');
    Route::get('/file/{id}', [App\Http\Controllers\BMETUpdateController::class, 'serveFile'])->name('bmet-update.serve-file');
    Route::get('/file/token/{token}', [App\Http\Controllers\BMETUpdateController::class, 'serveFileByToken'])->name('bmet-update.serve-file-by-token');
    Route::get('/bmet-clearance/{clearanceId}', [App\Http\Controllers\BMETUpdateController::class, 'showByClearanceId'])->name('bmet-update.show-by-clearance');
});

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('user/uttoradhikarsonod')->name('user.uttoradhikarsonod.')->group(function () {
        Route::get('/', [UttoradhikarSonodController::class, 'index'])->name('index');
        Route::get('/create', [UttoradhikarSonodController::class, 'create'])->name('create');
        Route::post('/', [UttoradhikarSonodController::class, 'store'])->name('store');
        Route::get('/{id}', [UttoradhikarSonodController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UttoradhikarSonodController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UttoradhikarSonodController::class, 'update'])->name('update');
    });
});

Route::get('/verify/uttoradhikar/{certificate_number}', [UttoradhikarSonodController::class, 'verify'])
    ->name('verify.uttoradhikar');

Route::get('/outgoing-ip', function () {
    return Http::get('https://api.ipify.org')->body();
});

Route::get('/test-proxy', function () {
    $response = Http::withOptions([
        'proxy' => 'http://113.160.132.26:8080',
        'verify' => false,
        'timeout' => 10,
    ])->get('https://httpbin.org/ip');

    return $response->json();
});
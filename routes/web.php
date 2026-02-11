<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocalLandingController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StorefrontController;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\DealerBulkOrder;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
Route::get('/about', [StorefrontController::class, 'about'])->name('about');
Route::get('/contact', [StorefrontController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:3,60')->name('contact.submit');
Route::get('/page/{slug}', [StorefrontController::class, 'page'])->name('page.show');

// Cart & Checkout
Route::get('/cart', CartPage::class)->name('cart');
Route::get('/checkout', CheckoutPage::class)->name('checkout');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,15');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,15');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Account Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AccountController::class, 'orderDetail'])->name('orders.show');
    Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password', [AccountController::class, 'updatePassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Dealer Routes
|--------------------------------------------------------------------------
*/

Route::get('/dealer/register', function () {
    return view('pages.dealer-register');
})->name('dealer.register');

Route::post('/dealer/register', [DealerController::class, 'register'])->middleware('throttle:3,60')->name('dealer.register.submit');

Route::middleware('auth')->group(function () {
    Route::get('/dealer/pending', [DealerController::class, 'pending'])->name('dealer.pending');
});

Route::middleware(['auth', 'dealer'])->prefix('dealer')->name('dealer.')->group(function () {
    Route::get('/dashboard', [DealerController::class, 'dashboard'])->name('dashboard');
    Route::get('/catalog', [DealerController::class, 'catalog'])->name('catalog');
    Route::get('/place-order', DealerBulkOrder::class)->name('place-order');
    Route::get('/orders', [DealerController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [DealerController::class, 'orderDetail'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [DealerController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::get('/profile', [DealerController::class, 'profile'])->name('profile');
    Route::put('/profile', [DealerController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/

Route::post('/payment/razorpay/{order}/callback', [PaymentController::class, 'razorpayCallback'])->name('payment.razorpay.callback');
Route::post('/payment/razorpay/webhook', [PaymentController::class, 'razorpayWebhook'])->name('payment.razorpay.webhook');
Route::post('/payment/phonepe/{order}/callback', [PaymentController::class, 'phonePeCallback'])->name('payment.phonepe.callback');
Route::post('/payment/phonepe/webhook', [PaymentController::class, 'phonePeWebhook'])->name('payment.phonepe.webhook');

Route::get('/order/{order}/success', [PaymentController::class, 'orderSuccess'])->name('order.success');
Route::get('/order/{order}/failed', [PaymentController::class, 'orderFailed'])->name('order.failed');

Route::middleware('auth')->group(function () {
    Route::get('/order/{order}/invoice', [AccountController::class, 'downloadInvoice'])->name('order.invoice');
});

/*
|--------------------------------------------------------------------------
| OTP Verification Routes
|--------------------------------------------------------------------------
*/

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/otp/send', [OtpController::class, 'send'])->name('otp.send');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
});

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| Local Landing Pages (SEO)
|--------------------------------------------------------------------------
*/

Route::get('/locations', [LocalLandingController::class, 'index'])->name('local.index');
Route::get('/locations/{district}', [LocalLandingController::class, 'show'])->name('local.show');
Route::get('/{productType}/{district}', [LocalLandingController::class, 'productType'])
    ->where('productType', 'cold-pressed-oil|groundnut-oil|sesame-oil|coconut-oil')
    ->name('local.product-type');

/*
|--------------------------------------------------------------------------
| Locale-Prefixed Routes (SEO)
|--------------------------------------------------------------------------
| Duplicate storefront routes under /ta/ prefix for Tamil SEO indexing.
| The SetLocale middleware detects the prefix and sets the locale.
*/

Route::prefix('{locale}')
    ->where(['locale' => 'en|ta'])
    ->group(function () {
        Route::get('/', [StorefrontController::class, 'home'])->name('locale.home');
        Route::get('/shop', [ShopController::class, 'index'])->name('locale.shop');
        Route::get('/product/{slug}', [ShopController::class, 'show'])->name('locale.product.show');
        Route::get('/about', [StorefrontController::class, 'about'])->name('locale.about');
        Route::get('/contact', [StorefrontController::class, 'contact'])->name('locale.contact');
        Route::get('/blog', [BlogController::class, 'index'])->name('locale.blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('locale.blog.show');
    });

/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

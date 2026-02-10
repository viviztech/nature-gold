<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealerController;
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
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
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
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
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

Route::post('/dealer/register', [DealerController::class, 'register'])->name('dealer.register.submit');

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

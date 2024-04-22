<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClearController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontpage\CartController;
use App\Http\Controllers\Frontpage\HomeController;
use App\Http\Controllers\Frontpage\MenuController;
use App\Http\Controllers\Frontpage\NewsController;
use App\Http\Controllers\Frontpage\BrandController;
use App\Http\Controllers\Frontpage\PagesController;
use App\Http\Controllers\Frontpage\SearchController;
use App\Http\Controllers\Frontpage\ProductController;
use App\Http\Controllers\Frontpage\ProfileController;
use App\Http\Controllers\Frontpage\CategoryController;
use App\Http\Controllers\Frontpage\CheckoutController;
use App\Http\Controllers\Frontpage\CustomerController;
use App\Http\Controllers\Frontpage\ContactUsController;
use App\Http\Controllers\Frontpage\FlashSaleController;
use App\Http\Controllers\Frontpage\APIRajaOngkirController;


Auth::routes();

// Multi Language
// Route::get('lang/home', 'LangController@index');
// Route::get('lang/change', 'LangController@change')->name('changeLang');

Route::get('/auth/redirect', [LoginController::class, 'redirectToProvider']);
Route::get('/auth/callback', [LoginController::class, 'handleProviderCallback']);


// Frontpage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/products-data', [HomeController::class, 'getProducts'])->name('products-data');
Route::post('/change-language', [HomeController::class, 'changeLanguage'])->name('change_language');
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}.html', [NewsController::class, 'detail'])->name('news_detail');
Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/catalogues', [ProductController::class, 'index'])->name('catalogues');
Route::post('/variant', [ProductController::class, 'addVariant'])->name('addVariant');
Route::get('/catalogues/{slug}.html', [ProductController::class, 'detail'])->name('catalogues.detail');
Route::post('/catalogues/detail', [ProductController::class, 'getDetail'])->name('catalogues.getDetail');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/load-cart-data', [CartController::class, 'cartLoadByAjax'])->name('load-cart-data');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('update-cart');
Route::delete('/delete-cart', [CartController::class, 'deleteCart'])->name('delete-cart');
Route::delete('/select-cart', [CartController::class, 'selectCart'])->name('select-cart');
Route::post('/catalogues/detail/variant', [ProductController::class, 'getDetailVariant'])->name('catalogues.getDetailVariant');
Route::get('/order-history', [CustomerController::class, 'orders'])->name('order_history');
Route::get('/order-history/{invoice_number}', [CustomerController::class, 'orderDetail'])->name('order_history_detail');
Route::put('/payment-confirmation/save', [CustomerController::class, 'paymentConfirmation'])->name('payment_confirmation');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout-order', [CheckoutController::class, 'order'])->name('checkout-order');
Route::post('/checkout-order', [CheckoutController::class, 'order'])->name('checkout-order');
Route::post('/checkout-order-item', [CheckoutController::class, 'orderItems'])->name('checkout-order-item');
Route::post('/handler', [CheckoutController::class, 'notification'])->name('notification');
Route::get('/payment-finish', [CheckoutController::class, 'payment_finish'])->name('payment_finish');
Route::post('/getServiceCourier', [CheckoutController::class, 'getServiceCourier'])->name('getServiceCourier');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/address', [ProfileController::class, 'address'])->name('address');
Route::get('/address-create', [ProfileController::class, 'createAddress'])->name('create-address');
Route::post('/save-profile', [ProfileController::class, 'saveProfile'])->name('save-profile');
Route::post('/save-address', [ProfileController::class, 'saveAddress'])->name('save-address');
Route::post('/address', [ProfileController::class, 'editAddress'])->name('address');
Route::delete('/address', [ProfileController::class, 'deleteAddress'])->name('address');

Route::prefix('pages')->group(function () {
    Route::get('/{slug}.html', [PagesController::class, 'index'])->name('pages_detail');
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category');
    Route::get('/{slug}', [CategoryController::class, 'categoryDetail'])->name('category_detail');
});

Route::prefix('brand')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brand');
    Route::get('/{slug}', [BrandController::class, 'brandDetail'])->name('brand_detail');
});

Route::prefix('clear')->group(function () {
    Route::get('/all', [ClearController::class, 'clearOptimize'])->name('clear.all');
    Route::get('/config', [ClearController::class, 'clearConfig'])->name('clear.config');
    Route::get('/cache', [ClearController::class, 'clearCache'])->name('clear.cache');
    Route::get('/migrate', [ClearController::class, 'migrate'])->name('migrate');
    Route::get('/fresh', [ClearController::class, 'migrateFresh'])->name('migrate.fresh');
    Route::get('/seeder', [ClearController::class, 'seeder'])->name('seeder');
    Route::get('/cart', [CartController::class, 'clearCart'])->name('clear_cart');
    Route::get('/storage', [ClearController::class, 'storageLink'])->name('storage');
    Route::get('/seed-permission', [ClearController::class, 'seedPermissions'])->name('seedPermissions');
});

Route::post('get-ongkir', [APIRajaOngkirController::class, 'getOngkir'])->name('get-ongkir');
Route::get('get-province', [APIRajaOngkirController::class, 'getProvince'])->name('province');
Route::post('get-cities', [APIRajaOngkirController::class, 'getCities'])->name('getCities');
Route::post('get-districts', [APIRajaOngkirController::class, 'getKecamatan'])->name('getKecamatan');
Route::post('get-waybill', [APIRajaOngkirController::class, 'getWaybill'])->name('getWaybill');

Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::post('/contact-us', [ContactUsController::class, 'contactSave'])->name('contact-save');
Route::get('/redirect', [ContactUsController::class, 'redirect'])->name('redirect');

Route::get('refresh-csrf', function(){
    return csrf_token();
});
// WISHLIST
Route::post('/wishlist', [ProductController::class, 'addToWishList'])->name('catalogues.wishlist');
Route::get('/wishlist', [ProfileController::class, 'wishList'])->name('wishlist');
Route::get('/count-wishlist', [ProfileController::class, 'countWishlist'])->name('count-wishlist');
Route::get('/delete-wishlist/{id}', [ProfileController::class, 'deleteWishList'])->name('delete.wishlist');

// SEARCH
Route::get('/search', [SearchController::class, 'index'])->name('search');


// MENU
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::post('trackings', [APIBiteShipController::class, 'trackings']);
Route::get('/test-email', [HomeController::class, 'testEmail']);
Route::get('/test-email-customer', [CheckoutController::class, 'testEmailCustomer']);
Route::get('update-status-failed',[CheckoutController::class, 'updateStatusFailed'])->name('update-status-failed');
Route::post('/handler-order', [APIBiteShipController::class, 'orderHandler'])->name('order-status');
Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale');
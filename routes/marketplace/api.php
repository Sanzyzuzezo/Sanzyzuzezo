<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\AbsenController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckOutController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\PromotionsController;
use App\Http\Controllers\API\CashRegisterController;
use App\Http\Controllers\API\CustomerGroupController;
use App\Http\Controllers\API\PaymentMethodController;
use App\Http\Controllers\API\ProductDetailController;
use App\Http\Controllers\API\AuthMarketPlaceController;
use App\Http\Controllers\API\OrderTransactionController;
use App\Http\Controllers\API\PagesController;
use App\Http\Controllers\API\ArticlesController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\StoreController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthMarketPlaceController::class, 'login']);

Route::post('/auth/password/send-mail', [AuthMarketPlaceController::class, 'mailResetPassword']);
Route::put('/auth/password/reset', [AuthMarketPlaceController::class, 'resetPassword']);

Route::get('/auth/google', [AuthMarketPlaceController::class, 'redirectToGoogle']);
Route::post('/auth/google/callback', [AuthMarketPlaceController::class, 'handleGoogleCallback']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum', 'api.marketplace']], function () {
    //User
    Route::post('/logout', [AuthController::class, 'logout']);

    //Wishlist
    Route::post('/wishlist', [ProductController::class, 'addToWishList']);
    Route::get('/wishlist',[ProfileController::class,'wishlist']);
    Route::get('/count-wishlist', [ProfileController::class, 'countWishlist']);
    Route::delete('/delete-wishlist/{id}', [ProfileController::class, 'deleteWishList']);

    //Transaction
    Route::get('/order-history', [CustomerController::class, 'orders']);
    Route::get('/order-history/count', [CustomerController::class, 'orderTotal']);
    Route::get('/order-history/{invoice_number}', [CustomerController::class, 'orderDetail']);

    //Profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/save', [ProfileController::class, 'saveProfile']);

    //Address
    Route::get('/list-address', [ProfileController::class, 'listAddress']);
    Route::get('/address-provinces', [ProfileController::class, 'provinces']);
    Route::get('/address-cities', [ProfileController::class, 'cities']);
    Route::get('/address-districts', [ProfileController::class, 'districts']);
    Route::get('/address/{id}', [ProfileController::class, 'address']);
    Route::post('/address', [ProfileController::class, 'saveAddress']);
    Route::put('/address', [ProfileController::class, 'saveAddress']);
    Route::delete('/address/{id}', [ProfileController::class, 'deleteAddress']);
    Route::put('/setAddressDefault', [ProfileController::class, 'setAddressDefault']);

    //Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::get('/load-cart-data', [CartController::class, 'cartLoadByAjax'])->name('load-cart-data');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('update-cart');
    Route::delete('/delete-cart/{id}', [CartController::class, 'deleteCart'])->name('delete-cart');

    //Transaksi
    Route::post('/checkout', [CheckOutController::class, 'create_order_marketplace']);
    Route::post('/payment/save/{id}', [PaymentController::class, 'create_payment_marketplace']);
    Route::put('/payment/update/{id}', [PaymentController::class, 'update_payment_marketplace']);
    Route::get('/order-transaction/list', [OrderTransactionController::class, 'order_list_marketplace']);
    Route::put('/order-transaction/edit/{id}', [OrderTransactionController::class, 'order_update_marketplace']);
    Route::get('/order-transaction/{id}', [OrderTransactionController::class, 'order_detail_marketplace']);
    
});

    //guest

    //Category
    Route::get('/category/index', [CategoryController::class, 'index'])->name('category');
    Route::get('/category/{id}', [CategoryController::class, 'categoryDetail'])->name('category_detail');

    //Products
    Route::get('/products', [ProductController::class, 'products'])->name('products');
    Route::get('/products/{id}', [ProductController::class, 'productDetails'])->name('product_details');
    Route::get('/new-products', [ProductController::class, 'newProducts'])->name('new_products');
    Route::get('/hot-products', [ProductController::class, 'hotProducts'])->name('hot_products');

    //Promotions
    Route::get('/promotions/flash-sale', [PromotionsController::class, 'flashSale'])->name('flash_sale');
    Route::get('/promotions/reguler', [PromotionsController::class, 'reguler'])->name('reguler');
    Route::get('/list-promos/flash-sale', [PromotionsController::class, 'ListPromosflashSale'])->name('flash_sale_list_promos');
    Route::get('/list-promos/reguler', [PromotionsController::class, 'ListPromosReguler'])->name('reguler_list_promos');
    Route::get('/promo-details/flash-sale/{id}', [PromotionsController::class, 'flashSalePromoDetails'])->name('flash_sale_promo_details');
    Route::get('/promo-details/reguler/{id}', [PromotionsController::class, 'regulerPromoDetails'])->name('reguler_promo_details');

    //Company
    Route::get('/company', [CompanyController::class, 'company'])->name('company');
    Route::get('/setting-company', [SettingsController::class, 'company']);

    //Pages
    Route::get('/pages', [PagesController::class, 'index'])->name('pages');

    //Articles
    Route::get('/article-categories', [ArticlesController::class, 'articleCategories'])->name('article_categories');
    Route::get('/articles', [ArticlesController::class, 'articles'])->name('articles');

    //Brands
    Route::get('/brands', [BrandController::class, 'brands'])->name('brands');
    Route::get('/brand-details/{id}', [BrandController::class, 'brandDetails'])->name('brand_details');

    //Banner
    Route::get('/banners', [BannerController::class, 'banners'])->name('banners');

    //Store
    Route::get('/stores', [StoreController::class, 'stores'])->name('stores');

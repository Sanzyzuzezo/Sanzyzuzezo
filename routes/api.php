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
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\PromotionsController;
use App\Http\Controllers\API\CashRegisterController;
use App\Http\Controllers\API\CustomerGroupController;
use App\Http\Controllers\API\PaymentMethodController;
use App\Http\Controllers\API\ProductDetailController;
use App\Http\Controllers\API\AuthMarketPlaceController;
use App\Http\Controllers\API\OrderTransactionController;

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

//Protecting Routes
Route::prefix('pos')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //User
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'index']);
        
        Route::get('/category', [CategoryController::class, 'category']);
        Route::get('/customer', [CustomerController::class, 'customer']);
        Route::post('/customer-save', [CustomerController::class, 'create_customer']);
        Route::get('/customer-group', [CustomerGroupController::class, 'customer_group']);
        Route::post('/product', [ProductController::class, 'product']);
        Route::get('/order/{id}', [OrderItemController::class, 'orderItem']);
        Route::post('/order/{id}/print-bill', [OrderController::class, 'print_bill']);
        Route::post('/order/invoice', [OrderController::class, 'create_invoice_number']);
        Route::post('/order/add', [OrderItemController::class, 'addOrderItem']);
        Route::patch('/order/{id}/edit', [OrderItemController::class, 'updateOrderItem']);
        Route::delete('/order/{id}/delete', [OrderItemController::class, 'deleteOrderItem']);

        Route::post('/checkout', [CheckOutController::class, 'create_order']);
        Route::post('/payment/save/{id}', [PaymentController::class, 'create_payment']);
        Route::put('/payment/update/{id}', [PaymentController::class, 'update_payment']);
        Route::get('/order-transaction/list', [OrderTransactionController::class, 'order_list']);
        Route::put('/order-transaction/edit/{id}', [OrderTransactionController::class, 'order_update']);
        Route::put('/order-transaction/void/{id}', [OrderTransactionController::class, 'order_void']);
        Route::get('/order-transaction/{id}', [OrderTransactionController::class, 'order_detail']);
        
        Route::get('/category', [CategoryController::class, 'category']);
        
        Route::get('/product', [ProductController::class, 'product']);
        Route::get('/product/{id}', [ProductController::class, 'product_detail']);
        
        Route::get('/payment-method', [PaymentMethodController::class, 'payment_method']);
        
        Route::get('/cash-register/{id}', [CashRegisterController::class, 'cash_register']);
        Route::post('/open-register', [CashRegisterController::class, 'open_register']);
        Route::post('/close-register/{id}', [CashRegisterController::class, 'close_register']);
        // absensi
        Route::post('/absen-masuk',[AbsenController::class,'absen_masuk']);
        Route::put('/absen-keluar',[AbsenController::class,'absen_keluar']);
        Route::get('/list-absen', [Absencontroller::class, 'listAbsen']);
        Route::post('/pengajuan-absen', [AbsenController::class, 'pengajuanAbsen']);
        
    });
});


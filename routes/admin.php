<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AbsenController;
use App\Http\Controllers\Administrator\AuthController;
use App\Http\Controllers\Administrator\BuysController;
use App\Http\Controllers\Administrator\NewsController;
use App\Http\Controllers\Administrator\ItemsController;
use App\Http\Controllers\Administrator\PagesController;
use App\Http\Controllers\Administrator\SalesController;
use App\Http\Controllers\Administrator\StoreController;
use App\Http\Controllers\Administrator\UnitsController;
use App\Http\Controllers\Administrator\UsersController;
use App\Http\Controllers\Administrator\BrandsController;
use App\Http\Controllers\Administrator\OrdersController;
use App\Http\Controllers\Administrator\SystemController;
use App\Http\Controllers\Administrator\BannersController;
use App\Http\Controllers\Administrator\CompanyController;
use App\Http\Controllers\Administrator\PaymentsController;
use App\Http\Controllers\Administrator\ProduksiController;
use App\Http\Controllers\Administrator\SettingsController;
use App\Http\Controllers\Administrator\SupplierController;
use App\Http\Controllers\Administrator\VisitorsController;
use App\Http\Controllers\Administrator\AdjusmentController;
use App\Http\Controllers\Administrator\CustomersController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\StockCardController;
use App\Http\Controllers\Administrator\CategoriesController;
use App\Http\Controllers\Administrator\ItemGroupsController;
use App\Http\Controllers\Administrator\UserAdminsController;
use App\Http\Controllers\Administrator\UserGroupsController;
use App\Http\Controllers\Administrator\WarehousesController;
use App\Http\Controllers\Administrator\IngredientsController;
use App\Http\Controllers\Administrator\PermissionsController;
use App\Http\Controllers\Administrator\AccurateSyncController;
use App\Http\Controllers\Administrator\DeliveryNoteController;
use App\Http\Controllers\Administrator\InvoiceSalesController;
use App\Http\Controllers\Administrator\AccurateTokenController;
use App\Http\Controllers\Administrator\CustomerGroupController;
use App\Http\Controllers\Administrator\HumanResourceController;
use App\Http\Controllers\Administrator\PromoProductsController;
use App\Http\Controllers\Administrator\MenuManagementController;
use App\Http\Controllers\Administrator\NewsCategoriesController;
use App\Http\Controllers\Administrator\SettingsCompanyController;
use App\Http\Controllers\Administrator\UnitConversionsController;


Route::get('login', [AuthController::class, 'index'])->name('admin.login');
Route::post('login/isExistEmail', [AuthController::class, 'isExistEmail'])->name('admin.login.isExistEmail');
Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => 'auth:admin'], function () {


    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('dashboard/getReport', [DashboardController::class, 'getReportBuying'])->name('admin.dashboard.getReportBuying');
    Route::get('dashboard/getChart', [DashboardController::class, 'getChartBuying'])->name('admin.dashboard.getChartBuying');
    

    Route::get('categories', [CategoriesController::class, 'index'])->name('admin.categories');
    Route::get('categories-data', [CategoriesController::class, 'getData'])->name('admin.categories.getData');
    Route::get('categories/add', [CategoriesController::class, 'add'])->name('admin.categories.add');
    Route::post('categories/save', [CategoriesController::class, 'save'])->name('admin.categories.save');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::get('categories/detail/{id}', [CategoriesController::class, 'detail'])->name('admin.categories.detail');
    Route::put('categories/update', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/delete', [CategoriesController::class, 'delete'])->name('admin.categories.delete');
    Route::post('categories/change-status', [CategoriesController::class, 'changeStatus'])->name('admin.categories.changeStatus');

    // Route::get('products',[ProductsController::class, 'index'])->name('admin.products');
    // Route::get('products-data', [ProductsController::class, 'getData'])->name('admin.products.getData');
    // Route::get('products/add',[ProductsController::class, 'add'])->name('admin.products.add');
    // Route::post('products/save',[ProductsController::class, 'save'])->name('admin.products.save');
    // Route::get('products/edit/{id}',[ProductsController::class, 'edit'])->name('admin.products.edit');
    // Route::put('products/update',[ProductsController::class, 'update'])->name('admin.products.update');
    // Route::get('products/duplicate/{id}',[ProductsController::class, 'duplicate'])->name('admin.products.duplicate');
    // Route::post('products/duplicate',[ProductsController::class, 'doDuplicate'])->name('admin.products.doduplicate');
    // Route::delete('products/delete',[ProductsController::class, 'delete'])->name('admin.products.delete');
    // Route::get('products/import',[ProductsController::class, 'import'])->name('admin.products.import');
    // Route::post('products/import',[ProductsController::class, 'doImport'])->name('admin.products.doimport');
    // Route::get('products/detail/{id}',[ProductsController::class, 'detail'])->name('admin.products.detail');
    // Route::post('products/change-status',[ProductsController::class, 'changeStatus'])->name('admin.products.changeStatus');
    // Route::post('products-data/detail',[ProductsController::class, 'getDetail'])->name('admin.products.getDetail');
    // Route::post('products/update-stock',[ProductsController::class, 'updateStock'])->name('admin.products.updateStock');
    // Route::get('products/download-format',[ProductsController::class, 'downloadFormat'])->name('admin.products.downloadFormat');

    Route::get('items', [ItemsController::class, 'index'])->name('admin.items');
    Route::get('items-data', [ItemsController::class, 'getData'])->name('admin.items.getData');
    Route::get('items/add', [ItemsController::class, 'add'])->name('admin.items.add');
    Route::post('items/save', [ItemsController::class, 'save'])->name('admin.items.save');
    Route::get('items/edit/{id}', [ItemsController::class, 'edit'])->name('admin.items.edit');
    Route::put('items/update', [ItemsController::class, 'update'])->name('admin.items.update');
    Route::get('items/duplicate/{id}', [ItemsController::class, 'duplicate'])->name('admin.items.duplicate');
    Route::post('items/duplicate', [ItemsController::class, 'doDuplicate'])->name('admin.items.doduplicate');
    Route::delete('items/delete', [ItemsController::class, 'delete'])->name('admin.items.delete');
    Route::get('items/import', [ItemsController::class, 'import'])->name('admin.items.import');
    Route::post('items/import', [ItemsController::class, 'doImport'])->name('admin.items.doimport');
    Route::get('items/detail/{id}', [ItemsController::class, 'detail'])->name('admin.items.detail');
    Route::post('items/change-status', [ItemsController::class, 'changeStatus'])->name('admin.items.changeStatus');
    Route::post('items-data/detail', [ItemsController::class, 'getDetail'])->name('admin.items.getDetail');
    Route::post('items/update-stock', [ItemsController::class, 'updateStock'])->name('admin.items.updateStock');
    Route::get('items/download-format', [ItemsController::class, 'downloadFormat'])->name('admin.items.downloadFormat');

    Route::get('brands', [BrandsController::class, 'index'])->name('admin.brands');
    Route::get('brands-data', [BrandsController::class, 'getData'])->name('admin.brands.getData');
    Route::get('brands/add', [BrandsController::class, 'add'])->name('admin.brands.add');
    Route::post('brands/insert', [BrandsController::class, 'insert'])->name('admin.brands.insert');
    Route::get('brands/edit/{id}', [BrandsController::class, 'edit'])->name('admin.brands.edit');
    Route::put('brands/update/{id}', [BrandsController::class, 'update'])->name('admin.brands.update');
    Route::delete('brands/delete', [BrandsController::class, 'delete'])->name('admin.brands.delete');

    Route::get('customer_group', [CustomerGroupController::class, 'index'])->name('admin.customer_group');
    Route::get('customer_group-data', [CustomerGroupController::class, 'getData']);
    Route::get('customer_group/add', [CustomerGroupController::class, 'add'])->name('admin.customer_group.add');
    Route::post('customer_group/insert', [CustomerGroupController::class, 'insert'])->name('admin.customer_group.insert');
    Route::get('customer_group/detail/{id}', [CustomerGroupController::class, 'detail'])->name('admin.customer_group.detail');
    Route::post('customer_group/insert/categories', [CustomerGroupController::class, 'categories'])->name('admin.customer_group.categories');
    Route::get('customer_group/edit/{id}', [CustomerGroupController::class, 'edit'])->name('admin.customer_group.edit');
    Route::put('customer_group/update/{id}', [CustomerGroupController::class, 'update'])->name('admin.customer_group.update');
    Route::delete('customer_group/delete', [CustomerGroupController::class, 'delete'])->name('admin.customer_group.delete');

    Route::get('customers', [CustomersController::class, 'index'])->name('admin.customers');
    Route::get('customers-data', [CustomersController::class, 'getData'])->name('admin.customers.getData');
    Route::get('customers/add', [CustomersController::class, 'add'])->name('admin.customers.add');
    Route::post('customers/insert', [CustomersController::class, 'insert'])->name('admin.customers.insert');
    Route::get('customers/detail/{id}', [CustomersController::class, 'detail'])->name('admin.customers.detail');
    Route::get('customers/edit/{id}', [CustomersController::class, 'edit'])->name('admin.customers.edit');
    Route::put('customers/update/{id}', [CustomersController::class, 'update'])->name('admin.customers.update');
    Route::delete('customers/delete', [CustomersController::class, 'delete'])->name('admin.customers.delete');

    Route::prefix('menu-management')->group(function () {

        Route::get('/', [MenuManagementController::class, 'index'])->name('menu-management.index');
        Route::get('/get-data', [MenuManagementController::class, 'getData'])->name('menu-management.getData');
        Route::get('/add', [MenuManagementController::class, 'create'])->name('menu-management.add');
        Route::get('/detail', [MenuManagementController::class, 'show'])->name('menu-management.detail');
        Route::get('/edit/{id}', [MenuManagementController::class, 'edit'])->name('menu-management.edit');
        Route::post('/insert', [MenuManagementController::class, 'store'])->name('menu-management.insert');
        Route::put('/update/{id}', [MenuManagementController::class, 'update'])->name('menu-management.update');
        Route::delete('/delete', [MenuManagementController::class, 'destroy'])->name('menu-management.delete');
    });

    Route::get('pages', [PagesController::class, 'index'])->name('admin.pages');
    Route::get('pages-data', [PagesController::class, 'getData'])->name('admin.pages.getData');
    Route::get('pages/add', [PagesController::class, 'add'])->name('admin.pages.add');
    Route::post('pages/insert', [PagesController::class, 'insert'])->name('admin.pages.insert');
    Route::get('pages/detail/{id}', [PagesController::class, 'detail'])->name('admin.pages.detail');
    Route::get('pages/edit/{id}', [PagesController::class, 'edit'])->name('admin.pages.edit');
    Route::put('pages/update/{id}', [PagesController::class, 'update'])->name('admin.pages.update');
    Route::delete('pages/delete', [PagesController::class, 'delete'])->name('admin.pages.delete');

    Route::get('visitors', [VisitorsController::class, 'index'])->name('admin.visitors');
    Route::get('visitors-data', [VisitorsController::class, 'getData'])->name('admin.visitors.getData');
    Route::delete('visitors/delete', [VisitorsController::class, 'delete'])->name('admin.visitors.delete');

    Route::get('setting-smtp', [SettingsController::class, 'smtp'])->name('admin.settings.smtp');
    Route::put('setting-smtp', [SettingsController::class, 'updateSMTP'])->name('admin.settings.updateSMTP');
    Route::get('setting-general', [SettingsController::class, 'general'])->name('admin.settings.general');
    Route::put('setting-general', [SettingsController::class, 'updateGeneral'])->name('admin.settings.updateGeneral');

    Route::get('orders', [OrdersController::class, 'index'])->name('admin.orders');
    Route::get('orders-data', [OrdersController::class, 'getData']);
    Route::get('store-data', [OrdersController::class, 'getStoreData']);
    Route::get('product-data', [OrdersController::class, 'getProductData']);
    Route::get('orders/detail/{id}', [OrdersController::class, 'detail'])->name('admin.orders.detail');
    Route::put('orders/update-status', [OrdersController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::put('orders/payment-confirm', [OrdersController::class, 'paymentConfirmation'])->name('admin.order.confirm_payment');
    Route::get('orders/export', [OrdersController::class, 'export'])->name('admin.order.export');

    Route::get('user-groups', [UserGroupsController::class, 'index'])->name('admin.user_groups');
    Route::get('user-groups-data', [UserGroupsController::class, 'getData'])->name('admin.user_groups.getData');
    Route::get('user-groups/add', [UserGroupsController::class, 'add'])->name('admin.user_groups.add');
    Route::post('user-groups/save', [UserGroupsController::class, 'save'])->name('admin.user_groups.save');
    Route::get('user-groups/edit/{id}', [UserGroupsController::class, 'edit'])->name('admin.user_groups.edit');
    Route::get('user-groups/detail/{id}', [UserGroupsController::class, 'detail'])->name('admin.user_groups.detail');
    Route::put('user-groups/update', [UserGroupsController::class, 'update'])->name('admin.user_groups.update');
    Route::delete('user-groups/delete', [UserGroupsController::class, 'delete'])->name('admin.user_groups.delete');
    Route::post('user-groups/change-status', [UserGroupsController::class, 'changeStatus'])->name('admin.user_groups.changeStatus');

    Route::get('users', [UsersController::class, 'index'])->name('admin.users');
    Route::get('users-data', [UsersController::class, 'getData'])->name('admin.users.getData');
    Route::get('users/add', [UsersController::class, 'add'])->name('admin.users.add');
    Route::post('users/save', [UsersController::class, 'save'])->name('admin.users.save');
    Route::get('users/edit/{id}', [UsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('users/detail/{id}', [UsersController::class, 'detail'])->name('admin.users.detail');
    Route::put('users/update', [UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('users/delete', [UsersController::class, 'delete'])->name('admin.users.delete');
    Route::post('users/change-status', [UsersController::class, 'changeStatus'])->name('admin.users.changeStatus');
    Route::get('users/store-data', [UsersController::class, 'getStoreData'])->name('admin.users.store-data');
    Route::get('users/warehouse-data', [UsersController::class, 'getWarehouseData'])->name('admin.users.warehouse-data');
    Route::post('users/isExistEmail', [UsersController::class, 'isExistEmail'])->name('admin.users.isExistEmail');

    Route::get('user-admins-dashboard', [UserAdminsController::class, 'dashboard'])->name('admin.user-admins-dashboard');
    Route::get('user-admins', [UserAdminsController::class, 'index'])->name('admin.user-admins');
    Route::get('user-admins-data', [UserAdminsController::class, 'getData'])->name('admin.user-admins.getData');
    Route::get('user-admins/add', [UserAdminsController::class, 'add'])->name('admin.user-admins.add');
    Route::post('user-admins/save', [UserAdminsController::class, 'save'])->name('admin.user-admins.save');
    Route::get('user-admins/edit/{id}', [UserAdminsController::class, 'edit'])->name('admin.user-admins.edit');
    Route::get('user-admins/detail/{id}', [UserAdminsController::class, 'detail'])->name('admin.user-admins.detail');
    Route::put('user-admins/update', [UserAdminsController::class, 'update'])->name('admin.user-admins.update');
    Route::delete('user-admins/delete', [UserAdminsController::class, 'delete'])->name('admin.user-admins.delete');
    Route::post('user-admins/change-status', [UserAdminsController::class, 'changeStatus'])->name('admin.user-admins.changeStatus');
    Route::get('user-admins/store-data', [UserAdminsController::class, 'getStoreData'])->name('admin.user-admins.store-data');
    Route::get('user-admins/warehouse-data', [UserAdminsController::class, 'getWarehouseData'])->name('admin.user-admins.warehouse-data');
    Route::post('user-admins/isExistEmail', [UserAdminsController::class, 'isExistEmail'])->name('admin.user-admins.isExistEmail');

    Route::get('logs', [SystemController::class, 'index'])->name('admin.logs');
    Route::get('logs-data', [SystemController::class, 'getData'])->name('admin.logs.getData');

    Route::get('permissions', [PermissionsController::class, 'index'])->name('admin.permissions');
    Route::get('permissions-data', [PermissionsController::class, 'getData'])->name('admin.permissions.getData');
    Route::get('permissions/add', [PermissionsController::class, 'add'])->name('admin.permissions.add');
    Route::post('permissions/save', [PermissionsController::class, 'save'])->name('admin.permissions.save');
    Route::get('permissions/edit/{id}', [PermissionsController::class, 'edit'])->name('admin.permissions.edit');
    Route::get('permissions/detail/{id}', [PermissionsController::class, 'detail'])->name('admin.permissions.detail');
    Route::put('permissions/update', [PermissionsController::class, 'update'])->name('admin.permissions.update');
    Route::delete('permissions/delete', [PermissionsController::class, 'delete'])->name('admin.permissions.delete');

    Route::get('banners', [BannersController::class, 'index'])->name('admin.banners');
    Route::get('banners-data', [BannersController::class, 'getData'])->name('admin.banners.getData');
    Route::get('banners/add', [BannersController::class, 'add'])->name('admin.banners.add');
    Route::post('banners/insert', [BannersController::class, 'insert'])->name('admin.banners.insert');
    Route::get('banners/detail/{id}', [BannersController::class, 'detail'])->name('admin.banners.detail');
    Route::get('banners/edit/{id}', [BannersController::class, 'edit'])->name('admin.banners.edit');
    Route::put('banners/update/{id}', [BannersController::class, 'update'])->name('admin.banners.update');
    Route::delete('banners/delete', [BannersController::class, 'delete'])->name('admin.banners.delete');

    //
    Route::get('article-categories', [NewsCategoriesController::class, 'index'])->name('admin.article_categories');
    Route::get('article-categories-data', [NewsCategoriesController::class, 'getData'])->name('admin.article_categories.getData');
    Route::get('article-categories/add', [NewsCategoriesController::class, 'add'])->name('admin.article_categories.add');
    Route::post('article-categories/save', [NewsCategoriesController::class, 'save'])->name('admin.article_categories.save');
    Route::get('article-categories/edit/{id}', [NewsCategoriesController::class, 'edit'])->name('admin.article_categories.edit');
    Route::get('article-categories/detail/{id}', [NewsCategoriesController::class, 'detail'])->name('admin.article_categories.detail');
    Route::put('article-categories/update', [NewsCategoriesController::class, 'update'])->name('admin.article_categories.update');
    Route::delete('article-categories/delete', [NewsCategoriesController::class, 'delete'])->name('admin.article_categories.delete');
    Route::post('article-categories/change-status', [NewsCategoriesController::class, 'changeStatus'])->name('admin.article_categories.changeStatus');

    Route::get('article', [NewsController::class, 'index'])->name('admin.article');
    Route::get('article-data', [NewsController::class, 'getData'])->name('admin.article.getData');
    Route::get('article/add', [NewsController::class, 'add'])->name('admin.article.add');
    Route::post('article/save', [NewsController::class, 'save'])->name('admin.articStoreControllerle.save');
    Route::get('article/edit/{id}', [NewsController::class, 'edit'])->name('admin.article.edit');
    Route::get('article/detail/{id}', [NewsController::class, 'detail'])->name('admin.article.detail');
    Route::put('article/update', [NewsController::class, 'update'])->name('admin.article.update');
    Route::delete('article/delete', [NewsController::class, 'delete'])->name('admin.article.delete');
    Route::post('article/change-status', [NewsController::class, 'changeStatus'])->name('admin.article.changeStatus');
    //

    Route::get('bank-accounts', [PaymentsController::class, 'indexBankAccounts'])->name('admin.bank_accounts');
    Route::get('bank-accounts-data', [PaymentsController::class, 'getDataBankAccounts'])->name('admin.bank_accounts.getData');
    Route::get('bank-accounts/add', [PaymentsController::class, 'addBankAccounts'])->name('admin.bank_accounts.add');
    Route::post('bank-accounts/save', [PaymentsController::class, 'saveBankAccounts'])->name('admin.bank_accounts.save');
    Route::get('bank-accounts/edit/{id}', [PaymentsController::class, 'editBankAccounts'])->name('admin.bank_accounts.edit');
    Route::get('bank-accounts/detail/{id}', [PaymentsController::class, 'detailBankAccounts'])->name('admin.bank_accounts.detail');
    Route::put('bank-accounts/update', [PaymentsController::class, 'updateBankAccounts'])->name('admin.bank_accounts.update');
    Route::delete('bank-accounts/delete', [PaymentsController::class, 'deleteBankAccounts'])->name('admin.bank_accounts.delete');
    Route::post('bank-accounts/change-status', [PaymentsController::class, 'changeStatusBankAccounts'])->name('admin.bank_accounts.changeStatus');

    Route::get('stores', [StoreController::class, 'index'])->name('admin.store');
    Route::get('stores-data', [StoreController::class, 'getData'])->name('admin.store.getData');
    Route::get('stores/add', [StoreController::class, 'add'])->name('admin.store.add');
    Route::post('store/insert', [StoreController::class, 'insert'])->name('admin.store.save');
    Route::get('store/detail/{id}',[StoreController::class, 'detail'])->name('admin.store.detail');
    Route::get('stores/edit/{id}', [StoreController::class, 'edit'])->name('admin.store.edit');
    Route::put('stores/update/{id}', [StoreController::class, 'update'])->name('admin.store.update');
    Route::delete('store/delete', [StoreController::class, 'delete'])->name('admin.store.delete');
    Route::delete('store/deleteDetail',[StoreController::class, 'deleteDetail'])->name('admin.store.deleteDetail');
    Route::get('stores/item-data', [StoreController::class, 'getItemData'])->name('admin.store.item-data');

    // Master Data Warehouse

    Route::get('item_groups', [ItemGroupsController::class, 'index'])->name('admin.item_groups');
    Route::get('item_groups-data', [ItemGroupsController::class, 'getData']);
    Route::get('item_groups/add', [ItemGroupsController::class, 'add'])->name('admin.item_groups.add');
    Route::post('item_groups/insert', [ItemGroupsController::class, 'insert'])->name('admin.item_groups.insert');
    Route::get('item_groups/edit/{id}', [ItemGroupsController::class, 'edit'])->name('admin.item_groups.edit');
    Route::put('item_groups/update/{id}', [ItemGroupsController::class, 'update'])->name('admin.item_groups.update');
    Route::delete('item_groups/delete', [ItemGroupsController::class, 'delete'])->name('admin.item_groups.delete');

    Route::get('units', [UnitsController::class, 'index'])->name('admin.units');
    Route::get('units-data', [UnitsController::class, 'getData']);
    Route::get('units/add', [UnitsController::class, 'add'])->name('admin.units.add');
    Route::post('units/insert', [UnitsController::class, 'insert'])->name('admin.units.insert');
    Route::get('units/edit/{id}', [UnitsController::class, 'edit'])->name('admin.units.edit');
    Route::put('units/update/{id}', [UnitsController::class, 'update'])->name('admin.units.update');
    Route::delete('units/delete', [UnitsController::class, 'delete'])->name('admin.units.delete');

    Route::get('warehouse', [WarehousesController::class, 'index'])->name('admin.warehouse');
    Route::get('warehouse-data', [WarehousesController::class, 'getData']);
    Route::get('warehouse/add', [WarehousesController::class, 'add'])->name('admin.warehouse.add');
    Route::post('warehouse/insert', [WarehousesController::class, 'insert'])->name('admin.warehouse.insert');
    Route::get('warehouse/edit/{id}', [WarehousesController::class, 'edit'])->name('admin.warehouse.edit');
    Route::put('warehouse/update/{id}', [WarehousesController::class, 'update'])->name('admin.warehouse.update');
    Route::delete('warehouse/delete', [WarehousesController::class, 'delete'])->name('admin.warehouse.delete');
    Route::get('warehouse/detail', [WarehousesController::class, 'detail'])->name('admin.warehouse.detail');
    Route::get('warehouse-data-detail', [WarehousesController::class, 'getDataDetail'])->name('admin.warehouse.getDataDetail');
    
    Route::get('unit_conversions', [UnitConversionsController::class, 'index'])->name('admin.unit_conversions');
    Route::get('unit_conversions-data', [UnitConversionsController::class, 'getData'])->name('admin.unit_conversions.getData');
    Route::get('unit_conversions/add', [UnitConversionsController::class, 'add'])->name('admin.unit_conversions.add');
    Route::post('unit_conversions/insert', [UnitConversionsController::class, 'save'])->name('admin.unit_conversions.save');
    Route::get('unit_conversions/edit/{id}', [UnitConversionsController::class, 'edit'])->name('admin.unit_conversions.edit');
    Route::put('unit_conversions/update', [UnitConversionsController::class, 'update'])->name('admin.unit_conversions.update');
    Route::delete('unit_conversions/delete', [UnitConversionsController::class, 'delete'])->name('admin.unit_conversions.delete');
    Route::get('unit_conversions/unit-data', [UnitConversionsController::class, 'getUnitData']);
    Route::get('unit_conversions/variant-data', [UnitConversionsController::class, 'getVariantData'])->name('admin.unit_conversions.variant-data');
    Route::get('unit_conversions/item-data-select', [UnitConversionsController::class, 'getItemDataSelect'])->name('admin.unit_conversions.item-data-select');

    Route::get('ingredients', [IngredientsController::class, 'index'])->name('admin.ingredients');
    Route::get('ingredients-data', [IngredientsController::class, 'getData'])->name('admin.ingredients.getData');
    Route::get('ingredients/add', [IngredientsController::class, 'add'])->name('admin.ingredients.add');
    Route::post('ingredients/insert', [IngredientsController::class, 'save'])->name('admin.ingredients.save');
    Route::get('ingredients/edit/{id}', [IngredientsController::class, 'edit'])->name('admin.ingredients.edit');
    Route::put('ingredients/update', [IngredientsController::class, 'update'])->name('admin.ingredients.update');
    Route::delete('ingredients/delete', [IngredientsController::class, 'delete'])->name('admin.ingredients.delete');
    Route::delete('ingredients/deleteDetail', [IngredientsController::class, 'deleteDetail'])->name('admin.ingredients.deleteDetail');
    Route::get('ingredients/variant-data', [IngredientsController::class, 'getVariantData'])->name('admin.ingredients.variant-data');
    Route::get('ingredients/item-data', [IngredientsController::class, 'getItemData'])->name('admin.ingredients.item-data');
    Route::get('ingredients/getItemDataForIngredient', [IngredientsController::class, 'getItemDataForIngredient'])->name('admin.ingredients.getItemDataForIngredient');
    Route::get('ingredients/item-data-select', [IngredientsController::class, 'getItemDataSelect'])->name('admin.ingredients.item-data-select');
    Route::get('ingredients/unit-main-data', [IngredientsController::class, 'getUnitMainData'])->name('admin.ingredients.unit-main-data');
    Route::get('ingredients/units-data', [IngredientsController::class, 'getUnitsData'])->name('admin.ingredients.units-data');
    Route::get('ingredients/item-ingredients', [IngredientsController::class, 'getItemIngredients'])->name('admin.ingredients.item-ingredients');
    Route::get('ingredients/item-ingredient', [IngredientsController::class, 'getItemIngredient'])->name('admin.ingredients.item-ingredient');
    Route::get('ingredients/detail/{id}', [IngredientsController::class, 'detail'])->name('admin.ingredients.detail');
    Route::get('ingredients/supplier-data-select', [IngredientsController::class, 'getSupplierDataSelect'])->name('admin.ingredients.supplier-data-select');
    Route::post('ingredients/isExistInformation', [IngredientsController::class, 'isExistInformation'])->name('admin.ingredients.isExistInformation');
    Route::get('ingredients/getDataIngredient', [IngredientsController::class, 'getDataIngredient'])->name('admin.ingredients.getDataIngredient');
    Route::get('ingredients/duplicate', [IngredientsController::class, 'add'])->name('admin.ingredients.duplicate');
    Route::get('ingredients/getDataItem', [IngredientsController::class, 'getDataItem'])->name('admin.ingredients.getDataItem');
    Route::get('ingredients/getDataItemVariant', [IngredientsController::class, 'getDataItemVariant'])->name('admin.ingredients.getDataItemVariant');
    Route::get('ingredients/getDataItemVariantIngredient', [IngredientsController::class, 'getDataItemVariantIngredient'])->name('admin.ingredients.getDataItemVariantIngredient');

    Route::get('stock_card', [StockCardController::class, 'index'])->name('admin.stock_card');
    Route::get('stock_card-data', [StockCardController::class, 'getData'])->name('admin.stock_card.getData');
    Route::get('stock_card/add', [StockCardController::class, 'create'])->name('admin.stock_card.add');
    Route::post('stock_card/insert', [StockCardController::class, 'store'])->name('admin.stock_card.save');
    Route::get('stock_card/edit/{id}', [StockCardController::class, 'edit'])->name('admin.stock_card.edit');
    Route::put('stock_card/update', [StockCardController::class, 'update'])->name('admin.stock_card.update');
    Route::delete('stock_card/delete', [StockCardController::class, 'destroy'])->name('admin.stock_card.delete');
    Route::delete('stock_card/delete-detail', [StockCardController::class, 'deleteDetail'])->name('admin.stock_card.delete-detail');
    Route::get('stock_card/detail/{id}', [StockCardController::class, 'show'])->name('admin.stock_card.detail');
    Route::get('stock_card/warehouse-data', [StockCardController::class, 'getWarehouseData'])->name('admin.stock_card.warehouse-data');
    Route::get('stock_card/item-data', [StockCardController::class, 'getItemData'])->name('admin.stock_card.item-data');
    Route::get('stock_card/unit-data', [StockCardController::class, 'getUnitData'])->name('admin.stock_card.unit-data');
    Route::get('stock_card/destination-warehouse-data', [StockCardController::class, 'getDestinationWarehouseData'])->name('admin.stock_card.destination-warehouse-data');
    Route::get('stock_card/store-data', [StockCardController::class, 'getStoreData'])->name('admin.stock_card.store-data');

    Route::get('adjusment', [AdjusmentController::class, 'index'])->name('admin.adjusment');
    Route::get('adjusment-data', [AdjusmentController::class, 'getData'])->name('admin.adjusment.getData');
    Route::get('adjusment/add', [AdjusmentController::class, 'create'])->name('admin.adjusment.add');
    Route::post('adjusment/insert', [AdjusmentController::class, 'store'])->name('admin.adjusment.save');
    Route::get('adjusment/edit/{id}', [AdjusmentController::class, 'edit'])->name('admin.adjusment.edit');
    Route::put('adjusment/update', [AdjusmentController::class, 'update'])->name('admin.adjusment.update');
    Route::delete('adjusment/delete', [AdjusmentController::class, 'destroy'])->name('admin.adjusment.delete');
    Route::delete('adjusment/delete-detail', [AdjusmentController::class, 'deleteDetail'])->name('admin.adjusment.delete-detail');
    Route::get('adjusment/detail/{id}', [AdjusmentController::class, 'show'])->name('admin.adjusment.detail');
    Route::get('adjusment/warehouse-data', [AdjusmentController::class, 'getWarehouseData'])->name('admin.adjusment.warehouse-data');
    Route::get('adjusment/item-data', [AdjusmentController::class, 'getItemData'])->name('admin.adjusment.item-data');
    Route::get('adjusment/unit-data', [AdjusmentController::class, 'getUnitData'])->name('admin.adjusment.unit-data');

    Route::get('promo_products', [PromoProductsController::class, 'index'])->name('admin.promo_products');
    Route::get('promo_products-data', [PromoProductsController::class, 'getData'])->name('admin.promo_products.getData');
    Route::get('promo_products/add', [PromoProductsController::class, 'create'])->name('admin.promo_products.add');
    Route::post('promo_products/insert', [PromoProductsController::class, 'store'])->name('admin.promo_products.save');
    Route::get('promo_products/edit/{id}', [PromoProductsController::class, 'edit'])->name('admin.promo_products.edit');
    Route::put('promo_products/update', [PromoProductsController::class, 'update'])->name('admin.promo_products.update');
    Route::delete('promo_products/delete', [PromoProductsController::class, 'destroy'])->name('admin.promo_products.delete');
    Route::delete('promo_products/delete-detail', [PromoProductsController::class, 'deleteDetail'])->name('admin.promo_products.delete-detail');
    Route::get('promo_products/detail/{id}', [PromoProductsController::class, 'show'])->name('admin.promo_products.detail');
    Route::get('promo_products/product-data', [PromoProductsController::class, 'getProductData'])->name('admin.promo_products.product-data');
    //
    Route::get('human_resource/getData', [HumanResourceController::class, 'getData'])->name('admin.human_resource.getData');
    Route::get('human_resource/getLog', [AbsenController::class, 'getLog'])->name('admin.human_resource.getLog');
    Route::get('human_resource/log', [HumanResourceController::class, 'log'])->name('admin.human_resource.log');
    Route::get('human_resource', [HumanResourceController::class, 'index'])->name('admin.human_resource');
    Route::get('human_resource/setting', [HumanResourceController::class, 'setting'])->name('admin.human_resource.setting');
    Route::put('human_resource/update-setting', [HumanResourceController::class, 'updateSetting'])->name('admin.human_resource.update_setting');
    Route::get('human_resource/exportExcel', [HumanResourceController::class, 'exportExcel'])->name('admin.human_resource.exportExcel');
    Route::get('human_resource/pengajuan-absensi', [HumanResourceController::class, 'pengajuanAbsensi'])->name('admin.human_resource.pengajuan_absensi');
    Route::get('human_resource/get-pengajuan-absensi', [HumanResourceController::class, 'getPengajuanAbsensi'])->name('admin.human_resource.get_pengajuan_absensi');
    Route::post('human_resource/act-pengajuan-absensi', [HumanResourceController::class, 'actPengajuanAbsensi'])->name('admin.human_resource.act_pengajuan_absensi');
    Route::get('human_resource/rekap-absensi-per-bulan', [HumanResourceController::class, 'rekapAbsensiPerBulan'])->name('admin.human_resource.rekap_absensi_per_bulan');
    Route::get('human_resource/rekap-absensi-per-bulan/get-data', [HumanResourceController::class, 'getDataRekapAbsensiPerBulan'])->name('admin.human_resource.rekap_absensi_per_bulan.get_data');
    Route::get('human_resource/rekap-absensi-per-bulan/detail/{id}/{bulan}/{tahun}', [HumanResourceController::class, 'getRekapAbsensiPerBulanDetail'])->name('admin.human_resource.rekap_absensi_per_bulan.detail');
    Route::get('human_resource/rekap-absensi-per-bulan/export', [HumanResourceController::class, 'exportRekapAbsensiPerBulan'])->name('admin.human_resource.rekap_absensi_per_bulan.export');
    Route::get('human_resource/rekap-absensi-per-bulan/detail/export', [HumanResourceController::class, 'exportRekapAbsensiDetailPerBulan'])->name('admin.human_resource.rekap_absensi_per_bulan.detail.export');
    Route::get('human_resource/rekap-absensi-per-tahun', [HumanResourceController::class, 'rekapAbsensiPerTahun'])->name('admin.human_resource.rekap_absensi_per_tahun');
    Route::get('human_resource/rekap-absensi-per-tahun/get-data', [HumanResourceController::class, 'getDataRekapAbsensiPerTahun'])->name('admin.human_resource.rekap_absensi_per_tahun.get_data');
    Route::get('human_resource/rekap-absensi-per-tahun/detail/{id}', [HumanResourceController::class, 'getRekapAbsensiPerTahunDetail'])->name('admin.human_resource.rekap_absensi_per_tahun.detail');
    Route::get('human_resource/rekap-absensi-per-tahun/exportExcel', [HumanResourceController::class, 'exportExcelTahun'])->name('admin.human_resource_tahun.exportExcel');

    Route::get('supplier', [SupplierController::class, 'index'])->name('admin.supplier');
    Route::get('supplier-data', [SupplierController::class, 'getData'])->name('admin.supplier.getData');
    Route::get('supplier/add', [SupplierController::class, 'add'])->name('admin.supplier.add');
    Route::post('supplier/insert', [SupplierController::class, 'insert'])->name('admin.supplier.save');
    Route::get('supplier/edit/{id}', [SupplierController::class, 'edit'])->name('admin.supplier.edit');
    Route::put('supplier/update/{id}', [SupplierController::class, 'update'])->name('admin.supplier.update');
    Route::delete('supplier/delete', [SupplierController::class, 'delete'])->name('admin.supplier.delete');
    Route::post('supplier/change-status', [SupplierController::class, 'changeStatus'])->name('admin.supplier.changeStatus');

    Route::get('buys',[BuysController::class, 'index'])->name('admin.buys');
    Route::get('buys-data',[BuysController::class, 'getData'])->name('admin.buys.getData');
    Route::get('buys/add',[BuysController::class, 'create'])->name('admin.buys.add');
    Route::post('buys/insert',[BuysController::class, 'store'])->name('admin.buys.save');
    Route::get('buys/edit/{id}',[BuysController::class, 'edit'])->name('admin.buys.edit');
    Route::put('buys/update',[BuysController::class, 'update'])->name('admin.buys.update');
    Route::delete('buys/delete',[BuysController::class, 'destroy'])->name('admin.buys.delete');
    Route::delete('buys/delete-detail',[BuysController::class, 'deleteDetail'])->name('admin.buys.delete-detail');
    Route::get('buys/detail/{id}',[BuysController::class, 'show'])->name('admin.buys.detail');
    Route::get('buys/warehouse-data',[BuysController::class, 'getWarehouseData'])->name('admin.buys.warehouse-data');
    Route::get('buys/item-data',[BuysController::class, 'getItemData'])->name('admin.buys.item-data');
    Route::get('buys/unit-data',[BuysController::class, 'getUnitData'])->name('admin.buys.unit-data');
    Route::get('buys/destination-warehouse-data',[BuysController::class, 'getDestinationWarehouseData'])->name('admin.buys.destination-warehouse-data');
    Route::get('buys/store-data',[BuysController::class, 'getStoreData'])->name('admin.buys.store-data');
    Route::get('buys/excel/{id}',[BuysController::class, 'exportDetailExcel'])->name('admin.buys.export-excel-detail');
    Route::get('buys/exportExcel', [BuysController::class, 'exportExcel'])->name('admin.buys.exportExcel');
    Route::put('buys/approve',[BuysController::class, 'approve'])->name('admin.buys.approve');
    Route::get('buys-data-product',[BuysController::class, 'getDataProduct'])->name('admin.buys.getDataProduct');
    Route::put('buys/validasi',[BuysController::class, 'validasi'])->name('admin.buys.validasi');
    Route::get('buys-data-nomor-buys',[BuysController::class, 'getDataNomor'])->name('admin.buys.getDataNomor');
    Route::get('buys/generate-nomor',[BuysController::class, 'generateNomorBuys'])->name('admin.buys.generate-nomor');
    Route::get('buys/cek-nomor',[BuysController::class, 'cekNomor'])->name('admin.buys.cek-nomor');
    Route::get('buys/exportPdf', [BuysController::class, 'exportPdf'])->name('admin.buys.exportPdf');
    Route::get('buys/getUnit', [BuysController::class, 'getUnit'])->name('admin.buys.getUnit');

    Route::get('production',[ProduksiController::class, 'index'])->name('admin.produksi');
    Route::get('production/getData',[ProduksiController::class, 'getData'])->name('admin.produksi.getData');
    Route::get('production/gudang-data',[ProduksiController::class, 'getGudangData'])->name('admin.produksi.gudang-data');
    Route::get('production/item-data',[ProduksiController::class, 'getItemData'])->name('admin.produksi.item-data');
    Route::get('production/variant-data',[ProduksiController::class, 'getVariantData'])->name('admin.produksi.variant-data');
    Route::get('production/ingredient-data',[ProduksiController::class, 'getIngredients'])->name('admin.produksi.ingredient-data');
    Route::get('production/stok-data',[ProduksiController::class, 'getStok'])->name('admin.produksi.stok-data');
    Route::get('production/generate-nomor',[ProduksiController::class, 'generateNomorProduksi'])->name('admin.produksi.generate-nomor');
    Route::get('production/cek-nomor',[ProduksiController::class, 'cekNomor'])->name('admin.produksi.cek-nomor');
    Route::get('production/add',[ProduksiController::class, 'create'])->name('admin.produksi.add');
    Route::post('production/insert',[ProduksiController::class, 'store'])->name('admin.produksi.save');
    Route::get('production/edit/{id}',[ProduksiController::class, 'edit'])->name('admin.produksi.edit');
    Route::put('production/update',[ProduksiController::class, 'update'])->name('admin.produksi.update');
    Route::delete('production/delete',[ProduksiController::class, 'destroy'])->name('admin.produksi.delete');
    Route::delete('production/delete-detail',[ProduksiController::class, 'deleteDetail'])->name('admin.produksi.delete-detail');
    Route::get('production/detail/{id}',[ProduksiController::class, 'show'])->name('admin.produksi.detail');
    Route::get('production/product-data',[ProduksiController::class, 'getProductData'])->name('admin.produksi.product-data');
    Route::get('production/getDataWarehouse',[ProduksiController::class, 'getDataWarehouse'])->name('admin.produksi.getDataWarehouse');
    Route::get('production/getDataItem',[ProduksiController::class, 'getDataItem'])->name('admin.produksi.getDataItem');
    Route::get('production/getDataVariant',[ProduksiController::class, 'getDataVariant'])->name('admin.produksi.getDataVariant');
    Route::get('production/export', [ProduksiController::class, 'export'])->name('admin.produksi.export');
    Route::get('production/exportDetail', [ProduksiController::class, 'exportDetail'])->name('admin.produksi.exportDetail');
    Route::get('production/getIngredient',[ProduksiController::class, 'getIngredient'])->name('admin.produksi.getIngredient');
    Route::get('production/getStock',[ProduksiController::class, 'getStock'])->name('admin.produksi.getStock');

    Route::get('sales',[SalesController::class, 'index'])->name('admin.sales');
    Route::get('sales/getData',[SalesController::class, 'getData'])->name('admin.sales.getData');
    Route::get('sales/add',[SalesController::class, 'add'])->name('admin.sales.add');
    Route::post('sales/save',[SalesController::class, 'save'])->name('admin.sales.save');
    Route::get('sales/edit/{id}',[SalesController::class, 'edit'])->name('admin.sales.edit');
    Route::put('sales/update',[SalesController::class, 'update'])->name('admin.sales.update');
    Route::delete('sales/delete',[SalesController::class, 'delete'])->name('admin.sales.delete');
    Route::delete('sales/deleteDetail',[SalesController::class, 'deleteDetail'])->name('admin.sales.deleteDetail');
    Route::put('sales/updateTotalSalesAmount',[SalesController::class, 'updateTotalSalesAmount'])->name('admin.sales.updateTotalSalesAmount');
    Route::get('sales/detail/{sales_number}',[SalesController::class, 'detail'])->name('admin.sales.detail');
    Route::get('sales/getDataWarehouse',[SalesController::class, 'getDataWarehouse'])->name('admin.sales.getDataWarehouse');
    Route::get('sales/getDataItemVariant',[SalesController::class, 'getDataItemVariant'])->name('admin.sales.getDataItemVariant');
    Route::get('sales/getDataCustomer',[SalesController::class, 'getDataCustomer'])->name('admin.sales.getDataCustomer');
    Route::get('sales/getDataCourier',[SalesController::class, 'getDataCourier'])->name('admin.sales.getDataCourier');
    Route::get('sales/export', [SalesController::class, 'export'])->name('admin.sales.export');
    Route::get('sales/exportDetail', [SalesController::class, 'exportDetail'])->name('admin.sales.exportDetail');
    Route::get('sales/generateSalesNumber',[SalesController::class, 'generateSalesNumber'])->name('admin.sales.generateSalesNumber');
    Route::post('sales/isExistSalesNumber',[SalesController::class, 'isExistSalesNumber'])->name('admin.sales.isExistSalesNumber');
    Route::get('sales/getUnit',[SalesController::class, 'getUnit'])->name('admin.sales.getUnit');

    Route::get('companies', [CompanyController::class, 'index'])->name('admin.companies');
    Route::get('companies-data', [CompanyController::class, 'getData'])->name('admin.companies.getData');
    Route::get('companies/add', [CompanyController::class, 'add'])->name('admin.companies.add');
    Route::post('companies/save', [CompanyController::class, 'save'])->name('admin.companies.save');
    Route::get('companies/edit/{id}', [CompanyController::class, 'edit'])->name('admin.companies.edit');
    Route::put('companies/update{id}', [CompanyController::class, 'update'])->name('admin.companies.update');
    Route::delete('companies/delete', [CompanyController::class, 'delete'])->name('admin.companies.delete');
    Route::post('companies/change-status', [CompanyController::class, 'changeStatus'])->name('admin.companies.changeStatus');
    
    Route::get('delivery-note',[DeliveryNoteController::class, 'index'])->name('admin.delivery_note');
    Route::get('delivery-note/getData',[DeliveryNoteController::class, 'getData'])->name('admin.delivery_note.getData');
    Route::get('delivery-note/sales',[DeliveryNoteController::class, 'sales'])->name('admin.delivery_note.sales');
    Route::get('delivery-note/sales/detail/{id}',[DeliveryNoteController::class, 'sales_detail'])->name('admin.delivery_note.sales.detail');
    Route::get('delivery-note/sales/cek/{id}',[DeliveryNoteController::class, 'isQuantityFulfilled'])->name('admin.delivery_note.sales.isQuantityFulfilled');
    Route::get('delivery-note/getDataSales',[DeliveryNoteController::class, 'getDataSales'])->name('admin.delivery_note.getDataSales');
    Route::get('delivery-note/getSales',[DeliveryNoteController::class, 'getSales'])->name('admin.delivery_note.getSales');
    Route::get('delivery-note/add',[DeliveryNoteController::class, 'add'])->name('admin.delivery_note.add');
    Route::post('delivery-note/save',[DeliveryNoteController::class, 'save'])->name('admin.delivery_note.save');
    Route::get('delivery-note/edit/{id}',[DeliveryNoteController::class, 'edit'])->name('admin.delivery_note.edit');
    Route::put('delivery-note/update',[DeliveryNoteController::class, 'update'])->name('admin.delivery_note.update');
    Route::delete('delivery-note/delete',[DeliveryNoteController::class, 'delete'])->name('admin.delivery_note.delete');
    Route::delete('delivery-note/deleteDetail',[DeliveryNoteController::class, 'deleteDetail'])->name('admin.delivery_note.deleteDetail');
    Route::get('delivery-note/detail/{id}',[DeliveryNoteController::class, 'detail'])->name('admin.delivery_note.detail');
    Route::get('delivery-note/getDataWarehouse',[DeliveryNoteController::class, 'getDataWarehouse'])->name('admin.delivery_note.getDataWarehouse');
    Route::get('delivery-note/getDataItemVariant',[DeliveryNoteController::class, 'getDataItemVariant'])->name('admin.delivery_note.getDataItemVariant');
    Route::get('delivery-note/getDataStock',[DeliveryNoteController::class, 'getDataStock'])->name('admin.delivery_note.getDataStock');
    Route::get('delivery-note/exportExcel', [DeliveryNoteController::class, 'exportExcel'])->name('admin.delivery_note.exportExcel');
    Route::get('delivery-note/exportPdf', [DeliveryNoteController::class, 'exportPdf'])->name('admin.delivery_note.exportPdf');
    Route::get('delivery-note/generateDeliveryNoteNumber',[DeliveryNoteController::class, 'generateDeliveryNoteNumber'])->name('admin.delivery_note.generateDeliveryNoteNumber');
    Route::post('delivery-note/isExistDeliveryNoteNumber',[DeliveryNoteController::class, 'isExistDeliveryNoteNumber'])->name('admin.delivery_note.isExistDeliveryNoteNumber');
    Route::get('delivery-note/sisaPengiriman',[DeliveryNoteController::class, 'sisaPengiriman'])->name('admin.delivery_note.sisaPengiriman');
    Route::get('delivery-note/getUnit',[DeliveryNoteController::class, 'getUnit'])->name('admin.delivery_note.getUnit');

    Route::get('setting-company', [SettingsCompanyController::class, 'settingsCompany'])->name('admin.settings.company');
    Route::put('setting-company', [SettingsCompanyController::class, 'updateSettingsCompany'])->name('admin.settings.updateCompany');

    //Accurate
    Route::get('accurate/sync', [AccurateSyncController::class, 'index'])->name('admin.accurate.sync');
    Route::post('accurate/sync/saveWarehouse', [AccurateSyncController::class, 'saveWarehouse'])->name('admin.accurate.sync.saveWarehouse');
    Route::get('accurate/sync/getToken', [AccurateSyncController::class, 'getToken'])->name('admin.accurate.sync.getToken');
    Route::get('accurate/sync/getDataWarehouse', [AccurateSyncController::class, 'getDataWarehouse'])->name('admin.accurate.sync.getDataWarehouse');
    
    Route::get('accurate/token', [AccurateTokenController::class, 'index'])->name('admin.accurate.token');
    Route::put('accurate/token', [AccurateTokenController::class, 'update'])->name('admin.accurate.token.update');
    
    //Accurate
    Route::get('accurate/sync', [AccurateSyncController::class, 'index'])->name('admin.accurate.sync');
    Route::get('accurate/sync/getToken', [AccurateSyncController::class, 'getToken'])->name('admin.accurate.sync.getToken');
    Route::get('accurate/sync/getData', [AccurateSyncController::class, 'getData'])->name('admin.accurate.sync.getData');
    
    Route::get('accurate/sync/getDataWarehouse', [AccurateSyncController::class, 'getDataWarehouse'])->name('admin.accurate.sync.getDataWarehouse');
    Route::get('accurate/sync/getDataWarehouseDeleted', [AccurateSyncController::class, 'getDataWarehouseDeleted'])->name('admin.accurate.sync.getDataWarehouseDeleted');
    Route::post('accurate/sync/saveWarehouse', [AccurateSyncController::class, 'saveWarehouse'])->name('admin.accurate.sync.saveWarehouse');
    Route::post('accurate/sync/updateWarehouse', [AccurateSyncController::class, 'updateWarehouse'])->name('admin.accurate.sync.updateWarehouse');
    Route::get('accurate/sync/getAccurateWarehouse', [AccurateSyncController::class, 'getAccurateWarehouse'])->name('admin.accurate.sync.getAccurateWarehouse');
    
    Route::get('accurate/sync/getDataEmployee', [AccurateSyncController::class, 'getDataEmployee'])->name('admin.accurate.sync.getDataEmployee');
    Route::get('accurate/sync/getDataEmployeeDeleted', [AccurateSyncController::class, 'getDataEmployeeDeleted'])->name('admin.accurate.sync.getDataEmployeeDeleted');
    Route::post('accurate/sync/saveEmployee', [AccurateSyncController::class, 'saveEmployee'])->name('admin.accurate.sync.saveEmployee');
    Route::post('accurate/sync/updateEmployee', [AccurateSyncController::class, 'updateEmployee'])->name('admin.accurate.sync.updateEmployee');
    Route::get('accurate/sync/getAccurateEmployee', [AccurateSyncController::class, 'getAccurateEmployee'])->name('admin.accurate.sync.getAccurateEmployee');
    
    Route::get('accurate/token', [AccurateTokenController::class, 'index'])->name('admin.accurate.token');
    Route::put('accurate/token', [AccurateTokenController::class, 'update'])->name('admin.accurate.token.update');
    
    Route::get('invoice-sales',[InvoiceSalesController::class, 'index'])->name('admin.invoice_sales');
    Route::get('invoice-sales/getData',[InvoiceSalesController::class, 'getData'])->name('admin.invoice_sales.getData');
    Route::get('invoice-sales/add',[InvoiceSalesController::class, 'add'])->name('admin.invoice_sales.add');
    Route::post('invoice-sales/save',[InvoiceSalesController::class, 'save'])->name('admin.invoice_sales.save');
    Route::get('invoice-sales/edit/{id}',[InvoiceSalesController::class, 'edit'])->name('admin.invoice_sales.edit');
    Route::put('invoice-sales/update',[InvoiceSalesController::class, 'update'])->name('admin.invoice_sales.update');
    Route::delete('invoice-sales/delete',[InvoiceSalesController::class, 'delete'])->name('admin.invoice_sales.delete');
    Route::delete('invoice-sales/deleteDetail',[InvoiceSalesController::class, 'deleteDetail'])->name('admin.invoice_sales.deleteDetail');
    Route::put('invoice-sales/updateTotalPaymentAmount',[InvoiceSalesController::class, 'updateTotalPaymentAmount'])->name('admin.invoice_sales.updateTotalPaymentAmount');
    Route::get('invoice-sales/detail/{invoice_sales_number}',[InvoiceSalesController::class, 'detail'])->name('admin.invoice_sales.detail');
    Route::get('invoice-sales/getDataInvoiceSales',[InvoiceSalesController::class, 'getDataInvoiceSales'])->name('admin.invoice_sales.getDataInvoiceSales');
    Route::get('invoice-sales/getDataSales',[InvoiceSalesController::class, 'getDataSales'])->name('admin.invoice_sales.getDataSales');
    Route::get('invoice-sales/getDataSalesDetail',[InvoiceSalesController::class, 'getDataSalesDetail'])->name('admin.invoice_sales.getDataSalesDetail');
    Route::get('invoice-sales/getDataDeliveryNote',[InvoiceSalesController::class, 'getDataDeliveryNote'])->name('admin.invoice_sales.getDataDeliveryNote');
    Route::get('invoice-sales/getDataDeliveryNoteDetail',[InvoiceSalesController::class, 'getDataDeliveryNoteDetail'])->name('admin.invoice_sales.getDataDeliveryNoteDetail');
    Route::get('invoice-sales/getDataCustomer',[InvoiceSalesController::class, 'getDataCustomer'])->name('admin.invoice_sales.getDataCustomer');
    Route::get('invoice-sales/export', [InvoiceSalesController::class, 'export'])->name('admin.invoice_sales.export');
    Route::get('invoice-sales/exportDetail', [InvoiceSalesController::class, 'exportDetail'])->name('admin.invoice_sales.exportDetail');
    Route::get('invoice-sales/generateInvoiceSalesNumber',[InvoiceSalesController::class, 'generateInvoiceSalesNumber'])->name('admin.invoice_sales.generateInvoiceSalesNumber');
    Route::post('invoice-sales/isExistInvoiceSalesNumber',[InvoiceSalesController::class, 'isExistInvoiceSalesNumber'])->name('admin.invoice_sales.isExistInvoiceSalesNumber');
    Route::post('invoice-sales/uploadProofofPayment',[InvoiceSalesController::class, 'uploadProofofPayment'])->name('admin.invoice_sales.uploadProofofPayment');
    Route::post('invoice-sales/cancelProofofPayment',[InvoiceSalesController::class, 'cancelProofofPayment'])->name('admin.invoice_sales.cancelProofofPayment');
});



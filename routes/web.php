<?php

use App\Http\Controllers\BackendAuthController;
use App\Http\Controllers\BackendViewController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

// Error Page
Route::fallback(function () {
    return response()->view('Backend.Pages.Errors.404-Page', [], 404);
});
//------------------Backend View Routes------------------//
Route::middleware(['afterAuth'])->group(function () {
    Route::get('/', [BackendViewController::class, 'DashboardView'])->name('Dashboard');
    Route::get('/profile', [BackendViewController::class, 'BackendProfileView'])->name('Profile');
    Route::get('/categories', [BackendViewController::class, 'BackendCategoriesView'])->name('Categories');
    Route::get('/brands', [BackendViewController::class, 'BackendBrandView'])->name('Brands');
    Route::get('/taxes', [BackendViewController::class, 'BackendTaxView'])->name('Taxes');
    Route::get('/units', [BackendViewController::class, 'BackendUnitView'])->name('Units');
    Route::get('/products', [BackendViewController::class, 'BackendProductsView'])->name('Products');
    Route::get('/products/create', [BackendViewController::class, 'BackendProductCreateView'])->name('Product.Create');
    Route::get('/products/view/{slug}', [BackendViewController::class, 'BackendProductSingleView'])->name('Product.Single.View');
    Route::get('/products/update/{slug}', [BackendViewController::class, 'BackendProductSingleUpdateView'])->name('Product.Single.update');
    Route::get('/customers', [BackendViewController::class, 'BackendCustomersView'])->name('Customers');
    Route::get('/pos', [BackendViewController::class, 'BackendPOSView'])->name('POS');
    Route::get('/order/print/{order_number}', [BackendViewController::class, 'printReceipt'])
        ->name('order.print');
    Route::get('/orders', [BackendViewController::class, 'BackendOrdersView'])->name('Orders');
    Route::get('/support', [BackendViewController::class, 'BackendSupportView'])->name('Support');
    Route::get('/notifications', [BackendViewController::class, 'BackendNotificationsView'])->name('notifications');
    Route::get('/print-all-product-barcode', [BackendViewController::class, 'productAllBarcodePrint'])->name('productAllBarcodePrint');
    Route::get('/print-single-product-barcode/{slug}', [BackendViewController::class, 'productSingleBarcodePrint'])->name('productSingleBarcodePrint');
    Route::get('/setting', [BackendViewController::class, 'BackendSettingView'])->name('Setting')->middleware('afterAuth');
});

//auth
Route::get('/login', [BackendViewController::class, 'BackendLogin'])->name('Login');
Route::get('/forgot', [BackendViewController::class, 'BackendForgot'])->name('Forgot');
Route::get('/reset', [BackendViewController::class, 'BackendReset'])->name('Reset')->middleware('ForgotAuth');
Route::get('logout', [BackendAuthController::class, 'BackendLogout'])->name('Logout');
Route::post('/backendData/login', [BackendAuthController::class, 'Login'])->name('Backend.LoginPost');
Route::post('/backendData/forgot', [BackendAuthController::class, 'Forgot'])->name('Backend.ForgotPost');
Route::post('/backendData/reset', [BackendAuthController::class, 'Reset'])->name('Backend.ResetPost');


//------------------Backend Auth Routes------------------//
Route::middleware(['afterAuth'])->group(function () {
    Route::get('/backendData/profile', [BackendAuthController::class, 'Profile'])->name('Backend.ProfilePost');
    Route::post('/backendData/profile/update', [BackendAuthController::class, 'ProfileUpdate'])->name('Backend.ProfilePost.Update');
    Route::post('/backendData/profile/changePassword', [BackendAuthController::class, 'ChangePassword'])->name('Backend.ProfilePost.ChangePassword');
// ++++++++ Category ++++++++
    Route::post('/backendData/category-create', [CategoryController::class, 'categoryCreate'])->name('Backend.categoryCreate');
    Route::get('/backendData/category-list', [CategoryController::class, 'categoryList'])->name('Backend.categoryList');
    Route::post('/backendData/category-single/', [CategoryController::class, 'categorySingle'])->name('Backend.categorySingle');
    Route::post('/backendData/category-update/', [CategoryController::class, 'categoryUpdate'])->name('Backend.categoryUpdate');
    Route::post('/backendData/category-delete/', [CategoryController::class, 'categoryDelete'])->name('Backend.categoryDelete');
    Route::get('/backendData/get-category-by-status/', [CategoryController::class, 'categoryStatus'])->name('Backend.categoryStatus');
    Route::post('/backendData/get-category-by-name/', [CategoryController::class, 'categoryByName'])->name('Backend.categoryByName');
// ++++++++ Brand ++++++++
    Route::post('/backendData/brand-create', [BrandController::class, 'brandCreate'])->name('Backend.brandCreate');
    Route::get('/backendData/brand-list', [BrandController::class, 'brandList'])->name('Backend.brandList');
    Route::post('/backendData/brand-single/', [BrandController::class, 'brandSingle'])->name('Backend.brandSingle');
    Route::post('/backendData/brand-update/', [BrandController::class, 'brandUpdate'])->name('Backend.brandUpdate');
    Route::post('/backendData/brand-delete/', [BrandController::class, 'brandDelete'])->name('Backend.brandDelete');
    Route::get('/backendData/get-brand-by-status/', [BrandController::class, 'brandStatus'])->name('Backend.brandStatus');
// ++++++++ Tax ++++++++
    Route::post('/backendData/tax-create', [TaxController::class, 'taxCreate'])->name('Backend.taxCreate');
    Route::get('/backendData/tax-list', [TaxController::class, 'taxList'])->name('Backend.taxList');
    Route::post('/backendData/tax-single/', [TaxController::class, 'taxSingle'])->name('Backend.taxSingle');
    Route::post('/backendData/tax-update/', [TaxController::class, 'taxUpdate'])->name('Backend.taxUpdate');
    Route::post('/backendData/tax-delete/', [TaxController::class, 'taxDelete'])->name('Backend.taxDelete');
    Route::get('/backendData/get-tax-by-status/', [TaxController::class, 'taxStatus'])->name('Backend.taxStatus');
// ++++++++ units ++++++++
    Route::post('/backendData/units-create', [UnitController::class, 'UnitsCreate'])->name('Backend.UnitsCreate');
    Route::get('/backendData/units-list', [UnitController::class, 'UnitsList'])->name('Backend.UnitsList');
    Route::post('/backendData/units-single/', [UnitController::class, 'UnitsSingle'])->name('Backend.UnitsSingle');
    Route::post('/backendData/units-update/', [UnitController::class, 'UnitsUpdate'])->name('Backend.UnitsUpdate');
    Route::post('/backendData/units-delete/', [UnitController::class, 'UnitsDelete'])->name('Backend.UnitsDelete');
    Route::get('/backendData/units-by-status/', [UnitController::class, 'UnitsStatus'])->name('Backend.UnitsStatus');
// ++++++++ customers ++++++++
    Route::post('/backendData/customer-create', [CustomerController::class, 'CustomersCreate'])->name('Backend.CustomerCreate');
    Route::get('/backendData/customers-list', [CustomerController::class, 'CustomersList'])->name('Backend.CustomersList');
    Route::post('/backendData/customers-single/', [CustomerController::class, 'CustomersSingle'])->name('Backend.CustomersSingle');
    Route::post('/backendData/customers-update/', [CustomerController::class, 'CustomerUpdate'])->name('Backend.CustomerUpdate');
    Route::post('/backendData/customers-delete/', [CustomerController::class, 'CustomerDelete'])->name('Backend.CustomerDelete');
    Route::get('/backendData/units-by-status/', [UnitController::class, 'UnitsStatus'])->name('Backend.UnitsStatus');
// +++++++ Product ++++++++
    Route::post('/backendData/productSUKGenerator', [ProductController::class, 'ProductSKUGenerator'])->name('Backend.productSUKGenerator');
    Route::post('/backendData/productBarcodeGenerator', [ProductController::class, 'productBarcodeGenerator'])->name('Backend.productBarcodeGenerator');
    Route::post('/backendData/product-create', [ProductController::class, 'productCreate'])->name('Backend.productCreate');
    Route::post('/backendData/product-update/{slug}', [ProductController::class, 'productUpdate']);
    Route::get('/backendData/product-list', [ProductController::class, 'productList'])->name('Backend.productList');
    Route::post('/backendData/product-singleData', [ProductController::class, 'productSingleData'])->name('Backend.productSingleData');
    Route::post('/backendData/product-delete', [ProductController::class, 'productDelete'])->name('Backend.productDelete');
// ++++++ Order ++++++++
    Route::post('/backendData/order-create', [OrderController::class, 'orderCreate'])->name('Backend.orderCreate');
    Route::get('/backendData/order-list', [OrderController::class, 'orderList'])->name('Backend.orderList');
    Route::post('/backendData/order-delete', [OrderController::class, 'orderDelete'])->name('Backend.orderDelete');
    Route::post('/backendData/make-due-payment', [OrderController::class, 'makeDuePayment'])->name('Backend.makeDuePayment');
// ++++++ Notifications ++++++++
    Route::get('/backendData/activeNotifications-list', [NotificationController::class, 'activeNotificationsList'])->name('Backend.activeNotificationsList');
    Route::get('/backendData/fiveNotifications-list', [NotificationController::class, 'fiveNotificationsList'])->name('Backend.fiveNotificationsList');
    Route::get('/backendData/activeNotificationMarkAllRead', [NotificationController::class, 'activeNotificationMarkAllRead'])->name('Backend.activeNotificationMarkAllRead');
// ++++++ Settings +++++++//
    Route::post('/backendData/setting-update', [SettingController::class, 'SettingUpdate'])->name('Backend.SettingUpdate');
    Route::get('/backendData/get-setting', [SettingController::class, 'getSetting'])->name('Backend.getSetting');

});

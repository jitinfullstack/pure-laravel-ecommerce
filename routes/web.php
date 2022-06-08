<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('product/{product_slug}', [FrontendController::class, 'product'])->name('product');
Route::get('category/{category_slug}', [FrontendController::class, 'category'])->name('category');
Route::post('add_to_cart', [CartController::class, 'add_to_cart'])->name('add_to_cart');
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('search/{searchTerm}', [FrontendController::class, 'search'])->name('search');
Route::get('register', [FrontendController::class, 'register'])->name('register');
Route::post('registration_process', [FrontendController::class, 'registration_process'])->name('registration_process');
Route::post('login_process', [FrontendController::class, 'login_process'])->name('login_process');

Route::get('logout', function () {
    session()->forget('FRONT_USER_LOGIN');
    session()->forget('FRONT_USER_ID');
    session()->forget('FRONT_USER_NAME');
    // session()->forget('USER_TEMP_ID');
    return redirect('/');
})->name('logout');

Route::get('verification/{rand_id}', [FrontendController::class, 'email_verification'])->name('email_verification');

Route::get('forgot_password_change/{rand_id}', [FrontendController::class, 'forgot_password_change'])->name('forgot_password_change');

Route::post('forgot_password', [FrontendController::class, 'forgot_password'])->name('forgot_password');

Route::post('forgot_password_change_process', [FrontendController::class, 'forgot_password_change_process'])->name('forgot_password_change_process');

Route::post('apply_coupon_code', [FrontendController::class, 'apply_coupon_code'])->name('apply_coupon_code');

Route::post('remove_coupon_code', [FrontendController::class, 'remove_coupon_code'])->name('remove_coupon_code');

Route::post('place_order', [FrontendController::class, 'place_order'])->name('place_order');

Route::get('order_placed', [FrontendController::class, 'order_placed'])->name('order_placed');

Route::get('order_failed', [FrontendController::class, 'order_failed'])->name('order_failed');

Route::get('instamojo_payment_redirect', [FrontendController::class, 'instamojo_payment_redirect'])->name('instamojo_payment_redirect');

Route::post('product_review_process', [FrontendController::class, 'product_review_process'])->name('product_review_process');

Route::group(['middleware' => 'user_auth'], function () {

    Route::get('order', [FrontendController::class, 'order'])->name('order');

    Route::get('order_details/{id}', [FrontendController::class, 'order_details'])->name('order_details');
});

Route::get('admin', [AdminController::class, 'index']);
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::group(['middleware' => 'admin_auth'], function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/order', [OrderController::class, 'index'])->name('admin.order');

    Route::get('admin/order_details/{id}', [OrderController::class, 'order_details'])->name('admin.order_details');

    Route::post('admin/order_details/{id}', [OrderController::class, 'update_track_details'])->name('admin.update_track_details');

    Route::get('admin/update_payment_status/{status}/{id}', [OrderController::class, 'update_payment_status'])->name('admin.update_payment_status');

    Route::get('admin/update_order_status/{status}/{id}', [OrderController::class, 'update_order_status'])->name('admin.update_order_status');

    Route::get('admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('admin/category/manage_category', [CategoryController::class, 'manage_category'])->name('admin.manage_category');
    Route::get('admin/category/manage_category/{category_id}', [CategoryController::class, 'manage_category'])->name('admin.edit_manage_category');
    Route::post('admin/category/manage_category_process', [CategoryController::class, 'manage_category_process'])->name('category.manage_category_process');
    Route::get('admin/category/delete/{category_id}', [CategoryController::class, 'delete_category'])->name('category.delete_category');
    Route::get('admin/category/status/{status}/{category_id}', [CategoryController::class, 'category_status'])->name('category.category_status');

    Route::get('admin/coupon', [CouponController::class, 'index'])->name('admin.coupon');
    Route::get('admin/coupon/manage_coupon', [CouponController::class, 'manage_coupon'])->name('admin.manage_coupon');
    Route::get('admin/coupon/manage_coupon/{coupon_id}', [CouponController::class, 'manage_coupon'])->name('admin.edit_manage_coupon');
    Route::post('admin/coupon/manage_coupon_process', [CouponController::class, 'manage_coupon_process'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{coupon_id}', [CouponController::class, 'delete_coupon'])->name('coupon.delete_coupon');
    Route::get('admin/coupon/status/{status}/{coupon_id}', [CouponController::class, 'coupon_status'])->name('coupon.coupon_status');

    Route::get('admin/size', [SizeController::class, 'index'])->name('admin.size');
    Route::get('admin/size/manage_size', [SizeController::class, 'manage_size'])->name('admin.manage_size');
    Route::get('admin/size/manage_size/{size_id}', [SizeController::class, 'manage_size'])->name('admin.edit_manage_size');
    Route::post('admin/size/manage_size_process', [SizeController::class, 'manage_size_process'])->name('size.manage_size_process');
    Route::get('admin/size/delete/{size_id}', [SizeController::class, 'delete_size'])->name('size.delete_size');
    Route::get('admin/size/status/{status}/{size_id}', [SizeController::class, 'size_status'])->name('size.size_status');

    Route::get('admin/color', [ColorController::class, 'index'])->name('admin.color');
    Route::get('admin/color/manage_color', [ColorController::class, 'manage_color'])->name('admin.manage_color');
    Route::get('admin/color/manage_color/{color_id}', [ColorController::class, 'manage_color'])->name('admin.edit_manage_color');
    Route::post('admin/color/manage_color_process', [ColorController::class, 'manage_color_process'])->name('color.manage_color_process');
    Route::get('admin/color/delete/{color_id}', [ColorController::class, 'delete_color'])->name('color.delete_color');
    Route::get('admin/color/status/{status}/{color_id}', [ColorController::class, 'color_status'])->name('color.color_status');

    Route::get('admin/brand', [BrandController::class, 'index'])->name('admin.brand');
    Route::get('admin/brand/manage_brand', [BrandController::class, 'manage_brand'])->name('admin.manage_brand');
    Route::get('admin/brand/manage_brand/{brand_id}', [BrandController::class, 'manage_brand'])->name('admin.edit_manage_brand');
    Route::post('admin/brand/manage_brand_process', [BrandController::class, 'manage_brand_process'])->name('brand.manage_brand_process');
    Route::get('admin/brand/delete/{brand_id}', [BrandController::class, 'delete_brand'])->name('brand.delete_brand');
    Route::get('admin/brand/status/{status}/{brand_id}', [BrandController::class, 'brand_status'])->name('brand.brand_status');

    Route::get('admin/tax', [TaxController::class, 'index'])->name('admin.tax');
    Route::get('admin/tax/manage_tax', [TaxController::class, 'manage_tax'])->name('admin.manage_tax');
    Route::get('admin/tax/manage_tax/{tax_id}', [TaxController::class, 'manage_tax'])->name('admin.edit_manage_tax');
    Route::post('admin/tax/manage_tax_process', [TaxController::class, 'manage_tax_process'])->name('tax.manage_tax_process');
    Route::get('admin/tax/delete/{tax_id}', [TaxController::class, 'delete_tax'])->name('tax.delete_tax');
    Route::get('admin/tax/status/{status}/{tax_id}', [TaxController::class, 'tax_status'])->name('tax.tax_status');

    Route::get('admin/product_review', [ProductReviewController::class, 'product_review'])->name('admin.product_review');
    Route::get('admin/update_product_review/status/{status}/{product_id}', [ProductReviewController::class, 'update_product_review'])->name('admin.update_product_review');

    Route::get('admin/product', [ProductController::class, 'index'])->name('admin.product');
    Route::get('admin/product/manage_product', [ProductController::class, 'manage_product'])->name('admin.manage_product');
    Route::get('admin/product/manage_product/{product_id}', [ProductController::class, 'manage_product'])->name('admin.edit_manage_product');
    Route::post('admin/product/manage_product_process', [ProductController::class, 'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{product_id}', [ProductController::class, 'delete_product'])->name('product.delete_product');
    Route::get('admin/product/product_attr_delete/{product_attribute_id}/{product_id}', [ProductController::class, 'product_attr_delete'])->name('product.product_attr_delete');
    Route::get('admin/product/product_images_delete/{paid}/{pid}', [ProductController::class, 'product_images_delete']);
    Route::get('admin/product/status/{status}/{product_id}', [ProductController::class, 'product_status'])->name('product.product_status');

    Route::get('admin/customer', [CustomerController::class, 'index'])->name('admin.customer');
    Route::get('admin/customer/show/{customer_id}', [CustomerController::class, 'show'])->name('admin.show_customer');
    Route::get('admin/customer/status/{status}/{customer_id}', [CustomerController::class, 'customer_status'])->name('customer.customer_status');

    Route::get('admin/home_banner', [HomeBannerController::class, 'index'])->name('admin.home_banner');
    Route::get('admin/home_banner/manage_home_banner', [HomeBannerController::class, 'manage_home_banner'])->name('admin.manage_home_banner');
    Route::get('admin/home_banner/manage_home_banner/{home_banner_id}', [HomeBannerController::class, 'manage_home_banner'])->name('admin.edit_manage_home_banner');
    Route::post('admin/home_banner/manage_home_banner_process', [HomeBannerController::class, 'manage_home_banner_process'])->name('home_banner.manage_home_banner_process');
    Route::get('admin/home_banner/delete/{home_banner_id}', [HomeBannerController::class, 'delete_home_banner'])->name('home_banner.delete_home_banner');
    Route::get('admin/home_banner/status/{status}/{home_banner_id}', [HomeBannerController::class, 'home_banner_status'])->name('home_banner.home_banner_status');

    // Route::get('admin/updatePassword', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', 'Your session has been ended. Successfully Logout!');
        return redirect('admin');
    })->name('admin.logout');
});

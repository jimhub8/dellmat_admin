<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', 'Mobile\ProductController');


Route::get('scroll_products', 'Mobile\ProductController@scroll_products')->name('scroll_products');



Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');
    // Route::get('signup/activate/{token}', 'Api\AuthController@signupActivate');
    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
    });
});

Route::post('seller_register', 'Seller\Auth\RegisterController@store')->name('store');

Route::post('couponApply', 'Api\CouponController@couponApply')->name('couponApply');

Route::get('couponSes', 'Api\CartController@couponSes')->name('couponSes');
Route::resource('order_address', 'Api\OrdershippingController');

Route::get('/', 'Api\HomeController@index');
Route::resource('products', 'Api\ProductController');
Route::resource('wish', 'Api\WishController');
Route::resource('reviews', 'Api\ReviewController');
Route::resource('attributes', 'Api\AttributeController');
Route::resource('product_attribute', 'Api\ProductAttributeController');
Route::resource('attribute_value', 'Api\AttributeValueController');
Route::resource('address', 'Api\AddressController');
Route::resource('shipping', 'Api\ShippingaddressController');
Route::resource('billing', 'Api\BillingaddressController');
Route::resource('slider', 'Api\SliderController');
Route::resource('wish', 'Api\WishController');

Route::get('/ecommerce', 'Api\HomeController@ecommerce')->name('ecommerce')->middleware('verified');
Route::get('/getReviews/{id}', 'Api\ReviewController@getReviews')->name('getReviews');

Route::get('/category_products/{category}', 'Api\ProductController@category_products')->name('category_products');
Route::get('/category/{category}', 'Api\CategoryController@category')->name('category');


Route::get('/all_products', 'Api\ProductController@all_products')->name('all_products');
Route::get('/onSale', 'Api\ProductController@onSale')->name('onSale');

Route::get('/getsP', 'Api\SliderController@getsP')->name('getsP');
Route::get('/getTP', 'Api\SliderController@getTP')->name('getTP');
Route::get('/getTPN', 'Api\SliderController@getTPN')->name('getTPN');
Route::get('/headerPro', 'Api\SliderController@headerPro')->name('headerPro');

Route::get('/bestSellF', 'Api\SliderController@bestSellF')->name('bestSellF');
Route::get('/bestSellA', 'Api\SliderController@bestSellA')->name('bestSellA');
Route::get('/featuredF', 'Api\SliderController@featuredF')->name('featuredF');
Route::get('/featuredA', 'Api\SliderController@featuredA')->name('featuredA');
Route::get('/newProF', 'Api\SliderController@newProF')->name('newProF');
Route::get('/newProA', 'Api\SliderController@newProA')->name('newProA');

Route::post('/cart/{id}', 'Api\CartController@addToCart')->name('addToCart');
Route::get('/getCart', 'Api\CartController@getCart')->name('getCart');
Route::post('/update_cart/{id}', 'Api\CartController@update_cart')->name('update_cart');
Route::post('/cartAdd/{id}', 'Api\CartController@cartAdd')->name('cartAdd');
Route::post('/flashCart/{id}', 'Api\CartController@flashCart')->name('flashCart');
Route::get('/getCartProduct', 'Api\CartController@getCartProduct')->name('getCartProduct');
Route::get('/cart_total', 'Api\CartController@cart_total')->name('cart_total');
Route::get('/cart_count', 'Api\CartController@cart_count')->name('cart_count');

Route::get('/getProducts', 'Api\ProductController@getProducts')->name('getProducts');
Route::post('/product_image/{id}', 'Api\ProductController@product_image')->name('product_image');
Route::post('/proImg/{id}', 'Api\ProductController@proImg')->name('proImg');
Route::get('/featured', 'Api\ProductController@featured')->name('featured');
Route::get('/bestSell', 'Api\ProductController@bestSell')->name('bestSell');
Route::get('/newProduct', 'Api\ProductController@newProduct')->name('newProduct');
Route::post('/search', 'Api\ProductController@search')->name('search');
Route::post('/searchProduct', 'Api\ProductController@searchProduct')->name('searchProduct');

Route::get('/related/{id}', 'Api\ProductController@related')->name('related');


Route::post('/searchItems/{search}', 'Api\ProductController@searchItems')->name('searchItems');

Route::post('/filterProduct/{id}', 'Api\FilterController@filterProduct')->name('filterProduct');
Route::post('/FilterShop', 'Api\FilterController@FilterShop')->name('FilterShop');
Route::post('/filterItem', 'Api\FilterController@filterItem')->name('filterItem');


Route::post('/NotyOrder/{id}', 'Api\NotificationController@NotyOrder')->name('NotyOrder');
Route::post('/read', 'Api\NotificationController@read')->name('read');
Route::get('/Chattynoty', 'Api\NotificationController@Chattynoty')->name('Chattynoty');
Route::get('/notifications', 'Api\NotificationController@notifications')->name('notifications');

Route::resource('brands', 'Api\BrandController');
Route::resource('subcategories', 'Api\SubcategoryController');
Route::resource('categories', 'Api\CategoryController');
Route::resource('menu', 'Api\MenuController');

Route::get('ratings/{id}', 'Api\ReviewController@ratings')->name('ratings');
Route::post('rate/{id}', 'Api\ReviewController@rate')->name('rate');
Route::get('bestRated', 'Api\ReviewController@bestRated')->name('bestRated');

Route::get('subcategory/{id}', 'Api\SubcategoryController@subcategory')->name('subcategory');


Route::get('category/{id}', 'Api\CategoryController@category')->name('category');
Route::get('catLimit', 'Api\CategoryController@catLimit')->name('catLimit');



Route::get('show_product/{id}', 'Api\ProductController@show_product')->name('show_product');

Route::post('createpayment', 'Api\PaymentController@create')->name('create');
Route::get('execute-payment', 'Api\PaymentController@execute')->name('execute');
Route::post('cash_delivery', 'Api\PaymentController@cash_delivery')->name('cash_delivery');
Route::get('/clientOrders', 'Api\SaleController@clientOrders')->name('clientOrders');
Route::resource('clients', 'Api\ClientController');
Route::any('invoice/{id}', 'Api\InvoiceController@invoice')->name('invoice');
Route::resource('coupons', 'Api\CouponController');
Route::resource('sizes', 'Api\SizeController');
Route::resource('images', 'Api\ProductimgController');
Route::resource('sales', 'Api\SaleController');

Route::get('/logoutOther', 'Api\UserController@logoutOther')->name('logoutOther');
Route::post('/logOtherDevices', 'Api\UserController@logOtherDevices')->name('logOtherDevices');

Route::get('/getUsersCount', 'Api\UserController@getUsersCount')->name('getUsersCount');

Route::resource('orders', 'Api\OrderController');
Route::resource('aboutus', 'Api\AboutController');

Route::post('/StatusItem/{id}', 'Api\ProductController@StatusItem')->name('StatusItem');


Route::get('/home', 'Api\HomeController@index')->name('home');
Route::post('/filterItems', 'Api\FilterController@filterItems')->name('filterItems');

Route::get('/pay', 'Api\OrderController@pay')->name('pay');

Route::any('apiGet', 'Api\CarouselController@apiGet')->name('apiGet');


// Unique
Route::post('/searchItems/{search}', 'Api\ProductController@searchItems')->name('searchItems');
Route::post('/filterproducts', 'Api\ProductController@filterproducts')->name('filterproducts');
Route::get('/randomSku', 'Api\ProductController@randomSku')->name('randomSku');
Route::post('/filterProd_table', 'Api\ProductController@filterProd_table')->name('filterProd_table');

Route::get('/product_setting', 'Api\ProductController@product_setting')->name('product_setting');
Route::get('/shop', 'Api\ProductController@shop')->name('shop');

Route::get('product_variant/{id}', 'Api\VariantController@product_variant')->name('product_variant');
Route::post('variants_values/{id}', 'Api\SkuController@variants_values')->name('variants_values');

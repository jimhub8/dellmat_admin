<?php

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

Route::get('upload', function() {
    $files = Storage::disk('spaces')->files('uploads');

    return view('upload', compact('files'));
});

Route::post('upload', function() {
    Storage::disk('spaces')->putFile('uploads', request()->file, 'public');

    return redirect()->back();
});

Auth::routes(['verify' => true]);

Auth::routes();
Route::group(['middleware' => ['authcheck']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('products', 'ProductController');
    Route::resource('sales', 'SaleController');
    Route::resource('clients', 'ClientController');
    Route::resource('groups', 'GroupController');
    Route::resource('drawers', 'DrawerController');
    Route::resource('discounts', 'OfferController');
    Route::resource('variants', 'VariantController');
    Route::resource('sku', 'SkuController');
    Route::resource('menu', 'MenuController');
    Route::resource('categories', 'CategoryController');
    Route::resource('subcategories', 'SubcategoryController');
    Route::resource('brands', 'BrandController');
    Route::resource('images', 'ImageController');
    Route::resource('slider', 'SliderController');
    Route::resource('currencies', 'CurrencyController');
    Route::resource('order_address', 'OrdershippingController');
    Route::resource('statuses', 'StatusController');
    Route::resource('withdrawals', 'WithdrawController');
    Route::resource('product_options', 'OptionController');


    Route::post('status_update/{id}', 'StatusController@status_update')->name('status_update');


    Route::post('filter_withdrawals', 'WithdrawController@filter_withdrawals')->name('filter_withdrawals');


    Route::post('images/{id}', 'ImageController@images')->name('images');
    Route::post('product_image/{id}', 'ImageController@product_image')->name('product_image');

    Route::get('product_search/{search}', 'ProductController@product_search')->name('product_search');

    Route::get('client_search/{search}', 'ClientController@client_search')->name('client_search');

    Route::get('product_table', 'ProductController@product_table')->name('product_table');

    Route::get('options', 'VariantController@options')->name('options');
    Route::get('option_values', 'VariantController@option_values')->name('option_values');
    Route::get('product_variant/{id}', 'VariantController@product_variant')->name('product_variant');
    Route::get('variant_sku/{id}', 'VariantController@variant_sku')->name('variant_sku');

    Route::post('variants_values/{id}', 'SkuController@variants_values')->name('variants_values');

    Route::get('unique_sku/{id}', 'AutoGenerateController@unique_sku')->name('unique_sku');

    Route::get('permissions', 'RoleController@permissions')->name('permissions');
    Route::post('getRolesPerm/{id}', 'RoleController@getRolesPerm')->name('getRolesPerm');


    Route::post('getUserPerm/{id}', 'UserController@getUserPerm')->name('getUserPerm');
    Route::post('permisions/{id}', 'UserController@permisions')->name('permisions');
    Route::patch('undeletedUser/{id}', 'UserController@undeletedUser')->name('undeletedUser');
    Route::delete('force_user/{id}', 'UserController@force_user')->name('force_user');
    Route::get('deletedUsers', 'UserController@deletedUsers')->name('deletedUsers');


    Route::post('featured', 'ProductSettingsController@featured')->name('featured');
    Route::post('newproduct', 'ProductSettingsController@newproduct')->name('newproduct');
    Route::post('bestsellers', 'ProductSettingsController@bestsellers')->name('bestsellers');


    Route::post('product_settings', 'ProductSettingsController@product_settings')->name('product_settings');



    // Dashboard
    Route::any('user_count', 'DashboardController@user_count')->name('user_count');
    Route::any('clients_count', 'DashboardController@clients_count')->name('clients_count');
    Route::any('week_sales_count', 'DashboardController@week_sales_count')->name('week_sales_count');
    Route::any('sellers_count', 'DashboardController@sellers_count')->name('sellers_count');
    Route::any('total_sales_count', 'DashboardController@total_sales_count')->name('total_sales_count');

    // Charts
    Route::any('clients_chart', 'DashboardController@clients_chart')->name('clients_chart');
    Route::any('sellers_chart', 'DashboardController@sellers_chart')->name('sellers_chart');
    Route::any('sales_chart', 'DashboardController@sales_chart')->name('sales_chart');

    Route::any('product_count', 'DashboardController@product_count')->name('product_count');
    Route::any('category_count', 'DashboardController@category_count')->name('category_count');
    Route::any('brand_count', 'DashboardController@brand_count')->name('brand_count');

    // Seller Dashboard
    Route::any('week_total_sales_income', 'DashboardController@week_total_sales_income')->name('week_total_sales_income');
    Route::any('week_sold_items', 'DashboardController@week_sold_items')->name('week_sold_items');
    Route::any('week_orders', 'DashboardController@week_orders')->name('week_orders');




});


Route::get('passport', function() {

    return view('passport.index');
});

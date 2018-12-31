<?php

$router->get('/', function () use ($router) {
    return view('welcome', ['version' => $router->app->version()]);
});

/* Admin Login, Profile */
$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->post('login', 'Admin\AuthController@auth');
    $router->get('profile', 'Admin\ProfileController@show');
    $router->put('profile', 'Admin\ProfileController@update');
    $router->post('profile/upload-image', 'Admin\ProfileController@uploadImage');
    $router->put('profile/change-password', 'Admin\ProfileController@changePassword');
});

/**
 * Customer Login, Register, Profile 
 */
$router->post('register', 'Customer\AuthController@register');
$router->post('login', 'Customer\AuthController@login');
$router->get('profile', 'Customer\ProfileController@show');
$router->put('profile', 'Customer\ProfileController@update');
$router->post('profile/upload-image', 'Customer\ProfileController@uploadImage');
$router->put('profile/change-password', 'Customer\ProfileController@changePassword');
$router->get('customers', 'Admin\CustomerController@index'); # ADMIN ONLY, show all customers

/**
 *  Category Route 
 */
$router->get('category', 'CategoryController@index');
$router->get('category/{id}', 'CategoryController@show');
$router->post('category', 'CategoryController@create');
$router->put('category/{id}', 'CategoryController@update');
$router->delete('category/{id}', 'CategoryController@delete');

/**
 *  Sub Category Route 
 */
$router->get('subcategory', 'SubCategoryController@index');
$router->get('subcategory/category/{id}', 'SubCategoryController@showCategory');
$router->get('subcategory/{id}', 'SubCategoryController@show');
$router->post('subcategory', 'SubCategoryController@create');
$router->put('subcategory/{id}', 'SubCategoryController@update');
$router->delete('subcategory/{id}', 'SubCategoryController@delete');
$router->post('subcategory/upload-image', 'SubCategoryController@uploadImage');

/**
 *  Brand Route
 */
$router->get('brand', 'BrandController@index');
$router->get('brand/{id}', 'BrandController@show');
$router->post('brand', 'BrandController@create');
$router->put('brand/{id}', 'BrandController@update');
$router->delete('brand/{id}', 'BrandController@delete');

/**
 *  Product Route 
 */
$router->get('product', 'ProductController@index');
$router->get('product/{id}', 'ProductController@show');
$router->get('product/category/{idCategory}', 'ProductController@sort'); 
$router->post('product', 'ProductController@create');
$router->put('product/{id}', 'ProductController@update');
$router->delete('product/{id}', 'ProductController@delete');
$router->post('product/upload-image', 'ProductController@uploadImage');
$router->post('product/upload-sheet', 'ProductController@import');

/**
 * Province, City and Onkir, Courier
 */
$router->get('province', 'OngkirController@province');
$router->get('city', 'OngkirController@city');
$router->get('cost', 'OngkirController@cost');
$router->get('courier', 'OngkirController@courier');

/**
 *  Bank 
 */
$router->get('bank', 'BankController@index');
$router->get('bank/{id}', 'BankController@show');
$router->post('bank', 'BankController@create');
$router->put('bank/{id}', 'BankController@update');
$router->delete('bank/{id}', 'BankController@delete');

/**
 * Cart
 */
$router->get('cart', 'Customer\CartController@show');
$router->post('cart', 'Customer\CartController@addToCart');
$router->delete('cart/{idItem}', 'Customer\CartController@delete');

/**
 * Shippings
 */
$router->get('shipping', 'Customer\ShippingController@show');
$router->post('shipping', 'Customer\ShippingController@post');

/**
 * Checkout
 */
$router->get('checkout', 'Customer\CheckoutController@checkout');
$router->get('checkout/process', 'Customer\CheckoutController@process');

/**
 * Order
 * for customer (check unpaid order, confirmed order, shipped order)
 */
# for customers :
$router->get('order/unpaid', 'Customer\OrderController@unpaid');
$router->get('order/waiting-confirm', 'Customer\OrderController@waitingConfirm');
$router->get('order/onprocess', 'Customer\OrderController@onProcess');
$router->get('order/onshipping', 'Customer\OrderController@onShipping');
$router->get('order/confirm-received', 'Customer\OrderController@received');
$router->get('order/history', 'Customer\OrderController@history');
# for admins :
$router->get('order/unconfirmed', 'Admin\OrderController@unconfirmed');
$router->get('order/confirm', 'Admin\OrderController@confirm');
$router->get('order/waiting-shipping', 'Admin\OrderController@processed');
$router->get('order/shipping', 'Admin\OrderController@onShipping');
$router->post('order/confirm-shipping', 'Admin\OrderController@confirmShipping');
$router->get('order/show-success', 'Admin\OrderController@success');

/**
 * Payment Confirm
 * Confirm payment for customers
 * Confirm payment for admin
 */
$router->post('confirm', 'Customer\PaymentController@confirmCustomer'); # customer
$router->get('payment/{id:[0-9]+}', 'Admin\PaymentController@show'); # admin & customer
$router->get('payment/unconfirmed', 'Admin\PaymentController@unconfirmed'); # admin


$router->get('count', 'Admin\CountController@count');

$router->post('sheet', 'SpreadsheetTestController@import');
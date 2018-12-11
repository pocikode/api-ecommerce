<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/* Admin Login, Profile */
$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->post('login', 'Admin\AuthController@auth');
    $router->get('profile', 'Admin\ProfileController@show');
    $router->put('profile', 'Admin\ProfileController@update');
});

/**
 * Customer Login, Register, Profile 
 */
$router->post('register', 'Customer\AuthController@register');
$router->post('login', 'Customer\AuthController@login');
$router->get('profile', 'Customer\ProfileController@show');
$router->put('profile', 'Customer\ProfileController@update');

$router->get('customers', 'Admin\CustomerController@index'); # ADMIN ONLY

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
# to sort with sub category, add idSub parameter, ex : http://{api_url}/product/category/{idCategory}?idSub={idSub}
$router->post('product', 'ProductController@create');
$router->put('product/{id}', 'ProductController@update');
$router->delete('product/{id}', 'ProductController@delete');
$router->post('product/upload-image', 'ProductController@uploadImage');

/**
 * Province, City and Onkir
 */
$router->get('province', 'OngkirController@province');
$router->get('city', 'OngkirController@city');
$router->get('ongkir', 'OngkirController@cost');

/**
 *  Courier 
 */
$router->get('courier', 'CourierController@index');
$router->get('courier/{id}', 'CourierController@show');
$router->post('courier', 'CourierController@create');
$router->put('courier/{id}', 'CourierController@update');
$router->delete('courier/{id}', 'CourierController@delete');

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
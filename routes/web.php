<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/* ADMIN PREFIX ROUTE */
$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->post('login', 'Admin\AuthController@auth');
    $router->get('profile', 'Admin\AuthController@profile'); # TODO: TEST ONLY
});

/* Customer AUth */
$router->post('register', 'Customer\AuthController@register');
$router->post('login', 'Customer\AuthController@login');
$router->get('profile', 'Customer\AuthController@profile'); # FIXME: TEST ONLY

$router->get('customers', 'Admin\CustomerController@index'); # ADMIN ONLY

/* Category Route */
$router->get('category', 'CategoryController@index');
$router->get('category/{id}', 'CategoryController@show');
$router->post('category', 'CategoryController@create');
$router->put('category/{id}', 'CategoryController@update');
$router->delete('category/{id}', 'CategoryController@delete');

/* Sub Category Route */
$router->get('subcategory', 'SubCategoryController@index');
$router->get('subcategory/category/{id}', 'SubCategoryController@showCategory');
$router->get('subcategory/{id}', 'SubCategoryController@show');
$router->post('subcategory', 'SubCategoryController@create');
$router->put('subcategory/{id}', 'SubCategoryController@update');
$router->delete('subcategory/{id}', 'SubCategoryController@delete');

/* Brand Route */
$router->get('brand', 'BrandController@index');
$router->get('brand/{id}', 'BrandController@show');
$router->post('brand', 'BrandController@create');
$router->put('brand/{id}', 'BrandController@update');
$router->delete('brand/{id}', 'BrandController@delete');

/* Product Route */
$router->get('product', 'ProductController@index');
$router->get('product/{id}', 'ProductController@show');
$router->get('product/category/{idCategory}', 'ProductController@sort'); 
# to sort with sub category, add idSub parameter, ex : http://{api_url}/product/category/{idCategory}?idSub={idSub}
$router->post('product', 'ProductController@create');
$router->put('product/{id}', 'ProductController@update');
$router->delete('product/{id}', 'ProductController@delete');

/**
 * Province, City and Onkir
 */
$router->get('province', 'OngkirController@province');
$router->get('city', 'OngkirController@city');
$router->get('ongkir', 'OngkirController@cost');

/* Courier */
$router->get('courier', 'CourierController@index');
$router->get('courier/{id}', 'CourierController@show');
$router->post('courier', 'CourierController@create');
$router->put('courier/{id}', 'CourierController@update');
$router->delete('courier/{id}', 'CourierController@delete');

/* Bank */
$router->get('bank', 'BankController@index');
$router->get('bank/{id}', 'BankController@show');
$router->post('bank', 'BankController@create');
$router->put('bank/{id}', 'BankController@update');
$router->delete('bank/{id}', 'BankController@delete');
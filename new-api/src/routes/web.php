<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// $router->group(['prefix' => 'api/v1/testing'], function() use ($router){
//     $router->get('/', ['uses' => 'UserController@index']);
// 	$router->post('/', ['uses' => 'UserController@create ']);
// 	$router->get('/{id}', ['uses' => 'UserController@show']);
// 	$router->delete('/{id}', ['uses' => 'UserController@destroy']);
// 	$router->put('/{id}', ['uses' => 'UserController@update']);
// });

$router->group(['prefix' => 'api/v1/testing', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', ['uses' => 'UserController@index']);
});

$router->group(['prefix' => 'api/v1/customer', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', ['uses' => 'CustomerController@index']);
    $router->post('/', ['uses' => 'CustomerController@store']);
    $router->get('/{id}', ['uses' => 'CustomerController@show']);
    $router->put('/{id}', ['uses' => 'CustomerController@edit']);
    $router->delete('/{id}', ['uses' => 'CustomerController@destroy']);
});

$router->group(['prefix' => 'api/v1/product', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', ['uses' => 'ProductController@index']);
    $router->post('/', ['uses' => 'ProductController@store']);
    $router->get('/{id}', ['uses' => 'ProductController@show']);
    $router->put('/{id}', ['uses' => 'ProductController@edit']);
    $router->delete('/{id}', ['uses' => 'ProductController@destroy']);
});

$router->group(['prefix' => 'api/v1/order', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', ['uses' => 'OrderController@index']);
    $router->post('/', ['uses' => 'OrderController@store']);
    $router->get('/{id}', ['uses' => 'OrderController@show']);
    $router->put('/{id}', ['uses' => 'OrderController@edit']);
    $router->delete('/{id}', ['uses' => 'OrderController@destroy']);
});

$router->group(['prefix' => 'api/v1/orderitem', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', ['uses' => 'OrderItemController@index']);
    $router->post('/', ['uses' => 'OrderItemController@add']);
    $router->get('/{id}', ['uses' => 'OrderItemController@show']);
    $router->delete('/{id}', ['uses' => 'OrderItemController@delete']);
    $router->put('/{id}', ['uses' => 'OrderItemController@update']);
});

$router->group(['prefix' => 'api/v1/orderitem-join', 'middleware' => 'auth'], function() use ($router) {
    $router->get('/', ['uses' => 'OrderItemController@showDataJoin']);
    $router->get('/{id}', ['uses' => 'OrderItemController@showIdJoin']);
});


// $router->group(['prefix' => 'api/v1/product', 'middleware' => 'auth'], function() use ($router) {
//     $router->get('/', ['uses' => 'ProductController@index']);
//     $router->post('/add', ['uses' => 'ProductController@store']);
//     $router->get('/{id}', ['uses' => 'ProductController@show']);
//     $router->delete('/{id}', ['uses' => 'ProductController@destroy']);
//     $router->put('/{id}', ['uses' => 'ProductController@update']);
// });

// $router->group(['prefix' => 'api/v1/transaction', 'middleware' => 'auth'], function() use ($router) {
//     $router->get('/', ['uses' => 'TransactionController@index']);
//     $router->post('/add', ['uses' => 'TransactionController@store']);
//     $router->get('/{id}', ['uses' => 'TransactionController@show']);
//     $router->put('/{id}', ['uses' => 'TransactionController@update']);
// });

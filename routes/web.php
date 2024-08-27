<?php

// use cart controller
use App\Http\Controllers\CartController;
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


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('carts', 'CartController@index');
    $router->post('carts', 'CartController@create');
    $router->post('carts/{cartId}/items', 'CartController@addItem');
    $router->get('carts/{cartId}', 'CartController@getCart');
    $router->delete('carts/{cartId}/items/{itemId}', 'CartController@removeItem');
});

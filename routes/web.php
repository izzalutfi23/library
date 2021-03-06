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


$router->post('/register', 'Authcontroller@register');
$router->post('/login', 'Authcontroller@login');

$router->group(['middleware' => 'auth'], function() use($router){
    $router->get('/getkategori', 'Kategoricontroller@getkategori');
    $router->get('/getarsip', 'Arsipcontroller@getarsip');
    $router->post('/postarsip', 'Arsipcontroller@store');
    $router->post('/editarsip', 'Arsipcontroller@update');
    $router->post('/destroy', 'Arsipcontroller@destroy');
    $router->post('logout','Authcontroller@logoutApi');
});
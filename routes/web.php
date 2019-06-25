<?php

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

$router->post('/user/login', ['uses' => 'UsersController@getToken']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/mensaje', ['uses' => 'MensajeController@mensaje']);

$router->get('/key', function(){
    return str_random(32);
});

$router->group(['middleware'=>['auth']], function() use ($router){
    $router->get('/user', ['uses' => 'UsersController@index']);

    $router->get('/roles', 'UsersController@test');
    $router->get('/user/{id}', ['uses' => 'UsersController@getUser']);
    $router->post('/user', ['uses' => 'UsersController@createUser']);
    $router->put('/user', ['uses' => 'UsersController@updateUser']);
    $router->delete('/user', ['uses' => 'UsersController@deleteUser']);
});

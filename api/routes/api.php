<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//login routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');
});

Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/user', 'UserController@loggedUser');
  $router->get('/users', 'UserController@index');
  $router->get('/users/{id}', 'UserController@getById');
  $router->post('/users', 'UserController@create');
  $router->delete('/users/{id}', 'UserController@delete');
});

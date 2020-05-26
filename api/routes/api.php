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

//user routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/user', 'UserController@loggedUser');
  $router->get('/users', 'UserController@index');
  $router->get('/users/{id}', 'UserController@getById');
  $router->post('/users', 'UserController@create');
  $router->patch('/users/{id}', 'UserController@update');
  $router->delete('/users/{id}', 'UserController@delete');
});

//department routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/departments', 'DepartmentController@index');
});


//role routes
Route::group(['middleware' => 'check-token'], function($router){
  $router->get('/roles', 'RoleController@index');
});

//position routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/positions', 'PositionController@index');
});

//applicant routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/applicants', 'ApplicantController@index');
  $router->post('/applicants', 'ApplicantController@create');
});

//recruitment routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/recruitments', 'RecruitmentController@index');
  $router->get('/recruitments/{id}', 'RecruitmentController@getById');
  $router->post('/recruitments', 'RecruitmentController@create');
  $router->delete('/recruitments/{id}', 'RecruitmentController@delete');
});


//payroll routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->post('/payrolls', 'PayrollController@create');
});

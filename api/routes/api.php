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
  $router->get('/departments/{id}', 'DepartmentController@getById');
  $router->post('/departments', 'DepartmentController@create');
  $router->patch('/departments/{id}', 'DepartmentController@update');
  $router->delete('/departments/{id}', 'DepartmentController@delete');
});


//role routes
Route::group(['middleware' => 'check-token'], function($router){
  $router->get('/roles', 'RoleController@index');
});

//position routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/positions', 'PositionController@index');
  $router->get('/positions/{id}', 'PositionController@getbyId');
  $router->post('/positions', 'PositionController@create');
  $router->patch('/positions/{id}', 'PositionController@update');
  $router->delete('/positions/{id}', 'PositionController@delete');
});

//applicant routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/applicants', 'ApplicantController@index');
  $router->get('/applicants/{id}', 'ApplicantController@getById');
  $router->post('/applicants', 'ApplicantController@create');
  $router->patch('/applicants/{id}', 'ApplicantController@update');
  $router->delete('/applicants/{id}', 'ApplicantController@delete');

});

//recruitment routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/recruitments', 'RecruitmentController@index');
  $router->get('/recruitments/{id}', 'RecruitmentController@getById');
  $router->post('/recruitments', 'RecruitmentController@create');
  $router->post('/recruitments/{id}', 'RecruitmentController@create');
  $router->patch('/recruitments/{id}', 'RecruitmentController@update');
  $router->delete('/recruitments/{id}', 'RecruitmentController@delete');
});

//recruitment status routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->get('/recruitmentstatus', 'RecruitmentStatusController@index');
});

//payroll routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->post('/payrolls', 'PayrollController@create');
  $router->get('/payrolls', 'PayrollController@index');
  $router->get('/payrolls/{id}', 'PayrollController@getById');
  $router->patch('/payrolls/{id}/{user_id}', 'PayrollController@update');
  $router->delete('/payrolls/{id}', 'PayrollController@delete');
});

//user requests routes
Route::group(['middleware' => 'check-token'], function($router) {
  $router->post('/requests', 'UserRequestController@create');
  $router->get('/requests', 'UserRequestController@index');
  $router->get('/requests/{id}', 'UserRequestController@getById');
  $router->patch('/requests/approve/{id}', 'UserRequestController@approve');
  $router->patch('/requests/deny/{id}', 'UserRequestController@deny');
});

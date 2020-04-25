<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Interfaces\CRUDInterface;
use App\Http\Validation\UserValidation;
use App\Http\Exceptions\ValidationException;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use App\Http\Service\UserService;
use App\Http\Service\UserMetadataService;
use App\User;

class UserController extends Controller implements CRUDInterface
{
    private $userValidation;
    private $userService;
    private $metadataService;

    public function __construct() {
      $this->middleware('api');
      $this->userValidation = new UserValidation();
      $this->userService = new UserService();
      $this->metadataService = new UserMetadataService();
    }

    public function loggedUser(Request $req) {
      return $req->user();
    }

    public function index() {
      return User::get();
    }

    public function getById($id) {
      return User::find($id);
    }
    
    public function update(Request $request){}

    public function create(Request $request) {
      try {
        $this->userValidation->validateCreateUser($request);
      } catch(ValidationException $e) {
        return JsonError::message($e->getMessage());
      }
      $meta_id = $this->metadataService->insert([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'base_salary' => $request->input('base_salary'),
        'street' => $request->input('street'),
        'city' => $request->input('city'),
        'country' => $request->input('country'),
      ]);
      if ($meta_id) {
        try {
          $this->userService->insert([
            'email' => $request->input('email'),
            'department_id' => $request->input('department_id'),
            'metadata_id' => $meta_id,
            'role_id' => $request->input('role_id'),
            'password' => bcrypt($request->input('password'))
          ]);
        } catch(QueryException $e) {
          return JsonError::message('Duplicate entry');
        }
        return JsonSuccess::message('User created');
      }
      return JsonError::message('Something went wrong');
    }

    public function delete($id) {
      try {
        $t = User::find($id)->delete();
        if ($t) {
          return JsonSuccess::message('User deleted');
        }
      }catch(Exception $e) {
        return JsonError::message('Could not delete user, try again later');
      }
      return JsonError::message('Something went wrong');
    }
}

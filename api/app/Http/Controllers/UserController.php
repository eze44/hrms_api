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
use Illuminate\Support\Facades\DB;
use App\User;
USE App\UserMetadata;

class UserController extends Controller implements CRUDInterface
{
    private $userValidation;
    private $userService;

    public function __construct() {
      $this->middleware('api');
      $this->userValidation = new UserValidation();
      $this->userService = new UserService();
    }

    public function loggedUser(Request $req) {
      return $req->user();
    }

    public function index(Request $req) {
        $email_query = $req->query("email");
        $department_query = $req->query("department");
        $role_query = $req->query("role");
        if ($email_query && $department_query && $role_query) {
            return User::whereHas('department', function ($query) use ($department_query) {
                $query->where('id', $department_query);
            })->whereHas('role', function ($query) use ($role_query) {
                $query->where('id', $role_query);
            })->where("email", 'LIKE', $email_query)->simplePaginate(10);
        }
        if ($email_query) {
            return User::where("email", 'LIKE', $email_query)->simplePaginate(10);
        }
        if ($department_query) {
            return User::whereHas('department', function ($query) use ($department_query) {
                $query->where('id', $department_query);
            })->simplePaginate(10);
        }
        if ($role_query) {
            return User::whereHas('role', function ($query) use ($role_query) {
                $query->where('id', $role_query);
            })->simplePaginate(10);
        }

        return User::simplePaginate(10);
    }

    public function getById($id) {
      return User::find($id);
    }

    public function update(Request $request, $id){
      try {
        $update_password = $this->userValidation->validateUpdateUser($request);
      } catch(ValidationException $e) {
        return JsonError::message($e->getMessage());
      }

      $user = User::findOrFail($id);
      $password = $user->getAuthPassword();

      if (empty($user)) {
        return JsonError::message("No data found");
      }
      else {
        if ($update_password == TRUE) {
          DB::table('users')->where('id', $id)->update([
              'first_name' => $request->input('first_name'),
              'last_name' => $request->input('last_name'),
              'base_salary' => $request->input('base_salary'),
              'street' => $request->input('street'),
              'city' => $request->input('city'),
              'country' => $request->input('country'),
              'email' => $request->input('email'),
              'department_id' => $request->input('department_id'),
              'role_id' => $request->input('role_id'),
              'password' => bcrypt($request->input('password'))
          ]);
        }
        else {
          DB::table('users')->where('id', $id)->update([
              'first_name' => $request->input('first_name'),
              'last_name' => $request->input('last_name'),
              'base_salary' => $request->input('base_salary'),
              'street' => $request->input('street'),
              'city' => $request->input('city'),
              'country' => $request->input('country'),
              'email' => $request->input('email'),
              'department_id' => $request->input('department_id'),
              'role_id' => $request->input('role_id')
          ]);
        }

        return JsonSuccess::message("Succesfully updated user with id: ".$id);
      }
    }

    public function create(Request $request) {
        try {
        $this->userValidation->validateCreateUser($request);
        } catch(ValidationException $e) {
            return JsonError::message($e->getMessage());
        }
        try {
            $this->userService->insert([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'street' => $request->input('street'),
                'city' => $request->input('city'),
                'country' => $request->input('country'),
                'base_salary' => $request->input('base_salary'),
                'active' => false,
                'email' => $request->input('email'),
                'department_id' => $request->input('department_id'),
                'role_id' => $request->input('role_id'),
                'password' => bcrypt($request->input('password'))
            ]);
        } catch(QueryException $e) {
            return JsonError::message('Duplicate entry');
        }
        return JsonSuccess::message('User created');
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

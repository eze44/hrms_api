<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index() {
        return Department::all();
    }

    public function getById($id) {
        return Department::find($id);
    }

    public function delete($id) {
        try {
            $d = Department::find($id)->delete();
            if ($d) {
                return JsonSuccess::message('Department deleted');
            }
        } catch(Exception $e) {
            return JsonError::message('Could not delete department, try again later');
        }
            return JsonError::message('Something went wrong');
        }
}

<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use App\Http\Service\DepartmentService;
use App\Http\Exceptions\ValidationException;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    private $departmentService;

    public function __construct() {
        $this->middleware('api');
        $this->departmentService = new DepartmentService();
    }
    
    public function index() {
        return Department::all();
    }

    public function getById($id) {
        return Department::find($id);
    }

    public function create(Request $request)
    {
        try {
            $this->departmentService->insert([
                'name' => $request->input('name')
            ]);
        } catch(QueryException $e) {
            return JsonError::message('Something went wrong');
        }
        return JsonSuccess::message("Department Created");
    }

    public function update(Request $request, $id) {
        $department = Department::findOrFail($id);

        if (empty($department)) {
            return JsonError::message("No data found");
        }
        else {
            try{
                $this->departmentService->update([
                    'name' => $request->input('name')
                ], $id);
            } catch (QueryException $e) {
                return JsonError::message('Duplicate Entry');
            }
            return JsonSuccess::message("Department updated!");
        }
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

<?php

namespace App\Http\Controllers;

use App\Position;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use App\Http\Service\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    private $positionService;

    public function __construct() {
        $this->middleware('api');
        $this->positionService = new PositionService();
    }

    public function index()
    {
        return Position::simplePaginate(10);
    }

    public function getById($id) {
        return Position::find($id);
    }

    public function create(Request $request) {
        try {
            $this->positionService->insert([
                'name' => $request->input('name'),
                'department_id' => $request->input('department_id'),
                'qty' => $request->input('qty')
            ]);
        } catch(QueryException $e) {
            return JsonError::message('Something went wrong');
        }
        return JsonSuccess::message("Position Created");
    }

    public function update(Request $request, $id) {

        $position = Position::findOrFail($id);

        if (empty($position)) {
            return JsonError::message("No data found!");
        }
        else {
            try {
                $this->positionService->update([
                    'name' => $request->input('name'),
                    'department_id' => $request->input('department_id'),
                    'qty' => $request->input('qty')
                ], $id);
            } catch(QueryException $e) {
                return JsonError::message('Something went wrong');
            }
            return JsonSuccess::message("Position updated");
        }
    }

    public function delete($id) {
        try {
            $d = Position::find($id)->delete();
            if ($d) {
                return JsonSuccess::message('Position deleted');
            }
        } catch(Exception $e) {
            return JsonError::message('Could not delete position, try again later');
        }
            return JsonError::message('Something went wrong');
    }

}

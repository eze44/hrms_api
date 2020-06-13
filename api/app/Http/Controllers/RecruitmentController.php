<?php

namespace App\Http\Controllers;

use App\Recruitment;
use Illuminate\Http\Request;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use App\Http\Service\RecruitmentService;


class RecruitmentController extends Controller
{
    private $recruitmentService;

    public function __construct() {
        $this->middleware('api');
        $this->recruitmentService = new RecruitmentService();
    }

    public function index() {
        return Recruitment::all();
    }

    public function getById($id) {
        return Recruitment::find($id);
    }

    public function create(Request $request) {
        try {
            $this->recruitmentService->insert([
                'status_id' => $request->input('status_id'),
                'applicant_id' => $request->input('applicant_id'),
                'notes' => $request->input('notes')
            ]);
        } catch(QueryException $e) {
            return JsonError::message('Something went wrong');
        }
        return JsonSuccess::message("Recruitment Created");
    }

    public function update(Request $request, $id) {
        $recruitment = Recruitment::findOrFail($id);

        if (empty($recruitment)) {
            return JsonError::message("No data found!");
        }
        else {
            try {
                $this->recruitmentService->update([
                    'status_id' => $request->input('status_id'),
                    'applicant_id' => $request->input('applicant_id'),
                    'notes' => $request->input('notes')
                ], $id);
            } catch(QueryException $e) {
                return JsonError::message('Something went wrong');
            }
            return JsonSuccess::message("Recruitment updated");
        }
    }

    public function delete($id) {
        try {
            $d = Recruitment::find($id)->delete();
            if ($d) {
                return JsonSuccess::message('Recruitment deleted');
            }
        } catch(Exception $e) {
            return JsonError::message('Could not delete recruitment, try again later');
        }
            return JsonError::message('Something went wrong');
    }
}

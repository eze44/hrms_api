<?php

namespace App\Http\Controllers;

use App\Http\Service\UserService;
use App\Recruitment;
use App\RecruitmentStatus;
use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use App\Http\Service\RecruitmentService;


class RecruitmentController extends Controller
{
    private $recruitmentService;
    private $userService;

    public function __construct() {
        $this->middleware('api');
        $this->recruitmentService = new RecruitmentService();
        $this->userService = new UserService();
    }

    public function index() {
        return Recruitment::simplePaginate(10);
    }

    public function getById($id) {
        return Recruitment::find($id);
    }

    public function create(Request $request, $id=null) {
        if ($id == null) {
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

        else {
            try {
                $this->recruitmentService->insert([
                    'status_id' => 1,
                    'applicant_id' => $id,
                    'notes' => $request->input('notes')
                ]);
            } catch(QueryException $e) {
                return JsonError::message('Something went wrong');
            }

            return JsonSuccess::message("Recruitment Created");
        }
    }

    public function update(Request $request, $id) {
        $recruitment = Recruitment::findOrFail($id);

        if (empty($recruitment)) {
            return JsonError::message("No data found!");
        }
        else {
            try {
                $status = $request->input('status_id');
                if($status == RecruitmentStatus::$APPROVED_STATUS) {
                    $this->userService->insert([
                        'email' => $recruitment->applicant->personal_email,
                        'department_id' => $recruitment->applicant->position->department_id,
                        'first_name' => $recruitment->applicant->first_name,
                        'last_name' => $recruitment->applicant->last_name,
                        'base_salary' => 0, //this must be agreed salary as an input field
                        'street' => $recruitment->applicant->street,
                        'city' => $recruitment->applicant->city,
                        'country' => $recruitment->applicant->country,
                        'active' => 1,
                        'role_id' => Role::$EMPLOYEE,
                        'password' => bcrypt(User::$DEFAULT_PWD)
                    ]);
                }
                $this->recruitmentService->update([
                    'status_id' => $status,
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
        } catch(\Exception $e) {
            return JsonError::message('Could not delete recruitment, try again later');
        }
            return JsonError::message('Something went wrong');
    }
}

<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Position;
use App\Http\Response\JsonError;
use App\Http\Response\JsonSuccess;
use Illuminate\Http\Request;
use App\Http\Service\ApplicantService;
use App\Http\Validation\ApplicantValidation;
use App\Http\Exceptions\ValidationException;

class ApplicantController extends Controller
{
    private $applicantService;

    public function __construct() {
      $this->middleware('api');
      $this->applicantValidation = new ApplicantValidation();
      $this->applicantService = new ApplicantService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Applicant::get();
    }

    public function getById($id) {
      return Applicant::find($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
          $this->applicantValidation->validateCreate($request);
        } catch(ValidationException $e) {
          return JsonError::message($e->getMessage());
        }

        try {
          $this->applicantService->insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'personal_email' => $request->input('personal_email'),
            'position_id' => $request->input('position_id')
          ]);
        } catch(QueryException $e) {
          return JsonError::message('Something went wrong');
        }
        return JsonSuccess::message('Applicant created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $applicant = Applicant::findOrFail($id);

      try {
        $this->applicantService->update([
          'first_name' => $request->input('first_name'),
          'last_name' => $request->input('last_name'),
          'personal_email' => $request->input('personal_email'),
          'position_id' => $request->input('position_id')
        ], $id);
      } catch(QueryException $e) {
        return JsonError::message('Something went wrong');
      }
      return JsonSuccess::message('Applicant updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      try {
        $t = Applicant::find($id)->delete();
        if ($t) {
          return JsonSuccess::message('Applicant deleted');
        }
      }catch(Exception $e) {
        return JsonError::message('Could not delete applicant, try again later');
      }
      return JsonError::message('Something went wrong');
    }
}

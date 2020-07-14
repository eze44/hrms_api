<?php

namespace App\Http\Controllers;

use App\UserRequest;
use App\UserRequestStatus;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Http\Service\UserRequestService;
use App\Http\Response\JsonSuccess;
use App\Http\Response\JsonError;



class UserRequestController extends Controller
{
    public function __construct() {
        $this->middleware('api');
        $this->userRequestService = new UserRequestService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user = $request->user();
      if ($user->role_id == Role::$EMPLOYEE) {
        return UserRequest::with([("user")->where("user_id", $user->id), "user_request_status", ""])->simplePaginate(10);
      }
      if ($user->role_id == Role::$CEO || $user->role_id == Role::$FINANCIAL_MANAGER) {
        return UserRequest::with("user", "user_request_status", "user_request_type")->simplePaginate(10);
      }
      return JsonError::message('No role access');
    }

    public function getById($id) {
        return UserRequest::find($id);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $user = $request->user();
        
        try {
            $this->userRequestService->insert([
                'type_id' => $request->input('type_id'),
                'user_id' => $user->id,
                'details' => $request->input('details'),
                'status_id' => UserRequestStatus::$PENDING,
                'date_from' => $request->input('date_to'),
                'date_to' => $request->input('date_to'),
                'created_at' => $request->input('created_at'),
                'updated_at' => $request->input('updated_at')
            ]);
        }
        catch (Exception $e) {
            return JsonError::message("Something wrong happened while creating your request");
        }

        return JsonSuccess::message("User request created");
    }

    public function approve(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role_id == Role::$CEO || $user->role_id == Role::$FINANCIAL_MANAGER) {
            $this->userRequestService->approve($id);
            return JsonSuccess::message("User request approved");
        }
        else {
            return JsonError::message("User request failed to approve. You may not have permission to approve requests!");
        }
    }

    public function deny(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role_id == Role::$CEO || $user->role_id == Role::$FINANCIAL_MANAGER) {
            $this->userRequestService->deny($id);
            return JsonSuccess::message("User request denied");
        }
        else {
            return JsonError::message("User request failed to deny. You may not have permission to deny requests!");
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $userRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRequest $userRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRequest $userRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $userRequest)
    {
        //
    }
}

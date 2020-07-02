<?php

namespace App\Http\Controllers;

use App\Http\Response\JsonSuccess;
use App\Payroll;
use App\User;
use Illuminate\Http\Request;
use App\Http\Service\PayrollService;
use Illuminate\Support\Facades\Mail;

class PayrollController extends Controller
{
    private $payrollService;

    public function __construct() {
      $this->middleware('api');
      $this->payrollService = new PayrollService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
      //validate if $this->user() has access to generate payrolls
      $manager = $req->user();
      //validate if manager has rights to update
      $bonus_users = $req->input("bonus_users"); // [{"user_id": 1, "bonus": 255},{"user_id": 1, "bonus": 255}]
      $users = User::get();
      foreach($users as $user) {
        $bonus = 0;
        if (!empty($bonus_users)) {
          foreach($bonus_users as $bon_user) {
            if ($user->id == $bon_user->user_id) {
              $bonus = $bon_user->bonus;
            }
          }
        }
        $this->payrollService->insert([
          "manager_id" => $manager->id,
          "user_id" => $user->id,
          "sum" => $user->base_salary,
          "bonus" => $bonus
        ]);

        $this->mail($user->fullname(), $user->email); //this should be enqueued in real life
      }
      return JsonSuccess::message("Payrolls generated");
    }

    public function mail($to_name, $to_email)
    {
      $data = array("name"=> $to_name);

      try {
          Mail::send("mail", $data, function($message) use ($to_name, $to_email) {
              $message->to($to_email, $to_name)->subject("My subject");
              $message->from(env("MAIL_FROM_ADDRESS"), "Company provided");
          });
      } catch (\Exception $exception) {
          //log exception
          return false;
      }

      return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}

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
      return Payroll::simplePaginate(10);
    }

    public function getById($id) {
      return Payroll::find($id);
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
            if ($user->id == $bon_user["user_id"]) {
              $bonus = $bon_user["bonus"];
            }
          }
        }
        $this->payrollService->insert([
          "manager_id" => $manager->id,
          "user_id" => $user->id,
          "sum" => $user->base_salary,
          "bonus" => $bonus
        ]);

        //$this->mail($user->fullname(), $user->email, $bonus); //this should be enqueued in real life
      }
      return JsonSuccess::message("Payrolls generated");
    }

    public function mail($to_name, $to_email, $bonus)
    {
      $data = ["name"=> $to_name, "bonus" => $bonus];

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
    public function update(Request $request, $payroll_id, $user_id)
    {
      $payroll = Payroll::findOrFail($payroll_id);
      $user = User::findOrFail($user_id);

      if (empty($payroll)) {
        return JsonError::message("No data found");
      }
      
      $manager = $request->user();
      
      $this->payrollService->update([
        "manager_id" => $manager->id,
        "user_id" => $user->id,
        "sum" => $request->input('sum'),
        "bonus" => $request->input('bonus'),
      ], $payroll_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      try {
        $p = Payroll::find($id)->delete();
        if ($p) {
            return JsonSuccess::message('Payroll deleted');
        }
      } catch(Exception $e) {
          return JsonError::message('Could not delete payroll, try again later');
      }

    return JsonError::message('Something went wrong');
    }
}

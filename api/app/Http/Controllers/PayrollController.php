<?php

namespace App\Http\Controllers;

use App\Payroll;
use Illuminate\Http\Request;
use App\Http\Service\PayrollService;

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
        if (empty($bonus_users)) {
          foreach($bonus_users as $bon_user) {
            if ($user->id == $bon_user->user_id) {
              $bonus = $bon_user->bonus;
            }
          }
        }
        $this->payrollService->insert([
          "manager_id" => $manager->id,
          "user_id" => $user->id,
          "sum" => $user->metadata->base_salary,
          "bonus" => $bonus
        ]);
        //insert to email queue
      }
      dd($manager);
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

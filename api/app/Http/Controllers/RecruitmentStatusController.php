<?php

namespace App\Http\Controllers;

use App\RecruitmentStatus;
use Illuminate\Http\Request;

class RecruitmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RecruitmentStatus::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\RecruitmentStatus  $recruitmentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(RecruitmentStatus $recruitmentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RecruitmentStatus  $recruitmentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(RecruitmentStatus $recruitmentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RecruitmentStatus  $recruitmentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecruitmentStatus $recruitmentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RecruitmentStatus  $recruitmentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecruitmentStatus $recruitmentStatus)
    {
        //
    }
}

<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

/**
 *
 */
interface CRUDInterface
{
  public function index();
  public function getById($id);
  public function create(Request $request);
  public function update(Request $request);
  public function delete($id);
}

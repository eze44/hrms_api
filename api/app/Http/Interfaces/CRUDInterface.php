<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

/**
 *
 */
interface CRUDInterface
{
  public function index(Request $req);
  public function getById($id);
  public function create(Request $request);
  public function update(Request $request, $id);
  public function delete($id);
}

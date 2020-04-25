<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    public function index()
    {
        return Position::all();
    }
}

<?php

namespace App\Http\Response;

class JsonError {
  public static function message($msg) {
    return response()->json(['error' => $msg], 400);
  }

}

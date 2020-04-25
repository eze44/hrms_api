<?php

namespace App\Http\Response;

class JsonSuccess {
  public static function message($msg) {
    return response()->json(['message' => $msg], 200);
  }
}

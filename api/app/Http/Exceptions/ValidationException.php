<?php

namespace App\Http\Exceptions;

use Exception;

class ValidationException extends Exception {
    public function render($request) {
        return response("Validation exception");
    }
}

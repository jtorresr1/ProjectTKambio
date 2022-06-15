<?php

namespace App\Exceptions;

use Exception;

class CustomAuthorizationException extends Exception
{
    public function render($request)
    {
        return response()->json(['message' => "Failed in the authorization"] );
    }
}

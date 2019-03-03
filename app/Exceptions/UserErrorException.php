<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class UserErrorException extends Exception
{
    private $httpCode = 200;
    private $errors   = [
        'USER_NOT_FOUND' => 50001
    ];

    public function render($request, $exception)
    {
        $code = $this->errors[$exception->getMessage()] ?? $exception->getCode();

        if (\Lang::has('error.'.$code)) {
            $message = __('error.'.$code);
        } else {
            $message = $exception->getMessage();
        }

        return response()->json([
            'code'    => $code,
            'message' => $message
        ], $this->httpCode);
    }
}

<?php

namespace App\Http\Resources;

class ApiErrorResource extends ApiResource
{
    public static $wrap = 'error';

    public function __construct($message, $response_code, $with = [])
    {
        $this->response_code = $response_code;

        parent::__construct(array_merge([
            'message' => $message
        ], $with), $response_code);
    }
}

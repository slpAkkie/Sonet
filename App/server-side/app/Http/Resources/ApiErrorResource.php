<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiErrorResource extends JsonResource
{
    public $response_code;
    public static $wrap = 'error';

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->response_code);
    }

    public function __construct($message, $response_code, $with = [])
    {
        $this->response_code = $response_code;

        parent::__construct(array_merge([
            'code' => $response_code,
            'message' => $message
        ], $with));
    }
}

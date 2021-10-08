<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public static $wrap = 'data';
    public $response_code;

    public function with($request): array
    {
        return [
            'code' => $this->response_code
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->response_code);
    }

    public function __construct($resource, $response_code = 200)
    {
        $this->response_code = $response_code;

        parent::__construct($resource);
    }
}

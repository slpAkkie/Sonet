<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommonResource extends JsonResource
{
    public static $wrap = 'data';

    protected $response_code;

    private function getStatusCode() {
        return $this->response_code ?? 200;
    }

    public function with($request): array
    {
        return [
            'code' => $this->getStatusCode()
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->getStatusCode());
    }
}

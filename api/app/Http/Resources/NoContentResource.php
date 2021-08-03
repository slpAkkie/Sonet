<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoContentResource extends JsonResource
{
    public function withResponse($request, $response)
    {
        $response->setStatusCode(204);
    }

    public function __construct()
    {
        parent::__construct(null);
    }
}

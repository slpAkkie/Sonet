<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreatedResource extends JsonResource
{
    public function withResponse($request, $response)
    {
        $response->setStatusCode(201);
    }

    public function __construct()
    {
        parent::__construct(null);
    }
}

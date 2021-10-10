<?php

namespace App\Http\Resources;

class TestResource extends CommonResource
{
    public function __construct()
    {
        parent::__construct([
            'message' => 'test'
        ]);
    }
}

<?php

namespace App\Http\Resources;

class ValidationFailedResource extends ApiErrorResource
{
    public function __construct($validation_errors = [])
    {
        parent::__construct('Ваши данные не прошли проверку', 422, count($validation_errors) ? [
            'errors' => $validation_errors
        ] : []);
    }
}

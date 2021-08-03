<?php

namespace App\Http\Resources;

class ValidationFailedResource extends ErrorResource
{
    /**
     * ValidationErrorResource constructor.
     *
     * @param $errors
     */
    public function __construct($errors)
    {
        parent::__construct('Возникли проблемы при проверке ваших данных', 422, ['errors' => $errors]);
    }
}

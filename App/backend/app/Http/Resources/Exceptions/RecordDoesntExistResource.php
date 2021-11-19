<?php

namespace App\Http\Resources\Exceptions;

final class RecordDoesntExistResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('Объект не был сохранен, работы с дочерними объектами не возможна', 500);
    }
}

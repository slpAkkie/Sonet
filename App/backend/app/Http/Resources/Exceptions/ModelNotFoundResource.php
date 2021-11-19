<?php

namespace App\Http\Resources\Exceptions;

use Illuminate\Support\Collection;

final class ModelNotFoundResource extends CommonErrorResource
{
    public function __construct($model)
    {
        parent::__construct('Объект не был найден', 404, [
            'model' => Collection::make(explode('\\', $model))->last(),
        ]);
    }
}

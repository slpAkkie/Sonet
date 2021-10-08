<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class ModelNotFoundResource extends ApiErrorResource
{
    public function __construct($model)
    {
        parent::__construct(
            'Объект не был найден',
            404,
            [
                'model' => Collection::make(
                    explode('\\', $model)
                )->last()
            ]
        );
    }
}

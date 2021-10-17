<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class ModelNotFoundResource extends CommonErrorResource
{
    public function __construct($model)
    {
        parent::__construct('Объект не был найден', 404, [
            'model' => Collection::make(
                explode('\\', $model)
            )->last()
        ]);
    }

    // HACK: In Handler.php it waiting for Response instance so transform it
    public function getAsResponse() {
        return $this->toResponse($this->resource);
    }
}

<?php

namespace App\Http\Resources;

class ModelNotSavedResource extends CommonErrorResource
{
    public function __construct()
    {
        parent::__construct('Модель не была сохранена, дочерние элементы не могут быть присоединены', 500);
    }
}

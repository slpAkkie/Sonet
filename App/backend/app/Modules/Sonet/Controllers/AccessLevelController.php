<?php

namespace App\Modules\Sonet\Controllers;

use App\Modules\Sonet\Resources\AccessLevelResource;
use App\Modules\Sonet\Models\AccessLevel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccessLevelController extends \App\Http\Controllers\Controller
{
    /**
     * Get all access_level records
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return AccessLevelResource::collection(AccessLevel::all());
    }
}

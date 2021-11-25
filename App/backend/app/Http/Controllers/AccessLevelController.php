<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccessLevelResource;
use App\Models\AccessLevel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AccessLevelController extends Controller
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

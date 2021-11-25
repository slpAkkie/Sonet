<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContributorHintResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get Users by email
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function indexForContributors(Request $request): AnonymousResourceCollection
    {
        if (!$request->get('email')) return ContributorHintResource::collection(Collection::make([]));
        return ContributorHintResource::collection(
            User::where('id', '!=', Auth::id())
                ->where('email', 'like', '%' . $request->get('email') . '%')
                ->limit(10)
                ->get()
        );
    }
}

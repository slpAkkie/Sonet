<?php

namespace App\Modules\Sonet\Controllers;

use App\Modules\Sonet\Resources\ContributorHintResource;
use App\Modules\Sonet\Resources\DeletedResource;
use App\Modules\Sonet\Models\Attachment;
use App\Modules\Sonet\Models\Note;
use App\Modules\Sonet\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends \App\Http\Controllers\Controller
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

    /**
     * Delete User
     *
     * @return DeletedResource
     */
    public function destroy(): DeletedResource
    {
        /** @var User $user */
        $user = Auth::user();
        Attachment::whereIn('note_id', function (Builder $builder) {
            return $builder->from('notes')->select('id')->where('user_id', Auth::id());
        })->get('path')->each(function ($attachment) {
            unlink('storage/' . $attachment['path']);
        });
         $user->delete();

        return DeletedResource::make();
    }
}

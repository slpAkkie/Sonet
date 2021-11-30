<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContributorHintResource;
use App\Http\Resources\DeletedResource;
use App\Models\Attachment;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Query\Builder;
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

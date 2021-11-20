<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Http\Resources\CommonResource;
use App\Http\Resources\DeletedResource;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     * Show all user's folders
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();

        return FolderResource::collection($user->folders()->orderByDesc('order')->get());
    }

    /**
     * Store new user's folder
     *
     * @param StoreFolderRequest $request
     * @return FolderResource
     */
    public function store(StoreFolderRequest $request): FolderResource
    {
        ($folder = new Folder($request->all()))->save();

        return FolderResource::make($folder);
    }

    /**
     * Delete user's folder
     *
     * @param Folder $folder
     * @return DeletedResource
     */
    public function destroy(Folder $folder): DeletedResource
    {
        $folder->delete();

        return DeletedResource::make();
    }
}

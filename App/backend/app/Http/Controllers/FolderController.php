<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Http\Resources\CommonResource;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function index() {
        return FolderResource::collection(Auth::user()->folders);
    }

    public function store(StoreFolderRequest $request) {
        ($folder = new Folder($request->all()))->save();

        return FolderResource::make($folder);
    }

    public function destroy(Folder $folder) {
        $folder->delete();
        return CommonResource::make([
            'message' => 'Deleted'
        ]);
    }
}

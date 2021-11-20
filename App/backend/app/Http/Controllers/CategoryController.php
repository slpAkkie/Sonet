<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommonResource;
use App\Http\Resources\DeletedResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Show all user's categories
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();

        return CategoryResource::collection($user->categories()->orderByDesc('order')->get());
    }

    /**
     * Store new user's category
     *
     * @param StoreCategoryRequest $request
     * @return CategoryResource
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        ($category = new Category($request->all()))->save();

        return CategoryResource::make($category);
    }

    /**
     * Delete user's category
     *
     * @param Category $category
     * @return DeletedResource
     */
    public function destroy(Category $category): DeletedResource
    {
        $category->delete();

        return DeletedResource::make();
    }
}

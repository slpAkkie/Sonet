<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommonResource;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index() {
        return CategoryResource::collection(Auth::user()->categories()->orderBy('order', 'DESC')->get());
    }

    public function store(StoreCategoryRequest $request) {
        ($category = new Category($request->all()))->save();

        return CategoryResource::make($category);
    }

    public function destroy(Category $category) {
        $category->delete();
        return CommonResource::make([
            'message' => 'Deleted'
        ]);
    }
}

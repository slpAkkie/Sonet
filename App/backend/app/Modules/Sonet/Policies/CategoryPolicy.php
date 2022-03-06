<?php

namespace App\Modules\Sonet\Policies;

use App\Modules\Sonet\Models\Category;
use App\Modules\Sonet\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update category.
     *
     * @param User $user
     * @param Category $category
     * @return bool
     */
    public function update(User $user, Category $category): bool
    {
        return $category->user_id === $user->id;
    }
}

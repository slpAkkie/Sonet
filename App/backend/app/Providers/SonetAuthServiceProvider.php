<?php

namespace App\Providers;

use App\Modules\Sonet\Models\Note;
use App\Modules\Sonet\Policies\CategoryPolicy;
use App\Modules\Sonet\Policies\CommentPolicy;
use App\Modules\Sonet\Policies\NotePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class SonetAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Note::class => NotePolicy::class,

        // TODO: Folder policy
        // TODO: Category policy
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /** Note gates ------------------------ */
        Gate::define('view-note', [NotePolicy::class, 'view']);
        Gate::define('update-note', [NotePolicy::class, 'update']);
        Gate::define('delete-note', [NotePolicy::class, 'delete']);

        /** Comment gates --------------------- */
        Gate::define('create-comment', [CommentPolicy::class, 'create']);
        Gate::define('delete-comment', [CommentPolicy::class, 'delete']);

        /** Category gates -------------------- */
        Gate::define('update-category', [CategoryPolicy::class, 'update']);

        // TODO: Folder gates
        // TODO: Category gates
        // TODO: Contributors gates
    }
}

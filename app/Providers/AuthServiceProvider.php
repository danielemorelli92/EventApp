<?php

namespace App\Providers;


use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('create-request', function (User $user){
            $user = User::find(Auth::id());
            return $user !== null && $user->type === 'normale' && $user->request === null;
        });

        Gate::define('create-event', function (User $user) {
            $user = User::find(Auth::id());
            return $user->type === 'organizzatore' || $user->type === 'admin';
        });
        Gate::define('delete-event', function (User $user, Event $event) {
            $user = User::find(Auth::id());
            return $user->id === $event->author_id;
        });
        Gate::define('has-a-event', function (User $user) {
            $user = User::find(Auth::id());
            return $user->createdEvents->count() > 0;
        });
        Gate::define('edit-event', function (User $user, Event $event) {
            $user = User::find(Auth::id());
            return $user->id === $event->author_id;
        });

    }

}

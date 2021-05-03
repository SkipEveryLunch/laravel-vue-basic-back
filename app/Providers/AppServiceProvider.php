<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        \Gate::define("view",
        function(User $user,$model){
            return $user->hasAccess("view_{$model}") || $user->hasAccess("edit_{$model}");
        });
        \Gate::define("edit",
        function(User $user,$model){
            return $user->hasAccess("edit_{$model}");
        });
    }
}

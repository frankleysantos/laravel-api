<?php

namespace App\Providers;


use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\Eloquent\EloquentUserRepository;
use App\Repositories\Core\QueryBuilder\QueryBuilderUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //eloquent ou QueryBuilder
        $this->app->bind(
            UserRepositoryInterface::class,
            // EloquentUserRepository::class
            QueryBuilderUserRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

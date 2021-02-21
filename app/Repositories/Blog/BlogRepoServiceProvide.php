<?php

namespace App\Repositories\Blog;


use Illuminate\Support\ServiceProvider;


class BlogRepoServiceProvide extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Blog\BlogInterface', 'App\Repositories\Blog\BlogRepository');
    }
}
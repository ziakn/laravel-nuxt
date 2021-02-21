<?php

namespace App\Repositories\Category;


use Illuminate\Support\ServiceProvider;


class CategoryRepoServiceProvide extends ServiceProvider
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
        $this->app->bind('App\Repositories\Category\CategoryInterface', 'App\Repositories\Category\CategoryRepository');
    }
}
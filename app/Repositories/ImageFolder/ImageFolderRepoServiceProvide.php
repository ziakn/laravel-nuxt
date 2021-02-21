<?php

namespace App\Repositories\ImageFolder;


use Illuminate\Support\ServiceProvider;


class ImageFolderRepoServiceProvide extends ServiceProvider
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
        $this->app->bind('App\Repositories\ImageFolder\ImageFolderInterface', 'App\Repositories\ImageFolder\ImageFolderRepository');
    }
}
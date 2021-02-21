<?php

namespace App\Repositories\Image;


use Illuminate\Support\ServiceProvider;


class ImageRepoServiceProvide extends ServiceProvider
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
        $this->app->bind('App\Repositories\Image\ImageInterface', 'App\Repositories\Image\ImageRepository');
    }
}